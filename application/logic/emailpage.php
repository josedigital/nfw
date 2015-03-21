<?php
// include config variables
include './application/config/config.php';

// Connect to a imap server
$mailbox 		= 	new fMailbox('imap', $config['mail_server'], $config['mail_user'], $config['mail_pw']);
$messages 		= 	$mailbox->listMessages();


// Implement Parsedown
$pd = new Parsedown();

/* PARSE MESSAGES
======================================================================== */
// number of messages
$num = count($messages);


foreach ($messages as $key => $value) :

	// get message
	$m = $mailbox->fetchMessage($key);
	
	// store variables
	$title		=	$m['headers']['subject'];
	$text		=	$m['text'];
	$parts		=	explode("---", $text);

	// handle attachments
	if(isset($m['attachment'])) :
		$ma 		=	$m['attachment'][0];
		$maname		=	$ma['filename'];
		$madata		=	$ma['data'];
		
		file_put_contents(ROOT . '/static/images/' . $maname, $madata);
	endif;


	// parse out $text from $parts
	$slugurl	=	$parts[0];
	$body		=	$pd->text($parts[1]); // use $pd to parse to markdown
	$body		=	str_replace('"', '\"', $body); // delimt any double quotes inside the body
	$body		=	str_replace('[[', '" . ', $body); // capture [[ ]] to allow helper functions in body
	$body		=	str_replace(']]', ' . "', $body); // capture [[ ]] to allow helper functions in body


	// parse slugurl
	$slug		=	explode("/", $slugurl);
	$dir		= $slug[1];
	array_shift($slug); // remove first item since it is blank (all info before first /)
	array_pop($slug); // remove last item since it is blank (all info after last /)

	// count number of arguments in slug
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



	// create pagename from last item in slug array
	$pagename	=	array_pop($slug);

	// prepend unix timestamp if first argument is blog
	$date 		= new DateTime();
	$timestamp 	= $date->getTimestamp();
	if($dir == 'blog') :
		$pagename = $timestamp . '_' . $pagename;
	endif;




	// write content to page 
	if($numargs > 1) :
		$newpage = fopen($subdirectory . $pagename . ".html", "w") or die("Unable to open file!");
	else :
		$newpage = fopen(VIEWS . "/" . $pagename . ".html", "w") or die("Unable to open file!");
	endif;




	// create template file
	if($dir == 'blog') :
		$newpagecontent = '<?php
$title = "' . $title . '";
$body = "' . $body . '";


include(VIEWS . "/includes/blog.inc");?>';
		fwrite($newpage, $newpagecontent);
		fclose($newpage);
	else :
		$newpagecontent = '<?php
$title = "' . $title . '";
$body = "' . $body . '";


include(VIEWS . "/includes/main.inc");?>';
		fwrite($newpage, $newpagecontent);
		fclose($newpage);
	endif;





	// delete message after creating page
	// $mailbox->deleteMessages($key);

endforeach;




$done = <<<EOT
<html>
	<body>
		<h1>$num messages fetched.</h1>
		<p>return to <a href="/">home</a>.</p>
	</body>
</html>
EOT;
echo $done;