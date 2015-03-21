<?php
/* define constants
======================================================================================= */
define("BASE_URL","http://localhost/nfw");
define('ROOT', realpath(dirname(__FILE__)));
define('SRC', ROOT . '/src');
define('VIEWS', ROOT . '/application/views');





/* include functions
======================================================================================= */
include './functions.php';






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
	loadview('home');
});
	// homepage route @ /home/
	get('/home/', function() {
		loadview('home');
	});
// forms processor
post('/formsprocessor/', function() {
	loadview('formsprocessor');
});
// get email messages = generate new pages from email
get('/fetch/', function(){
	include ROOT . '/emailpage.php';
});


/* create routes manually - using per page templates - variables declared here like controler
======================================================================================= */
// about page
get('/about/', function() {
	$about = array(
		'title' 	=> 'About Us',
		'name'		=> 'alex',
		'what'		=> 'what was replaced by this text'
	);
	loadview('about', $about);
});



/* create routes dynamically - read from views directory and/or subdirectories thereof
======================================================================================= */
$pages = new DirectoryIterator(VIEWS);
while($pages->valid()) 
{
	if(!$pages->isDir()) 
	{
		$page = pathinfo($pages->getFilename(), PATHINFO_FILENAME);
		get('/' . $page . '/', function() use ($page) {
			loadview($page);
		});
	}
	$pages->next();
}


// create new iterator for each directory
$contactpages = new DirectoryIterator(VIEWS . '/contact');
while($contactpages->valid()) 
{
	if(!$contactpages->isDir()) 
	{
		$page = pathinfo($contactpages->getFilename(), PATHINFO_FILENAME);
		get('/contact/' . $page . '/', function() use ($page) {
			loadview('contact/' . $page);
		});
	}
	$contactpages->next();
}




// create new iterator for each directory
$blogposts = new DirectoryIterator(VIEWS . '/blog');
while($blogposts->valid()) 
{
	if(!$blogposts->isDir()) 
	{
		$page = pathinfo($blogposts->getFilename(), PATHINFO_FILENAME);
		$pagename = explode('_',$page);
		$blogpost = $pagename[1];
		get('/blog/' . $blogpost . '/', function() use ($page) {
			loadview('blog/' . $page);
		});
	}
	$blogposts->next();
}




/* re-route pages manually - create new route for page that already exists
======================================================================================= */
// contact page
get('/about/contact/', function() {
		loadview('contact');
});

// 404
if (!Nanite::$routeProccessed) {
    // 404 page here
    echo '404';
}
