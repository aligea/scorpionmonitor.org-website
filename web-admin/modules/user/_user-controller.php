<?php
//-- router
$app->get('/user', 'getview')->name('user-view');
$app->post('/user', 'postview')->name('user-view');

$app->get('/user/add', 'getadd')->name('user-insert');
$app->post('/user/add', 'postadd')->name('user-insert');

$app->get('/user/edit/:id', 'getedit')->name('user-update');
$app->post('/user/edit/:id', 'postedit')->name('user-update');

$app->post('/user/data', 'fetchdata')->name('user-view-query');
$app->post('/user/validate', 'validate')->name('novalidate');
$app->post('/user/query-insert', 'insertdata')->name('user-insert-query');
$app->post('/user/query-update', 'updatedata')->name('user-update-query');
$app->post('/user/query-delete', 'deletedata')->name('user-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_user', $id);
	
	$smarty->assign('datagrupuser', fetchGrupuser());
	$smarty->assign('data', $data);
	$smarty->display(basepath.'/modules/user/edit-user.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_user', $id);
	
	$smarty->assign('datagrupuser', fetchGrupuser());
	$smarty->assign('data', $data);
	$smarty->assign('content', basepath.'/modules/user/edit-user.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_user where id=?', array($dataid));	
		
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

	$obj = izy::dispense('tb_user');
	$obj->grupuser = $request->params('grupuser');
	$obj->username = $request->params('username');
	$obj->email = $obj->username;
	$obj->nama = $request->params('nama');
	$obj->telp = $request->params('telp');
	$obj->password = $request->params('password');

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

	$obj = izy::load('tb_user', $request->params('id'));
	$obj->grupuser = $request->params('grupuser');
	$obj->username = $request->params('username');
	$obj->email = $obj->username;
	$obj->nama = $request->params('nama');
	$obj->telp = $request->params('telp');
	$obj->password = $request->params('password');

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
	
	$row = izy::findOne('tb_user', 'email=?', array($request->params('username')));
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
	
	$smarty->assign('datagrupuser', fetchGrupuser());
	$smarty->display(basepath.'/modules/user/add-user.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('datagrupuser', fetchGrupuser());
	$smarty->assign('content', basepath.'/modules/user/add-user.tpl');
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
		$filter_kategory = " AND grupuser = '$catid' ";
	}

	$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
	$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.*
	FROM tb_user A 
	WHERE A.id IS NOT NULL $filter_query $filter_kategory
	ORDER BY A.grupuser ASC, A.nama ASC ";
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


	$selectedgrup = $_REQUEST['grup'];
	$smarty->assign('selectedgrup', $selectedgrup);

	$smarty->assign('datagrupuser', fetchGrupuser());
	$smarty->display(basepath.'/modules/user/view-user.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$selectedgrup = $_REQUEST['grup'];
	$smarty->assign('selectedgrup', $selectedgrup);



	$smarty->assign('datagrupuser', fetchGrupuser());
	$smarty->assign('content', basepath.'/modules/user/view-user.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchGrupuser(){
	return izy::getAll("SELECT A.*
		FROM tb_grupuser A
		ORDER BY A.grupuser ASC");
}
?>