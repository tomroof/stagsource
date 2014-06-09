<?php

/**
 * This is the model class for table "{{post_event_relation}}".
 *
 * The followings are the available columns in table '{{post_event_relation}}':
 * @property integer $id
 * @property string $post_id
 * @property string $event_id
 *
 * The followings are the available model relations:
 * @property Contents $event
 * @property Contents $post
 */
class PostEventRelation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostEventRelation the static model class
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
		return '{{post_event_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_id, event_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, post_id, event_id', 'safe', 'on'=>'search'),
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
//            'tags_relation' => array(self::BELONGS_TO, 'Tags', 'tag_id'),
			'event' => array(self::BELONGS_TO, 'Contents', 'event_id'),
			'post' => array(self::BELONGS_TO, 'Contents', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'post_id' => 'Post',
			'event_id' => 'Event',
		);
	}

    public static function addPostEventRelation($contentId, $celebritiesArr) {
        $res = PostEventRelation::model()->deleteAllByAttributes(array('post_id' => $contentId));
        foreach ($celebritiesArr as $key => $value) {
            if ($key and $contentId) {
                $newRelation = new PostEventRelation;
                $newRelation->post_id = $contentId;
                $newRelation->event_id = $key;
                $newRelation->save();
            }
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
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('event_id',$this->event_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public static function getLinkEvent($content_id)
    {
        $modelContentTags = PostEventRelation::model()->findAllByAttributes(array('post_id' => $content_id), array('order' => 'id ASC'));;
        if ($modelContentTags) {
            $arrayModels = CHtml::listData($modelContentTags, 'event_id', 'event.content_title');
            foreach ($arrayModels as $key=>$tag) {
                $arrayLinkTags[] = CHtml::link(strtoupper($tag), Yii::app()->createUrl('/contents/'.$key.'/'.$tag));
            }
            $str = implode('', $arrayLinkTags);
        } else
            $str = '';
        return $str;
    }
}