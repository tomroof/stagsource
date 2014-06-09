<?php
class CommentsController extends Controller {

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
                'actions' => array('view', 'update', 'delete'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'expression' => '!Yii::app()->user->isAdmin()',
            ),
        );
	}

    public function actionView($id) {
        $model = Comments::model()->findByPk($id);

        $this->render('view', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = Comments::model()->findByPk($id);

        // Uncomments the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Comments'])) {
            $model->attributes = $_POST['Comments'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {

        $model = $this->loadModel($id);
        if ($model) {
            $content = Contents::model()->findByPk($model->id);
            if ($content) {
                $content->content_comment_count = ContentComments::getCommentsCount($model->id);
                $content->save();
            }
            $model->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function loadModel($id) {

        $model = Comments::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}