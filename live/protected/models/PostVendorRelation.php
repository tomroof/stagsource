<?php

/**
 * This is the model class for table "{{post_celebrity_relation}}".
 *
 * The followings are the available columns in table '{{post_celebrity_relation}}':
 * @property integer $id
 * @property integer $post_id
 * @property integer $vendor_id
 */
class PostVendorRelation extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PostVendorRelation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{post_vendor_relation}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('post_id, vendor_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, post_id, vendor_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                //'celebrity_content_rel' => array(self::BELONGS_TO, 'Contents', array('post_id' => 'id')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'post_id' => 'Post',
            'vendor_id' => 'Celebrity',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('post_id', $this->post_id);
        $criteria->compare('vendor_id', $this->vendor_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public static function getPostCelebrities($contentId) {

        $celebritiesArr = PostVendorRelation::model()->findAllByAttributes(array('post_id' => $contentId));
        return $celebritiesArr;
        //   var_dump($celebritiesArr);
    }

    public static function addPostVendorRelation($contentId, $celebritiesArr) {
        $celebritiesArr = array_flip((array)$celebritiesArr);
        $res = PostVendorRelation::model()->deleteAllByAttributes(array('post_id' => $contentId));
        foreach ($celebritiesArr as $key => $value) {
            if ($key and $contentId) {
                $newRelation = new PostVendorRelation;
                $newRelation->post_id = $contentId;
                $newRelation->vendor_id = $key;
                $newRelation->save();
            }
        }

    }

    public static function getAllCelebrity() {

//        $criteria = new CDbCriteria;
//        $criteria->with = array('content_celebrity_rel');
//        $criteria->compare('content_type', Contents::TYPE_FEATURED);
//        $contentCriteria = PostVendorRelation::model()->findAll($criteria);
//        echo "<pre>";
//        var_dump($contentCriteria);
//        echo "</pre>";
        // die('dead');
    }

}