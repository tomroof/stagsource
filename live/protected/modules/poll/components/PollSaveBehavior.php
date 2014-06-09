<?php
class PollSaveBehavior extends CActiveRecordBehavior
{
    public $model;
    public $controller;
    public $action;
    public $params = array();

    public function PollSaveBehavior (){
        Yii::import('application.modules.poll.models.*');
    }

    public function afterSave($model)
    {
        $request = Yii::app()->request->getPost('PollItem');
        if (!empty($request['content'])) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('item_id', array_diff($request["id"], array('')));
            $criteria->index = 'item_id';
            $model = PollItem::model()->findall($criteria);
            foreach (array_diff($request["id"], array('')) as $key => $value) {
                $model[$value]->content = $request['content'][$key];
                if(isset($request['img'][$key])){
                    $model[$value]->img = $request['img'][$key];
                }
                $model[$value]->model_name = get_class($this->model);
                $model[$value]->model_id = $this->model->getPrimaryKey();
                $model[$value]->type=PollItem::TYPE_ADDED_BY_ADMIN;
                $model[$value]->save();
                unset($request["id"][$key]);
            }

            foreach ($request["id"] as $key => $value) {
                if($request['content'][$key]=='' && $request['content'][$key]=='' ){
                    continue;
                }
                $model = new PollItem();
                $model->model_name = get_class($this->model);
                $model->model_id = $this->model->getPrimaryKey();
                $model->type = PollItem::TYPE_ADDED_BY_ADMIN;
                $model->content = $request['content'][$key];
                if(isset($request['img'][$key])){
                    $model->img = $request['img'][$key];
                }
                $model->save();
            }
        }
        if (!empty($request['delete'])) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('item_id', array_diff($request['delete'], array('')));
            PollItem::model()->deleteAll($criteria);
        }
//                return parent::afterSave();

    }


}