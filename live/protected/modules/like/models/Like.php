<?php

/**
 * This is the model class for table "{{likes}}".
 *
 * The followings are the available columns in table '{{likes}}':
 * @property integer $id
 * @property string $model_name
 * @property string $model_id
 * @property string $user_id
 * @property string $like_type
 */
class Like extends CActiveRecord
    {
    const TYPE_lIKE = 'like';
    const TYPE_FAVORITE= 'favorite';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Like the static model class
     */
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return '{{likes}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('model_id, user_id', 'required'),
                array('model_name, like_type', 'length', 'max' => 64),
                array('model_id, user_id', 'length', 'max' => 10),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, model_name, model_id, user_id, like_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
              'user' => array(self::BELONGS_TO, 'User', array('user_id' => 'id')),
              'contents_type_favorite'          => array(self::BELONGS_TO, 'Contents', 'model_id', 'on' => "model_name='Contents'",'condition'=>"like_type='".self::TYPE_FAVORITE."'"),
//              'content_comments'  => array(self::BELONGS_TO, 'ContentComments', 'model_id', 'on' => "model_name='ContentComments'"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
                'id' => 'ID',
                'model_name' => 'Model Name',
                'model_id' => 'Model',
                'user_id' => 'User',
                'like_type' => 'Like Type',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('model_name', $this->model_name, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('like_type', $this->like_type, true);

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
        ));
    }

    public static function getCountLikes($modelName, $modelId, $likeType){

        $model = Like::model()->findAllByAttributes(
        array(
        'model_name' => $modelName,
        'model_id' => $modelId,
        'like_type' => $likeType
        ));
        return count($model);
    }

    public static function getLikeStatus($modelName, $modelId, $likeType, $userId){
        $model = Like::model()->findByAttributes(
        array(
        'model_name' => $modelName,
        'model_id' => $modelId,
        'like_type' => $likeType,
        'user_id' => $userId,
        ));
        return (bool)$model;
    }

    public static function userCountFavorites($userID)
    {
        return Like::model()->count('user_id = '. $userID . ' AND like_type = "favorite"');
    }
    }