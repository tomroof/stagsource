<?php

/**
 * This is the model class for table "{{spam_report}}".
 *
 * The followings are the available columns in table '{{spam_report}}':
 * @property string $id
 * @property string $model
 * @property string $model_id
 * @property integer $user_reported
 * @property string $create_datetime
 * @property string $causes
 * @property string $status
 */
class SpamReport extends CActiveRecord
{
    const SPAM_STATUS_NOT_READ = 0;
    const SPAM_STATUS_READ = 1;


    public $author_name_1;
    public $author_name_2;
    public $user_reported_name;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SpamReport the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{spam_report}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_reported, model_id, status', 'numerical', 'integerOnly' => true),
//			array('model, causes', 'length', 'max'=>255),
//			array('model_id', 'length', 'max'=>11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, model, model_id, user_reported, create_datetime, causes, status, user_reported_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user_rel' => array(self::BELONGS_TO, 'User', 'user_reported'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'user_reported' => 'User Reported',
            'create_datetime' => 'Create Datetime',
            'causes' => 'Causes',
            'status' => 'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = '8')
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        if ($pageSize == '8') {
            if (Yii::app()->user->StateKeyPrefix == '_admin') {
                $pageSize = 50;
            }
        }

        $criteria = new CDbCriteria;



        $criteria->compare('id', $this->id, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('model_id', $this->model_id, true);
  /*      $criteria->compare('user_reported', $this->user_reported); // */
        $criteria->compare('create_datetime', $this->create_datetime, true);
        $criteria->compare('causes', $this->causes, true);
        $criteria->compare('status', $this->status, true);
        $criteria->order = 't.id DESC';

           $criteria->with = 'user_rel';
  $criteria->addSearchCondition('user_rel.first_name', $this->author_name_1, true, 'OR');
    $criteria->addSearchCondition('user_rel.last_name', $this->author_name_1, true, 'OR');
    $criteria->addSearchCondition('user_rel.first_name', $this->author_name_2, true, 'OR');
    $criteria->addSearchCondition('user_rel.last_name', $this->author_name_2, true, 'OR');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pageSize
            )
        ));
    }

    public function beforeSave()
    {
        $this->causes = json_encode($this->causes);
        return parent::beforeSave();
    }

    public static function getTextCauses($id)
    {
        $causes_array = array(
            '1' => 'Explicit language',
            '2' => 'Attacks on groups or individual',
            '3' => 'Invades my privacy',
            '4' => 'Hateful speech or symbols',
            '5' => 'Spam or scam',
            '6' => 'Other'
        );


        $model = SpamReport::model()->findByPk($id);
        $causes = json_decode($model->causes);
        $text = "";
        foreach ($causes as $value) {
           $text = $text . $causes_array[$value] . "<br /> ";
        }

        return $text;
    }

    public static function getSpamText($id){
        $model = SpamReport::model()->findByPk($id);
        if($model->model == "Contents"){
            $model_spam = Contents::model()->findByPk($model->model_id);
            if($model_spam){
                return $model_spam->content;
            }else{
                return 'This content has been removed. Please, delete this spam report.';
            }

        } elseif ($model->model == "ContentComments") {
            $model_spam = ContentComments::model()->findByPk($model->model_id);
            if($model_spam){
                return $model_spam->content;
            }else{
                return 'This content has been removed. Please, delete this spam report.';
            }

        }
    }

    /**
     * @param $key_status
     * @internal param string $out
     * @return string representation of the status
     */
    public static function getTextStatus($key_status) {
        $label = self::getArrayStatus();
        return $label[$key_status];
    }

    /**
     * $param empty.
     * @return array_status.
     */
    public static function getArrayStatus() {
        return array(
            self::SPAM_STATUS_READ => 'Read',
            self::SPAM_STATUS_NOT_READ => 'Not Read',
        );
    }
}