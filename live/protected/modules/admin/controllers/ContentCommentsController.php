<?php

class ContentCommentsController extends Controller {

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
        $model = new ContentComments;

        $request = Yii::app()->request;
        $postContent = $request->getPost('ContentComments');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if ($postContent) {
            $model->attributes = $postContent;
            if ($model->validate()) {

                if ($model->save()) {
                    $content = Contents::model()->findByPk($model->id);

                    if ($content) {
                        $content->content_comment_count = ContentComments::getCommentsCount($model->id);
                        $content->save();
                    }
                    $this->redirect("/admin/contentComments/admin");
                }
            }
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
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $spamId = Yii::app()->request->getQuery("spId");
        if($spamId)
            Yii::app()->db->createCommand()->update('{{spam_report}}', array('status' => SpamReport::SPAM_STATUS_READ), 'id=:spamId', $params = array(':spamId'=>$spamId) );

        if (isset($_POST['ContentComments'])) {
            $model->attributes = $_POST['ContentComments'];
            if ($model->save())
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_comments_update'));
            if (isset($_POST['preview_button'])) {
                $this->redirect($model->link());
            }
            $this->redirect(Yii::app()->request->requestUri);
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
    public function actionDelete($id) {


        $model = $this->loadModel($id);
        if ($model) {
            $content = Contents::model()->findByPk($model->id);
            if ($content) {
                $content->content_comment_count = ContentComments::getCommentsCount($model->id);
                $content->save();
            }
            $model->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ContentComments');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ContentComments('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ContentComments']))
            $model->attributes = $_GET['ContentComments'];

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
        $model = ContentComments::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'content-comments-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
