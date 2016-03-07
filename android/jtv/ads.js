$.getJSON("[% APP.api %]/m.php", {version: "[% APP.version %]"},
  function(data) {
  for (var i=0; i < data.length; i++){
		if(data[i].img){
			$('#messages').append('<li class="mlink"><a href="'+data[i].link+'"><img src="'+data[i].img+'" /></a></li>');
		}
		if(data[i].text){
			$('#messages').append('<li class="warnlink"><a href="'+data[i].link+'">'+data[i].text+'</a></li>');
		}
  }
});
