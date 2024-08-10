<?php
//-- router
$app->get('/faq', 'getview')->name('faq-view');
$app->post('/faq', 'postview')->name('faq-view');

$app->get('/faq/add', 'getadd')->name('faq-insert');
$app->post('/faq/add', 'postadd')->name('faq-insert');

$app->get('/faq/edit/:id', 'getedit')->name('faq-update');
$app->post('/faq/edit/:id', 'postedit')->name('faq-update');

$app->post('/faq/data', 'fetchdata')->name('faq-view-query');
$app->post('/faq/validate', 'validate')->name('novalidate');
$app->post('/faq/query-insert', 'insertdata')->name('faq-insert-query');
$app->post('/faq/query-update', 'updatedata')->name('faq-update-query');
$app->post('/faq/query-delete', 'deletedata')->name('faq-delete-query');

//-- controller

function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$data = izy::load('tb_faq', $id);

	$smarty->assign('data', $data);

	$smarty->display(basepath.'/modules/faq/edit-faq.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_faq', $id);
	$smarty->assign('data', $data);

	$smarty->assign('content', basepath.'/modules/faq/edit-faq.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_faq where id=?', array($dataid));

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

	$obj = izy::dispense('tb_faq');
	$obj->tanya = $request->params('tanya');
	$obj->jawab = $request->params('jawab');
	
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

	$obj = izy::load('tb_faq', $request->params('id'));
	$obj->tanya = str_replace(baseurlroot, '[baseurlroot]', $request->params('tanya'));
	$obj->jawab = str_replace(baseurlroot, '[baseurlroot]', $request->params('jawab'));

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
	
	$row = izy::findOne('tb_kurir', 'nama=?', array($request->params('nama')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'nama';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'nama';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();	



	$smarty->display(basepath.'/modules/faq/add-faq.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('content', basepath.'/modules/faq/add-faq.tpl');
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
	$sql = "SELECT A.id, A.tanya
	FROM tb_faq A
	WHERE A.id IS NOT NULL $filter_query 
	ORDER BY A.tanya ASC
	";
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
	

	$smarty->display(basepath.'/modules/faq/view-faq.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('content', basepath.'/modules/faq/view-faq.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

?>