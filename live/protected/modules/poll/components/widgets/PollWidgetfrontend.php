<?php
/**
 * Created by JetBrains PhpStorm.
 * User: spiritvoin
 * Date: 10.06.13
 * Time: 13:04
 * To change this template use File | Settings | File Templates.
 */


class PollWidgetfrontend extends CWidget
{
    public $submit=true;
    public $view='_pollfrontend';
    public $model;
    public $return_url;
    public $fixed_issues_type;
    public $scripts = array(
        'pollwidgetfrontend_1_0.js'
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
    }

    public function run()
    {

        $request = Yii::app()->request->getPost('poll');
        if ($request) {
            if (isset($request['old_poll_item_id']) && !empty($request['old_poll_item_id'])) {
                Pollresult::model()->deleteAllByAttributes(array('poll_item_id' => $request['old_poll_item_id'], 'user_id' => Yii::app()->user->id));
            }
            $model = new Pollresult();
            $model->user_id = Yii::app()->user->id;
            $model->attributes = $request;
            $model->save();
            Yii::app()->controller->redirect($request['return_url']);
        }


        $model = PollItem::model()->with('pollRelationResults')->findAllByAttributes(
            array('model_name' => get_class($this->model), 'model_id' => $this->model->getPrimaryKey(),'type'=>PollItem::TYPE_ADDED_BY_ADMIN));
        foreach ($model as $key => $value) {
                $criteria = new CDbCriteria();
                $criteria->compare('poll_item_id', $value->item_id);
                $model_count = Pollresult::model()->count($criteria);
                $value->vote_count = $model_count;
                $value->save();
        }

        $sum = Yii::app()->db->createCommand()
            ->select('sum(vote_count)')
            ->from('tsn_poll_item t')
            ->where('model_name=:model_name AND model_id=:model_id AND type=:type ',
                array(':model_name'=>get_class($this->model),':model_id'=>$this->model->getPrimaryKey(),'type'=>PollItem::TYPE_ADDED_BY_ADMIN))
            ->queryScalar();
        $this->render('_poll_form',

            array('model' => $model,
                'view'=> $this->view,
                'content_model_id' => $this->model->getPrimaryKey(),
                'return_url' => $this->return_url,
                'sum'=>$sum,
            ));
    }

}