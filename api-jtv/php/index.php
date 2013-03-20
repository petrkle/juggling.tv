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

</style>
</head>
<body>

<h1><a href="http://juggling.tv">juggling.tv</a> api</h1>

<ul>
<?php
require('config.php');
foreach($cat_map as $long=>$short){
	print '<li><a href="l/'.$long.'">'.$long.'</a></li>';
}
?>
</ul>

</body>
</html>
