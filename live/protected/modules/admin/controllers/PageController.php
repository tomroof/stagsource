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
                'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete', 'infoPage'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'expression' => '!Yii::app()->user->isAdmin()',
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
                throw new CHttpException(404, 'Запрашиваемая страница не существует.');
        }
        return $this->_model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $model = new Page;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];

           $vowels = array(" ", ',');
           $permalink = strtolower(str_replace($vowels, "-", $model->title));
           $find_like_permalink = Page::model()->findAll(array('order' => 'permalink', 'condition' => 'permalink LIKE :permalink', 'params' => array(':permalink' => "$permalink%")));
           $listData =  CHtml::listData($find_like_permalink, 'id', 'permalink');
           $model->url = $model->permalink = Functions::generationPermalink($permalink,$listData); 

            if ($model->save())
                $this->redirect(array('admin', 'id' => $model->id));
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

        if (isset($_POST['Page'])) {

            $cur_permalink = $model->permalink;
            $model->attributes = $_POST['Page'];

            if (isset($_POST['Page']['permalink']) && $cur_permalink != $_POST['Page']['permalink']) {

                $vowels = array(" ", ',');
//                $permalink = urlencode(strtolower(str_replace($vowels, "-", $_POST['Page']['permalink'])));
                $permalink = strtolower(str_replace($vowels, "-", $_POST['Page']['permalink']));

                $array_permalink = Page::model()->findAll(array('order' => 'permalink', 'condition' => 'permalink LIKE :permalink', 'params' => array(':permalink' => "$permalink%")));

                if (empty($array_permalink)) {
//                    $model->permalink = urlencode($permalink);
                    $model->permalink = $permalink;
                } else {

                    $arr = CHtml::listData($array_permalink, 'id', 'permalink');

                    foreach ($arr as $value) {
                        $found = preg_replace('/' . preg_quote($permalink) . '\-.*/isU', '', $value);
                    }
                    if ($permalink != $found)
//                        $model->permalink = $permalink . '-' . $found . '-' . ((int) $found + 1);
//                        $model->permalink = urlencode($permalink) . '-' . ((int) $found + 1);
                        $model->permalink = $permalink . '-' . ((int) $found + 1);
                    else
//                        $model->permalink = urlencode($permalink) . '-1';
                        $model->permalink = $permalink . '-1';
                }
                $model->url = $model->permalink;
            }
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            
            $model = $this->loadModel($id);
            if(Page::model()->findByAttributes(array('id'=>$id, 'in_menu'=>1))){
                $model->delete();
                Page::checkMenuPositions();
            } else {
                $model->delete();
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex()
    {

        $criteria = new CDbCriteria(array(
                    'condition' => 'status=' . Page::STATUS_PUBLISHED,
                        //   'order'=>'update_time DESC',
                        //      'with'=>'commentCount',
                ));
        if (isset($_GET['tag']))
            $criteria->addSearchCondition('tags', $_GET['tag']);

        $dataProvider = new CActiveDataProvider('Page', array(
                    'pagination' => array(
                        'pageSize' => 5,
                    ),
                    'criteria' => $criteria,
                ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {

        $model = new Page('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Page']))
            $model->attributes = $_GET['Page'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }



    public function actionInfoPage()
    {
        $this->render($_GET['name']);
    }

}
