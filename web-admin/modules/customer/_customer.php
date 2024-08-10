<?php
//-- router
$app->get('/customer', 'getview')->name('customer-view');
$app->post('/customer', 'postview')->name('customer-view');

$app->get('/customer/add', 'getadd')->name('customer-insert');
$app->post('/customer/add', 'postadd')->name('customer-insert');

$app->get('/customer/edit/:id', 'getedit')->name('customer-update');
$app->post('/customer/edit/:id', 'postedit')->name('customer-update');

$app->get('/customer/export', 'exportdata')->name('customer-view');

$app->post('/customer/data', 'fetchdata')->name('customer-view-query');
$app->post('/customer/validate', 'validate')->name('novalidate');
$app->post('/customer/query-insert', 'insertdata')->name('customer-insert-query');
$app->post('/customer/query-update', 'updatedata')->name('customer-update-query');
$app->post('/customer/query-delete', 'deletedata')->name('customer-delete-query');


//-- controller
function exportdata(){
	require_once basepath.'/libraries/class/export-xls.class.php';

	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$filterdata = $_REQUEST['pilihfilter'];
	$cari = $_REQUEST['cari'];

	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.nama, A.email, telpon, alamat, kota, kodepos, tgldaftar
	FROM tb_customer A 
	WHERE A.id IS NOT NULL $filter_query
	ORDER BY A.nama ASC, A.email ASC
	";
	$rs = $db->query($sql) or die($db->error);

	$filename = $_REQUEST['namafile'];
	$filename = ($filename == "") ? "export.xls" : $filename.'.xls';
	$xls = new ExportXLS($filename);
	$kolom = array();

	$i = 0;
	while ($rowfield = $rs->fetch_field()) {
		$kolom[$i] = $rowfield->name;
		$i++;
	}

	//-- head
	$xls -> addHeader($kolom);

	//-- body/data
	$data = array();
	$i = $j = 0;
	while ($rowdata = $rs->fetch_assoc()) {
		for ($i = 0; $i < count($kolom); $i++) {
			$data[$j][$kolom[$i]] = $rowdata[$kolom[$i]];
		}
		$data[$j]['telpon'] = "'".$rowdata['telpon'];
		$data[$j]['kodepos'] = "'".$rowdata['kodepos'];

		$xls-> addRow($data[$j]);
		$j++;
	}

	$db = $rs = null;

	//-- output
	$xls -> sendFile();
}

function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$data = izy::load('tb_customer', $id);


	$smarty->assign('data', $data);

	$smarty->display(basepath.'/modules/customer/edit-customer.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_customer', $id);


	$smarty->assign('data', $data);

	$smarty->assign('content', basepath.'/modules/customer/edit-customer.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_customer where id=?', array($dataid));
		
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

	$obj = izy::dispense('tb_customer');
	$obj->username = $request->params('username');
	$obj->email = $request->params('username');
	$obj->password = $request->params('password');
	$obj->nama = $request->params('nama');
	$obj->telpon = $request->params('telpon');
	$obj->kota = $request->params('kota');
	$obj->alamat = $request->params('alamat');
	$obj->kodepos = $request->params('kodepos');
	$obj->tgldaftar = date('Y-m-d');
	$obj->grupuser = 1;

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

	$obj = izy::load('tb_customer', $request->params('id'));
	$obj->username = $request->params('username');
	$obj->email = $request->params('username');
	$obj->password = $request->params('password');
	$obj->nama = $request->params('nama');
	$obj->telpon = $request->params('telpon');
	$obj->kota = $request->params('kota');
	$obj->alamat = $request->params('alamat');
	$obj->kodepos = $request->params('kodepos');
		

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
	
	$row = izy::findOne('tb_customer', 'username=?', array($request->params('username')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'username';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'username';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();	
	$smarty->display(basepath.'/modules/customer/add-customer.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$smarty->assign('content', basepath.'/modules/customer/add-customer.tpl');
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
	$sql = "SELECT A.*
	FROM tb_customer A 
	WHERE A.id IS NOT NULL $filter_query
	ORDER BY A.nama ASC, A.email ASC
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
	$smarty->display(basepath.'/modules/customer/view-customer.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('content', basepath.'/modules/customer/view-customer.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

?>