<?php

/**
 * This is the model class for table "{{zipareas}}".
 *
 * The followings are the available columns in table '{{zipareas}}':
 * @property integer $id
 * @property string $zip
 * @property string $state
 * @property string $city
 * @property string $latitude
 * @property string $longitude
 * @property string $old_lng
 * @property string $old_lat
 * @property integer $updated
 */
class Zipareas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Zipareas the static model class
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
		return '{{zipareas}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zip', 'required'),
			array('updated', 'numerical', 'integerOnly'=>true),
			array('zip', 'length', 'max'=>5),
			array('state', 'length', 'max'=>2),
			array('city, latitude, longitude, old_lng, old_lat', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, zip, state, city, latitude, longitude, old_lng, old_lat, updated', 'safe', 'on'=>'search'),
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
			'zip' => 'Zip',
			'state' => 'State',
			'city' => 'City',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'old_lng' => 'Old Lng',
			'old_lat' => 'Old Lat',
			'updated' => 'Updated',
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
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('old_lng',$this->old_lng,true);
		$criteria->compare('old_lat',$this->old_lat,true);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}