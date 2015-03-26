<?php
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
$attachments = '';
$page = array();


foreach ($messages as $key => $value) :

	// get message
	$m = $mailbox->fetchMessage($key);



	// handle attachments
	if(isset($m['attachment'])) :

		foreach($m['attachment'] as $ma) :

			// $ma 		=	$m['attachment'][0];
			$maname		=	$ma['filename'];
			$maext		=	$ma['mimetype'];
			$madata		=	$ma['data'];

			$attachments .=  '<li>' . $maname . '</li>';
			
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

		endforeach;

	endif;



	
	// store variables
	$page['title']		=	$m['headers']['subject'];
	$text				=	$m['text'];
	$parts				=	explode("---", $text);



	// iterate through $parts
	foreach ($parts as $part) :
		
		$m = explode(':', $part, 2);

		// if the variable is url, trim it and replace spaces with -
		if($m[0] == 'url')
		{
			$m[1] = trim($m[1]);
			$m[1] = str_replace(' ', '-', $m[1]);
		}
		$page[trim($m[0])] = trim($m[1]);

	endforeach;


	// handle markdown and shorttags
	$body		=	$pd->text($page['body']); 			// use $pd to parse markdown
	$body		=	str_replace('"', '\"', $body); 		// delimt any double quotes inside the body
	$body		=	str_replace('[[', '" . ', $body); 	// capture [[ ]] to allow helper functions in body
	$body		=	str_replace(']]', ' . "', $body); 	// capture [[ ]] to allow helper functions in body




	// parse url if contains subdirectory
	if (strpos($page['url'],'/') !== false) :
	
    	$slugs		=	explode("/", $page['url']);
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
		$pagename	=	trim($page['url']);
		$newpage = fopen(VIEWS . "/" . $pagename . ".html", "w") or die("Unable to open file!");

	endif;


		
	





	// create template file
	if(isset($dir) && $dir == 'blog') :
		$newpagecontent = "<?php\r\n";
		foreach ($page as $key => $value) {
			$newpagecontent .= "$".$key." = \"" . $value . "\";\r\n";
		}
		$newpagecontent .= "include(VIEWS . \"/includes/blog.inc\");?>";
		fwrite($newpage, $newpagecontent);
		fclose($newpage);
	else :
		$newpagecontent = "<?php\r\n";
		foreach ($page as $key => $value) {
			$newpagecontent .= "$".$key." = \"" . $value . "\";\r\n";
		}
		$newpagecontent .= "include(VIEWS . \"/includes/main.inc\");?>";
		fwrite($newpage, $newpagecontent);
		fclose($newpage);
	endif;







	// delete message after creating page
	// $mailbox->deleteMessages($key);

endforeach;



$baseurl 	= BASE_URL;
$url 		= $page['url'];
$done = <<<EOT
<html>
	<body>
		<h1>$num messages fetched.</h1>
		<p>the following attachments were saved: <ul> $attachments </ul> and are available with their respective <a href="$baseurl/helpers/functions">helper fucntions</a>.</p>
		<p>view your page here: <a href="$baseurl/$url/">$url</a></p>
		<p>return to <a href="$baseurl">home</a>.</p>
	</body>
</html>
EOT;
echo $done;