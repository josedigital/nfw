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
	$section	=	$m['headers']['subject'];
	$mtext		=	$m['text'];
	$parts		=	explode("---", $mtext);
	$text		=	$parts[0];

	// handle attachments
	if(isset($m['attachment'])) :
		$ma 		=	$m['attachment'][0];
		$maname		=	$ma['filename'];
		$madata		=	$ma['data'];
		
		file_put_contents(ROOT . '/static/images/' . $maname, $madata);
	endif;


	// parse out $text from $parts
	$body		=	$pd->text($text); 					// use $pd to parse to markdown
	$body		=	str_replace('"', '\"', $body); 		// delimt any double quotes inside the body
	$body		=	str_replace('[[', '<?php echo', $body); 	// capture [[ ]] to allow helper functions in body
	$body		=	str_replace(']]', '?>', $body); 	// capture [[ ]] to allow helper functions in body



	// create sections subdirectory if it does not exist
	$subdirectory	=	VIEWS . '/sections/';
	if (!file_exists($subdirectory))
	{
		mkdir($subdirectory, 0777, true) or die('cannot make directory');
	}

	// write content to page 
	$sectionfile = fopen($subdirectory . $section . ".html", "w") or die("Unable to open file!");

	// create template file
	$newpagecontent = $body;
		fwrite($sectionfile, $newpagecontent);
		fclose($sectionfile);





	// delete message after creating page
	$mailbox->deleteMessages($key);

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