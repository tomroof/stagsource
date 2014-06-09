<?php

/**
 * This is the model class for table "{{poll_relation_result}}".
 *
 * The followings are the available columns in table '{{poll_relation_result}}':
 * @property integer $id_item
 * @property integer $user_id
 * @property integer $model_id
 * @property string $guest_ip
 *
 * The followings are the available model relations:
 * @property PollItem $poll
 * @property User $user
 */
class Pollresult extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pollresult the static model class
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
		return '{{poll_relation_result}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, poll_item_id', 'numerical', 'integerOnly'=>true),
			array('guest_ip', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_item, user_id, poll_item_id, guest_ip', 'safe', 'on'=>'search'),
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
			'poll' => array(self::BELONGS_TO, 'PollItem', array('poll_item_id'=>'item_id')),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_item' => 'Id Item',
			'user_id' => 'User',
			'guest_ip' => 'Guest Ip',
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

		$criteria->compare('id_item',$this->id_item);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('guest_ip',$this->guest_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}