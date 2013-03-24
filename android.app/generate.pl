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
my $API = "http://api-jtv.rhcloud.com";

my $t = Template->new({
		INCLUDE_PATH => 'jtv',
		ENCODING => 'utf8',
});

for my $group (@{$groups->{family}}){

	$t->process('group.html',
		{ 'group' => $group,
			'API' 	=> $API,
		},
	"$OUT/$group->{'short'}.html",
		{ binmode => ':utf8' }) or die $t->error;

	$t->process('v.html',
		{ 'group' => $group,
			'API' 	=> $API,
		},
	"$OUT/$group->{'short'}-v.html",
		{ binmode => ':utf8' }) or die $t->error;

}

$t->process('index.html',
	{ 'groups' => [@{$groups->{family}}],
	},
	"$OUT/index.html",
	{ binmode => ':utf8' }) or die $t->error;

$t->process('u.html',
	{ 'title' => 'jtv users',
		'API' 	=> $API,
	},
	"$OUT/u.html",
	{ binmode => ':utf8' }) or die $t->error;

$t->process('about.html',
	{	'title' => 'jtv',
		'version' => $manifest->{'android:versionName'},
	},
	"$OUT/about.html",
	{ binmode => ':utf8' }) or die $t->error;

copy("jtv/jtv.css","$OUT/jtv.css");
copy("jtv/img/home.png","$OUT/home.png");
copy("jtv/img/right.png","$OUT/right.png");
copy("jtv/img/left.png","$OUT/left.png");
copy("jtv/img/loading.gif","$OUT/loading.gif");
copy("jtv/jquery.js","$OUT/jquery.js");
