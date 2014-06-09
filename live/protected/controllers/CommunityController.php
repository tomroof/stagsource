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
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'expression' => 'Yii::app()->user->isGuest || !Yii::app()->user->isGuest',
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => '!Yii::app()->user->isGuest',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Contents', array(
                    'criteria' => array(
                        'order' => 'created_at DESC',
                        'condition' => 'content_type = "community"'
                    ),
                    'pagination' => array(
                        'pageSize' => 11,
                    ),
                ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Contents();
        $array_category = CHtml::listData(ContentCategories::model()->findAll("content_type = '=community'"), 'id', 'name');
        $model->setScenario('community');

        if (isset($_POST['Contents'])&& isset($_POST['Contents']['content_content'])) {
            $model->attributes = $_POST['Contents'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->content_type = Contents::TYPE_COMMUNITY;
            $model->content_author = Yii::app()->user->getID();
//            $model->content_content = Contents::model()->explodeCommynityContent($_POST['Contents']['content_content'], 300);
            if ($model->save())
                echo "<script>parent.location.reload();</script>";
        }
        $model->content_category_id = key($array_category);

        $this->layout = 'popup';
        $this->render('create', array(
            'model' => $model,
            'array_category' => $array_category,
        ));
    }

    public function actionView() {
        $model = Contents::model()->findByPk($_GET['id']);
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(
                array('content_id' => $model->id), 'AND'
        );
        $criteria->compare('status', '<>2');
        $all_comments = ContentComments::model()->findAll($criteria);


        $user = User::model()->findByPk(Yii::app()->user->id);
        $new_comment = new ContentComments;
        if (isset($_POST['ContentComments'])) {

            $new_comment->attributes = $_POST['ContentComments'];
            $new_comment->author_id = $user->id;
            $new_comment->content_id = $model->id;
            $new_comment->created_at = date('Y-m-d H:i:s');
            $new_comment->status = 0;
            $new_comment->guest_name = $user->first_name . ' ' . $user->last_name;
            $new_comment->guest_email = $user->email;

            if ($new_comment->validate()) {
                if ($new_comment->save()) {
                    $model->content_comment_count = ContentComments::getCommentsCount($new_comment->id);
                    $model->save();
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->setPageTitle(Yii::app()->name.' - '.$model->content_title);
        $this->seoPack = SeoPack::model()->getSeoData('Contents', $model->id);

        $dataProvider = new CActiveDataProvider('ContentComments', array('criteria' => $criteria, 'pagination' => array(
                        'pageSize' => 30,
                    ), 'sort' => array(
                        'attributes' => array(
                            'date' => array(
                                'asc' => 'created_at ASC',
                                'desc' => 'created_at DESC',
                                'default' => 'desc',
                            ),
                        ),
                        'defaultOrder' => array(
                            'date' => CSort::SORT_DESC,
                        )
                    ),
                ));


        Yii::app()->clientScript->registerMetaTag($model->content_title, null, null, array('property' => 'og:title'));
        Yii::app()->clientScript->registerMetaTag($model->permalink, null, null, array('property' => 'og:url'));
//        if(isset($model->content_content)){
            Yii::app()->clientScript->registerMetaTag(strip_tags($model->content_content), null, null, array('property' => 'og:description'));
//        }
        Yii::app()->clientScript->registerMetaTag(Yii::app()->createAbsoluteUrl($model->content_thumbnail), null, null, array('property' => 'og:image'));

        $this->render('view', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'new_comment' => $new_comment,
            'all_comments' => $all_comments,
            'current_user' => $user
        ));
    }

}