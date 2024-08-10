<?php
//-- router
$app->get('/moduleitem', 'getview')->name('moduleitem-view');
$app->post('/moduleitem', 'postview')->name('moduleitem-view');

$app->get('/moduleitem/add', 'getadd')->name('moduleitem-insert');
$app->post('/moduleitem/add', 'postadd')->name('moduleitem-insert');

$app->get('/moduleitem/edit/:id', 'getedit')->name('moduleitem-update');
$app->post('/moduleitem/edit/:id', 'postedit')->name('moduleitem-update');

$app->post('/moduleitem/data', 'fetchdata')->name('moduleitem-view-query');
$app->post('/moduleitem/validate', 'validate')->name('novalidate');
$app->post('/moduleitem/query-insert', 'insertdata')->name('moduleitem-insert-query');
$app->post('/moduleitem/query-update', 'updatedata')->name('moduleitem-update-query');
$app->post('/moduleitem/query-delete', 'deletedata')->name('moduleitem-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$data = izy::load('tb_otorisasi_module_item', $id);

	
	$smarty->assign('data', $data);
	$smarty->assign('datagroupmenu', getAllGroupmenu());
	$smarty->display(basepath.'/modules/moduleitem/edit-moduleitem.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty(); 

	$data = izy::load('tb_otorisasi_module_item', $id);
	$smarty->assign('data', $data);
	$smarty->assign('datagroupmenu', getAllGroupmenu());
	$smarty->assign('content', basepath.'/modules/moduleitem/edit-moduleitem.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('DELETE from tb_otorisasi_module_item where id=?', array($dataid));	
		
		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function insertdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$obj = izy::dispense('tb_otorisasi_module_item');
	$obj->groupmenu = $request->params('groupmenu');
	$obj->menu = $request->params('menu');
	$obj->module = $request->params('module');
	$obj->deskripsi = $request->params('deskripsi');
	$obj->is_menu = $request->params('is_menu');
	$obj->urut = $request->params('urut');
	$obj->single_module = $request->params('single_module');
	

	$result = "";
	izy::begin();
	try {
		$data_id = izy::store($obj);

		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function updatedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$obj = izy::load('tb_otorisasi_module_item', $request->params('id'));
	$obj->groupmenu = $request->params('groupmenu');
	$obj->menu = $request->params('menu');
	$obj->module = $request->params('module');
	$obj->deskripsi = $request->params('deskripsi');
	$obj->is_menu = $request->params('is_menu');
	$obj->urut = $request->params('urut');
	$obj->single_module = $request->params('single_module');

	$result = "";
	izy::begin();
	try {
		$data_id = izy::store($obj);
		
		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function validate(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$id = $request->params('id');


	$arrayToJs = array();
	$i = 0;
	
	$row = izy::findOne('tb_otorisasi_module_item', 'module=?', array($request->params('module')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'module';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'module';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->assign('datagroupmenu', getAllGroupmenu());
	$smarty->display(basepath.'/modules/moduleitem/add-moduleitem.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$smarty->assign('datagroupmenu', getAllGroupmenu());

	$smarty->assign('content', basepath.'/modules/moduleitem/add-moduleitem.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$barisdiinginkan = $request->params('jumlahbaris');
	$filterdata = $request->params('pilihfilter');
	$halaman = $request->params('halaman');
	$cari = $request->params('cari');

	$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
	$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.*
	FROM tb_otorisasi_module_item A INNER JOIN tb_otorisasi_groupmenu B ON A.groupmenu = B.nama
	WHERE A.id IS NOT NULL $filter_query
	ORDER BY B.urut ASC, A.urut ASC ";
	$rs = $db->query($sql) or die($db->error);

	$jumlahdata = $rs->num_rows;
	$jumlahhalaman = ceil($jumlahdata / $barisdiinginkan);

	$databody = izy::getAll($sql.$limit_query);
	$datasetting["jumlahdata"] = $jumlahdata;
	$datasetting["jumlahhalaman"] = $jumlahhalaman;

	$result = array();
	$result['datahead'] = array();
	$result['databody'] = $databody;
	$result['datasetting'] = $datasetting;
	echo json_encode($result);
}

function postview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->display(basepath.'/modules/moduleitem/view-moduleitem.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('content', basepath.'/modules/moduleitem/view-moduleitem.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function getAllGroupmenu(){
	return izy::getAll("SELECT * 
	FROM tb_otorisasi_groupmenu
	ORDER BY urut ASC");	
}
?>