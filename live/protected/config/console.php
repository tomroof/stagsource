<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.


//$db_settings = array(
//    'connectionString' => 'mysql:host=178.20.155.30;dbname=stagsource_db',
//    'emulatePrepare' => true,
//    'username' => 'stagsource_u',
//    'password' => 'zDTprb0K',
//    'charset' => 'utf8',
//    'tablePrefix' => 'tsn_',
//    'enableProfiling' => true,
//);

    $db_settings = array(
        'connectionString' => 'mysql:host=localhost;dbname=stagsource',
        'emulatePrepare' => true,
        'username' => 'stagsource',
        'password' => 'vreqXeq72hhznSVW',
        'charset' => 'utf8',
        'tablePrefix' => 'tsn_',
        'enableProfiling' => true,
    );

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.*'
    ),

	// application components
	'components'=>array(

        'db' => $db_settings,

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);