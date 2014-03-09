<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Lingo\Redirect',
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Lingo\Redirect\PageError404'	=> 'system/modules/redirect_404/classes/PageError404.php'
));
