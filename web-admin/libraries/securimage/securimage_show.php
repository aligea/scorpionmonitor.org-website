<?php
error_reporting(E_ALL ^ E_NOTICE);
include 'securimage.php';
$img = new securimage();
$img->show(); // alternate use:  $img->show('/path/to/background.jpg');
?>
