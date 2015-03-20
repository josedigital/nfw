<?php
/* define constants
======================================================================================= */
define("BASE_URL","http://localhost/nanite");
define('ROOT', realpath(dirname(__FILE__)));
define('SRC', ROOT . '/src');
define('VIEWS', ROOT . '/application/views');





/* include functions
======================================================================================= */
include './application/config/config.php';
include './functions.php';
include './emailpage.php';





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
$subpages = new DirectoryIterator(VIEWS . '/contact');
while($subpages->valid()) 
{
	if(!$subpages->isDir()) 
	{
		$page = pathinfo($subpages->getFilename(), PATHINFO_FILENAME);
		get('/contact/' . $page . '/', function() use ($page) {
			loadview('contact/' . $page);
		});
	}
	$subpages->next();
}





/* re-route pages manually - create new route for page that already exists
======================================================================================= */
// contact page
get('/about/contact/', function() {
		loadview('contact');
});


if (!Nanite::$routeProccessed) {
    // 404 page here
    echo '404';
}