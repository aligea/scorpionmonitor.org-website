<?php
//-- router
$app->get('/dashboard', 'viewdashboard')->name('dashboard-view');
$app->post('/dashboard', 'postdashboard')->name('dashboard-view');

//-- controller
function postdashboard(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->display(basepath.'/modules/dashboard/post-dashboard.tpl');
}
function viewdashboard(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->assign('content', basepath.'/modules/dashboard/post-dashboard.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}
?>