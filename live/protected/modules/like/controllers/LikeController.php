<?php

class LikeController extends Controller
    {

    public function actionIndex(){


//        $data = Yii::app()->request->getQuery('Like');
        $data = Yii::app()->request->getPost('Like');
        $modelLike = Like::model()->findByAttributes($data);
        if(!$modelLike)
        {
            $modelLike = new Like();
            $modelLike->attributes = $data;
            if($modelLike->save())
            {
                echo json_encode(array('className' => '', 'countLikes' => Like::getCountLikes(
                                  $data['model_name'], $data['model_id'], $data['like_type'])));
                Yii::app()->end();
            }
        }
        else
        {
            $modelLike->delete();
            echo json_encode(array('className' => 'active', 'countLikes' => Like::getCountLikes(
                              $data['model_name'], $data['model_id'], $data['like_type'])));
            Yii::app()->end();
        }
        Yii::app()->end();
    }

    }