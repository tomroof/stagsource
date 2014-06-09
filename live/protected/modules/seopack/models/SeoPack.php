<?php

/**
 * This is the model class for table "pe_seopack".
 *
 * The followings are the available columns in table 'pe_seopack':
 * @property integer $id
 * @property integer $model_name
 * @property integer $object_id
 * @property string $seo_title
 * @property string $seo_description
 */
class SeoPack extends CActiveRecord
    {

    const SEO_INDEX = 0;
    const SEO_NOINDEX = 1;
    const SEO_FOLLOW = 0;
    const SEO_NOFOLLOW = 1;
    public $pagetitle;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SeoPack the static model class
     */
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'tsn_seopack';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('model_name, object_id', 'required'),
                array('object_id,seo_nofollow,seo_noindex', 'numerical', 'integerOnly' => true),
                array('seo_title,seo_description,seo_keywords,seo_canonical','safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, model_name, object_id, seo_title, seo_description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
                'id' => 'ID',
                'model_name' => 'Model Name',
                'object_id' => 'Object',
                'seo_title' => 'Seo Title',
                'seo_description' => 'Seo Description',
                'seo_keywords' => 'Seperated by a comma',
                'seo_nofollow' => 'No Follow',
                'seo_noindex' => 'No Index',
                'seo_canonical' => 'Canonical URL',
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
        $criteria->compare('model_name', $this->model_name);
        $criteria->compare('object_id', $this->object_id);
        $criteria->compare('seo_title', $this->seo_title, true);
        $criteria->compare('seo_description', $this->seo_description, true);

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
        ));
    }

    /**
     *
     * @return array() Seo Content
     */
    public function getSeoData($model_name, $object_id){

        $modelSeo = SeoPack::model()->findByAttributes(
                  array('model_name' => $model_name, 'object_id' => $object_id));
        if(!$modelSeo)
        {
            $modelSeo = new SeoPack();
            $url = explode('/', Yii::app()->request->requestUri);
            $url = end($url);
            $modelSeo->seo_title = $url;
            $modelSeo->seo_description = null;
        }elseif($modelSeo && !$modelSeo->seo_title){
            $url = explode('/', Yii::app()->request->requestUri);
            $url = end($url);
            $modelSeo->seo_title = $url;
        }



        return $modelSeo;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $model_name active record class name.
     * @param string $object_id current object id.
     * @return SeoPackModel class
     */

    public function getSeoModel($model_name, $object_id){

        $modelSeo = SeoPack::model()->findByAttributes(
                  array('model_name' => $model_name, 'object_id' => $object_id));


        return $modelSeo;
    }

    }