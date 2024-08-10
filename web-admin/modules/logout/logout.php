<?php
$app->get('/logout', function() use ($app){
	unset($_COOKIE);
	unset($_SESSION['login_admin']);
	unset($_SESSION['login_status']);
	session_regenerate_id();
	echo 'please wait...';
	
	$app->redirect(baseurl.'/login');
})->name('novalidate');

?>