<?php
function initApp(){
$app = \Slim\Slim::getInstance();
$rooturi = $app->request->getRootUri();

		//-- batasi penggunaan index.php
		if (in_array('index.php', explode('/', $_SERVER['REQUEST_URI']))) {
			$app->redirect(baseurl.'/');
		}

		//-- cek halaman root jika sudah/belum login
		$pathinfo = $app->request()->getResourceUri();
		if ($pathinfo == '/') {
			if (!isset($_SESSION['login_admin'])) {
				$app->redirect(baseurl . '/login');
			} else {
				$app->redirect(baseurl . '/dashboard');
			}
		}

		//-- cek hanya modul login yang bisa diakses jika belum login
		if (!in_array('login', explode('/', $pathinfo))) {
			if (!isset($_SESSION['login_admin'])) {
				$app->redirect(baseurl . '/login');
			}else{
				cekSessionLoginUser();
			}
			
		}

}

function authLoginUser(){
	$app = \Slim\Slim::getInstance();
	$modulePack = $app->router->getCurrentRoute()->name;
	$modulename = explode('-', $modulePack)[0];
	$moduleType = explode('-', $modulePack)[1];
	$moduleQuery = (explode('-', $modulePack)[2] == 'query')? true : false;


	if($modulename == 'novalidate' || $_SESSION['mode'] == 'development'){
		return;
	}

	//var_dump($app->request->getMethod());

	$otorisasiModul = izy::getRow("SELECT A.*, B.single_module
		FROM tb_otorisasi_admin A INNER JOIN tb_otorisasi_module_item B ON A.idmodul = B.id
		WHERE B.module = ? AND A.idgrupuser = ? ",
		array($modulename, $_SESSION['login_admin']['idgrupuser']));

	if(!$modulename){
		//die('Unknown module');
		$app->halt(500, 'Unknown module. <a href="'.$app->request->getRootUri().'">Visit the Home Page</a>');
	}

	if(!$otorisasiModul && $modulename != 'novalidate'){
		//die('Module not registered.');
		$app->halt(500, 'Module not registered. <a href="'.$app->request->getRootUri().'">Visit the Home Page</a>');
	}

	if($otorisasiModul['single_module'] == 1){
		$moduleType = 'view';
	}

	if($otorisasiModul['is_can_'.$moduleType] == 0){
		if(strtolower($app->request->getMethod()) == 'get'){
			showAccessDenied1();
		}else{
			showAccessDenied2();
		}
		
		$app->stop();
	}
}

function showAccessDenied2(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->display(basepath.'/modules/denied-template1.tpl');
}

function showAccessDenied1(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->assign('content', basepath.'/modules/denied-template1.tpl');
	$smarty->display(basepath.'/modules/main.tpl');
}

function getMenuAdmin(){
	$datamenu = array();
	$db = mysqliConnection();
	$sql = "SELECT A.id, B.groupmenu, C.icon, B.menu, B.module
FROM tb_otorisasi_admin A INNER JOIN tb_otorisasi_module_item B ON A.idmodul = B.id INNER JOIN tb_otorisasi_groupmenu C ON B.groupmenu = C.nama
WHERE B.is_menu = 1 AND A.idgrupuser = ?
ORDER BY C.urut ASC, B.urut ASC";

	$dataresult = izy::getAll($sql, array($_SESSION['login_admin']['idgrupuser']));

	foreach ($dataresult as $row) {
		//-- jika modul folder tidak ada maka gak usah di tampilkan, walau terdaftar di database.
		$modulefolder = basepath.'/modules/'.$row['module'];
		if(!is_dir($modulefolder)){
			continue;
		}

		$datamenu[$row['groupmenu']]['nama'] = $row['groupmenu'];
		$datamenu[$row['groupmenu']]['icon'] = $row['icon'];
		$datamenu[$row['groupmenu']]['datamodul'][$row['id']]['menu'] = $row['menu'];
		$datamenu[$row['groupmenu']]['datamodul'][$row['id']]['module'] = $row['module'];
	}
	
	$dataresult = null;
	return $datamenu;
}


function cekSessionLoginUser(){
	$loginuser = izy::load('tb_users', $_SESSION['login_admin']['id']);
	if($loginuser->tracking != $_SESSION['login_admin']['sessid']){
		unset($_SESSION['login_admin']);
		$app = \Slim\Slim::getInstance();
		$app->redirect(baseurl . '/login');
	}
}

