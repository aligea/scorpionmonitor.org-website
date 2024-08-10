<?php
//-- router
$app->get('/profile', 'getview')->name('profile-view');
$app->post('/profile', 'postview')->name('profile-view');

$app->post('/profile/validate', 'validate')->name('novalidate');
$app->post('/profile/query-update', 'updatedata')->name('profile-view');

//-- controller
function updatedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$obj = izy::load('tb_users', $request->params('id'));
	
	$obj->username = $request->params('username');
	$obj->email = $obj->username;
	$obj->name = $request->params('name');
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
	
	$row = izy::findOne('tb_users', 'username=?', array($request->params('username')));
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

function postview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();



	$smarty->assign('data', getLoginUser());

	$smarty->display(basepath.'/modules/profile/view-profile.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();


	$smarty->assign('data', getLoginUser());


	$smarty->assign('content', basepath.'/modules/profile/view-profile.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function getLoginUser(){
	return izy::load('tb_users', $_SESSION['login_admin']['id']);
}
?>