<?php

class SeopackWidget extends CWidget
{
    public $model;
    public function init()
    {

        // этот метод будет вызван внутри CBaseController::beginWidget()
    }

    public function run()
    {
        $this->generateMetaTags();
    }

    public function generateMetaTags(){
        Yii::import('application.modules.seopack.models.SeoPack');
        $controller = Yii::app()->getController();

        if(!empty($controller->seoPack))
        {
            $seoModel = new SeoPack();
            $seoModel->attributes = $controller->seoPack->attributes;
            $seoModel->seo_title = (!empty($seoModel->seo_title))? $seoModel->seo_title : Settings::getSettingValue('seo_title');
            $seoModel->seo_description = (!empty($seoModel->seo_description)) ? $seoModel->seo_description : Settings::getSettingValue('seo_description');
            $seoModel->seo_keywords = (!empty($seoModel->seo_keywords)) ? $seoModel->seo_keywords : Settings::getSettingValue('seo_keywords');
            $seoModel->seo_canonical = (!empty($seoModel->seo_canonical))?$seoModel->seo_canonical : Settings::getSettingValue('seo_canonical_url');

        }
        else
        {
            $seoModel = new SeoPack();
            $controller->setPageTitle(Yii::app()->name);
            $seoModel->seo_title = Settings::getSettingValue('seo_title');
            $seoModel->seo_description = Settings::getSettingValue('seo_description');
            $seoModel->seo_keywords = Settings::getSettingValue('seo_keywords');
            $seoModel->seo_canonical = Settings::getSettingValue('seo_canonical_url');
        }


        if(!empty($seoModel))
        {
            $robots='all';
            $isNoindex='';
            $isFollow='';
            if($seoModel->seo_noindex == SeoPack::SEO_NOINDEX){
                $isNoindex='noindex,';
            }elseif($seoModel->seo_noindex == SeoPack::SEO_INDEX){
                $isNoindex='index,';
            }
            if($seoModel->seo_nofollow == SeoPack::SEO_NOFOLLOW){
                $isFollow='nofollow';
            }elseif($seoModel->seo_nofollow == SeoPack::SEO_FOLLOW){
                $isFollow='follow';
            }
            $temp = $isNoindex.$isFollow;
            $robots=(!empty($temp)) ? $temp : $robots;
            Yii::app()->clientScript->registerMetaTag($seoModel->seo_title,'title');
            Yii::app()->clientScript->registerMetaTag($seoModel->seo_description,'description');
            Yii::app()->clientScript->registerLinkTag($seoModel->seo_canonical);
            Yii::app()->clientScript->registerMetaTag($seoModel->seo_keywords,'keywords');
            Yii::app()->clientScript->registerMetaTag(CHtml::encode($robots,'robots'));
        }
    }

}

?>