<?php
//-- setting config server
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
//date_default_timezone_set('Europe/London');
session_start();

//-- setting variabel global 
//-- tulis nama server local = http://localhost/namafolder ; server http://namadomain.com
define('basepath', dirname(__FILE__));
define('BASEPATH', basepath);
define('baseurl', 'http://'.$_SERVER['SERVER_NAME'].'');
define('baseurlroot', 'http://'.$_SERVER['SERVER_NAME'].'');


setcookie("baseurl", baseurl);
setcookie("baseurlroot", baseurlroot);

define('dbserver', 'localhost');
define('dbname', '');
define('dbuser', '');
define('dbpassword', '');

/*define('dbserver', 'localhost');
define('dbname', 'db_scorpionmonitor');
define('dbuser', 'root');
define('dbpassword', '');*/

$_SESSION['config']['pakai_login'] = false;
$_SESSION['config']['namaperusahaan'] = 'Scorpion-The Wildlife Trade Monitoring Group';
$_SESSION['config']['emailadmin'] = 'alibangungea@gmail.com';
$_SESSION['config']['emailwebsite'] = 'info@scorpionmonitor.org';
$_SESSION['config']['namawebsite'] = 'www.scorpionmonitor.org';

//session config email
$_SESSION['mail_config']['Host'] = 'smtp.gmail.com';
$_SESSION['mail_config']['Port'] = 587;
$_SESSION['mail_config']['SMTPSecure'] = 'tls';
$_SESSION['mail_config']['Username'] = "xxx@gmail.com";
$_SESSION['mail_config']['Password'] = "xxx";


//-- koneksi izy
if ($izyredbean) {
    printf($izyredbean);
    die('yes izyredbean');
    izy::setup('mysql:host=' . dbserver . ';dbname=' . dbname . '', '' . dbuser . '', '' . dbpassword . '');
    izy::setStrictTyping(false);
    izy::freeze(TRUE);
}

//-- koneksi mysqli
function mysqliConnection(){
    //die('im here mysqli connection');
    $koneksidb =  new mysqli(dbserver, dbuser, dbpassword, dbname);
    //print_r($koneksidb);die();
    if($koneksidb->connect_errno > 0){
        die($koneksidb->connect_error);
    }
    return $koneksidb;
}

//-- PDO
function pdoConnection(){
    $dbhost = dbserver;
    $dbuser = dbuser;
    $dbpass = dbpassword;
    $dbname = dbname;
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>