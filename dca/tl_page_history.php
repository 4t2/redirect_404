<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

$GLOBALS['TL_DCA']['tl_page_history'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'				=> 'Table',
		'ctable'					=> array('tl_page'),
		'switchToEdit'				=> false,
		'enableVersioning'			=> false,

		'sql' => array
		(
			'keys' => array
			(
				'id'		=> 'primary',
				'pid'		=> 'index',
				'alias'		=> 'index',
				'language'	=> 'index',
				'dns'		=> 'index'
			)
		)
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'			=> "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'			=> "int(10) unsigned NOT NULL"
		),
		'alias' => array
		(
		 	'sql'			=> "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		 ),
		'language' => array
		(
		 	'sql'			=> "varchar(5) NOT NULL default ''"
		),
		'dns' => array
		(
		 	'sql'			=> "varchar(128) NOT NULL default ''"
		)
	)
);
