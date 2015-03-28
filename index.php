<?php
date_default_timezone_set('America/Chicago');
$started_at = microtime(true);
/* define constants
======================================================================================= */
define("BASE_URL","http://localhost/nfw");
define('ROOT', realpath(dirname(__FILE__)));
define('SRC', ROOT . '/src');
define('VIEWS', ROOT . '/application/views');





/* include functions
======================================================================================= */
include './application/functions/core.php';
include './application/functions/helpers.php';






/* autoload classes
======================================================================================= */
function __autoload($class_name) {
    
		if (file_exists(SRC . '/' . $class_name . '.php')) {
        	include SRC . '/' . $class_name . '.php';
        	return;
    	}

        if (file_exists(SRC . '/flourishlib/' . $class_name . '.php')) {
        	include SRC . '/flourishlib/' . $class_name . '.php';
        	return;
    	}

}







/* create routes manually - using delegate tempalte method - variables declared in view
======================================================================================= */

// homepage route
get('/', function() {
	// using delegate method; vars are created in home.html
	loadview(VIEWS . '/home');
});
	// homepage route @ /home/
	get('/home/', function() {
		loadview(VIEWS . '/home');
	});
// forms processor
post('/formsprocessor/', function() {
	loadview(VIEWS . '/formsprocessor');
});
// get email messages = generate new pages from email
get('/fetch-pages/', function(){
	include ROOT . '/application/logic/emailpage.php';
});
// get email messages = generate new section from email
get('/fetch-sections/', function(){
	include ROOT . '/application/logic/emailsection.php';
});


/* create routes manually - using per page templates - variables declared here like controller
======================================================================================= */
// about page
get('/about/', function() {
	$about = array(
		'title' 	=> 'About Us',
		'name'		=> 'alex',
		'what'		=> '#what# was replaced by this text'
	);
	loadview(VIEWS . '/about', $about);
});



/* create routes dynamically - read from views directory and/or subdirectories thereof
======================================================================================= */
$ignore = array('.', '..', '.DS_Store', '.gitignore', '.git', '.svn', '.htaccess');
$views = new RecursiveDirectoryIterator(VIEWS);
foreach (new RecursiveIteratorIterator($views) as $filename => $file)
{

	// echo '<pre>'; print_r($filename); echo '</pre>';
	if($file->getExtension() == 'html')
	{
		
		// get filename without extension
		$f 			=	$file->getBasename('.html');
		$fullpath	=	$file->getPath() . '/' . $f;
		$getpath	=	str_replace(VIEWS.'/', '', $fullpath);


		// set routes
		get('/' . $getpath . '/', function() use ($fullpath) {
			loadview($fullpath);
		});
		get('/' . $getpath . '/del/', function() use ($fullpath) {
			include ROOT . '/application/logic/deletepage.php';
		});
		// using routing below will allow all pages to be viewed at root level.
		// so if using emphatic just for a microblog and you want it at root level
		// use the router below to have all blog posts at root level e.g. www.yoursite.com/your-blog-post/
		// note: all blog posts will reside in blog/ subdirectory. same goes for other subdir.
		// get('/' . $f . '/', function() use ($fullpath) {
		// 	loadview($fullpath);
		// });
	}



	
}

/* re-route pages manually - create new route for page that already exists
======================================================================================= */
// contact page
get('/about/contact/', function() {
		loadview(VIEWS . '/contact');
});

// 404
if (!Nanite::$routeProccessed) {
    // 404 page here
    echo '404';
}
echo '<div class="container">page loaded in ' . (microtime(true) - $started_at) . ' seconds.<div>'; 