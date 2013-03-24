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
	$video['image_src_big']=JTV."/thumb/l-0_$id.jpg";
	$video['mp4']=extract_atr($dom,"//a[contains(@href,'.mp4') and contains(@href,'encoded')]","href");
	$video['user_avatar']=extract_atr($dom,"//div[@class='vv-avatar']/a/img","src");
	$video['user_link']=extract_atr($dom,"//div[@class='vv-avatar']/a","href");
	$video['user_id']=extract_userid($video['user_link']);
	$video['user_name']=extract_text($dom,"//h3[@class='vv-box-title']/a[contains(@href,'/users/')]");
	$video['place']=extract_text($dom,"//span[@class='vv-cunt']");
	$video['sponsor_link']=extract_atr($dom,"//a[@class='vv-sponsor']","href");
	$video['sponsor_img']=extract_atr($dom,"//a[@class='vv-sponsor']/img","src");
	$swf_key=preg_split('/key=/',extract_atr($dom,"//link[@rel='video_src']","href"));
	$video['swf_key']=$swf_key[1];
	$video['comments_count']=extract_text($dom,"//span[@class='comment floatr']");
	$video['comments']=array();

	$xpath = new DOMXPath($dom);
	$comments = $xpath->query("//div[@class='comment-list']");

	foreach ($comments as $comment) {
		$com=array();
		$com['author_img']=extract_attr_fn(".//img[@class='comment-image']","src",$comment,$xpath);
		$com['author_name']=extract_text_fn(".//a",$comment,$xpath);
		$com['author_link']=extract_attr_fn(".//a","href",$comment,$xpath);
		$com['author_id']=extract_userid($com['author_link']);
		$com['author_time']=preg_replace('/^_ /','',extract_text_fn(".//span[@class='vv-info']",$comment,$xpath));
		$com['text']=preg_replace('/.*“(.*)”.*/s','\1',extract_text_fn(".//div[@class='comment-body']",$comment,$xpath));
		array_push($video['comments'],$com);
	}

	$downloads = $xpath->query("//div[@class='download-data']");
	if(isset($downloads->item(0)->nodeValue)){
		$raw=preg_replace('/( class="[^"]*"|\n|\s*)/','',$dom->saveXML($downloads->item(0)));
		$raw=preg_replace('/.*<br\/>/','',$raw);
		$raw=preg_replace('/<span>([0-9]+)<\/span><span>x<\/span><span>([0-9]+)-[0-9]*<\/span><span>fps<\/span><span>-mp4-([0-9]+).*<\/span><span>(.*)<\/span>.*/','\1:\2:\3:\4',$raw);
		$raw=preg_split('/:/',$raw);
		$video['width']=$raw[0];
		$video['height']=$raw[1];
		$video['size']=$raw[2];
		$video['size_unit']=$raw[3];
	}

	$video=json_encode($video);
	save_to_cache($url,$video);
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print $video;
