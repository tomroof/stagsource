<?php

/**
 * This is the model class for table "{{blockedwords}}".
 *
 * The followings are the available columns in table '{{blockedwords}}':
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property string $create_at
 * @property string $update_at
 */
class Blockedwords extends CActiveRecord
{
    const STATUS_DRAFT = 2;
    const STATUS_PUBLISHED = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Blackwords the static model class
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
        return '{{blockedwords}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 30),
            array('title', 'unique'),
            array('title', 'required'),
            array('created_at, updated_at', 'safe'),
            array('created_at', 'default', 'value' => date('Y-m-d H:i:s')),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = $this->updated_at = date('Y-m-d H:i:s');
        } else {
            $this->created_at=date('Y-m-d H:i:s', strtotime($this->created_at));
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave();

    }


    public function getStatus()
    {
        self::getStatuslist();
        $status_arr = self::getStatuslist();
        if (isset($status_arr[$this->status])) {
            return $status = $status_arr[$this->status];
        } else {
            return 'null';
        }
    }

    public static function getStatuslist()
    {
        return array(
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Published',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'create_at' => 'Created At',
            'update_at' => 'Updated At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
//    example validate not delete

//    public function validateCheckBlackwords($attribute, $params)
//    {
//        $criteria = new CDbCriteria();
//        $criteria->compare('status',Blockedwords::STATUS_PUBLISHED);
//        $words = Blockedwords::model()->findAll($criteria);
//        foreach ($words as $word) {
//            if (stripos($this->$attribute, $word->title) !== FALSE) {
//                $this->addError($attribute, 'Text contains words from our blocked list');
//                return FALSE;
//            }
//        }
//        return TRUE;
//    }
}