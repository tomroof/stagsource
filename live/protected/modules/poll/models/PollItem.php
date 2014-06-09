<?php

/**
 * This is the model class for table "{{poll_item}}".
 *
 * The followings are the available columns in table '{{poll_item}}':
 * @property integer $id_item
 * @property string $model_name
 * @property integer $model_id
 * @property string $content
 * @property integer $vote_count
 *
 * The followings are the available model relations:
 * @property PollRelationResult[] $pollRelationResults
 */
class PollItem extends CActiveRecord
{
    const TYPE_ADDED_BY_ADMIN='ADDED_BY_ADMIN';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PollItem the static model class
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
		return '{{poll_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, model_id, vote_count', 'numerical', 'integerOnly'=>true),
			array('model_name, content', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('type, img, sort','safe'),
			array('item_id, img, model_name, model_id, content, vote_count, type ,sort', 'safe', 'on'=>'search'),
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
			'pollRelationResults' => array(self::HAS_ONE, 'Pollresult', array('poll_item_id'=>'item_id')),
            'pollRelationResultsUser' => array(self::HAS_ONE, 'Pollresult', array('poll_item_id'=>'item_id'),'condition'=>'user_id="'.Yii::app()->user->id.'"'),
//            'pollresultCount' =>    array(self::STAT, 'Pollresult','poll_item_id','condition'=>' type="'.self::TYPE_ADDED_BY_ADMIN.'"'),
		);
	}
    public function getis_checked(){
        if($this->pollRelationResults!=''){
            return true;
        }else{
            return false;
        }
    }
    public function getis_checkedUser(){
        if($this->pollRelationResultsUser!=''){
            return true;
        }else{
            return false;
        }
    }
    public function getpercentage ($sum){

        $criteria = new CDbCriteria();
        $criteria->join='  JOIN  `tsn_poll_relation_result`  `pollRelationResults` ON (  `pollRelationResults`.`poll_item_id` =  `t`.`item_id` ) ';
        $criteria->compare('type',$this->type);
        $criteria->compare('item_id',$this->item_id);
        $coutn=self::model()->count($criteria);
        if(!empty($coutn)&&!empty($sum)){
            return round($coutn*100/$sum, 2);
        }else{
            return 0;
        }
    }


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'item_id' => 'Item Id',
			'model_name' => 'Model Name',
			'model_id' => 'Model',
            'poll_item_id'=>'Poll item id',
			'content' => 'Answers',
            'img'=>'Poll Options',
			'vote_count' => 'Vote Count',
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

		$criteria->compare('item_id',$this->id_item);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('vote_count',$this->vote_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}