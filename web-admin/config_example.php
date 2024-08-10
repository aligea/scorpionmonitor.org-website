<?php
//-- setting config server
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Jakarta');
session_start();

$_SESSION['mode'] = 'development';

//-- setting variabel global 
//-- tulis nama server local = http://localhost/namafolder ; server http://namadomain.com
define('basepath', dirname(__FILE__));
define('baseurl', 'http://'.$_SERVER['SERVER_NAME'].'/web-admin');
define('baseurlroot', 'http://'.$_SERVER['SERVER_NAME']);


define('dbserver', 'localhost');
define('dbname', '');
define('dbuser', '');
define('dbpassword', 'abcd1234');



//-- koneksi izy
if ($izyredbean) {
    izy::setup('mysql:host=' . dbserver . ';dbname=' . dbname . '', '' . dbuser . '', '' . dbpassword . '');
    izy::setStrictTyping(false);
    izy::freeze(TRUE);
}

//-- koneksi mysqli
function mysqliConnection(){
    $koneksidb =  new mysqli(dbserver, dbuser, dbpassword, dbname);
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