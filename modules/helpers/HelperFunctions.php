<?php

class Helper {

   static function getCurrentUrl() {
      $app = \Slim\Slim::getInstance();
      $currenturl = baseurl . $app->request()->getResourceUri();
      $ekor = substr($currenturl, -1, 1);
      if ($ekor == '/') {
         $currenturl = substr($currenturl, 0, strlen($currenturl) - 1);
      }
      
      //$currenturl = str_replace('//', '/', $currenturl);     
      
      return $currenturl;
   }

   static function prevent_indexphp() {
      $app = \Slim\Slim::getInstance();
      $rooturi = str_replace('index.php', '', $app->request->getRootUri());

      //-- batasi penggunaan index.php
      if (in_array('index.php', explode('/', $_SERVER['REQUEST_URI']))) {
         $app->redirect($rooturi);
         //$app->redirect(baseurl.'/');
      }
   }

   static function validate_session_form($sessionform) {
      if ($sessionform != $_SESSION['sessionform']) {
         exit('No direct access allowed');
      }
   }

   static function create_session_form() {
      $string = str_replace('==', '', base64_encode(session_id()));
      $_SESSION['sessionform'] = substr($string, strlen($string) - 4);
      return $sessionform = $_SESSION['sessionform'];
   }

   static function create_form_token($formname) {
      $token = random_string('alnum', 4);
      $_SESSION['token'][$formname] = $token;

      return $_SESSION['token'][$formname];
   }

   static function validate_form_token($token, $formname) {
      if ($_SESSION['token'][$formname] == $token) {
         return true;
      } else {
         return false;
      }
   }

   static function init_login_customer() {
      if ($_SESSION['login_customer']['token'] !== session_id()) {
         unset($_SESSION['login_customer']);
      }
      $login_customer = (!$_SESSION['login_customer']) ? array() : $_SESSION['login_customer'];

      return $login_customer;
   }

   static function resize_image($source, $width, $height) {
      include_once basepath . '/libraries/php-image-magician/php_image_magician.php';
      //$source = 'images/Desert.jpg';
      //$path=array(PATHINFO_DIRNAME,PATHINFO_BASENAME,PATHINFO_EXTENSION,PATHINFO_FILENAME);

      $source = str_replace('[baseurlroot]', baseurlroot, $source);

      if ($source == '') {
         return $source;
      }

      //-- jika file di internal server, lalu file gambar tsb tidak ada ?
      //-- jika file gambar eksternal, lalu url gambar nya gak valid ?
      //-- jika source gambar tidak ada, maka keluar dari fungsi ini
      $is_file_in_localserver = (strpos($source, baseurlroot) == false) ? false : true;
      if ($is_file_in_localserver) {
         if (!file_exists(str_replace(baseurlroot, basepath, $source))) {
            return $source;
         }
      } else {
         $file_headers = @get_headers($source);
         if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return $source;
         }
      }


      //-- jika folder images/ temp tidak ada, maka create folder tsb dulu
      if (!is_dir(basepath . '/images/temp')) {
         mkdir(basepath . '/images/temp');
      }

      //-- sesuaikan nama folder dengan ukuran gambar
      $foldername = $width . 'x' . $height;
      if (!is_dir(basepath . '/images/temp/' . $foldername)) {
         mkdir(basepath . '/images/temp/' . $foldername);
      }

      //-- sesuaikan nama file gambar yang baru
      $uniqmaker = substr(md5($source), 0, 8);
      $filename = $uniqmaker . '_' . friendlyString(pathinfo($source, PATHINFO_FILENAME));
      $file = $filename . '_' . $width . 'x' . $height . '.' . pathinfo($source, PATHINFO_EXTENSION);

      //-- konversi gambar baru, output nya berupa url gambar
      $outputfile = basepath . '/images/temp/' . $foldername . '/' . $file;
      if (is_file($outputfile)) {
         return str_replace(basepath, baseurl, $outputfile);
      }

