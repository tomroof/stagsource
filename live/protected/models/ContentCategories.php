<?php

/**
 * This is the model class for table "{{content_categories}}".
 *
 * The followings are the available columns in table '{{content_categories}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $category_img
 * @property string $permalink
 * @property integer $parent
 */
class ContentCategories extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContentCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{content_categories}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent', 'numerical', 'integerOnly'=>true),
			array('name, category_img, permalink', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, category_img, permalink, parent', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'category_img' => 'Category Img',
			'permalink' => 'Permalink',
			'parent' => 'Parent',
		);
	}
        public function getparent_name(){
            if(!empty($this->parent)){
                return self::model()->findByPk($this->parent)->name;
            }else{
                return $this->parent;
            }
         
        }

        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('category_img',$this->category_img,true);
		$criteria->compare('permalink',$this->permalink,true);
		$criteria->compare('parent',$this->parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}