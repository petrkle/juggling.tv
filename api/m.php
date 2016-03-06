<?php
# video details
require('config.php');
require('func.php');

$sponsors = array();

array_push($sponsors, array(
	'img' => 'star-burst15.gif',
	'link' => 'http://juggling.tv/sponsors/15'
));

array_push($sponsors, array(
	'img' => 'orange-diabolo8.gif',
	'link' => 'http://juggling.tv/sponsors/8'
));

array_push($sponsors, array(
	'img' => 'ball-flash7.gif',
	'link' => 'http://juggling.tv/sponsors/7'
));

array_push($sponsors, array(
	'img' => 'supported-by17.jpg',
	'link' => 'http://juggling.tv/sponsors/17'
));

$oldversion = array(
	'img' => 'old-version.png',
	'link' => 'https://zonglovani.info'
);

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
