<?php
# video list
require('config.php');
require('func.php');

if(isset($_GET['q'])){
	$q = $_GET['q'];
}else{
	exit();
}

$type=array('u'=>'users','v'=>'videos');

if(isset($_GET['type']) and isset($type[$_GET['type']])){
	$type = $type[$_GET['type']];
}else{
	exit();
}

$url = JTV."/search.php?search_id=$q&search_type=$type";

if(is_cached($url)){
	$results=load_from_cache($url);
}else{
	$results = array();
	$dom = new DOMDocument();
	@$dom->loadHTML(file_get_contents($url));
	$xpath = new DOMXPath($dom);

	if($type=='users'){
		$nodes = $xpath->query("//div[@class='listmember']");
		if($nodes){
			foreach ($nodes as $node) {
				$result=array();
				$result['name']=extract_text_fn(".//div[@class='membername']/a",$node,$xpath);
				$result['link']=extract_attr_fn(".//div[@class='membername']/a","href",$node,$xpath);
				$result['img']=extract_attr_fn(".//div[@class='imagemember']/a/img","src",$node,$xpath);
				array_push($results,$result);
			}
		}
	}else{
		$nodes = $xpath->query("//div[@class='detailed']");
		if($nodes){
			foreach ($nodes as $node) {
				$result=array();
				$result['title']=extract_text_fn(".//div[@class='title']/a",$node,$xpath);
				$result['link']=extract_attr_fn(".//div[@class='title']/a","href",$node,$xpath);
				$result['id']=str_replace(JTV.'/','',$result['link']);
				$result['image']=extract_attr_fn(".//div[@class='videothumb']/a/img","src",$node,$xpath);
				$result['user_link']=extract_attr_fn(".//p[@class='user']/a","href",$node,$xpath);
				$result['user_name']=extract_text_fn(".//p[@class='user']",$node,$xpath);
				$result['user_id']=extract_userid($result['user_link']);
				$result['description']=extract_text_fn(".//div[@class='desc']",$node,$xpath);
				$result['duration']=extract_text_fn(".//p[@class='duration']",$node,$xpath);
				$result['views']=extract_text_fn(".//p[@class='views']",$node,$xpath);
				$result['added']=extract_text_fn(".//p[@class='added']",$node,$xpath);
				$result['comments']=extract_text_fn(".//p[@class='comments']",$node,$xpath);
				array_push($results,$result);
			}
		}
	}

	$results=json_encode($results);
	save_to_cache($url,$results);

}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print $results;
