<?php
//-- router
$app->get('/groupuser', 'getview')->name('groupuser-view');
$app->post('/groupuser', 'postview')->name('groupuser-view');

$app->get('/groupuser/add', 'getadd')->name('groupuser-insert');
$app->post('/groupuser/add', 'postadd')->name('groupuser-insert');

$app->get('/groupuser/edit/:id', 'getedit')->name('groupuser-update');
$app->post('/groupuser/edit/:id', 'postedit')->name('groupuser-update');

$app->post('/groupuser/data', 'fetchdata')->name('groupuser-view-query');
$app->post('/groupuser/validate', 'validate')->name('novalidate');
$app->post('/groupuser/query-insert', 'insertdata')->name('groupuser-insert-query');
$app->post('/groupuser/query-update', 'updatedata')->name('groupuser-update-query');
$app->post('/groupuser/query-delete', 'deletedata')->name('groupuser-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_grupuser', $id);	

	$smarty->assign('data', $data);
	$smarty->display(basepath.'/modules/groupuser/edit-groupuser.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_grupuser', $id);
	

	$smarty->assign('data', $data);
	$smarty->assign('content', basepath.'/modules/groupuser/edit-groupuser.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_grupuser where id=?', array($dataid));	
		
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

	$obj = izy::dispense('tb_grupuser');
	$obj->grupuser = $request->params('grupuser');

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

	$oldRow = izy::getRow('SELECT * FROM tb_grupuser WHERE id =?', array($request->params('id')));
	$obj = izy::load('tb_grupuser', $request->params('id'));
	$obj->grupuser = $request->params('grupuser');
	

	$result = "";
	izy::begin();
	try {
		//-- update tb_grupuser
		$data_id = izy::store($obj);

		//-- update tb_user dengan grup user lama
		izy::exec("UPDATE tb_user SET grupuser=:grupbaru WHERE grupuser=:gruplama", array(
				'grupbaru'=>$obj->grupuser,
				'gruplama'=>$oldRow['grupuser']
			));

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
	
	$row = izy::findOne('tb_grupuser', 'grupuser=?', array($request->params('grupuser')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'grupuser';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'grupuser';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	
	$smarty->display(basepath.'/modules/groupuser/add-groupuser.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();


	$smarty->assign('content', basepath.'/modules/groupuser/add-groupuser.tpl');
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
	$sql = "SELECT A.*, (SELECT COUNT(B.id) FROM tb_user B WHERE B.grupuser = A.grupuser ) AS jumlahuser
	FROM tb_grupuser A
	WHERE A.id IS NOT NULL $filter_query
	ORDER BY A.grupuser ASC ";
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


	$smarty->display(basepath.'/modules/groupuser/view-groupuser.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('content', basepath.'/modules/groupuser/view-groupuser.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}


?>