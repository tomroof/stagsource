<?php

/**
 *  SpamButtonWidget widget
 *  @package momentfree.spam_report.components
 */

class SpamButtonWidget extends CWidget {


    public $params = array();
    public $model = NULL;
    public $model_id = 0;

    private $_module = NULL;

    public function init() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->assetManager->publish(
                        dirname(__FILE__) . '/assets/js/report_button.js'
                )
        );

        parent::init();
    }

    public function run() {
        if(Yii::app()->user->isGuest) {
            return;
        }

        $criteria = new CDbCriteria();
        $criteria->condition = "model = :model AND model_id = :model_id AND user_reported = :user_id";
        $criteria->params = array(':model' => $this->model, ":model_id" => $this->model_id, ':user_id' => Yii::app()->user->id);
        $model = SpamReport::model()->find($criteria);
        if($model == NULL) {
            $this->render('report_button');
        }

    }

}

?>