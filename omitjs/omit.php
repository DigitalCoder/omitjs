<?php
/**
 * Class containing some basic php functions
 */
class Omit {
	/**
	 * Constants for JS-files and charset.
	 */
	const JQUERY_LOCATION = 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js';
	const OMIT_LOCATION = 'omit.js';
	const CHARSET = 'UTF-8';

	/**
	 * Meta tags to echo out (can't be generated by js)
	 * @var array
	 */
	public static $facebookMetaTags = array(
		'og:title' => 'Site title for Facebook',
		'og:img' => 'Image for Facebook',
		'og:description' => 'Site descrition for Facebook',
	);
	public static $googleMetaTags = array(
		'keywords' => 'Keywords for search engines',
		'description' => 'Description for search engines',
	);

	/**
	 * Echoes meta tags
	 * @param $tags
	 * @param bool $facebook
	 * @return string
	 */
	public static function metaTags($tags, $facebook = false) {
		$output = '';
		foreach ($tags as $tag => $content) {
			$output .= '<meta '.($facebook ? 'property' : 'name').'="'.$tag.'" content="'.$content.'"/>';
		}
		return $output;
	}

	/**
	 * Constants & variables used by Omit
	 * Parameter used by search engines when crawling omit-sites. This parameter contains the value of #!folder/index
	 */
	const SEO_PARAMETER = '_escaped_fragment_';

	/**
	 * Echoes some basic HTML that shouldn't be generated by the client.
	 */
	public static function echoSiteForVisitor() {
		echo '<!doctype html>'
			.'<html omit="omit">'
				.'<head>'
					.'<meta charset="'.self::CHARSET.'" />'
					.self::metaTags(self::$facebookMetaTags, true)
					.'<link rel="shortcut icon" href="favicon.ico"> '
				.'</head>'
				.'<body>'
					.'<script type="text/javascript" src="'.self::JQUERY_LOCATION.'"></script>'
					.'<script src="'.self::OMIT_LOCATION.'"></script>'
				.'</body>'
			.'</html>';
	}

	/**
	 * Echoes some basic HTML directed towards search engines. This is where you should put your SEO-guy to work.
	 * @param string $file
	 */
	public static function echoSiteForSearchEngine($file) {
		echo '<!doctype html>'
			.'<html>'
				.'<head>'
					.'<title>Search engine title</title>'
					.'<meta charset="'.self::CHARSET.'" />'
					.self::metaTags(self::$facebookMetaTags)
				.'</head>'
				.'<body>'
					.'<h1></h1>'
					.'<p></p>'
				.'</body>'
			.'</html>';
		exit();
	}

	/**
	 * Init Omit and output different things depending on if there is a visitor
	 * or a search engine making the request.
	 */
	public static function init() {
		$file = filter_input(INPUT_GET, self::SEO_PARAMETER, FILTER_SANITIZE_STRING);
		if ($file) {
			self::echoSiteForSearchEngine($file);
		} else {
			self::echoSiteForVisitor();
		}
	}
}

/**
 * Initiate omit when this file is included.
 */
Omit::init();
?>