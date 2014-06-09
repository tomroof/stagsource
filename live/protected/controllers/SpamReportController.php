<?php

class SpamReportController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(

            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('Ajax_add_item'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

       /**
     * Add item to spam
     */
    public function actionAjax_add_item()
    {

        if (Yii::app()->user->isGuest) {
            die();
        }

        $model_spam = new SpamReport;
        if (isset($_POST['SpamReport'])) {
            $model_spam->attributes = $_POST['SpamReport'];
            $model_spam->user_reported = Yii::app()->user->id;
            $model_spam->model = $_POST['SpamReport']['model'];
            $model_spam->causes = $_POST['ids'];
            if($model_spam->save()){
                Yii::app()->user->setFlash('success', "Thanks for reporting this content. We'll look into it.");
            }

        }
    }


}
