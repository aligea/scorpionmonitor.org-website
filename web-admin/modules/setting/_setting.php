<?php
//-- router
$app->get('/setting', 'viewsetting')->name('setting-view');
$app->post('/setting', 'postsetting')->name('setting-view');
$app->post('/setting/query-update', 'updatesetting')->name('setting-view');

//-- controller
function updatesetting(){
	include basepath.'/libraries/class/json.php';
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$allsettings = new stdClass;
	$setting = izy::load('tb_settings', 1);
	$allsettings->alamat = $request->params('alamat');
	$allsettings->email = $request->params('email');
	$allsettings->facebook = $request->params('facebook');
	$allsettings->favico = str_replace(baseurlroot, '[baseurlroot]', $request->params('favico'));
	$allsettings->kota = $request->params('kota');
	$allsettings->logo = str_replace(baseurlroot, '[baseurlroot]', $request->params('favico'));
	$allsettings->maintenance = $request->params('maintenance');
	$allsettings->metadesc = $request->params('metadesc');
	$allsettings->metakey = $request->params('metakey');
	$allsettings->metatitle = $request->params('metatitle');
	$allsettings->nama = $request->params('nama');
	$allsettings->pengumuman = $request->params('pengumuman');
	$allsettings->setadd = $request->params('setadd');
	$allsettings->telpon = $request->params('telpon');
	$allsettings->twitter = $request->params('twitter');
	$allsettings->instagram = $request->params('instagram');
	$allsettings->path_user = $request->params('path_user');
	$allsettings->image_product_width = $request->params('image_product_width');;
	$allsettings->image_product_height = $request->params('image_product_height');;
	$allsettings->image_banner_width = $request->params('image_banner_width');;
	$allsettings->image_banner_height = $request->params('image_banner_height');;
	$allsettings->script_head = $request->params('script_head');
	$allsettings->script_body = $request->params('script_body');

	$setting->value = json_encode($allsettings);

	


	$result = "";
	izy::begin();
	try {
		izy::store($setting);

		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}


function postsetting(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$setting = izy::load('tb_settings', 1);
	$allsettings = json_decode($setting->value, true);


	$smarty->assign("allsettings", $allsettings);

	$smarty->assign('datatemplate', dataTemplate());

	$smarty->assign('setting', $datasetting);
	$smarty->display(basepath.'/modules/setting/post-setting.tpl');
}

function viewsetting(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$setting = izy::load('tb_settings', 1);
	$allsettings = json_decode($setting->value, true);


	$smarty->assign("allsettings", $allsettings);

	$smarty->assign('datatemplate', dataTemplate());
	$smarty->assign('setting', $setting);
	$smarty->assign('content', basepath.'/modules/setting/post-setting.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function dataTemplate(){
	$template = array();
	$rootfolder =  realpath(basepath.'/..');
	$templatePath = $rootfolder.'/template';
	if(!is_dir($templatePath)){
		$templatePath = $rootfolder.'/templates';
	}

	$templateFolder = scandir($templatePath);
	foreach ($templateFolder as $content) {
		if ($content != "." && $content != "..") {
			$template[] = $content;
		}
	}
	return $template;
}
?>