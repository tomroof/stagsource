<?php

class ContentsController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $content_type_templates;

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
    public function accessRules() {
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

    public function array_walk_funct(&$item, $key) {
        global $templates;
        if (strpos($item, '_') === false) {
            unset($templates[$key]);
        } else {
            $item = str_replace('.php', '', $item);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($type) {
        global $templates;
        $request = Yii::app()->request;
        $postContent = $request->getPost('Contents');
        $templates = scandir(dirname(dirname(__FILE__)) . '/views/contents/content_types/');
        array_walk($templates, array($this, 'array_walk_funct'));
        sort($templates);
        $this->content_type_templates = $templates;
        $model = new Contents;
        $model->content_type = $type;
        if ($type == Contents::TYPE_SLIDESHOW_ALBUM) {
            $model->scenario = 'content_slideshow';
        }
        if ($type == Contents::TYPE_QUESTION_ANSWER) {
            $model->scenario = 'content_type_question_answer';
        }
        if ($type == Contents::TYPE_VIDEO)
            $model->scenario = 'content_video';
        if ($type == Contents::TYPE_IMAGE) {
            $model->scenario = 'content_image';
        }

        if ($type == Contents::TYPE_FACEBOOK) {
            $model->scenario = 'content_facebook_url';
        }
        if ($type == Contents::TYPE_INSTAGRAM) {
            $model->scenario = 'content_instagram_url';
        }
        if ($type == Contents::TYPE_TWITTER) {
            $model->scenario = 'content_twitter_url';
        }
        if ($type == Contents::TYPE_POLL) {
            $model->scenario = 'content_poll';
        }
        if ($type == Contents::TYPE_PICTURE_POLL) {
            $model->scenario = 'picture_poll';
        }
        if ($type == Contents::TYPE_EVENT) {
            $model->scenario = 'event';
        }
        if ($type == Contents::TYPE_PRODUCT) {
            $model->scenario = 'product';
        }


        if ($postContent) {
            $model->attributes = $postContent;
            if (empty($model->content_author))
                $model->content_author = Yii::app()->user->getID();
            if (($model->content_type == Contents::TYPE_IMAGE || $model->content_type == Contents::TYPE_ARTICLE || $model->content_type == Contents::TYPE_EVENT || $model->content_type == Contents::TYPE_PRODUCT) && $model->content_thumbnail != null) {
                if ($model->validate()) {
                    $model->sliceContentImage($model->content_thumbnail);
                }
            }

            if ($type == Contents::TYPE_FACEBOOK) {
                if ($model->validate()) {
                    $model->getFacebookContentData($model->content_source);
                    $model->scenario = 'content_facebook';
                }
            }

            if ($type == Contents::TYPE_INSTAGRAM) {
                if ($model->validate()) {
                    $model->getInstagramContent($model->content_source);
                    $model->scenario = 'content_instagram_url';
                }
            }

            if ($type == Contents::TYPE_TWITTER) {
                if ($model->validate()) {
                    $model->getTweetContent($model->content_source);
                    $model->scenario = 'content_twitter_url';
                }
            }


            if ($model->validate()) {
                if ($model->save()) {
                    Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_content_create'));
                    if (isset($_POST['preview_button'])) {
//                        $model->content_status = 'draft';
                        $this->redirect($model->permalink);
                    }
                    $this->redirect(Yii::app()->createAbsoluteUrl('/admin/contents/update/', array('id' => $model->id)));
                }
//                }
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
        global $templates;
        $request = Yii::app()->request;
        $postContent = $request->getPost('Contents');

        $templates = scandir(dirname(dirname(__FILE__)) . '/views/contents/content_types/');
        array_walk($templates, array($this, 'array_walk_funct'));
        sort($templates);
        $this->content_type_templates = $templates;
        $model = $this->loadModel($id);
        if ($model->content_type == Contents::TYPE_SLIDESHOW_ALBUM) {
            $model->scenario = 'content_slideshow';
        }
        if ($model->content_type == Contents::TYPE_QUESTION_ANSWER) {
            $model->scenario = 'content_type_question_answer';
        }
        if ($model->content_type == Contents::TYPE_VIDEO)
            $model->scenario = 'content_video';

        if ($model->content_type == Contents::TYPE_IMAGE) {
            $model->scenario = 'content_image';
        }
        if ($model->content_type == Contents::TYPE_FACEBOOK) {
            $model->scenario = 'content_facebook_url';
        }
        if ($model->content_type == Contents::TYPE_POLL) {
            $model->scenario = 'content_poll';
        }
        if ($model->content_type == Contents::TYPE_PICTURE_POLL) {
            $model->scenario = 'picture_poll';
        }
        if ($model->content_type == Contents::TYPE_EVENT) {
            $model->scenario = 'event';
        }
        if ($model->content_type == Contents::TYPE_PRODUCT) {
            $model->scenario = 'product';
        }

        if ($postContent) {
            $model->attributes = $postContent;

            if (($model->content_type == Contents::TYPE_IMAGE || $model->content_type == Contents::TYPE_ARTICLE || $model->content_type == Contents::TYPE_EVENT || $model->content_type == Contents::TYPE_PRODUCT) && $model->content_thumbnail != null) {
                if ($model->validate()) {
                    $model->sliceContentImage($model->content_thumbnail);
                }
            }
            if ($model->content_type == Contents::TYPE_POLL) {
                if (empty($model->content_content)) {
                    $model->content_content = array();
                }
            }
            if ($model->content_type == Contents::TYPE_FACEBOOK) {
                if ($model->validate()) {
                    $model->getFacebookContentData($model->content_source);
                    $model->scenario = 'content_facebook';
                }
            }

            if (!isset($postContent['content_slider_images'])) {
                $model->content_slider_images = '';
            }
            if ($model->save()) {

                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_content_update'));
                if (isset($_POST['preview_button']))
                    $this->redirect($model->permalink);

                if (!empty($model->content_slider_images))
                    $model->content_slider_images = unserialize($model->content_slider_images);
            }
        }

        $this->render('update', array(
            'model' => $model
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
//                $model->content_type = '<>community';
        if (isset($_GET['Contents'])) {

            $model->attributes = $_GET['Contents'];
            $model->created_at = (strtotime($model->created_at)) ? date('Y-m-d', strtotime($model->created_at)) : '';
//            echo '<pre>';
//            var_dump($model->attributes);
//            echo '</pre>';
//            die();
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
