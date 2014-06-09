<?php

class DancersController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index'),
//                'expression' => 'Yii::app()->user->isGuest || !Yii::app()->user->isGuest',
                'expression' => 'false',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Contents', array(
                    'criteria' => array(
                        'order' => 'created_at DESC',
                        'join' => 'JOIN ' . Yii::app()->db->tablePrefix . 'user AS u ON u.id=t.dancer_author',
                        'condition' => 'content_type = :content_type',
                        'condition' => 'u.pro_status = ' . User::STATUS_USER_PRO,
                        'params' => array(':content_type' => Contents::TYPE_VENDOR),
                    ),
                    'pagination' => array(
                        'pageSize' => 12,
                    ),
                ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

}