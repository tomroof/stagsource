<?php

/**
 * This is the model class for table "{{content_comments}}".
 *
 * The followings are the available columns in table '{{content_comments}}':
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property string $created_at
 * @property string $guest_name
 * @property string $guest_email
 * @property string $url
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property User $author
 * @property Posts $post
 */
class ContentComments extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ContentComments the static model class
     */
    const COMMENT_STATUS_NEW = 0;
    const COMMENT_STATUS_OPEN = 1;
    const COMMENT_STATUS_CLOSE = 2;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{content_comments}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content, status, created_at ,content_id', 'required'),
            array('status, id, author_id', 'numerical', 'integerOnly' => true),
            array('guest_name, guest_email, url', 'length', 'max' => 128),
            array('content','validateCheckBlackwords'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, status, created_at, guest_name, guest_email, url, author_id ,content_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'post' => array(self::BELONGS_TO, 'Contents', array('id','content_id')),
        );
    }
    public static function get_comment_status_list() {
        return array(
            self::COMMENT_STATUS_NEW => 'New',
            self::COMMENT_STATUS_OPEN => 'Open',
            self::COMMENT_STATUS_CLOSE=>'Close'
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'content' => 'Content',
            'status' => 'Status',
            'created_at' => 'Create Time',
            'guest_name' => 'Guest Name',
            'guest_email' => 'Guest Email',
            'url' => 'Url',
            'content_id' => 'Post',
            'author_id' => 'Author',
        );
    }
    public function beforeSave() {

        $this->created_at = ($this->created_at != '0000-00-00 00:00:00') ? date('Y-m-d H:i:s', strtotime($this->created_at)) : date('Y-m-d H:i:s');
        return parent::beforeSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
 ;
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('guest_name', $this->guest_name, true);
        $criteria->compare('guest_email', $this->guest_email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('content_id', $this->content_id);
        $criteria->compare('author_id', $this->author_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    public static function getCommentStatus($cid) {
        $comment = ContentComments::model()->findByPk($cid);

        if ($comment->status == 0) {
            $status = 'New';
        } elseif ($comment->status == 1) {
            $status = 'Open';
        } elseif ($comment->status == 2) {
            $status = 'Close';
        }
        return $status;
    }

    public static function getCommentsCount($commentID) {
        $model = ContentComments::model()->findByPk($commentID);
        if ($model) {
            $contentId = $model->content_id;
            $commentsCount = ContentComments::model()->countByAttributes(array('content_id' => $contentId));
            return $commentsCount;
        }
    }

    public static function userCountComments($userID) {
        $criteria  = new CDbCriteria;
        $criteria->condition = 'author_id = ' . $userID;
        return ContentComments::model()->count($criteria);
    }

    public function beforeDelete()
    {
        Yii::import('application.modules.like.models.Like');
        $criteria = new CDbCriteria();
        $criteria->condition = 'model_name = "ContentComments" AND model_id = ' . $this->id;
        Like::model()->deleteAll($criteria);

        $criteria = new CDbCriteria();
        $criteria->condition = 'model = "ContentComments" AND model_id = ' . $this->id;
        SpamReport::model()->deleteAll($criteria);
        return parent::beforeDelete();
    }

    public function validateCheckBlackwords($attribute, $params)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status',Blockedwords::STATUS_PUBLISHED);
        $words = Blockedwords::model()->findAll($criteria);
        foreach ($words as $word) {
            if (stripos($this->$attribute, $word->title) !== FALSE) {
                $this->addError($attribute, 'Text contains words from our blocked list');
                return FALSE;
            }
        }
        return TRUE;
    }

}
