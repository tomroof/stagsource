<?php
/**
 * Created by JetBrains PhpStorm.
 * User: spiritvoin
 * Date: 09.06.13
 * Time: 11:30
 * To change this template use File | Settings | File Templates.
 * init seo pack
 *
 * action
 *  $model->attachBehavior('SeoPack', array(
 * 'class' => 'application.modules.seopack.components.SeoPackBeforeSaveBehavior'
 *  ));
 *
 * $model->save();
 *
 * $model->detachBehavior('myBehavior');
 * OR
 * modeles
 * public function behaviors(){
 *  return array(
 *   'SeoPack' => array(
 *    'class' => 'application.modules.seopack.components.SeoPackBeforeSaveBehavior',
 *   ),
 *   );
 *   }
 *
 * Ccontroler
 * public $seoPack = array();
 * public function beforeAction($action)
 * {
 * Yii::import('application.modules.seopack.components.SeopackWidget');
 * $SeopackWidget = new SeopackWidget();
 * $SeopackWidget->run();
 *
 * return parent::beforeAction($action);
 * }
 *      OR
 * layouts
 * $this->widget('application.modules.seopack.components.SeopackWidget');
 *
 *
 * $this->widget('application.modules.seopack.components.SeopackAdminWidget', array('model' => $model));
 *
 * viewaction
 * $this->seoPack = SeoPack::model()->getSeoData('BlogContent', $model->id);
 */

class SeoPackBeforeSaveBehavior extends CActiveRecordBehavior
{
    public function  SeoPackBeforeSaveBehavior (){
        Yii::import('application.modules.seopack.models.SeoPack');
    }

    public function afterSave($event){
        $model= $this->getOwner();
        $request = Yii::app()->request->getPost('SeoPack');
        if(!empty($request)){
        $modelSeoPack = SeoPack::model()->getSeoModel(get_class($model),$model->getPrimaryKey());
        if(!$modelSeoPack)
        {
            $modelSeoPack = new SeoPack();
        }
        #Save SeoPack Data
        $modelSeoPack->attributes = $request;
        $modelSeoPack->model_name = get_class($model);
        $modelSeoPack->object_id = $model->getPrimaryKey();
        $modelSeoPack->save();
        #end Seo Pack
        }
    }
}