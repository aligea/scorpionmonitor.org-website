<?php
function initApp(){
$app = \Slim\Slim::getInstance();

		//-- batasi penggunaan index.php
		if (in_array('index.php', explode('/', $_SERVER['REQUEST_URI']))) {
			redirect_to(baseurl . '/');
		}

		//-- cek halaman root jika sudah/belum login
		$pathinfo = $app->request()->getResourceUri();
		if ($pathinfo == '/') {
			if (!isset($_SESSION['login_admin'])) {
				redirectpage(baseurl . '/login');
			} else {
				redirectpage(baseurl . '/dashboard');
			}
		}

		//-- cek hanya modul login yang bisa diakses jika belum login
		if (!in_array('login', explode('/', $pathinfo))) {
			if (!isset($_SESSION['login_admin'])) {
				redirectpage(baseurl . '/login');
			}else{
				cekSessionLoginUser(); 
			}
			
		}

}

function redirectpage($url) {
	if (!headers_sent()) {
		//If headers not sent yet... then do php redirect
		header('Location: ' . $url);
		exit ;
	} else {
		//If headers are sent... do java redirect... if java disabled, do html redirect.
		echo '<script type="text/javascript">';
		echo 'window.location.href="' . $url . '";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
		echo '</noscript>';
		exit ;
	}
}

function Smarty(){
	$smarty = new Smarty;
	$smarty->caching = FALSE;
	
	if(isset($_SESSION['login_admin'])){
		//$smarty->assign('login_admin', $_SESSION['login_admin']);
	}
	$allsetting = izy::load('tb_settings', 1);
	$settings = json_decode($allsetting->value, true);

	$smarty->assign('settings', $settings);
	$smarty->assign('metadesc', $settings['metadesc']);
	$smarty->assign('metakey', $settings['metakey']);
	$smarty->assign('metatitle', $settings['metatitle']);

	$_SESSION['lang'] = 'en';
	$_SESSION['path'] = 'en';
	$smarty->assign('lang', $_SESSION['lang']);
	$smarty->assign('path', $_SESSION['path']);

	//-- fetch link page
	$navpage = izy::getAll("SELECT alias, title
		FROM tb_content 
		WHERE type='page'
		ORDER BY alias ASC, title ASC");
	$smarty->assign('navpage', $navpage);

	
	$smarty->assign('waktu_server', date("F d, Y H:i:s", time()));
	$smarty->assign('basepath', basepath);
	$smarty->assign('baseurl', baseurl);
	$smarty->assign('baseurlroot', baseurlroot);

	if($settings['maintenance'] == 'offline'){
		$smarty->display(basepath."/templates/offline.tpl");
		die();
	}
	
	return $smarty;
}

function newSmarty(){
	return smarty();
}

function friendlyString($str){
    $alias = preg_replace('/[^A-Za-z0-9\']/', '-', $str);
    $alias = str_replace(' ', '-', $alias);
    $alias = str_replace('---', '-', $alias);
    $alias = str_replace('--', '-', $alias);

    return $alias;
}

function fetchLastNews(){
    $datanews = izy::getAll("SELECT id, images, title, introtext, alias, created, publish_up 
        FROM tb_content WHERE type='news' AND state=1
        ORDER BY created DESC
        LIMIT 5");
    foreach ($datanews as $key => $value) {
    	$datanews[$key]['image_small'] = resizeImage($datanews[$key]['images'], $width=200, $height=150);
    }
    return $datanews;
}
function resizeImage($source, $width, $height){
	include_once basepath.'/libraries/php-image-magician/php_image_magician.php';
	//$source = 'images/Desert.jpg';
	//$path=array(PATHINFO_DIRNAME,PATHINFO_BASENAME,PATHINFO_EXTENSION,PATHINFO_FILENAME);
	$source = str_replace('[baseurlroot]', baseurlroot, $source);
	//$source = str_replace(baseurlroot, '', $source);

	//-- jika source gambar tidak ada, maka keluar dari fungsi ini
	if(!file_exists($source)){
		//return $source;
	}

	//-- jika folder images/ temp tidak ada, maka create folder tsb dulu
	if(!is_dir(basepath.'/images/temp')){
		mkdir(basepath.'/images/temp');
	}

	//-- sesuaikan nama folder dengan ukuran gambar
	$foldername = $width.'x'.$height;
	if(!is_dir(basepath.'/images/temp/'.$foldername)){
		mkdir(basepath.'/images/temp/'.$foldername);
	}

	//-- sesuaikan nama file gambar yang baru
	$filename = friendlyString(pathinfo($source, PATHINFO_FILENAME));
	$file = $filename.'_'.$width.'x'.$height.'.'.pathinfo($source, PATHINFO_EXTENSION);

	//-- konversi gambar baru, output nya berupa url gambar
	$outputfile = basepath.'/images/temp/'.$foldername.'/'.$file;
	if(is_file($outputfile)){
		return str_replace(basepath, baseurl, $outputfile);
	}

	$magicianObj = new imageLib($source);

	$magicianObj-> resizeImage($width, $height, 'crop');
	$magicianObj-> saveImage($outputfile);
	return str_replace(basepath, baseurl, $outputfile);
}


?>