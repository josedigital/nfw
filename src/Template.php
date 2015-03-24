<?php

class Template {

	public static $template;

	public static function load($filepath) {

		self::$template = file_get_contents($filepath . '.html');

	}

	public static function replace($var, $content) {

		self::$template = str_replace("#$var#", $content, self::$template);

	}

	public static function publish() {

			eval("?>".self::$template."<?php ?>");

	}

}

?>