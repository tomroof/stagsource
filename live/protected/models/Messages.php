<?php

/**
 * This is the model class for table "{{messages}}".
 *
 * The followings are the available columns in table '{{messages}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $date
 * @property integer $read_status
 *
 * The followings are the available model relations:
 * @property User $fromUser
 * @property User $toUser
 */
class Messages extends CActiveRecord
{
    public $_from_user_id;
    public $_to_user_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Messages the static model class
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
		return '{{messages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('to_user_id, from_user_id, title, content', 'required'),
			array('from_user_id, to_user_id, read_status', 'numerical', 'integerOnly'=>true),
			array('title, content, date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, from_user_id, to_user_id, date, read_status, _to_user_id, _from_user_id', 'safe', 'on'=>'search'),
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
			'fromUser' => array(self::BELONGS_TO, 'User', 'from_user_id'),
			'toUser' => array(self::BELONGS_TO, 'User', 'to_user_id'),
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
			'content' => 'Content',
			'from_user_id' => 'From User',
			'to_user_id' => 'To User',
			'date' => 'Date',
			'read_status' => 'Read Status',
		);
	}
        
      
        public function send_email(){
             $headers = 'Content-type: text/html' . "\r\n";
            $headers .= 'From: TSN <'.$this->fromUser->email.'>' . "\r\n";
            return(mail($this->toUser->email, $this->title,$this->content,$headers));              
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
        $criteria->with=array('fromUser','toUser');
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('to_user_id',$this->to_user_id);
        $criteria->compare('fromUser.email',$this->_from_user_id,true);
        $criteria->compare('toUser.email',$this->_to_user_id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('read_status',$this->read_status);
        $criteria->order = "t.id DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
		));
	}

    public static function notReadMessageCount($userID)
    {
        return Messages::model()->count('to_user_id = ' . $userID . ' AND read_status = 0');
    }
}