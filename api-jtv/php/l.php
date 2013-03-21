<?php
# video list
require('config.php');
require('func.php');

if(isset($_GET['cat']) and isset($cat_map[$_GET['cat']])){
	$cat = $cat_map[$_GET['cat']];
}else{
	exit();
}

if(isset($_GET['page'])){
	$page = $_GET['page'];
}else{
	$page = 1;
}

$url = JTV."/videos/detailed/$cat/$page";

if(is_cached($url)){
	$videos=load_from_cache($url);
}else{
	$videos = array();
	$dom = new DOMDocument();
	@$dom->loadHTML(file_get_contents($url));
	$xpath = new DOMXPath($dom);
	$nodes = $xpath->query("//div[@class='detailed']");

	foreach ($nodes as $node) {
		$video['title']=extract_text_fn(".//h3[@class='title']/a",$node,$xpath);
		$video['link']=extract_attr_fn(".//h3[@class='title']/a","href",$node,$xpath);
		$video['id']=str_replace(JTV.'/','',$video['link']);
		$video['image']=extract_attr_fn(".//div[@class='videothumb']/a/img","src",$node,$xpath);
		$video['user_link']=extract_attr_fn(".//p[@class='user']/a","href",$node,$xpath);
		$video['user_name']=extract_text_fn(".//p[@class='user']",$node,$xpath);
		$video['user_id']=extract_userid($video['user_link']);
		$video['description']=extract_text_fn(".//div[@class='desc']",$node,$xpath);
		$video['duration']=extract_text_fn(".//p[@class='duration']",$node,$xpath);
		$video['views']=extract_text_fn(".//p[@class='views']",$node,$xpath);
		$video['added']=extract_text_fn(".//p[@class='added']",$node,$xpath);
		$video['comments']=extract_text_fn(".//p[@class='comments']",$node,$xpath);
		array_push($videos,$video);
	}

	$videos=json_encode($videos);
	save_to_cache($url,$videos);

}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print $videos;
