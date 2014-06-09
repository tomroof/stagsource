<?php

class PollController extends Controller
{
    // не пригодился abstract :)
//    public function actionIndex()
//    {
//        $request = Yii::app()->request->getPost('poll');
//        if ($request) {
//            if (isset($request['old_poll_item_id']) && !empty($request['old_poll_item_id'])) {
//                Pollresult::model()->deleteAllByAttributes(array('poll_item_id' => $request['old_poll_item_id'], 'user_id' => Yii::app()->user->id));
//            }
//            $model = new Pollresult();
//            $model->user_id = Yii::app()->user->id;
//            $model->attributes = $request;
//            $model->save();
//            $this->redirect($request['return_url']);
//        }
//    }
}