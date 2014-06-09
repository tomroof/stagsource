<?php

/**
 * This is the model class for table "{{states}}".
 *
 * The followings are the available columns in table '{{states}}':
 * @property integer $id
 * @property string $state_code
 * @property integer $country_id
 * @property string $state_name_en
 * @property string $state_name_ru
 *
 * The followings are the available model relations:
 * @property Countries $country
 */
class States extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return States the static model class
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
		return '{{states}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('state_code, state_name_en, state_name_ru', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, state_code, country_id, state_name_en, state_name_ru', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'state_code' => 'State Code',
			'country_id' => 'Country',
			'state_name_en' => 'State Name En',
			'state_name_ru' => 'State Name Ru',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('state_code',$this->state_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('state_name_en',$this->state_name_en,true);
		$criteria->compare('state_name_ru',$this->state_name_ru,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}