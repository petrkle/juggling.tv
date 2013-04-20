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
	$xpath = new DOMXPath($dom);

	$user=array();

	$userinfo = $xpath->query("//div[@id='userinfo']");

	$user['name']=preg_replace('/^_ /','',extract_text_fn(".//h2[@class='bx-rt-title']",$userinfo->item(O),$xpath));
	$user['img']=extract_attr_fn(".//div[@class='pictprofile']/img","src",$userinfo->item(O),$xpath);

	$raw=$dom->saveXML($userinfo->item(0));
	$delim='<h3 ';
	$raw=preg_split("/$delim/",$raw);
	for($foo=1;$foo<count($raw);$foo++){
		$baz=$delim.$raw[$foo];

		$pdom = new DOMDocument();
		@$pdom->loadHTML($baz);
		$prop=preg_replace('/( |:)/','',strtolower(extract_text($pdom,"//h3")));
		$val=extract_text($pdom,"//div[@class='profileinfo' or @class='profileinfo mb-5']");
		$user[$prop]=$val;
	}
	
		$nodes = $xpath->query("//div[@class='myvideo']");
		if($nodes){
			$videos=array();
			foreach ($nodes as $node) {
				$result=array();
				$result['title']=extract_text_fn(".//h3[@class='title']/a",$node,$xpath);
				$result['link']=extract_attr_fn(".//h3[@class='title']/a","href",$node,$xpath);
				$result['id']=str_replace(JTV.'/','',$result['link']);
				$result['added']=extract_text_fn(".//p[@class='added']",$node,$xpath);
				$result['duration']=extract_text_fn(".//p[@class='duration']",$node,$xpath);
				$result['views']=extract_text_fn(".//p[@class='views']",$node,$xpath);
				$result['desc']=preg_replace('/.*\\t/s','',extract_text_fn(".//div[@class='desc']",$node,$xpath));
				array_push($videos,$result);
			}
			$user['videos']=$videos;
		}


	$user=json_encode($user);
	save_to_cache($url,$user);
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print $user;
