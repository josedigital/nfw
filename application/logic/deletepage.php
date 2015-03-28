<?php
// include config variables
include './application/config/config.php';

$path 			=	parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathtrimmed 	=	trim($path, '/');
$segments 		=	explode('/', $pathtrimmed);

// remove delete page segment
array_pop($segments);

$pagetodelete 	=	end($segments);


if(count($segments) > 2) :
	$filetodelete	=	VIEWS . '/' . arg(count($segments)-1) . '/' . arg(count($segments));
else :
	$filetodelete	=	VIEWS . '/' . arg(count($segments));
endif;


// if confirmed, delete file and return to homepage
if($_SERVER['QUERY_STRING'] == 'confirm') :


	unlink($filetodelete . '.html');
	header('Location: ' . BASE_URL);

endif;






$title	=	"Delete Page";
$body = '
<p class="warning"><span class="icon fa-exclamation-circle"></span> warning: this cannot be undone.</p>
<h2>
	are you sure you want to delete this page?
</h2>

<p>
	---	<br>
		' . $pagetodelete . '
	<br> ---
</p>

<ul class="actions">
	<li><a href="?confirm" class="button special">Yes</a></li>
</ul>
';

include(VIEWS . "/templates/blank.inc");?>