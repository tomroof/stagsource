<?php

class UserController extends Controller
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
//            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete', 'loginasuser', 'dynamicstate'),
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
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->passwd = md5($_POST['User']['passwd']);
//            $model->status = User::STATUS_USER_ACTIVE;
//            $model->date_create = date("Y-m-d");
            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('admin'));
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
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $attributes = $_POST['User'];
            unset($attributes['passwd']);

            $model->attributes = $attributes;
            if ($model->passwd != $_POST['User']['passwd'] && !empty($_POST['User']['passwd'])) {
                $model->passwd = md5($_POST['User']['passwd']);
            }
            if ($model->validate()) {
                if ($model->save())
                    $this->redirect(array('admin'));
            }
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
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])){
            $model->attributes = $_GET['User'];
            $model->date_create = (strtotime($model->date_create)) ? date("Y-m-d", strtotime($model->date_create)) : "";
        }


        $this->render('admin', array(
            'model' => $model
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoginasuser($id)
    {

        Yii::app()->user->setStateKeyPrefix('_user');
//        $state = Yii::app()->user->getStateKeyPrefix();

        $identity = new UserIdentity(null, null, $id);
        $res = Yii::app()->user->login($identity);

        if ($res) {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    public function actionDynamicstate()
    {
        
        $data = States::model()->findAllByAttributes(array('country_id' => $_POST['User']['country_id']));
        if(!empty($data) && $_POST['User']['country_id'] != 220){
            $data = CHtml::listData($data, 'id', 'state_name_en');
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }  else {
             echo 'none';
        }
        
    }

    public function actionadminProRequest()
    {
        if($_GET['proStatus'] == 'accept')
            $pro_status = User::STATUS_USER_PRO;
        else
            $pro_status = 'NULL';
        $sql = 'UPDATE  tsn_user SET  pro_status = ' . $pro_status . ' WHERE id = ' . $_GET['id'];
        Yii::app()->db->createCommand($sql)->query();
        $this->redirect(Yii::app()->createUrl('/admin/user/admin'));
    }

}
