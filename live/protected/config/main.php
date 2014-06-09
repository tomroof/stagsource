<?php
/*
$db_settings = array(
            'connectionString' => 'mysql:host=178.20.155.30;dbname=stagsource_db',
            'emulatePrepare' => true,
            'username' => 'stagsource_u',
            'password' => 'zDTprb0K',
            'charset' => 'utf8',
            'tablePrefix' => 'tsn_',
            'enableProfiling' => true,
        );
$cache['name']='';
$cache['cache']=array();
if ($_SERVER["SERVER_ADDR"] == '162.242.160.89') {
$db_settings = array(
            'connectionString' => 'mysql:host=localhost;dbname=stagsource',
            'emulatePrepare' => true,
            'username' => 'stagsource',
            'password' => 'vreqXeq72hhznSVW',
            'charset' => 'utf8',
            'tablePrefix' => 'tsn_',
            'enableProfiling' => true,
        );
    $cache['name']='cache';
    $cache['cache']=array(
        'class'=>'CApcCache',
    );
}
*/

/*
//// LIVE
$db_settings = array(
            'connectionString' => 'mysql:host=localhost;dbname=stagsource_com',
            'emulatePrepare' => true,
            'username' => 'stagsource_com',
            'password' => 'QteO(Cay[G*T',
            'charset' => 'utf8',
            'tablePrefix' => 'tsn_',
            'enableProfiling' => true,
        );
    $cache['name']='cache';
    $cache['cache']=array(
        'class'=>'CApcCache',
    );
*/

$db_settings = array(
            'connectionString' => 'mysql:host=localhost;dbname=staglive_tmp',
            'emulatePrepare' => true,
            'username' => 'staglivetmp',
            'password' => '56.&SiFQoOxq',
            'charset' => 'utf8',
            'tablePrefix' => 'tsn_',
            'enableProfiling' => true,
        );
    $cache['name']='cache';
    $cache['cache']=array(
        'class'=>'CApcCache',
    );
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
// Yii::app()->theme = 'fashion';
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'StagSource',
    'timeZone' => 'America/Los_Angeles',
    // preloading 'log' component
    'preload' => array('log', 'maintenanceMode'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*',
        'application.modules.like.*',
        'application.components.ImageHandler.CImageHandler',
    ),
	
		
    'modules' => array(
// uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'generatorPaths' => array(
                'ext.giix-core', // giix generators
            ),
            'password' => '123321',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'admin',
        'like',
        'poll',
    ),
    // application components
    'components' => array(
        $cache{'name'}=>$cache['cache'],
        'facebook' => array(
            'class' => 'ext.yii-facebook-opengraph.SFacebook',
            'appId' => '337545633049074', // needed for JS SDK, Social Plugins and PHP SDK
            'secret' => 'e6490fe605d0bfa9307381858bdef3af', // needed for the PHP SDK
//            'appId' => '237325766427272', // test
//            'secret' => 'fa49ae581e405165aeefef831e524e35', // test
//            'appId' => '606393366050122', // needed for JS SDK, Social Plugins and PHP SDK
//            'secret' => 'a9cd6341a015185db02b4cc6d2804944', // needed for the PHP SDK
        //'fileUpload'=>false, // needed to support API POST requests which send files
        //'trustForwarded'=>false, // trust HTTP_X_FORWARDED_* headers ?
        //'locale'=>'en_US', // override locale setting (defaults to en_US)
        //'jsSdk'=>true, // don't include JS SDK
        //'async'=>true, // load JS SDK asynchronously
        //'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
        //'status'=>true, // JS SDK - check login status
        //'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
        //'oauth'=>true,  // JS SDK - enable OAuth 2.0
        //'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
        //'frictionlessRequests'=>true, // JS SDK - enable frictionless requests for request dialogs
        //'html5'=>true,  // use html5 Social Plugins instead of XFBML
        //'ogTags'=>array(  // set poll OG tags
        //'title'=>'MY_WEBSITE_NAME',
        //'description'=>'MY_WEBSITE_DESCRIPTION',
        //'image'=>'URL_TO_WEBSITE_LOGO',
        //),
        ),
        'user' => array(
// enable cookie-based authentication
            'class' => 'application.components.WebUser',
            'allowAutoLogin' => true,
            'autoRenewCookie' => true,
            'identityCookie' => false,
            'loginUrl' => array('/#login_popup'),
            'StateKeyPrefix' => '_user'
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '/' => '/contents/index',
//                'categories/<url>'=>'/ContentCategories/view/<url>',
                'category/view/<url>/*' => '/category/view/url/<url>',
                'category/community/<url>/*' => '/category/community/url/<url>',
                'admin/' => '/admin/admin/',
//                'page/<url:[\%\+A-Za-z-\d+]+>' => '/page/view/permalink/<url>',
                'contact' => '/site/contact',
//                'page/premium-services' => '/page/premiumServices',
                'page/<url>' => '/page/view/permalink/<url>',
                'vendor/<name>' => '/contents/vendorview/name/<name>',
                'contents/<id:\d+>/<title>' => '/contents/view/<title>',
                'Community/<id:\d+>/<title>' => '/Community/view/<title>',
                'events' => '/contents/Events',
                'news' => '/contents/News',
                'like' => '/like/like/index',
                'poll' => '/poll/poll/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/c_id/<c_id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'maintenanceMode' => array(
            'class' => 'application.extensions.MaintenanceMode.MaintenanceMode',
            'message' => 'Sorry this site is temporarily unavailable, work is underway',
            'capUrl' => 'site/MaintenanceMode',
            'urls' => array('admin'),
        ),
        // uncomment the following to use a MySQL database

        'db' => $db_settings,
        //stagsource_db
        //stagsource_u
        //zDTprb0K
        'errorHandler' => array(
// use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
//        'log' => array(
//            'class' => 'CLogRouter',
//            'enabled' => true,
//            'routes' => array(
//                array(
//                    'class' => 'CFileLogRoute',
//                    'levels' => 'error, warning',
//                ),
//                array(
//                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
//                    'ipFilters' => array('127.0.0.1', '192.168.1.215'),
//                ),
//            ),
//        ),

    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']486512871386079
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'info@stagsource.com',
        'facebook' => array('appId' => '337545633049074', // needed for JS SDK, Social Plugins and PHP SDK
            'secret' => 'e6490fe605d0bfa9307381858bdef3af',),
//        'facebook' => array(
//            'appId' => '237325766427272', // test
//            'secret' => 'fa49ae581e405165aeefef831e524e35', // test
//        ),
        'menus' => array(
//            '_head' => 'Header Menu',
            '_sidebarMenu' => 'Sidebar Menu',
//            '_sidebar_bottom' => 'Sidebar Bottom Menu',
            '_footer' => 'Footer Menu (3 column)',
        ),
        'twitter' => array(
            'consumerKey' => 'JPwiLouxzGfDApCCTo9zVA',
            'consumerSecret' => 'ZDDw6z7XTxhfyTL79vVUCXcfPGnss0jUfjGLjNqTus',
            'accessToken' => '91552323-FeYSocxrXhtXk7XBj5MCtF9LBFfKKwuzYD2lhgmof',
            'accessTokenSecret' => '5F4YM9mzZbmlcqjWwTGqYCEoibcD4xf3Ah1Kr5oM',
        ),
//        'instagram' =>array(
//            'clientId' => '2c49ed430a56431f991d3834f5f042cf',
//            'clientSecret' => '142c102dde924e768caa34ef9d57d9a3',
//        ),

    ),
);
