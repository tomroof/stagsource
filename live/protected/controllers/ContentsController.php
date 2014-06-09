<?php

class ContentsController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $seoPack = array();
    public $ogTitle = '';
    public $ogUrl = '';
    public $ogDescription = '';
    public $ogImage = '';

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
                'actions' => array('index', 'view', 'Search', 'vendorview', 'News', 'Events'),
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
        $criteria = new CDbCriteria();
//          $criteria->addNotInCondition('content_type',array(Contents::TYPE_COMMUNITY) );
        $criteria->order = 'created_at DESC';
        $criteria->join = 'LEFT OUTER JOIN ' . Yii::app()->db->tablePrefix . 'user AS u ON u.id=t.dancer_author';
        $criteria->addCondition('content_type = "' . Contents::TYPE_VENDOR . '"');
        $criteria->addCondition('u.pro_status = "' . User::STATUS_USER_PRO . '"');
        $criteria->addNotInCondition('content_type', array(Contents::TYPE_VENDOR), 'OR');
        $criteria->addCondition('content_status = "' . Contents::STATUS_PUBLISHED . '"');
        $dataProvider = new CActiveDataProvider('Contents', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 22,
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
    public function actionView() {
        $request = Yii::app()->request;

        $cid = $request->getQuery('id');
        $content = Contents::model()->findByPk($cid);

        if (!$content) {
            throw new CHttpException(404, 'Nothing found');
        }
        if ($content->content_type == Contents::TYPE_COMMUNITY)
            $this->redirect($content->permalink);

        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(
                array('content_id' => $content->id), 'AND'
        );




        $criteria->compare('status', '<>2');
        $allComments = ContentComments::model()->findAll($criteria);
        $user = User::model()->findByPk(Yii::app()->user->id);
        $newComment = new ContentComments;
        if ($request->getPost('ContentComments')) {
            $newComment->attributes = $request->getPost('ContentComments');
            $newComment->author_id = $user->id;
            $newComment->content_id = $content->id;
            $newComment->created_at = date('Y-m-d H:i:s');
            $newComment->status = 0;
            $newComment->guest_name = $user->first_name . ' ' . $user->last_name;
            $newComment->guest_email = $user->email;
            if ($newComment->validate()) {
                if ($newComment->save()) {
                    $content->content_comment_count = ContentComments::getCommentsCount($newComment->id);
                    $content->save();
                }
                $this->redirect(array('view', 'id' => $content->id));
            }
        }
        $dataProvider = new CActiveDataProvider('ContentComments', array('criteria' => $criteria,
                    'pagination' => array(
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
                            'created_at' => CSort::SORT_DESC,
                        )
                    ),
                ));

        $criteria = new CDbCriteria();
        $criteria->condition = 'content_type=:content_type AND created_at>:datetime AND content_status=:published';
        $criteria->order = ' created_at ASC';
        $criteria->params = array(
            ':content_type' => $content->content_type,
            ':datetime' => date('Y-m-d H:i:s', strtotime($content->created_at)),
            ':published' => 'publish',
        );
        $prevModel = Contents::model()->find($criteria);
        if ($prevModel == null) {

            $criteria = new CDbCriteria();

            $criteria->addNotInCondition('content_type', array($content->content_type, Contents::TYPE_INSTAGRAM, Contents::TYPE_FACEBOOK, Contents::TYPE_TWITTER, Contents::TYPE_VENDOR,Contents::TYPE_EVENT));
            $criteria->compare('content_status', Contents::STATUS_PUBLISHED);
            $criteria->order = ' RAND()';
            $prevModel = Contents::model()->find($criteria);
        }


        $criteria = new CDbCriteria();
        $criteria->condition = 'content_type=:content_type AND created_at<:datetime AND content_status=:published';
        $criteria->order = ' created_at DESC';
        $criteria->params = array(
            ':content_type' => $content->content_type,
            ':datetime' => date('Y-m-d H:i:s', strtotime($content->created_at)),
            ':published' => 'publish',
        );
        $nextModel = Contents::model()->find($criteria);
        if ($nextModel == null) {

            $criteria = new CDbCriteria();

            $criteria->addNotInCondition('content_type', array($content->content_type, Contents::TYPE_INSTAGRAM, Contents::TYPE_FACEBOOK, Contents::TYPE_TWITTER, Contents::TYPE_VENDOR,Contents::TYPE_EVENT));
            $criteria->compare('content_status', Contents::STATUS_PUBLISHED);
            $criteria->order = ' RAND()';
            $nextModel = Contents::model()->find($criteria);
        }


        $this->setPageTitle(Yii::app()->name . ' - ' . $content->content_title);
        $this->seoPack = SeoPack::model()->getSeoData('Contents', $content->id);
        Yii::app()->clientScript->registerMetaTag($content->content_title, null, null, array('property' => 'og:title'));
        Yii::app()->clientScript->registerMetaTag(Yii::app()->createAbsoluteUrl($content->permalink), null, null, array('property' => 'og:url'));
        Yii::app()->clientScript->registerMetaTag(strip_tags($content->content_content), null, null, array('property' => 'og:description'));
        Yii::app()->clientScript->registerMetaTag(Yii::app()->createAbsoluteUrl($content->content_thumbnail), null, null, array('property' => 'og:image'));

        $view_file = $content->content_type;
        $this->render('_contents_view/' . $view_file . '_view', array(
            'content' => $content,
            'dataProvider' => $dataProvider,
            'new_comment' => $newComment,
            'all_comments' => $allComments,
            'current_user' => $user,
            'prevModel' => $prevModel,
            'nextModel' => $nextModel,
        ));
    }

    public function actionVendorView($name) {
        $content = Contents::model()->findByAttributes(array('content_type' => Contents::TYPE_VENDOR, 'content_slug' => $name));
        $criteria = new CDbCriteria();
        $criteria->with = array('content_celebrity_rel');
        $criteria->compare('content_celebrity_rel.vendor_id', $content->id);
        $criteria->order = 't.created_at DESC ';
        $dataProvider = new CActiveDataProvider('Contents', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 22,
                    ),
               )
        );
        $this->setPageTitle(Yii::app()->name . ' - ' . $content->content_title);
        $this->seoPack = SeoPack::model()->getSeoData('Contents', $content->id);

        $view_file = $content->content_type;
        $this->render('_contents_view/' . $view_file . '_view', array(
            'content' => $content,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionSearch() {
        $criteria = new CDbCriteria();
        $request = Yii::app()->request->getQuery('type_search');
        if ($request) {
            if (in_array('recent_activity', $request)) {
                $criteria->addCondition('content_comment_count !=0 ', 'OR');
                $criteria->order = ' content_comment_count DESC  ';
                $request = array_diff($request, array('recent_activity'));
                $criteria->order = 't.content_comment_count DESC ';
            }
            if (count($request)) {
                $criteria->addInCondition('content_type', $request, "OR");
                $criteria->order = 't.created_at DESC ';
            }
        } elseif (isset($_GET['tag']) && !empty($_GET['tag'])) {
            $TagId = $TagModel = Tags::model()->findByAttributes(array('tag' => $_GET['tag']))->id;
            $criteria->with = array('tag_rel');
            $criteria->addSearchCondition('tag_rel.tag_id  ', $TagId, false);
            $criteria->order = 't.created_at DESC ';
        } else {
            $keyword = Yii::app()->request->getQuery('search_keyword');
            $criteria->addSearchCondition('content_title', $keyword, true, 'OR');
            $criteria->addSearchCondition('content_content', $keyword, true, 'OR');
            $criteria->with = array('user_rel');
            $criteria->addSearchCondition('user_rel.first_name', $keyword, true, 'OR');
            $criteria->addSearchCondition('user_rel.last_name', $keyword, true, 'OR');
            $criteria->order = 't.created_at DESC ';
        }
        $criteria->addCondition('content_status = "' . Contents::STATUS_PUBLISHED . '"');


        $dataProvider = new CActiveDataProvider('Contents', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 22,
                    ),
                ));

        $this->render('search', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionNews() {
        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('content_type', array(Contents::TYPE_VENDOR));
        $criteria->order = 'created_at DESC';

        $dataProvider = new CActiveDataProvider('Contents', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 22,
                    ),
                ));
        $this->render('news', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionEvents() {
        $criteria = new CDbCriteria();
        $criteria->order = 'created_at DESC';
        $criteria->addCondition('content_type = :content_type');
        $criteria->params = array(':content_type' => Contents::TYPE_EVENT);

        $dataProvider = new CActiveDataProvider('Contents', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 22,
                    ),
                ));
        $this->render('events', array(
            'dataProvider' => $dataProvider,
        ));
    }

}
