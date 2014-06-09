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
                'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete', 'ajax_add_item'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'expression' => '!Yii::app()->user->isAdmin()',
            ),
        );
	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new SpamReport;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SpamReport'])) {
            $model->attributes = $_POST['SpamReport'];
            if ($model->save())
                $this->redirect("");
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SpamReport'])) {
            $model->attributes = $_POST['SpamReport'];
            $model->save();
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('SpamReport');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SpamReport('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SpamReport'])){
            $model->attributes = $_GET['SpamReport'];
            $author_arr = explode(' ', $model->user_reported_name);

            $model->author_name_1 = (isset($author_arr[0]) && !empty($author_arr[0])) ? $author_arr[0] : '';
            $model->author_name_2 = (isset($author_arr[1]) && !empty($author_arr[1])) ? $author_arr[1] : '';
            $model->create_datetime = (strtotime($model->create_datetime)) ? date("Y-m-d", strtotime($model->create_datetime)) : "";
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = SpamReport::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'spam-report-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
            $model_spam->save();

        }
    }


}
