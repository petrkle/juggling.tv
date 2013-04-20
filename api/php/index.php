<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>jtv api</title>
	<meta name="robots" content="noindex,nofollow" />
<style type="text/css">
body{background:#fff;margin:0;padding:0;}
h1{margin:0;padding:10px 0 10px 170px;background:url('jtv.png') no-repeat 10px 50% #f7eb01;border-bottom:solid 2px #000;display:block;height:120px}
h3{padding:10px;}
p{padding:0 10px;}
</style>
</head>
<body>

<h1><a href="http://juggling.tv">juggling.tv</a> api</h1>

<h3>Lists</h3>
<ul>
<?php
require('config.php');
foreach($cat_map as $long=>$short){
	print '<li><a href="l/'.$long.'">'.$long.'</a></li>';
}
?>
</ul>

<h3>Status</h3>
<p>Cached objects: <?php print(count(scandir(CACHEDIR)));?></p>
<p>Cache expire time: <?php print CACHETIME;?>s</p>

<h3><a href="https://github.com/petrkle/juggling.tv">Get source code</a></h3>

</body>
</html>
