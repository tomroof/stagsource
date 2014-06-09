<?php

/**
 * This is the model class for table "{{content_tag}}".
 *
 * The followings are the available columns in table '{{content_tag}}':
 * @property string $id
 * @property integer $content_id
 * @property integer $tag_id
 * @property string $created_at
 */
class ContentTag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContentTag the static model class
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
		return '{{content_tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_id, tag_id', 'numerical', 'integerOnly'=>true),
			array('created_at, data_last_add', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content_id, tag_id, created_at, data_last_add', 'safe', 'on'=>'search'),
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
            'tags_relation' => array(self::BELONGS_TO, 'Tags', 'tag_id'),
            'contents_relation' => array(self::BELONGS_TO, 'Contents', array('content_id' => 'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content_id' => 'Content',
			'tag_id' => 'Tag',
			'created_at' => 'Created At',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('tag_id',$this->tag_id);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getContentTags($content_id)
    {
        $modelContentTags = ContentTag::model()->findAllByAttributes(array('content_id' => $content_id), array('order' => 'created_at ASC'));
        if ($modelContentTags) {
            $arrayModels = CHtml::listData($modelContentTags, 'tag_id', 'tags_relation.tag');
            $str = implode(',', $arrayModels);
        } else
            $str = '';
        return $str;
    }

    public static function getLinkTags($content_id)
    {
        $modelContentTags = ContentTag::model()->findAllByAttributes(array('content_id' => $content_id), array('order' => 'created_at ASC'));
        if ($modelContentTags) {
            $arrayModels = CHtml::listData($modelContentTags, 'tag_id', 'tags_relation.tag');
            foreach ($arrayModels as $tag) {
                $arrayLinkTags[] = CHtml::link(strtoupper($tag), Yii::app()->createUrl('/Contents/Search', array('tag' => $tag)));
            }
            $str = implode('', $arrayLinkTags);
        } else
            $str = '';
        return $str;
    }
}