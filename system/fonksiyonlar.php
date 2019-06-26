<?php

function post(){
	if ($_POST) {
		return true;
	}else{
		return false;
	}
}
function get(){
	if ($_GET) {
		return true;
	}else{
		return false;
	}
}
function p($deger){
	if (isset($_POST[$deger])) {
		return trim($_POST[$deger]);
	}
	return false;
}
function g($deger){
	if (isset($_GET[$deger])) {
		return trim($_GET[$deger]);
	}
	return false;
}
function redirect($url,$time=0){
	if ($time==0) {
		header("location:$url");
	}else{
		$time=(int)$time;
		header("refresh:$time;$url");
	}
}
function seoUrlOlustur($text){
	$tr=["Ç","Ş","Ğ","Ü","İ","Ö","ç","ş","ğ","ü","ı","ö","+","#"];
	$ing = ["C","S","G","U","I","O","c","s","g","u","i","o","",""];
	$text = strtolower(str_replace($tr, $ing, $text));
	$text = preg_replace("@[\.+]@", "", $text);
	$text = preg_replace("@[^A-Za-z0-9\-_\+]@", " ", $text);
	$text = trim(preg_replace('/\s+/', " ", $text));
	$text= str_replace(" ", "-", $text);
	return $text;
}
function pr($dizi){
	echo "<pre>";
	print_r($dizi);
	echo "</pre>";
}

function base_url($param=""){
	return BASEURL."".$param;
}
