<?php
/*!
 * Nanite
 * Copyright (C) 2012-2014 Jack P.
 * https://github.com/nirix
 *
 * Nanite is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; version 3 only.
 *
 * Nanite is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Nanite. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Shortcut to the Nanite::get() method.
 *
 * @param string $route
 * @param function $function
 */
function get($route, $function)
{
    Nanite::get($route, $function);
}

/**
 * Shortcut to the Nanite::post() method.
 *
 * @param string $route
 * @param function $function
 */
function post($route, $function)
{
    Nanite::post($route, $function);
}


/**
*
* LOAD VIEW
* @param string $view = name of view
* @param array $vars = array of template variables
*/

function loadview($view, $vars = NULL)
{
	// $template = new Template;
	Template::load(VIEWS . "/" . $view);
	if($vars != NULL)
	{
		foreach ($vars as $key => $value) 
		{
			Template::replace($key, $value);
		}
	}
	return Template::publish();
}







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
			#echo 'yes ' . $thumbs->getFilename() . '<br>';
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
	$images = ROOT . '/static/images/';
	$img = new DirectoryIterator($images);
	$imgpath = BASE_URL . '/static/images/';
	$filename = $imagename;

	while($img->valid()) 
	{
		if($img->getFilename() == $filename) 
		{
			return '<img src="' . $imgpath . $filename . '" />';
		}
		$img->next();
	}
}



/**
*
* JPG
* @param string name of image without extension; assumes jpg
*/

function jpg($imagename) 
{
	$images = ROOT . '/static/images/';
	$img = new DirectoryIterator($images);
	$imgpath = BASE_URL . '/static/images/';
	$filename = $imagename . '.jpg';

	while($img->valid()) 
	{
		if($img->getFilename() == $filename) 
		{
			return '<img src="' . $imgpath . $filename . '" alt="' . $filename . '" />';
		}
		$img->next();
	}
}


/**
*
* NAV
* @param string tag to surround image e.g. li, div, span
*/
function makenav()
{
	$dir_writable = substr(sprintf('%o', fileperms(VIEWS)), -4) == "0775" ? "true" : "false";
	echo $dir_writable;
}

function getnav() 
{
	$pages = new DirectoryIterator(VIEWS);
	
	
	while($pages->valid()) 
	{
		if(!$pages->isDir()) 
		{
			$page = pathinfo($pages->getFilename(), PATHINFO_FILENAME);
			echo '<li><a href="' . BASE_URL . '/' . $page . '/">' . $page . '</a></li>';
		}
		$pages->next();

	}

}


/**
*
* TIMEIT
* 
*/
function starttime()
{
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$start = $time;
}
function endtime()
{
	// $time = microtime();
	// $time = explode(' ', $time);
	// $time = $time[1] + $time[0];
	// $finish = $time;
	// $total_time = round(($finish - $start), 4);
	// echo 'Page generated in '.$total_time.' seconds.';
}