<?php
/* message format:
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



	
	// get message text
	$subject				=	$m['headers']['subject'];
	$text					=	$m['text'];
	$parts					=	explode("---", $text);

	// parse subject to get subdirectory, section and url
	if (strpos($subject,'/') !== false) :
		$slugs				=	explode("/", $subject);
		$dir				= 	$slugs[0];
		$page['title'] 		= 	trim($slugs[1]);
		$page['url'] 		=	str_replace(' ', '-', $page['title']);

	else :
		// no subdirectory
		$page['title'] 		= 	trim($subject);
		$page['url'] 		=	str_replace(' ', '-', $page['title']);

	endif;
	

	// change 'section' to 'sections' : easier on the user i think
	if($dir == 'section') 
		$dir 				= 	'sections';
		$pagename 			= 	$page['url'];

	
	// iterate through $parts and save as key=>value in $page
	foreach ($parts as $part) :
		if(count($parts)<2) break;
		$m = explode(':', $part, 2);
		$page[trim($m[0])] = trim($m[1]);
	endforeach;




	// handle markdown and shorttags
	$body					=	$pd->text($page['body']); 					// use $pd to parse markdown
	$body					=	str_replace('"', '\"', $body); 		// delimt any double quotes inside the body
	$body					=	str_replace('[[', '" . ', $body); 	// capture [[ ]] to allow helper functions in body
	$body					=	str_replace(']]', ' . "', $body); 	// capture [[ ]] to allow helper functions in body
	$page['body'] 			= 	$body;




	// if we have a subdirectory
	if (isset($dir)) :

		// create subdirectory if it does not exist
		$subdirectory	=	VIEWS . '/' . $dir . '/';
		if (!file_exists($subdirectory))
		{
			mkdir($subdirectory, 0777, true) or die('cannot make directory');
		}

		// prepend unix timestamp if $dir is blog
		if($dir == 'blog') :
			$date 			= 	new DateTime();
			$timestamp 		= 	$date->getTimestamp();
			// $pagename 		= 	$timestamp . '_' . $page['url'];

			// created date variable
			$page['created'] = 	gmdate("d \of M Y @ g:i:s a", $timestamp);		
		endif;


		// create page in subdirectory
		$newpage 	= 	fopen($subdirectory . $pagename . ".html", "w") or die("Unable to open file!");

	else :
		// just create normal page at VIEWS root
		$pagename	=	$page['url'];
		$newpage 	= 	fopen(VIEWS . "/" . $pagename . ".html", "w") or die("Unable to open file!");

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

	elseif(isset($dir) && $dir == 'sections') :
		$newpagecontent = $page['body'];
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


if($num > 0):
	$baseurl 	= BASE_URL;
	$url 		= (isset($dir)) ? $dir.'/'.$page['url'] : $page['url'];
	$done 		= <<<EOT
<html>
<title>emphatic fetching email</title>
	<body>
		<h1>$num messages fetched.</h1>
		<p>the following attachments were saved: <ul> $attachments </ul> and are available with their respective <a href="$baseurl/helpers/functions">helper fucntions</a>.</p>
		<p>view your page here: <a href="$baseurl/$url/">$url</a></p>
		<p>return to <a href="$baseurl">home</a>.</p>
	</body>
</html>
EOT;
else:
	$done 		= 'No Messages';
endif;
echo $done;