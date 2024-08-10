<?php
if (!defined('basepath')) {
	exit('<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>');
}

//-- router 
$app->get('/login', 'viewlogin')->name('novalidate');
$app->post('/login/validate', 'validatelogin')->name('novalidate');
$app->post('/login/submit', 'submitlogin')->name('novalidate');

//-- bagian controllernya
function viewlogin(){	
	if(isset($_SESSION['login_admin'])){
		$app = \Slim\Slim::getInstance();
		$app->redirect(baseurl . '/dashboard');
	}
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->display(basepath."/modules/login/login.tpl");
}

function validatelogin(){
	require_once basepath.'/libraries/securimage/securimage.php';

	$app = \Slim\Slim::getInstance();
	$request = $app->request();
	
	$arrayToJs = array();
	$i = 0;
	
	validatesessionform($request->params('sessionform'));
			
	$textcaptcha = $request->params('textcaptcha');
	
	if (strtolower($_SESSION['securimage_code_value'] == strtolower($_REQUEST['textcaptcha']))) {
			$arrayToJs[$i][0] = 'textcaptcha';
			$arrayToJs[$i][1] = true;
			//$arrayToJs[$i][2] = "Correct Captcha";
		} else {
			$arrayToJs[$i][0] = 'textcaptcha';
			$arrayToJs[$i][1] = false;
			$arrayToJs[$i][2] = "Wrong Captcha";
		}
	
	
	echo json_encode($arrayToJs);

};

function submitlogin(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$username = $request->params('username');
	$password = ($request->params('password'));
	
	$user = izy::findOne('tb_users', 'username=? AND password=?', array($username, $password));
	
	if($user->username == $username){
		$user->tracking = session_id();
		izy::store($user);
		//$grupuser = izy::findOne('tb_grupuser', 'grupuser=?', array($user->grupuser));
		$_SESSION['login_admin'] = $user->export();
		$_SESSION['login_admin']['session_id'] = session_id();
		$_SESSION['login_admin']['sessid'] = session_id();
		$_SESSION['login_admin']['idgrupuser'] = $grupuser->id;
		//$_SESSION[session_id()]['datamenu'] = getMenuAdmin();
		$_SESSION['login_status'] = TRUE;
		echo "success";
	}else{
		$_SESSION['login_status'] = TRUE;
		echo 'failed';	
	}
	
};
?>
