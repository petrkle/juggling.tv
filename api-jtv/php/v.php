<?php
# video details
require('config.php');
require('func.php');

if(isset($_GET['id'])){
	$id = preg_replace('/[^0-9]/','',$_GET['id']);
}else{
	exit();
}

$url = JTV."/$id";

if(is_cached($url)){
	$video=load_from_cache($url);
}else{
	$dom = new DOMDocument();
	@$dom->loadHTMLFile($url);

	$video=array();
	$video['title']=extract_text($dom,"//h3[@class='vv-video-title']");
	$video['description']=extract_text($dom,"//div[@class='vv-video-desc']");
	$video['duration']=extract_text($dom,"//span[@class='vv-dura']");
	$video['views']=extract_text($dom,"//span[@class='vv-views']");
	$video['date']=extract_text($dom,"//span[@class='vv-date']");
	$video['image_src']=extract_atr($dom,"//link[@rel='image_src']","href");
	$video['mp4']=extract_atr($dom,"//a[contains(@href,'.mp4') and contains(@href,'encoded')]","href");
	$video['video_src']=extract_atr($dom,"//link[@rel='video_src']","href");
	$video['user_avatar']=extract_atr($dom,"//div[@class='vv-avatar']/a/img","src");
	$video['user_link']=extract_atr($dom,"//div[@class='vv-avatar']/a","href");
	$video['user_name']=extract_text($dom,"//h3[@class='vv-box-title']/a[contains(@href,'/users/')]");
	$video['place']=extract_text($dom,"//span[@class='vv-cunt']");
	$video['sponsor_link']=extract_atr($dom,"//a[@class='vv-sponsor']","href");
	$video['sponsor_img']=extract_atr($dom,"//a[@class='vv-sponsor']/img","src");

	$video=json_encode($video);
	save_to_cache($url,$video);
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print $video;
