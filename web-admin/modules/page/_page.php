<?php
//-- router
$app->map('/page', 'PageCtrl::view')->via('POST', 'GET')->name('page-view');
$app->map('/page/add', 'PageCtrl::add')->via('POST', 'GET')->name('page-insert');
$app->map('/page/edit/:id', 'PageCtrl::edit')->via('POST', 'GET')->name('page-update');

$app->post('/page/data', 'PageCtrl::fetchdata')->name('page-view-query');
$app->post('/page/validate', 'PageCtrl::validate')->name('novalidate');
$app->post('/page/query-insert', 'PageCtrl::insertdata')->name('page-insert-query');
$app->post('/page/query-update', 'PageCtrl::updatedata')->name('page-update-query');
$app->post('/page/query-delete', 'PageCtrl::deletedata')->name('page-delete-query');
$app->post('/page/query-delete-selected-items', 'PageCtrl::deleteSelectedItems')->name('page-delete-query');


//-- controller
class PageCtrl{
	static function view(){
		require_once basepath.'/libraries/smarty/Smarty.class.php';

		$app = \Slim\Slim::getInstance();
		$smarty = newSmarty();
	
		if($app->request->isAjax()){
			$smarty->display(basepath.'/modules/page/view-page.tpl');
		}else{
			$smarty->assign('content', basepath.'/modules/page/view-page.tpl');
			$smarty->display(basepath."/modules/main.tpl");
		}	
	}
	static function fetchdata(){
		$app = \Slim\Slim::getInstance();
		$request = $app->request();

		$barisdiinginkan = $request->params('jumlahbaris');
		$filterdata = $request->params('pilihfilter');
		$halaman = $request->params('halaman');
		$cari = $request->params('cari');

		$filter_kategory = "";
		if($catid != ''){
			$filter_kategory = " AND C.id = '$catid' ";
		}

		$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
		$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
		$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

		$db = mysqliConnection();
		$sql = "SELECT A.id, A.title, A.created, A.publish_up, A.type as categoryname, A.alias
		FROM tb_content A 
		WHERE A.type = 'page'  $filter_query $filter_kategory
		ORDER BY A.alias ASC, A.title ASC ";
		$rs = $db->query($sql) or die($db->error);

		$jumlahdata = $rs->num_rows;
		$jumlahhalaman = ceil($jumlahdata / $barisdiinginkan);

		$databody = izy::getAll($sql.$limit_query);
		foreach ($databody as $key => $value) {
			$databody[$key]['tanggal'] = date('Y-m-d', strtotime($databody[$key]['publish_up'])) ;
		}


		$datasetting["jumlahdata"] = $jumlahdata;
		$datasetting["jumlahhalaman"] = $jumlahhalaman;

		$result = array();
		$result['datahead'] = array();
		$result['databody'] = $databody;
		$result['datasetting'] = $datasetting;
		echo json_encode($result);
	}
	static function add(){
		require_once basepath.'/libraries/smarty/Smarty.class.php';

		$app = \Slim\Slim::getInstance();
		$smarty = newSmarty();
	
		if($app->request->isAjax()){
			$smarty->display(basepath.'/modules/page/add-page.tpl');
		}else{
			$smarty->assign('content', basepath.'/modules/page/add-page.tpl');
			$smarty->display(basepath."/modules/main.tpl");
		}	
	}
	static function edit($id){
		require_once basepath.'/libraries/smarty/Smarty.class.php';

		$app = \Slim\Slim::getInstance();
		$smarty = newSmarty();

		$data = izy::load('tb_content', $id);
		$smarty->assign('data', $data);
	
		if($app->request->isAjax()){
			$smarty->display(basepath.'/modules/page/edit-page.tpl');
		}else{
			$smarty->assign('content', basepath.'/modules/page/edit-page.tpl');
			$smarty->display(basepath."/modules/main.tpl");
		}	
	}
	static function deleteSelectedItems(){
		$app = \Slim\Slim::getInstance();
		$request = $app->request();
		izy::begin();
		try {
			$dataid = $request->params('dataid');
			foreach ($dataid as $key => $value) {
				izy::exec('delete from tb_content where id=?', array($value));
			}
			
			izy::commit();
			$result = 'berhasil';
		} catch(Exception $e) {
			izy::rollback();
			$result = $e->getMessage();
		}
		echo $result;
	}

