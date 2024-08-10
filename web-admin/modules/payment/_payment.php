<?php
//-- router
$app->get('/payment', 'getview')->name('payment-view');
$app->post('/payment', 'postview')->name('payment-view');

$app->get('/payment/add', 'getadd')->name('payment-insert');
$app->post('/payment/add', 'postadd')->name('payment-insert');

$app->get('/payment/edit/:id', 'getedit')->name('payment-update');
$app->post('/payment/edit/:id', 'postedit')->name('payment-update');

$app->post('/payment/data', 'fetchdata')->name('payment-view-query');
$app->post('/payment/validate', 'validate')->name('novalidate');
$app->post('/payment/query-insert', 'insertdata')->name('payment-insert-query');
$app->post('/payment/query-update', 'updatedata')->name('payment-update-query');
$app->post('/payment/query-delete', 'deletedata')->name('payment-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$data = izy::load('tb_bank', $id);

	$smarty->assign('datajenis', fetchJenis());
	$smarty->assign('data', $data);

	$smarty->display(basepath.'/modules/payment/edit-payment.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_bank', $id);
	
	$smarty->assign('data', $data);
	$smarty->assign('datajenis', fetchJenis());
	$smarty->assign('content', basepath.'/modules/payment/edit-payment.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('DELETE from tb_bank where id=?', array($dataid));	
		
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

	$obj = izy::dispense('tb_bank');
	$obj->atas_nama = $request->params('atas_nama');
	$obj->jenis = $request->params('jenis');
	$obj->logo = str_replace(baseurlroot, '[baseurlroot]', $request->params('logo'));
	$obj->nama = $request->params('nama');
	$obj->rekening = $request->params('rekening');

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

	$obj = izy::load('tb_bank', $request->params('id'));
	$obj->atas_nama = $request->params('atas_nama');
	$obj->jenis = $request->params('jenis');
	$obj->logo = str_replace(baseurlroot, '[baseurlroot]', $request->params('logo'));
	$obj->nama = $request->params('nama');
	$obj->rekening = $request->params('rekening');

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
	
	$row = izy::findOne('tb_bank', 'nama=?', array($request->params('id')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'nama';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'naama';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$smarty->assign('datajenis', fetchJenis());
	$smarty->display(basepath.'/modules/payment/add-payment.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('datajenis', fetchJenis());
	$smarty->assign('content', basepath.'/modules/payment/add-payment.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$barisdiinginkan = $request->params('jumlahbaris');
	$filterdata = $request->params('pilihfilter');
	$halaman = $request->params('halaman');
	$cari = $request->params('cari');

	$catid = $request->params('category');
	$filter_kategory = "";
	if($catid != ''){
		$filter_kategory = " AND A.jenis = '$catid' ";
	}

	$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
	$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.*
	FROM tb_bank A 
	WHERE A.id IS NOT NULL $filter_query $filter_kategory
	ORDER BY A.jenis ASC, A.nama ASC ";
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

	$smarty->assign('datajenis', fetchJenis());
	$smarty->display(basepath.'/modules/payment/view-payment.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	

	$smarty->assign('datajenis', fetchJenis());

	$smarty->assign('content', basepath.'/modules/payment/view-payment.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchJenis(){
	$data = array();
	$data[1]['value'] = 'bank';
	$data[1]['text'] = 'Akun bank';

	$data[2]['value'] = 'paypal';
	$data[2]['text'] = 'Paypal';

	return $data;
}
?>