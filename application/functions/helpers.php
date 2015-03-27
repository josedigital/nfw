<?php
/* ********************* HELPER FUNCTIONS FOR TEMPLATES *********************
**
**	some functions to help add images and other things in templates
**
**************************************************************************** */

/**
*
* THUMBNAILS
* @param string tag to surround image e.g. li, div, span
*/
function thumbs($imagewrapper) 
{

	$images = ROOT . '/static/images/';
	$thumbnails = $images . 'thumbs/';
	$thumbs = new DirectoryIterator($thumbnails);
	$thumbpath = BASE_URL . '/static/images/thumbs/';

	while($thumbs->valid()) 
	{

		if($thumbs->getExtension() == 'jpg') 
		{
			echo '<' . $imagewrapper . '><img src="' . $thumbpath . $thumbs->getFilename() . '" /></' . $imagewrapper . '>';
		}

		$thumbs->next();
	}

}



/**
*
* IMG
* @param string name of image with extension
*/

function img($imagename) 
{
	$imgpath = BASE_URL . '/static/images/';
	$filename = $imagename;
	return '<img src="' . $imgpath . $filename . '" alt="" />';
}



/**
*
* JPG
* @param string name of image without extension; assumes jpg
*/

function jpg($imagename) 
{
	$imgpath = BASE_URL . '/static/images/';
	$filename = $imagename . '.jpg';
	return '<img src="' . $imgpath . $filename . '" alt="' . $filename . '" />';
}



/**
*
* PDF
* @param string name of pdf without extension; assumes pdf
*/

function pdf($file, $linktext) 
{
	$filepath = BASE_URL . '/static/pdf/';
	$filename = $file . '.pdf';
	return '<a href="'. $filepath . $filename .'">' . $linktext . '</a>';
}





/**
*
* YouTube
* @param string url of youtube video
*/

function youtube($yurl) 
{
	$videoid = substr($yurl, strpos($yurl, "v=") + 2);
	return '<div class="yt"></div><iframe width="420" height="315" src="https://www.youtube.com/embed/' . $videoid . '" frameborder="0" allowfullscreen></iframe><div>';
}



/**
*
* JS
* @param resource path to js directory
*/

function js($path = NULL)
{
	$path = ROOT . '/static/js/';
	$base_url = BASE_URL;
	$files = new DirectoryIterator($path);
	while($files->valid()) 
	{
		if(!$files->isDir()) 
		{
			echo "<script src=\"{$base_url}/static/js/{$files->getFilename()}\"></script>\n";
		}
		$files->next();
	}	
}


/**
*
* SECTION
* @param string section name
*/

function section($sectionname)
{
	include(VIEWS . "/sections/{$sectionname}.html");
}




/**
*
* BLOGPOSTS
* @param string class
* @param string id
*/

function blogposts($class=NULL,$id=NULL)
{
	// init month vars
	$jan = '';
	$feb = '';
	$mar = '';
	$apr = '';
	$may = '';
	$jun = '';
	$jul = '';
	$aug = '';
	$sep = '';
	$oct = '';
	$nov = '';
	$dec = '';

	// set class and id if not null
	$c = ($class != NULL ? ' class="' . $class . '"' : '');
	$i = ($id != NULL ? ' id="' . $id . '"' : '');


	$files = array();
	// create new iterator for directory
	$blogposts = new DirectoryIterator(VIEWS . '/blog');

	foreach ($blogposts as $fileinfo)
	{
		if ($fileinfo->isFile())
		{
			$files[$fileinfo->getMTime()] = $fileinfo->getFilename();
		}

	}
	krsort($files);
	

	foreach ($files as $timestamp => $file) :
		
		// break up the filepath to get the filename without extension
		$page = pathinfo($file);
		
		// get month
		$month = date('F', $timestamp);


			switch ($month) {
				case 'January':
					$jan .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'February':
					$feb .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'March':
					$mar .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'April':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'May':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'June':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'July':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'August':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'September':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'October':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'November':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;

				case 'December':
					$apr .= '<li><a href="' . BASE_URL . '/blog/' . $page['filename'] . '/">' . $page['filename'] . '</a></li>' . "\n";
					break;
				
				default:
					# code...
					break;
			}			

	endforeach;



	if($jan != '')
		echo '<h3>January</h3>',
		'<ul' . $c . $i .'>' . "\n" . $jan . '</ul>';
	if($feb != '')
		echo '<h3>February</h3>',
		'<ul' . $c . $i .'>' . "\n" . $feb . '</ul>';
	if($mar != '')
		echo '<h3>March</h3>',
		'<ul' . $c . $i .'>' . "\n" . $mar . '</ul>';
	if($apr != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $apr . '</ul>';
	if($may != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $may . '</ul>';
	if($jun != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $jun . '</ul>';
	if($jul != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $jul . '</ul>';
	if($aug != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $aug . '</ul>';
	if($sep != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $sep . '</ul>';
	if($oct != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $oct . '</ul>';
	if($nov != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $nov . '</ul>';
	if($dec != '')
		echo '<h3>April</h3>',
		'<ul' . $c . $i .'>' . "\n" . $dec . '</ul>';

}





/**
*
* ARG
* @param num uri segment
*/

function getsegments() {
    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}
 
function arg($n) {
    $segs = getsegments();
    return count($segs)>0&&count($segs)>=($n-1)?$segs[$n]:'';
}





/**
*
* NAV
* @param string tag to surround image e.g. li, div, span
*/
function makenav($nav=NULL)
{
	if(!is_array($nav))
	{
		section($nav);
	}
	else
	{
		$list = '<ul>';
		foreach ($nav as $url=>$page) {
			$list .= '<li><a href="'.$url.'/">'.$page.'</a></li>';
		}
		$list .= '</ul>';
		echo $list;		
	}
}

