<?php
# video details
require('config.php');
require('func.php');

$sponsors = array();

array_push($sponsors, array(
	'img' => 'http://juggling.tv/images/sponsors/star-burst.gif',
	'link' => 'http://juggling.tv/sponsors/15'
));

array_push($sponsors, array(
	'img' => 'http://juggling.tv/images/sponsors/orange-diabolo.gif',
	'link' => 'http://juggling.tv/sponsors/8'
));

array_push($sponsors, array(
	'img' => 'http://juggling.tv/images/sponsors/ball-flash.gif',
	'link' => 'http://juggling.tv/sponsors/7'
));

array_push($sponsors, array(
	'img' => 'http://juggling.tv/images/sponsors/supported-by.jpg',
	'link' => 'http://juggling.tv/sponsors/17'
));

$oldversion = array(
	'text' => 'This app is outdated. Please, upgrade.',
	'link' => 'https://play.google.com/store/apps/details?id=info.zonglovani.jtv'
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
