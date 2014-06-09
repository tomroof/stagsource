<?php

class AdminController extends Controller
{

    const ADMIN_ROLE = 1;
    const USER = 2;    //user

//    const SELLER_ROLE = 3;  //producer

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array('index'),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {




        if (!Yii::app()->user->id) {
            $this->_login();
        } else {
            $this->_dashboard();
        }
    }

    public function _login()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->createUrl('admin'));
            }
        }
        // display the login form
        $this->renderPartial('login_tsn', array('model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->createUrl('/admin'));
    }

    public function _dashboard()
    {

        $admin = User::model()->countUsers(array('role_id' => self::ADMIN_ROLE));
        $user = User::model()->countUsers(array('role_id' => self::USER));

        $all_users = User::model()->countUsers(array(), 'all');

        $users_percent['admin'] = round($admin / $all_users * 100);
        $users_percent['user'] = round($user / $all_users * 100);



        $this->render('index', array(
            'admin' => $admin,
            'user' => $user,
            'all_users' => $all_users,
            'users_percent' => $users_percent,
        ));
    }

    public function actionChartSpecializations()
    {
        $model_spec = Specializations::model();
        $model_spec->unsetAttributes();  // clear any default values
        if (isset($_GET['Specializations']))
            $model_spec->attributes = $_GET['Specializations'];

        $model_spec_rel = SpecializationsRelations::model();



        $total_spec = $model_spec->count();
        $array_spec = CHtml::listData($model_spec->findAll(), 'id', 'id');
        $array_not_null_spec = array();

        //Получаем масив специализаций которые используются
        foreach ($array_spec as $item) {
            if ($model_spec_rel->countByAttributes(array('specialization_id' => $item)) != 0) {
                $array_not_null_spec[] = $item;
            }
        }

        $this->render('chartSpecializations', array(
            'model_spec' => $model_spec,
            'model_spec_rel' => $model_spec_rel,
            'total_spec' => $total_spec,
            'array_not_null_spec' => $array_not_null_spec
        ));
    }

    public function actionRegistredByCategory()
    {
        $model = new Resources('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Resources']))
            $model->attributes = $_GET['Resources'];

        $this->render('registredByCategory', array(
            'model' => $model,
        ));
    }

}

