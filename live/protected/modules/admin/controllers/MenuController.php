<?php

class MenuController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = null;

    /**
     * @return array action filters
     */
    public function filters() {
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
                'actions' => array('admin', 'view', 'update', 'delete', 'menu', 'ajaxChangeOrder', 'infoPage'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'expression' => '!Yii::app()->user->isAdmin()',
            ),
        );
	}

    public function loadModel() {
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

    public function actionView() {
        //$page = $this->loadModel();
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    private $_model;

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request

            $model = $this->loadModel($id);
            if (Page::model()->findByAttributes(array('id' => $id, 'in_menu' => 1))) {
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

    /**
     * Manages all models.
     */
    public function actionAdmin() {


        $model = new Page('add_update_link');
        $modelForm = new Page('add_update_link');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Page']))
        $model->attributes = $_GET['Page'];

        if (isset($_POST['Page'])) {
            $modelForm->attributes = $_POST['Page'];
            $modelForm->link = $_POST['Page']['url'];
            $modelForm->content = "link";
            $modelForm->status = Page::STATUS_PUBLISHED;
            $vowels = array(" ", ',');
            $permalink = strtolower(str_replace($vowels, "-", $_POST['Page']['title']));
            $array_permalink = Page::model()->findAll(array('order' => 'permalink', 'condition' => 'permalink LIKE :permalink', 'params' => array(':permalink' => "$permalink%")));
            if (empty($array_permalink)) {
                $modelForm->permalink = $permalink;
            } else {
                $arr = CHtml::listData($array_permalink, 'id', 'permalink');
                foreach ($arr as $value) {
                    $found = preg_replace('/' . preg_quote($permalink) . '\-.*/isU', '', $value);
                }
                if ($permalink != $found)
//                    $model->permalink = $permalink . '-' . $found . '-' . ((int) $found + 1);
                $modelForm->permalink = $permalink . '-' . ((int) $found + 1);
                else
                $modelForm->permalink = $permalink . '-1';
            }
            $modelForm->url = $modelForm->link;
            if ($modelForm->save())
                $this->redirect(Yii::app()->createUrl('/admin/menu/admin'));
        }


        $this->render('admin', array(
            'model' => $model,
            'modelForm'=>$modelForm
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionMenu() {
        if (!isset($_GET['language']))
            $_GET['language'] = 'en';


        $first_menu_key = Yii::app()->params['menus'];
        if (isset($first_menu_key) && !empty($first_menu_key)) {
            $first_menu_key = key($first_menu_key);
        } else {
            echo CHtml::link('Back to Admin', '/admin');
            die("<br/>Check menu list in config/main.php : params=>menus");
        }

        if (!isset($_GET['menu_key'])):
            $this->redirect('/admin/menu/menu?menu_key=' . $first_menu_key);
        else:
            $first_menu_key = $_GET['menu_key'];

            $inMenu = array();
            $notInMenu = array();

            $pages = Page::model()->getMenu($_GET['language']);

            $criteria= new CDbCriteria();
            $criteria->with='page';
            $criteria->compare('menu_key',$first_menu_key);
            $criteria->compare('language', $_GET['language']);
            $criteria->compare('page.status',Page::STATUS_PUBLISHED);
            $menu_pages= MenuManager::model()->findAll($criteria);
//            $menu_pages = MenuManager::model()->findAllByAttributes(array('menu_key' => $first_menu_key, 'language' => $_GET['language']));
            foreach ($menu_pages as $key => $value) {
                $inMenu['id_' . $value->page_id]['content'] = $value->page->title;
                $inMenu['id_' . $value->page_id]['lvl'] = $value->lvl;
            }

            foreach ($pages as $key => $value) {
                $notInMenu['id_' . $value['id']]['content'] = $value['title'];
                $notInMenu['id_' . $value['id']]['lvl'] = 0;
            }

            $this->render('menu', compact('inMenu', 'notInMenu'));
        endif;
    }

    public function actionAjaxChangeOrder() {
        if (!isset($_GET['language']))
            $_GET['language'] = 'en';
        if (isset($_GET["language"])) {
            MenuManager::model()->deleteAllByAttributes(array('menu_key' => $_GET['menu_key'], 'language' => $_GET['language']));
        }
        if (isset($_GET["id"]) && isset($_GET['level']) && !empty($_GET["id"]) && isset($_GET['menu_key'])) {
            $ids = $_GET['id'];
            $lvls = $_GET['level'];

            parse_str($ids, $ids);
            parse_str($lvls, $lvls);

            $ids = $ids['id'];
            $lvls = $lvls['lvl'];

            foreach ($ids as $key => $id) {
                $lvl = $lvls[$key];
                $model = new MenuManager();
                $model->page_id = $id;
                $model->lvl = $lvl;
                $model->menu_key = $_GET['menu_key'];
                $model->menu_order = $key;
                $model->language = $_GET['language'];
                $model->save();
            }
//      MenuManager::checkMenuPositions($_GET['menu_key']);
        }
    }

    public function actionInfoPage() {
        $this->render($_GET['name']);
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Page']) && !empty($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
//            $model->links_icon = $_POST['Page']['links_icon'];
            $model->link = $_POST['Page']['url'];
            $model->url = $model->link;
            if ($model->save())
                $this->redirect(array('admin'));
        }



        $this->render('update', array(
            'model' => $model,
        ));
    }

}
