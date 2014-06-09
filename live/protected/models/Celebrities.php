<?php

/**
 * This is the model class for table "{{celebrities}}".
 *
 * The followings are the available columns in table '{{celebrities}}':
 * @property integer $vendor_id
 * @property string $celebrity_name
 * @property string $celebrity_description
 * @property string $celebrity_img
 * @property string $celebrity_permalink
 * @property integer $celebrity_parent
 */
class Celebrities extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Celebrities the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{celebrities}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('celebrity_name', 'required'),
            array('celebrity_permalink', 'unique'),
            array('celebrity_parent', 'numerical', 'integerOnly' => true),
            array('celebrity_name, celebrity_img, celebrity_permalink', 'length', 'max' => 255),
            array('celebrity_description,celebrity_post_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('vendor_id, celebrity_name, celebrity_description, celebrity_img, celebrity_permalink, celebrity_parent,celebrity_post_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'postCelebritiesRelations' => array(self::HAS_MANY, 'PostVendorRelation',array('vendor_id'=>'celebrity_id')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'celebrity_id' => 'Store',
            'celebrity_name' => 'Permalink',
            'celebrity_description' => 'Store Description',
            'celebrity_img' => 'Store Img',
            'celebrity_permalink' => 'Store Permalink',
            'celebrity_parent' => 'Store Parent',
            'celebrity_post_id' => 'Featured',
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

        $criteria->compare('celebrity_id', $this->celebrity_id);
        $criteria->compare('celebrity_name', $this->celebrity_name, true);
        $criteria->compare('celebrity_description', $this->celebrity_description, true);
        $criteria->compare('celebrity_img', $this->celebrity_img, true);
        $criteria->compare('celebrity_permalink', $this->celebrity_permalink, true);
        $criteria->compare('celebrity_parent', $this->celebrity_parent);
        $criteria->compare('celebrity_post_id', $this->celebrity_post_id, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public static function getlistdate_json() {

        $data = Celebrities::model()->findAll();
        $str_json = null;
        $bool = '';
        foreach ($data as $key => $value) {
            $str_json = $str_json . $bool . CJSON::encode(array('value' => $value->celebrity_id, 'label' => $value->celebrity_name));
            $bool = ",";
        }
        return $str_json;
    }

    public static function getCelebrityById($celebrityId) {
        $celebrity = Celebrities::model()->findByPk($celebrityId);
        return $celebrity;
    }

    public static function selectCelebrityFeatured($featuredId, $celebrityId) {
        $celebritiesFeatured = Celebrities::model()->findAllByAttributes(array('celebrity_post_id' => $featuredId));
        foreach ($celebritiesFeatured as $key => $celebrity) {
            $celebrity->celebrity_post_id = '';
            $celebrity->save();
        }
        $selectedCelebrity = Celebrities::model()->findByPk($celebrityId);
        if ($selectedCelebrity) {
            $selectedCelebrity->celebrity_post_id = $featuredId;
            $selectedCelebrity->save();
        }
    }

}