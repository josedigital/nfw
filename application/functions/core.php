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