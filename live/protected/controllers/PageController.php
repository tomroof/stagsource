<?php

class PageController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = null;

    /**
     * @return array action filters
     */
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
                'actions' => array('index', 'view', 'contact', 'captcha', 'InfoPage', 'premiumServices'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'expression' => '$user->isAdmin()',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'menu', 'AjaxChangeOrder'),
                'expression' => '$user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView()
    {
        //$page = $this->loadModel();
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    private $_model;

    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id'])) {
                if (Yii::app()->user->isGuest)
                    $condition = 'status=' . Page::STATUS_PUBLISHED
                            . ' OR status=' . Page::STATUS_ARCHIVED;
                else
                    $condition = '';
                $this->_model = Page::model()->findByPk($_GET['id'], $condition);
            }
            if (isset($_GET['permalink'])) {
                $this->_model = Page::model()->find('permalink = "' . $_GET['permalink'] . '"');
            }


            if ($this->_model === null)
                throw new CHttpException(404, 'Page not found.');
        }
        return $this->_model;
    }

   
//    public function actionIndex()
//    {
//
//        $criteria = new CDbCriteria(array(
//                    'condition' => 'status=' . Page::STATUS_PUBLISHED,
//                        //   'order'=>'update_time DESC',
//                        //      'with'=>'commentCount',
//                ));
//        if (isset($_GET['tag']))
//            $criteria->addSearchCondition('tags', $_GET['tag']);
//
//        $dataProvider = new CActiveDataProvider('Page', array(
//                    'pagination' => array(
//                        'pageSize' => 5,
//                    ),
//                    'criteria' => $criteria,
//                ));
//
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
//    }

    
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionMenu()
    {

        $inMenu = array();
        $notInMenu = array();

        $pages = Page::getMenu();

        foreach ($pages as $key => $value) {
            if ($value['in_menu'] == 1) {
                $inMenu['id_' . $value['id']] = $value['title'];
            } else {
                $notInMenu['id_' . $value['id']] = $value['title'];
            }
        }

        $this->render('menu', compact('inMenu', 'notInMenu'));
    }

    public function actionAjaxChangeOrder()
    {
        $orderedPages = array();
        $tmp = explode(',', $_POST['Order']);
        foreach ($tmp as $item) {
            $tmp1 = explode('_', $item);
            $orderedPages[] = $tmp1[1];
        }
        $pages = Page::getMenu();
        foreach ($pages as $page) {
            if (in_array($page['id'], $orderedPages)) {
                $order = array_search($page['id'], $orderedPages);
                $pageData = array(
                    'in_menu' => 1,
                    'menu_order' => $order
                );
            } else {
                $pageData = array(
                    'in_menu' => 0,
                    'menu_order' => 0
                );
            }
            Yii::app()->db->createCommand()->
                    update('tbl_pages', $pageData, 'id=:id', array(
                        ':id' => $page['id']
                    ));
        }
    }

//    public function actionPremiumServices ()
//    {
//        $this->render('premium_services');
//    }

}
