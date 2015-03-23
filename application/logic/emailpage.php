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
		$maext		=	$ma['mimetype'];
		$madata		=	$ma['data'];
		
		switch ($maext) {
			case 'image/jpeg':
				file_put_contents(ROOT . '/static/images/' . $maname, $madata);
				break;

			case 'image/gif':
				file_put_contents(ROOT . '/static/images/' . $maname, $madata);
				break;

			case 'image/png':
				file_put_contents(ROOT . '/static/images/' . $maname, $madata);
				break;

			case 'text/css':
				file_put_contents(ROOT . '/static/css/' . $maname, $madata);
				break;

			case 'application/x-javascript':
				file_put_contents(ROOT . '/static/js/' . $maname, $madata);
				break;

			case 'application/pdf':
				file_put_contents(ROOT . '/static/pdf/' . $maname, $madata);
				break;

			default:
				# code...
				break;
		}
	endif;


	/* message format:
			url: blog/his is my test slug
			---


			meta: this, is, my, meta, tags
			---



			body:
			this is the body texto.
			---



			footer:what?
	*/


	// iterate through $parts
	foreach ($parts as $part) :
		// echo substr($part, strpos($part, ":") + 1) . '<br>';
		$m = explode(':', $part, 2);

		switch (trim($m[0])) {
			case 'url':
				$u   = trim($m[1]);
				$url = str_replace(' ', '-', $u);
				break;

			case 'meta':
				$meta = trim($m[1]);
				break;

			case 'body':
				$bodi = $m[1];
				break;

			case 'footer':
				$footer = $m[1];
				break;
			
			default:
				# code...
				break;
		}


	endforeach;


	// handle markdown and shorttags
	$body		=	$pd->text($bodi); 					// use $pd to parse markdown
	$body		=	str_replace('"', '\"', $body); 		// delimt any double quotes inside the body
	$body		=	str_replace('[[', '" . ', $body); 	// capture [[ ]] to allow helper functions in body
	$body		=	str_replace(']]', ' . "', $body); 	// capture [[ ]] to allow helper functions in body




	// parse url if contains subdirectory
	if (strpos($url,'/') !== false) :
	
    	$slugs		=	explode("/", $url);
		$dir		= 	$slugs[0];
		$slug 		= 	trim($slugs[1]);

		// count number of sections in slug
		$numargs	=	count($slugs);
	
		// create pagename from last item in slug array
		$pagename	=	$slug;
		
		// create subdirectory if it does not exist
		$subdirectory	=	VIEWS . '/' . $dir . '/';
		if (!file_exists($subdirectory))
		{
			mkdir($subdirectory, 0777, true) or die('cannot make directory');
		}

		// prepend unix timestamp if first argument is blog
		if($dir == 'blog') :
			$date 		= new DateTime();
			$timestamp 	= $date->getTimestamp();			
			$pagename = $timestamp . '_' . $pagename;

			// created date variable
			$created  = gmdate("d \of M Y @ H:i:s", $timestamp);			
		endif;

		// create page in subdirectory
		$newpage = fopen($subdirectory . $pagename . ".html", "w") or die("Unable to open file!");

	else :
		// just create normal page at VIEWS root
		$pagename	=	trim($url);
		$newpage = fopen(VIEWS . "/" . $pagename . ".html", "w") or die("Unable to open file!");

	endif;
	
	







	// create template file
	if(isset($dir) && $dir == 'blog') :
		$newpagecontent = '<?php
$title = "' . $title . '";
$meta = "' . $meta . '";
$body = "' . $body . '";
$created = "' . $created . '";
$footer = "' . $footer . '";

include(VIEWS . "/includes/blog.inc");?>';
		fwrite($newpage, $newpagecontent);
		fclose($newpage);
	else :
		$newpagecontent = '<?php
$title = "' . $title . '";
$meta = "' . $meta . '";
$body = "' . $body . '";
$footer = "' . $footer . '";

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