<?php
//-- router
$app->get('/courier', 'getview')->name('courier-view');
$app->post('/courier', 'postview')->name('courier-view');

$app->get('/courier/add', 'getadd')->name('courier-insert');
$app->post('/courier/add', 'postadd')->name('courier-insert');

$app->get('/courier/edit/:id', 'getedit')->name('courier-update');
$app->post('/courier/edit/:id', 'postedit')->name('courier-update');

$app->post('/courier/data', 'fetchdata')->name('courier-view-query');
$app->post('/courier/validate', 'validate')->name('novalidate');
$app->post('/courier/query-insert', 'insertdata')->name('courier-insert-query');
$app->post('/courier/query-update', 'updatedata')->name('courier-update-query');
$app->post('/courier/query-delete', 'deletedata')->name('courier-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$data = izy::load('tb_kurir', $id);

	$smarty->assign('data', $data);
	$smarty->display(basepath.'/modules/courier/edit-courier.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_kurir', $id);

	$smarty->assign('data', $data);

	$smarty->assign('content', basepath.'/modules/courier/edit-courier.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_kurir where id=?', array($dataid));
		izy::exec('delete from tb_tarif where idKurir=?', array($dataid));

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

	$obj = izy::dispense('tb_kurir');
	$obj->nama = $request->params('nama');
	$obj->status = $request->params('status');
	$obj->keterangan = $request->params('keterangan');

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

	$obj = izy::load('tb_kurir', $request->params('id'));
	$obj->nama = $request->params('nama');
	$obj->status = $request->params('status');
	$obj->keterangan = $request->params('keterangan');
		

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
	$smarty->display(basepath.'/modules/courier/add-courier.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$smarty->assign('content', basepath.'/modules/courier/add-courier.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$barisdiinginkan = $request->params('jumlahbaris');
	$filterdata = $request->params('pilihfilter');
	$halaman = $request->params('halaman');
	$cari = $request->params('cari');

	/*
	$catid = $request->params('category');
	$filter_kategory = "";
	if($catid != ''){
		$filter_kategory = " AND C.id = '$catid' ";
	}
	*/

	$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
	$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.*, (select count(B.id) from tb_tarif B where B.idKurir = A.id) as jumlahtarif
	FROM tb_kurir A 
	WHERE A.id IS NOT NULL $filter_query
	ORDER BY A.nama ASC
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
	$smarty->display(basepath.'/modules/courier/view-courier.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('content', basepath.'/modules/courier/view-courier.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

?>