      $magicianObj = new imageLib($source);

      $magicianObj->resizeImage($width, $height, 'crop');
      $magicianObj->saveImage($outputfile);
      return str_replace(basepath, baseurl, $outputfile);
   }

   static function friendlyString($str) {
      $alias = preg_replace('/[^A-Za-z0-9\']/', '-', $str);
      $alias = str_replace(' ', '-', $alias);
      $alias = str_replace('---', '-', $alias);
      $alias = str_replace('--', '-', $alias);

      return $alias;
   }

   static function Smarty() {
      $smarty = new Smarty;
      //$smarty->caching = FALSE;

      $smarty->assign('waktu_server', date("F d, Y H:i:s", time()));
      $smarty->assign('basepath', basepath);
      $smarty->assign('baseurl', baseurl);
      $smarty->assign('baseurlroot', baseurlroot);

      return $smarty;
   }

   static function newSmarty() {
      return smarty();
   }

   static function selfURL() {
      $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
      $protocol = self::strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
      $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
      return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
   }

   static function strleft($s1, $s2) {
      return substr($s1, 0, strpos($s1, $s2));
   }

   static function convert_string_to_integer($str) {
      $str = str_replace(array('+', '-'), '', $str);
      preg_match_all('!\d+!', $str, $matches);
      $result = end($matches[0]);
      $result = ltrim($result, '0');
      return (int) $result;
   }

   static function namahari_indo($yyyymmdd) {
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

   static function namabulan_indo($yyyymmdd) {
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

   static function pembilang_waktu_jam_menit($jumlahmenit) {
      $jumlahjam = floor($jumlahmenit / 60);
      $sisamenit = $jumlahmenit % 60;
      if ($jumlahmenit < 60) {
         return $jumlahmenit . ' menit';
      }
      if ($sisamenit == 0) {
         return $jumlahjam . ' jam';
      } else {
         return $jumlahjam . " jam, " . $sisamenit . " menit";
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

   static function fix_url($url) {
      /*
       * ../images/bla..bla..bla
       * [baseurlroot]/../imasdf
       * images/asd
       * http://
       */
      $url = urldecode($url);
      $url = str_replace('../', '', $url);
      $url = str_replace('[baseurlroot]/', '', $url);
      $url = str_replace('[baseurl]/', '', $url);

      $urlpath = $url;
      if (strpos($url, 'http') == false) {
         //return $url;
      } else {
         //return baseurl.'/'.$url;
         $urlpath = baseurl . '/' . $url;
      }

      if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
         $urlpath = baseurl . '/' . $url;
      }


      return self::fix_filename_url($urlpath);
   }

   static function fix_content_url($content) {
      $content = str_replace('../', baseurl . '/', $content);
      $content = str_replace('[baseurlroot]/', baseurl . '/', $content);
      $content = str_replace('[baseurl]/', baseurl . '/', $content);
      $content = html_entity_decode($content);

      return $content;
   }

   static function fix_filename_url($urlpath) {
      $file = basename($urlpath);
      $newfilename = rawurlencode($file);
      return str_replace($file, $newfilename, $urlpath);
   }

   static function fix_path($content) {
      $content = urldecode($content);
      $content = str_replace(baseurl, basepath, $content);

      return $content;
   }

   static function create_fake_filename($filename) {
      $filename = self::fix_url($filename);
      
      /*
      ** yang lama--> $fake_filename = substr(md5($filename), -5);
      ** diganti biarin md5 dari nama file tersebue
      */
      
      $fake_filename = md5($filename);
      
      
      $_SESSION['temp'][$fake_filename] = $filename;
      return $fake_filename;
   }

   static function get_filename($fakepath) {
      $filename = $fakepath;
      if ($_SESSION['temp'][$fakepath]) {
         $filename = $_SESSION['temp'][$fakepath];
      }
      return $filename;
   }

}

?>