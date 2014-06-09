<?php
/**
 * Created by JetBrains PhpStorm.
 * User: spiritvoin
 * Date: 10.06.13
 * Time: 13:04
 * To change this template use File | Settings | File Templates.
 */


class PollWidgetAdmin extends CWidget
{
    public $img=false;
    public $model;
    public $fixed_issues;
    public $fixed_issues_type;
    public $scripts = array(
        'pollwidgetadmin_1_0.js'
    );
    public $css = array(
        'pollwidgetadmin.css'
    );

    public function init()
    {
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::import('application.modules.poll.models.*');
        $cs = Yii::app()->clientScript;
        foreach ($this->scripts as $script) {
            $cs->registerScriptFile(
                Yii::app()->assetManager->publish(
                    dirname(__FILE__) . '/assets/js/' . $script
                )
            );
        }
        foreach ($this->css  as $css) {
            $cs->registerCssFile(
                Yii::app()->assetManager->publish(
                    dirname(__FILE__) . '/assets/css/' . $css
                )
            );
        }
    }

    public function run()
    {
        $model_PollItem = PollItem::model()->findAllByAttributes(
            array('model_name' => get_class($this->model),
                'model_id' => $this->model->getPrimaryKey(),
                'type' => PollItem::TYPE_ADDED_BY_ADMIN)
        );
        $model_new = new PollItem();
        $this->render('_polladmin', array('model' => $model_PollItem, 'model_new' => $model_new));
    }

}