<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Lingo\Redirect',
));

if (version_compare(VERSION, '3.3', '<'))
{
	$strPageErrorFile = 'system/modules/redirect_404/classes/old/PageError404.php';
}
else
{
	$strPageErrorFile = 'system/modules/redirect_404/classes/PageError404.php';
}

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Lingo\Redirect\PageError404'	=> $strPageErrorFile
));
