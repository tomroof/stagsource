<?php

class SeoPackModule extends CWebModule
{
     protected static $moduleUrlRules = array(
//        'qwerty/SeoPack' => '/seopack/seopack/index',
//        'filter/*' => '/blog/content/filter',
//        'tag/<title>/<category:[a-z0-9-]+>' => '/blog/content/tag/title/<title>',
//        'poll/vote' => '/blog/content/ajaxPollAnswer',
//        'tag/<title>' => '/blog/content/tag/title/<title>',
//
//        'community/add' => '/blog/community/add',
//        'community/<url:[a-z0-9-]+>' => '/blog/community/view',
//        'community/*' => '/blog/community/list',
//
//        'category/<url:[a-z0-9-]+>/*' => '/blog/content/viewCategory',
//        'content/<url:[a-z0-9-]+>/*' => '/blog/content/viewContent',
    );

    /**
     *  Убрать для PHP 5.3
     */
    public static function getModuleUrlRules()
    {
        return self::$moduleUrlRules;
    }
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'seopack.models.*',
			'seopack.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
