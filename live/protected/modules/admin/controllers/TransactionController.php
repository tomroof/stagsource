<?php

class TransactionController extends Controller {

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
                'actions' => array('index', 'view'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'expression' => '!Yii::app()->user->isAdmin()',
            ),
        );
	}

    public function actionIndex() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];


        $this->render('index', array(
            'model' => $model
        ));
    }

    public function actionView($id) {
        $model = new Transaction('search');
        $model->unsetAttributes(); 
        
        if(isset($_GET['Transaction']))
            $model->attributes=$_GET['Transaction'];
           
        $this->render('view', array(
            'model' => $model,
            'user_id'=>$id,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */
}

?>
