<?php
# user details
require('config.php');
require('func.php');

if(isset($_GET['id'])){
	$id = preg_replace('/[^0-9]/','',$_GET['id']);
}else{
	exit();
}

$url = JTV."/users/$id";

if(is_cached($url)){
	$user=load_from_cache($url);
}else{

	$dom = new DOMDocument();
	@$dom->loadHTMLFile($url);

	$user=array();
	$user['name']=extract_text($dom,"//div[@class='profileinfo']");

	$user=json_encode($user);
	save_to_cache($url,$user);
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print $user;
