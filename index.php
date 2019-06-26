<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
session_start();
require 'const.php';
require 'system/fonksiyonlar.php';
require 'system/class.db.php';
require 'system/class.upload.php';
require 'app/fonksiyonlar.php';

// kategori/1/html
// admin/kategori_ekle
// admin/kategori_guncelle/1/html
$url = g("url");
$url_dizi = explode("/", $url);
if ($url_dizi[0]=="admin") {
	$dosya = trim(@$url_dizi[1]); # kategori_ekle #kategori_guncelle
	$id=trim(@$url_dizi[2]); # 1
	$seo_url = trim(@$url_dizi[3]); # html
}else{
	$dosya = trim($url_dizi[0]); # kategori
	$id=trim(@$url_dizi[1]); # 1
	$seo_url = trim(@$url_dizi[2]); # html
}
if ($dosya!="") {
	$file = $dosya;
}else{
	$file= "anasayfa";
}
$controller = "app/controller/".$file.".php";
if( $url_dizi[0]=="admin" ){
	$controller = "app/controller/admin/".$file.".php";
}
if (file_exists($controller)) {
	$db= new Db($server,$dbname,$dbuser,$dbpassword,$charset);
	require $controller;
}else{
	echo "<p style='background-color:#F77D11;padding:8px 20px;'><strong style='color:white;'>Kurulum Gerçekleştirlmedi..</strong></p>";
}
ob_end_flush();
