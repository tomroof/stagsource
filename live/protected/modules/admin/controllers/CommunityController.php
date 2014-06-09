<?php

class CommunityController extends Controller {

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
                'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Contents;
        $array_category = CHtml::listData(ContentCategories::model()->findAllByAttributes(array('content_type' => "=community")), 'id', 'name');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model->setScenario('community');
        if (isset($_POST['Contents'])) {
            $model->attributes = $_POST['Contents'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->content_type = Contents::TYPE_COMMUNITY;
//            $model->content_author = Yii::app()->user->getID();
            if ($model->save()) {
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_community_create'));
                if (isset($_POST['preview_button'])) {
                    $model->content_status = Contents::STATUS_DRAFT;
                    $this->redirect($model->permalink);
                }
                $this->redirect("/admin/community/admin");
            }
        }

        $this->render('create', array(
            'model' => $model,
            'array_category' => $array_category,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $array_category = CHtml::listData(ContentCategories::model()->findAllByAttributes(array('content_type' => "=community")), 'id', 'name');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model->scenario='community';
        if (isset($_POST['Contents'])) {
            $model->attributes = $_POST['Contents'];
            if ($model->save()) {
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_community_update'));
                if (isset($_POST['preview_button'])) {
                    $model->content_status = Contents::STATUS_DRAFT;
                    $this->redirect($model->permalink);
                }
                $this->redirect(Yii::app()->createUrl('/admin/community/admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'array_category' => $array_category
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Contents');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Contents('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Contents'])) {
            $model->attributes = $_GET['Contents'];
            $model->created_at = (strtotime($model->created_at)) ? date('Y-m-d', strtotime($model->created_at)) : '';
            $author_arr = explode(' ', $model->content_author);
            $model->content_author = '';
            $model->author_name_1 = (isset($author_arr[0]) && !empty($author_arr[0])) ? $author_arr[0] : '';
            $model->author_name_2 = (isset($author_arr[1]) && !empty($author_arr[1])) ? $author_arr[1] : '';
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
    public function loadModel($id) {
        $model = Contents::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contents-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
