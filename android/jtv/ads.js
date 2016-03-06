$.getJSON("[% APP.api %]/m.php", {version: "[% APP.version %]"},
  function(data) {
  for (var i=0; i < data.length; i++){
		$('#messages').append('<li class="mlink"><a href="'+data[i].link+'"><img src="[% APP.api %]/img/'+data[i].img+'" /></a></li>');
  }
});
