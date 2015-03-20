<?php

// Connect to a local pop3 server
$mailbox = new fMailbox('pop3', $config['mail_server'], $config['mail_user'], $config['mail_pw']);
$messages = $mailbox->listMessages();


// Implement Parsedown
$pd = new Parsedown();

/* PARSE MESSAGES
======================================================================== */
	// number of messages
	$num = count($messages);


foreach ($messages as $key => $value) :

	// get message
	$m = $mailbox->fetchMessage($key);
	echo '<pre>'; print_r($m); echo '</pre>';
	// store variables
	$title		=	$m['headers']['subject'];
	$text		=	$m['text'];
	$parts		=	explode("---", $text);

	// parse out $text from $parts
	$slugurl	=	$parts[0];
	$body		=	$pd->text($parts[1]); // use $pd to parse to markdown

	// parse slugurl
	$slug		=	explode("/", $slugurl);
	array_shift($slug); // remove first item since it is blank (all info before first /)
	array_pop($slug); // remove last item since it is blank (all info after last /)

	// get number of arguments in slug
	$numargs	=	count($slug);

	// create subdirectory out of first item if more than one item in slug
	if($numargs > 1) :
		$subdirectory	=	VIEWS . '/' . array_shift($slug) . '/';
		// create subdirectory if it does not exist
		if (!file_exists($subdirectory))
		{
			mkdir($subdirectory, 0777, true);
		}

	endif;





	// create pagename form last item in slug array
	$pagename	=	array_pop($slug);



	// write content to page 
	if($numargs > 1) :
		$newpage = fopen($subdirectory . $pagename . ".html", "w") or die("Unable to open file!");
	else :
		$newpage = fopen(VIEWS . "/" . $pagename . ".html", "w") or die("Unable to open file!");
	endif;

	$newpagecontent = '<?php
$title = "' . $title . '";
$body = "' . $body . '";


include(VIEWS . "/includes/main.inc");?>';
	fwrite($newpage, $newpagecontent);
	fclose($newpage);




endforeach;
