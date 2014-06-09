<?php
/**
 * Created by JetBrains PhpStorm.
 * User: spiritvoin
 * Date: 10.06.13
 * Time: 13:04
 * To change this template use File | Settings | File Templates.
 */


class PollWidgetFrontendImpression extends CWidget
{
    public $submit = true;
    public $view = '_pollfrontend';
    public $model;
    public $return_url;
    public $fixed_issues;
    public $fixed_issues_type;
    public $scripts = array('pollwidgetfrontendImpression_1_0.js');

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
            $criteria = new CDbCriteria();
            $criteria->join=' JOIN tsn_poll_item as poll ON (t.poll_item_id=poll.item_id) ';
            $criteria->compare('poll.model_name',get_class($this->model));
            $criteria->compare('poll.model_id',$this->model->getPrimaryKey());
            $criteria->compare('poll.type',$this->fixed_issues_type);
            $criteria->compare('user_id', Yii::app()->user->id);
            $modelPollResultDelete= Pollresult::model()->findAll($criteria);
            foreach($modelPollResultDelete as $value){
                $value->delete();
            }
            $model = new Pollresult();
            $model->user_id = Yii::app()->user->id;
            $model->attributes = $request;
            $model->save();
        }

        foreach ($this->fixed_issues as $key => $value) {
            $model = PollItem::model()->findByAttributes(
                array('model_name' => get_class($this->model),
                    'model_id' => $this->model->getPrimaryKey(),
                    'type' => $this->fixed_issues_type,
                    'content' => $value,
                ));
            if (!$model) {
                $model = new PollItem();
            }
            $model->model_name = get_class($this->model);
            $model->model_id = $this->model->getPrimaryKey();
            $model->type = $this->fixed_issues_type;
            $model->sort = $key;
            $model->content = $value;
            if ($model->save()) {
                $criteria = new CDbCriteria();
                $criteria->compare('poll_item_id', $model->item_id);
                $model_count = Pollresult::model()->count($criteria);
                $model->vote_count = $model_count;
                $model->save();
            }
        }
        $model = PollItem::model()->with('pollRelationResults')->findAllByAttributes(
            array('model_name' => get_class($this->model),
                'model_id' => $this->model->getPrimaryKey(),
                'type' => $this->fixed_issues_type,
            ));
        $sum = Yii::app()->db->createCommand()->select('sum(vote_count)')
            ->from('tsn_poll_item t')
            ->where('model_name=:model_name AND model_id=:model_id AND type=:type ',
                array(':model_name' => get_class($this->model), ':model_id' => $this->model->getPrimaryKey(), ':type' => $this->fixed_issues_type))
            ->queryScalar();
        $this->render('_poll_form',
            array('model' => $model,
                'view' => $this->view,
                'content_model_id' => $this->model->getPrimaryKey(),
                'return_url' => $this->return_url,
                'sum' => $sum,
            ));
    }

}