function validatesessionform($sessionform){
	if($sessionform != $_SESSION['sessionform']){
		exit('No direct access allowed');
	}
}

function createsessionform(){
	$string = str_replace('==', '', base64_encode(session_id()));
	$_SESSION['sessionform'] = substr($string, strlen($string)-4);
	return $sessionform  = $_SESSION['sessionform'];
}

function Smarty(){
	$smarty = new Smarty;
	$smarty->caching = FALSE;
	
	if(isset($_SESSION['login_admin'])){
		$smarty->assign('login_admin', $_SESSION['login_admin']);
	}
	$setting = izy::load('tb_settings', 1);
	$allsettings = json_decode($setting->value, true);


	$smarty->assign("allsettings", $allsettings);	
	$smarty->assign('sessionform', createsessionform());
	$smarty->assign('waktu_server', date("F d, Y H:i:s", time()));
	$smarty->assign('basepath', basepath);
	$smarty->assign('baseurl', baseurl);
	$smarty->assign('baseurlroot', baseurlroot);
	$smarty->assign('datamenu', $_SESSION[session_id()]['datamenu']);
	
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
class Helper{
	function __construct(){

	}

	static function prevent_indexphp(){
		$app = \Slim\Slim::getInstance();
		$rooturi = str_replace('index.php', '', $app->request->getRootUri());
		
		//-- batasi penggunaan index.php
		if (in_array('index.php', explode('/', $_SERVER['REQUEST_URI']))) {
			$app->redirect($rooturi);
			//$app->redirect(baseurl.'/');
		}		
	}

	static function validate_session_form($sessionform){
		if($sessionform != $_SESSION['sessionform']){
			exit('No direct access allowed');
		}
	}

	static function create_session_form(){
		$string = str_replace('==', '', base64_encode(session_id()));
		$_SESSION['sessionform'] = substr($string, strlen($string)-4);
		return $sessionform  = $_SESSION['sessionform'];
	}

	static function create_form_token($formname){
		$token = random_string('alnum', 4);
		$_SESSION['token'][$formname] = $token;

		return $_SESSION['token'][$formname];
	}

	static function validate_form_token($token, $formname){
		if($_SESSION['token'][$formname] == $token){
			return true;
		}else{
			return false;
		}
	}

	static function init_login_customer(){	
		if($_SESSION['login_customer']['token'] !== session_id()){
			unset($_SESSION['login_customer']);
		}
		$login_customer = (!$_SESSION['login_customer'])? array() : $_SESSION['login_customer'];

		return $login_customer;
	}

	static function resize_image($source, $width, $height){
		include_once basepath.'/libraries/php-image-magician/php_image_magician.php';
		//$source = 'images/Desert.jpg';
		//$path=array(PATHINFO_DIRNAME,PATHINFO_BASENAME,PATHINFO_EXTENSION,PATHINFO_FILENAME);

		$source = str_replace('[baseurlroot]', baseurlroot, $source);

		if($source == ''){
			return $source;
		}
		
		//-- jika file di internal server, lalu file gambar tsb tidak ada ?
		//-- jika file gambar eksternal, lalu url gambar nya gak valid ?
		//-- jika source gambar tidak ada, maka keluar dari fungsi ini
		$is_file_in_localserver = (strpos($source, baseurlroot) == false) ? false : true;
		if($is_file_in_localserver){
			if(!file_exists(str_replace(baseurlroot, basepath, $source))){
				return $source;
			}
		}else{
			$file_headers = @get_headers($source);
			if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
				return $source;
			}
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
		$uniqmaker = substr(md5($source), 0, 8);
		$filename = $uniqmaker.'_'.friendlyString(pathinfo($source, PATHINFO_FILENAME));
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

	static function friendlyString($str){
	    $alias = preg_replace('/[^A-Za-z0-9\']/', '-', $str);
	    $alias = str_replace(' ', '-', $alias);
	    $alias = str_replace('---', '-', $alias);
	    $alias = str_replace('--', '-', $alias);

	    return $alias;
	}

	static function Smarty(){
		$smarty = new Smarty;
		//$smarty->caching = FALSE;
		
		$smarty->assign('waktu_server', date("F d, Y H:i:s", time()));
		$smarty->assign('basepath', basepath);
		$smarty->assign('baseurl', baseurl);
		$smarty->assign('baseurlroot', baseurlroot);
		
		return $smarty;
	}

	static function newSmarty(){
		return smarty();
	}

	static function selfURL(){ 
	    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
	    $protocol = self::strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
	    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
	} 

	static function strleft($s1, $s2) { 
		return substr($s1, 0, strpos($s1, $s2)); 
	}

	static function convert_string_to_integer($str){
		$str = str_replace(array('+','-'), '', $str);
		preg_match_all('!\d+!', $str, $matches);
		$result = end($matches[0]);
		$result = ltrim($result, '0');
		return (int)$result;
	}

	static function namahari_indo($yyyymmdd){
		$hari = array();
		$hari[0] = 'Unknown';
		$hari[1] = 'Senin';
		$hari[2] = 'Selasa';
		$hari[3] = 'Rabu';
		$hari[4] = 'Kamis';
		$hari[5] = 'Jumat';
		$hari[6] = 'Sabtu';
		$hari[7] = 'Minggu';

		return $hari[date('N', strtotime($yyyymmdd))];
	}
	static function namabulan_indo($yyyymmdd){
		$bulan = array();
		$bulan[0] = 'Unknown';
		$bulan[1] = 'Januari';
		$bulan[2] = 'Februari';
		$bulan[3] = 'Maret';
		$bulan[4] = 'April';
		$bulan[5] = 'Mei';
		$bulan[6] = 'Juni';
		$bulan[7] = 'Juli';
		$bulan[8] = 'Agustus';
		$bulan[9] = 'September';
		$bulan[10] = 'Oktober';
		$bulan[11] = 'November';
		$bulan[12] = 'Desember';
		return $bulan[date('n', strtotime($yyyymmdd))];
	}
	static function pembilang_waktu_jam_menit($jumlahmenit){
		$jumlahjam = floor($jumlahmenit / 60);
		$sisamenit = $jumlahmenit % 60;
		if($jumlahmenit < 60){
			return $jumlahmenit.' menit';
		}
		if($sisamenit == 0){
			return $jumlahjam.' jam';
		}else{
			return $jumlahjam." jam, ".$sisamenit." menit";
		}
	}
	static function file_get_contents_curl($url) {
		$ch = curl_init();
	 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
	 
		$data = curl_exec($ch);
		curl_close($ch);
	 
		return $data;
	}
	static function fix_url($url){
		/*
		* ../images/bla..bla..bla
		* [baseurlroot]/../imasdf
		* images/asd
		* http://
		*/
		$url = urldecode($url);
		$url = str_replace('../', '', $url);
		$url = str_replace('[baseurlroot]/', '',$url);
		$url = str_replace('[baseurl]/', '',$url);

		$urlpath = $url;
		if (strpos($url,'http') == false) {
		   //return $url;
		}else{
			//return baseurl.'/'.$url;
			$urlpath = baseurl.'/'.$url;
		}

		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        	$urlpath = baseurl .'/'. $url;
    	}


		return self::fix_filename_url($urlpath);
	}

	static function fix_content_url($content){
		$content = str_replace('../', baseurl.'/', $content);
		$content = str_replace('[baseurlroot]/', baseurl.'/', $content);
		$content = str_replace('[baseurl]/', baseurl.'/', $content);
		$content = html_entity_decode($content);

		return $content;
	}

	static function fix_filename_url($urlpath){
		$file = basename($urlpath);
		$newfilename = rawurlencode($file);
		return str_replace($file, $newfilename, $urlpath);
	}

	static function fix_path($content){
		$content = urldecode($content);
		$content = str_replace(baseurl, basepath, $content);
	
		return $content;
	}

	static function create_fake_filename($filename){
		$filename = self::fix_url($filename);
		$fake_filename = substr(md5($filename), -5);
		$_SESSION['temp'][$fake_filename] = $filename;
		return $fake_filename;
	}

	static function get_filename($fakepath){
		$filename = $fakepath;
		if($_SESSION['temp'][$fakepath]){
			$filename = $_SESSION['temp'][$fakepath];
		}
		return $filename;
	}
}
?>