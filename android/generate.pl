#!/usr/bin/perl

use strict;
use warnings;
use utf8;
use Template;
use XML::Simple;
use File::Copy;

my $xml = new XML::Simple;

my $groups = $xml->XMLin('jtv/groups.xml');

my $manifest = $xml->XMLin("AndroidManifest.xml");

my $OUT = "assets/www";

my $APP = {
	'api' => "http://api-jtv.rhcloud.com",
	'name' => "juggling.tv",
	'groups' => [@{$groups->{family}}],
	'version' => $manifest->{'android:versionName'}
};

my @PAGES = ( "index", "group", "search", "user", "video", "about" );

my $t = Template->new({
		INCLUDE_PATH => 'jtv',
		ENCODING => 'utf8',
});

foreach my $page (@PAGES){
	$t->process("$page.html",
		{'APP' => $APP},
		"$OUT/$page.html",
		{ binmode => ':utf8' }) or die $t->error;
}

copy("jtv/jtv.css","$OUT/jtv.css");
copy("jtv/img/right.png","$OUT/right.png");
copy("jtv/img/loading.gif","$OUT/loading.gif");
copy("jtv/img/gradient.png","$OUT/gradient.png");
copy("jtv/img/logo.png","$OUT/logo.png");
copy("jtv/jquery-1.8.3.min.js","$OUT/jquery.js");
