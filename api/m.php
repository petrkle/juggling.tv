<?php
# video details
require('config.php');
require('func.php');

$sponsors = array();

$info = array();

array_push($info, $sponsors[array_rand($sponsors)]);

if(isset($_GET['version'])){
	$version = preg_replace('/[^0-9\.]+/', '', $_GET['version']);
	if($version <= WARNVERSION){
		array_push($info, $oldversion);
	}
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print json_encode($info);
