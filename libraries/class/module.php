<?php
function toNum($data) {
    $alphabet = array( 'a', 'b', 'c', 'd', 'e',
                       'f', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
    $alpha_flip = array_flip($alphabet);
    $return_value = -1;
    $length = strlen($data);
    for ($i = 0; $i < $length; $i++) {
        $return_value +=
            ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
    }
    return $return_value;
}

function toAlpha($data){
    $alphabet =   array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    $alpha_flip = array_flip($alphabet);
        if($data <= 25){
          return $alphabet[$data];
        }
        elseif($data > 25){
          $dividend = ($data + 1);
          $alpha = '';
          $modulo;
          while ($dividend > 0){
            $modulo = ($dividend - 1) % 26;
            $alpha = $alphabet[$modulo] . $alpha;
            $dividend = floor((($dividend - $modulo) / 26));
          } 
          return $alpha;
        }

}

function mailto_order_mod($kodeproyek, $koderequest, $data){
	$subject = "Purchase Request [$koderequest]";
	$message = $data;

	if($_SERVER['SERVER_NAME'] != 'mjs1' && $_SERVER['SERVER_NAME'] != 'localhost'){
		//mail('it@mjsolusindo.com', $subject, $message);
	}
}

function mailto_request_mod($kodeproyek, $koderequest, $data){
	$subject = "Purchase Request [$koderequest]";
	$message = $data;

	if($_SERVER['SERVER_NAME'] != 'mjs1' && $_SERVER['SERVER_NAME'] != 'localhost'){
		//mail('it@mjsolusindo.com', $subject, $message);
	}
}

function mailto_developer_error_mod($error_message){
	$subject = 'ERROR '.time();
	$message = json_encode(array(
		'error'=>$error_message,
		'server'=>$_SERVER
		));

	if($_SERVER['SERVER_NAME'] != 'mjs1' && $_SERVER['SERVER_NAME'] != 'localhost'){
		mail('it@mjsolusindo.com', $subject, $message);
	}
	
}

function autorisasi_hapus(){
	$a = explode("/", $_SERVER['PHP_SELF']);
	$current_page = $a[count($a) - 1];
	$exeption = array('dashboard.php', 'index.php', 'main.php');

	$grupuser_id = $_SESSION['session_grupuserId'];
	$sql = "SELECT id FROM tb_autorisasi WHERE page='$current_page' AND groupuser='$grupuser_id' ";
	if($current_page == "delData.php"){
		$tabel = $_REQUEST['p'];
		$sql = "SELECT id FROM tb_autorisasi WHERE page='".$current_page."?p=$tabel' AND groupuser='$grupuser_id' ";
	}
	$qry = mysql_query($sql) or die(mysql_error());
	$cek = ($_SESSION['ses_groupuser'] != "MIS") ? mysql_num_rows($qry) : 1;
	if(!$cek){
		die('Akses ditolak, gagal hapus data');
		exit();
	}
}

function validatesessionform(){
	if($_REQUEST['sessionform'] != $_SESSION['sessionform']){
		exit('No direct access allowed');
	}
}

//-- sisip ali (07-05-2014)
function exportMysqlToXls($filename, $sql) {
	$filename = ($filename == "") ? "export.xls" : $filename;
	$xls = new ExportXLS($filename);

	$qry = mysql_query($sql) or die(mysql_error());

	$kolom = array();
	$i = 0;
	while ($rowfield = mysql_fetch_field($qry)) {
		$kolom[$i] = $rowfield -> name;
		$i++;
	}

	//-- head
	$xls -> addHeader($kolom);

	//-- body/data
	$data = array();
	$i = $j = 0;
	while ($rowdata = mysql_fetch_array($qry)) {
		for ($i = 0; $i < count($kolom); $i++) {
			$data[$j][$kolom[$i]] = $rowdata[$kolom[$i]];
		}

		$xls -> addRow($data[$j]);
		$j++;
	}

	//-- output
	$xls -> sendFile();
}

function exportMysqlToCsv($filename, $sql) {
	$csv_terminated = "\n";
	$csv_separator = ",";
	$csv_enclosed = '"';
	$csv_escaped = "\\";
	$sql_query = $sql;

	if ($filename == "") {
		$filename = "export.csv";
	}
	// Gets the data from the database
	$result = mysql_query($sql_query) or die(mysql_error());
	$fields_cnt = mysql_num_fields($result);
	$schema_insert = '';
	for ($i = 0; $i < $fields_cnt; $i++) {
		$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
		$schema_insert .= $l;
		$schema_insert .= $csv_separator;
	}// end for
	$out = trim(substr($schema_insert, 0, -1));
	$out .= $csv_terminated;
	// Format the data
	while ($row = mysql_fetch_array($result)) {
		$schema_insert = '';
		for ($j = 0; $j < $fields_cnt; $j++) {
			if ($row[$j] == '0' || $row[$j] != '') {
				if ($csv_enclosed == '') {
					$schema_insert .= $row[$j];
				} else {
					$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
				}
			} else {
				$schema_insert .= '';
			}
			if ($j < $fields_cnt - 1) {
				$schema_insert .= $csv_separator;
			}
		}// end for
		$out .= $schema_insert;
		$out .= $csv_terminated;
	}// end while
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Length: " . strlen($out));
	// Output to browser with appropriate mime type, you choose ;)
	header("Content-type: text/x-csv");
	//header("Content-type: text/csv");
	//header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=$filename");
	echo $out;
	exit ;
}
//--

function get_column($sql){
	$qry = mysql_query($sql) or die(mysql_error());
	$kolom = array();
	$i = 0;
	while($row = mysql_fetch_field($qry)){
		$kolom[$i] = $row->name;
		$i++;
	}
	mysql_free_result($qry);
	return $kolom;
}
function cekLogin() {
	if (!isset($_SESSION['session_userUser'])) {
		redirect("index.php");
	}
}

function cekLoginAdmin() {
	if (!isset($_SESSION['session_userAdmin'])) {
		redirect("logout.php");
	}
	
	//-- hanya satu user user satu aktif login
	$email = $_SESSION['session_userAdmin'];
	$sql = "SELECT sessid FROM tb_user WHERE email = '$email'";
	$qry = mysql_query($sql);
	$row = mysql_fetch_assoc($qry);
	if($row['sessid'] != session_id()){
		echo '<script>alert("User ini sedang aktif digunakan.");window.location="logout.php"</script>';
		//redirect('logout.php');
	}
}

function konversi($x) {
	$x = abs($x);
	$angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($x < 12) {
		$temp = " " . $angka[$x];
	} else if ($x < 20) {
		$temp = konversi($x - 10) . " belas";
	} else if ($x < 100) {
		$temp = konversi($x / 10) . " puluh" . konversi($x % 10);
	} else if ($x < 200) {
		$temp = " seratus" . konversi($x - 100);
	} else if ($x < 1000) {
		$temp = konversi($x / 100) . " ratus" . konversi($x % 100);
	} else if ($x < 2000) {
		$temp = " seribu" . konversi($x - 1000);
	} else if ($x < 1000000) {
		$temp = konversi($x / 1000) . " ribu" . konversi($x % 1000);
	} else if ($x < 1000000000) {
		$temp = konversi($x / 1000000) . " juta" . konversi($x % 1000000);
	} else if ($x < 1000000000000) {
		$temp = konversi($x / 1000000000) . " milyar" . konversi($x % 1000000000);
	}
	return $temp;
}

function tkoma($x) {
	$str = stristr($x, ",");
	$ex = explode(',', $x);
	if (($ex[1] / 10) >= 1) {
		$a = abs($ex[1]);
	}
	$string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	$a2 = $ex[1] / 10;
	$pjg = strlen($str);
	$i = 1;
	if ($a >= 1 && $a < 12) {
		$temp .= " " . $string[$a];
	} else if ($a > 12 && $a < 20) {
		$temp .= konversi($a - 10) . " belas";
	} else if ($a > 20 && $a < 100) {
		$temp .= konversi($a / 10) . " puluh" . konversi($a % 10);
	} else {
		if ($a2 < 1) {
			while ($i < $pjg) {
				$char = substr($str, $i, 1);
				$i++;
				$temp .= " " . $string[$char];
			}
		}
	}
	return $temp;
}

function terbilang($x) {
	if ($x < 0) {
		$hasil = "minus " . trim(konversi(x));
	} else {
		$poin = trim(tkoma($x));
		$hasil = trim(konversi($x));
	}
	if ($poin) {
		$hasil = $hasil . " koma " . $poin;
	} else {
		$hasil = $hasil;
	}
	return $hasil;
}

function tanggal_indonesia($tanggal) {
	$tglArr = explode("-", $tanggal);
	switch ($tglArr[1]) {
		case '01' :
			$bulan = "Jan";
			break;
		case '02' :
			$bulan = "Feb";
			break;
		case '03' :
			$bulan = "Mar";
			break;
		case '04' :
			$bulan = "Apr";
			break;
		case '05' :
			$bulan = "Mei";
			break;
		case '06' :
			$bulan = "Juni";
			break;
		case '07' :
			$bulan = "Juli";
			break;
		case '08' :
			$bulan = "Agst";
			break;
		case '09' :
			$bulan = "Sept";
			break;
		case '10' :
			$bulan = "Okt";
			break;
		case '11' :
			$bulan = "Nov";
			break;
		case '12' :
			$bulan = "Des";
			break;
	}

	$idt = $tglArr[2] . "-" . $bulan . "-" . $tglArr[0];
	return $idt;
}

function random_string($l = 10) {
	$c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxwz0123456789";
	for (; $l > 0; $l--)
		$s .= $c{rand(0, strlen($c))};
	return str_shuffle($s);
}

function ganti_kata($arrkata, $kataganti, $kalimat) {
	$hasil = str_replace($arrkata, $kataganti, $kalimat);
	return $hasil;
}

function page($page) {
	$sqlpage = "select * from tb_pages where page='" . $page . "'";
	$qrypage = mysql_query($sqlpage);
	$rowpage = mysql_fetch_array($qrypage);
	echo $rowpage['content'];
}

function tampilbanner($posisi, $url, $css) {
	if ($posisi == "") {
		$posisi = "atas";
	}

	$sqlbanner = "SELECT * FROM dbbanner WHERE jenis='" . $posisi . "' ORDER BY id DESC";
	$qrybanner = mysql_query($sqlbanner);
	if (mysql_num_rows($qrybanner) > 0) {
		echo "<ul class='" . $css . "'>";
		while ($rowbanner = mysql_fetch_array($qrybanner)) {
			$namafilegambar = pisahstring($rowbanner['banner'], ".", 0);
			echo '<li class="' . $css . '">';
			echo '<img src="images/banner/' . $rowbanner['banner'] . '" style="border:none;" />';
			echo '</li>';
		}
	}
	echo "</ul>";
}

function tampilbanner1($posisi, $url, $dbconn) {
	if ($posisi == "") {
		$posisi = "atas";
	}

	echo "<ul>";
	$sqlbanner = "SELECT * FROM dbbanner WHERE jenis='" . $posisi . "' ORDER BY id DESC";
	$qrybanner = mysql_query($sqlbanner, $dbconn);

	if (mysql_num_rows($qrybanner) > 0) {
		while ($rowbanner = mysql_fetch_array($qrybanner)) {
			$namafilegambar = pisahstring($rowbanner['banner'], ".", 0);
			echo '<li>';
			if ($url <> "") {
				echo '<a href="images/banner/' . $namafilegambar . '_LRG.jpg" >';
			}
			echo '<img src="images/banner/' . $rowbanner['banner'] . '" />';
			if ($url <> "") {
				echo '</a>';
			}
			echo '</li>';
		}
		echo '<li><br clear:"all" /></li>';
		echo "</ul>";
	}
}

function pisahstring($kalimat, $simbol, $angka) {
	$array_string = explode($simbol, $kalimat);
	$kata = $array_string[$angka];
	return $kata;
}
function namahari($tanggal) {
	$a = explode('-', $tanggal);
	return hari($a[2], $a['1'], $a['0']);
}
function hari($hari, $bulan, $tahun) {
	$hari = mktime(0, 0, 0, $bulan, $hari, $tahun);
	$hari = date("D", $hari);
	switch ($hari) {
		case "Sun" :
			$hari = "Minggu";
			break;
		case "Mon" :
			$hari = "Senin";
			break;
		case "Tue" :
			$hari = "Selasa";
			break;
		case "Wed" :
			$hari = "Rabu";
			break;
		case "Thu" :
			$hari = "Kamis";
			break;
		case "Fri" :
			$hari = "Jumat";
			break;
		case "Sat" :
			$hari = "Sabtu";
			break;
	}
	return $hari;
}

function bulan($bulan) {
	switch ($bulan) {
		case "Jan" :
			$bulan = "01";
		case "Feb" :
			$bulan = "02";
		case "Mar" :
			$bulan = "03";
		case "Apr" :
			$bulan = "04";
		case "May" :
			$bulan = "05";
		case "Jun" :
			$bulan = "06";
		case "Jul" :
			$bulan = "07";
		case "Aug" :
			$bulan = "08";
		case "Sep" :
			$bulan = "09";
		case "Oct" :
			$bulan = "10";
		case "Nov" :
			$bulan = "11";
		case "Dec" :
			$bulan = "12";
	}
	return $bulan;
}

function redirect($url) {
	if (!headers_sent()) {//If headers not sent yet... then do php redirect
		header('Location: ' . $url);
		exit ;
	} else {//If headers are sent... do java redirect... if java disabled, do html redirect.
		echo '<script type="text/javascript">';
		echo 'window.location.href="' . $url . '";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
		echo '</noscript>';
		exit ;
	}
}//==== End -- Redirect

function rupiah($angka) {
	$rupiah = "";
	$rp = strlen($angka);
	while ($rp > 3) {
		$rupiah = "." . substr($angka, -3) . $rupiah;
		$s = strlen($angka) - 3;
		$angka = substr($angka, 0, $s);
		$rp = strlen($angka);
	}
	$rupiah = $angka . $rupiah . ",-";
	return $rupiah;
}

function spasi($cvar) {
	$angka = strlen($cvar);
	switch($angka) {
		case 1 :
			$hasil = "&nbsp;&nbsp;" . $cvar;
			break;
		case 2 :
			$hasil = "&nbsp;" . $cvar;
			break;
		case 3 :
			$hasil = "" . $cvar;
			break;
	}
	return $hasil;
}

function ymstatus($yahooid, $img_ol_path, $img_off_path, $title) {
	$yahoo_url = "http://opi.yahoo.com/online?u={$yahooid}&m=a&t=1";
	if (ini_get('allow_url_fopen')) {
		error_reporting(0);
		$yahoo = file_get_contents($yahoo_url);
	} elseif (function_exists('curl_init')) {
		$ch = curl_init($yahoo_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$yahoo = curl_exec($ch);
		curl_close($ch);
	}
	$yahoo = trim($yahoo);
	if (empty($yahoo)) {
		/* Maybe failed connection.*/
		$imgsrc = $img_off_path;
	} elseif ($yahoo == "01") {
		$imgsrc = $img_ol_path;
	} elseif ($yahoo == "00") {
		$imgsrc = $img_off_path;
	} else {
		$imgsrc = $img_off_path;
	}
	echo '<a href="ymsgr:sendim?' . $yahooid . '" title="' . $title . '">';
	echo '<img style="border:0px;" src="' . $imgsrc . '" alt="' . $title . '" /></a>';
}

function antiinject($var) {
	if (get_magic_quotes_gpc()) {
		$var1 = stripslashes($var);
	} else {
		$var1 = $var;
	}
	return mysql_real_escape_string($var1);
}

function cegah_inject($var) {
	list($a, $b) = explode("<?php", $var);
	list($c, $d) = explode("?>", $b);
	$data = str_replace($c, '', $var);
	$data = antiinject($data);
	return $data;
}

function yyyymmdd($tanggal) {
	$var = explode("-", $tanggal);
	$tanggal = $var[2] . "-" . $var[1] . "-" . $var[0];
	return $tanggal;
}

function ddmmyyyy($tanggal) {
	$var = explode("-", $tanggal);
	$tanggal = $var[2] . "-" . $var[1] . "-" . $var[0];
	return $tanggal;
}

function numbering($table, $id_column) {
	if ($table && $id_column) {
		$result = mysql_query("SELECT " . $id_column . " FROM " . $table . " LIMIT 0,1");
		$stuff = mysql_fetch_assoc($result);
		if ($stuff[$id_column] == 0) {
			$stuff[$id_column] = 1;
		}
		$nomor = $stuff[$id_column] + 1;
		$result = mysql_query("update $table set nomor='" . $nomor . "' where id='1'");

		return $stuff[$id_column];
	} else {
		return false;
	}
}

function digitangka($kode, $nomor, $jlhdigit) {
	$digit = $jlhdigit - strlen($nomor);
	$nol = "";
	for ($i = 1; $i <= $digit; $i++) {
		$nol = $nol . "0";
	}
	return $kode . $nol . $nomor;
}

function cegahInject($var) {
	list($a, $b) = explode("<?php", $var);
	list($c, $d) = explode("?>", $b);
	$data = str_replace($c, '', $var);
	$data = str_replace(array("'", '"'), array("", ""), $var);
	$data = antiInject($data);
	return $data;
}

function kirim_email($to, $subject, $message, $from) {
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= "Reply-To: $to <$to>\r\n";
	$headers .= "Return-Path: $to <$to>\r\n";
	$headers .= 'From: <' . $from . '>' . "\r\n";

	mail($to, $subject, $message, $headers);
}

function get_setting($namaField) {
	$sql_setting = "SELECT * FROM tb_setting WHERE id = 1";
	$res_setting = mysql_query($sql_setting) or die(mysql_error());
	$ds_setting = mysql_fetch_array($res_setting);

	return $ds_setting[$namaField];
}
?>