	static function deletedata(){
		$app = \Slim\Slim::getInstance();
		$request = $app->request();

		$dataid = $request->params('id');
		
		$result = "";
		izy::begin();
		try {
			izy::exec('delete from tb_content where id=?', array($dataid));	
			
			
			izy::commit();
			$result = 'berhasil';
		} catch(Exception $e) {
			izy::rollback();
			$result = $e->getMessage();
		}
		echo $result;
	}

	static function insertdata(){
		$app = \Slim\Slim::getInstance();
		$request = $app->request();

		$obj = izy::dispense('tb_content');
		$obj->type = 'page';
		$obj->title = $request->params('title');
		$obj->alias = friendlyString($request->params('alias'));
		//$obj->introtext = $request->params('introtext');
		$obj->fulltext = str_replace(baseurlroot, '[baseurlroot]', $request->params('fulltext'));
		$obj->state = 1;
		$obj->created = date('Y-m-d H:i:s');
		$obj->created_by = $_SESSION['login_admin']['id'];
		$obj->created_by_alias = $_SESSION['login_admin']['username'];
		$obj->modified = date('Y-m-d H:i:s');
		$obj->modified_by = $_SESSION['login_admin']['id'];
		$obj->publish_up = date("Y-m-d H:i:s", strtotime($request->params('tanggal')));
		//$obj->images = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
		$obj->metakey = $request->params('metakey');
		$obj->metadesc = $request->params('metadesc');

		$result = "";
		izy::begin();
		try {
			$content_id = izy::store($obj);

			izy::commit();
			$result = 'berhasil';
		} catch(Exception $e) {
			izy::rollback();
			$result = $e->getMessage();
		}
		echo $result;
	}

	static function updatedata(){
		$app = \Slim\Slim::getInstance();
		$request = $app->request();

		$obj = izy::load('tb_content', $request->params('id'));
		$obj->type = 'page';
		$obj->title = $request->params('title');
		$obj->alias = friendlyString($request->params('alias'));
		$obj->introtext = $request->params('introtext');
		$obj->fulltext = str_replace(baseurlroot, '[baseurlroot]', $request->params('fulltext'));
		//$obj->state = $request->params('state');
		//$obj->created = date('Y-m-d H:i:s');
		//$obj->created_by = $_SESSION['login_admin']['id'];
		//$obj->created_by_alias = $_SESSION['login_admin']['username'];
		$obj->modified = date('Y-m-d H:i:s');
		$obj->modified_by = $_SESSION['login_admin']['id'];
		$obj->publish_up = date("Y-m-d H:i:s", strtotime($request->params('tanggal')));
		$obj->images = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
		$obj->metakey = $request->params('metakey');
		$obj->metadesc = $request->params('metadesc');

		$result = "";
		izy::begin();
		try {
			$content_id = izy::store($obj);

			izy::commit();
			$result = 'berhasil';
		} catch(Exception $e) {
			izy::rollback();
			$result = $e->getMessage();
		}
		echo $result;
	}

	static function validate(){
		$app = \Slim\Slim::getInstance();
		$request = $app->request();

		$id = $request->params('id');
		
		$arrayToJs = array();
		$i = 0;
		
		$alias = friendlyString($request->params('alias'));
		$kolom = 'alias';
		if($alias == ""){
			$alias = friendlyString($request->params('title'));
			$kolom = 'title';
		}

		$row = izy::findOne('tb_content', 'alias=?', array($alias));

		if($row->id >0 && $row->id != $id){
			$arrayToJs[$i][0] = $kolom;
			$arrayToJs[$i][1] = false;
			$arrayToJs[$i][2] = "This name is already taken.!";
		}else{
			$arrayToJs[$i][0] = $kolom;
			$arrayToJs[$i][1] = true;
		}
		
		echo json_encode($arrayToJs);	
	}


}






?>