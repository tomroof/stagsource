<?php

/**
 * This is the model class for table "{{tags}}".
 *
 * The followings are the available columns in table '{{tags}}':
 * @property integer $id
 * @property string $tag
 * @property integer $count_used
 */
class Tags extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tags the static model class
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
		return '{{tags}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('count_used', 'numerical', 'integerOnly'=>true),
			array('tag', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tag, count_used', 'safe', 'on'=>'search'),
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
            'relationTagToContentTag' => array(self::BELONGS_TO, 'ContentTag', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tag' => 'Tag',
			'count_used' => 'Count Used',
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
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('count_used',$this->count_used);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function addTags($tags, $content_id)
    {
        $arrayTags = explode(',', strtolower(strip_tags($tags)));
        foreach ($arrayTags as $tag) {
            $TagModel = Tags::model()->findByAttributes(array('tag' => trim($tag)));
            if (!$TagModel) {
                $TagModel = new Tags();
                $TagModel->tag = trim($tag);
                $TagModel->save();
            }
        }
        //delete all old tags for content
        Yii::app()->db->createCommand()->delete('{{content_tag}}', 'content_id=:content_id', $params = array(':content_id' => $content_id));
        //save new tags
        foreach ($arrayTags as $tag) {
            $tagID = Tags::model()->findByAttributes(array('tag' => trim($tag)));
            Yii::app()->db->createCommand()->insert('{{content_tag}}', array(
                'content_id' => $content_id,
                'tag_id' => $tagID->id,
                'created_at' => date('Y-m-d H:i:s', time()),
            ));
//            $tagID->data_last_add=date('Y-m-d H:i:s', time());
//            $tagID->save();

        }
        $this->countUsedTags();
    }

    private function countUsedTags()
    {
        $arrayTags = Yii::app()->db->createCommand()->select('id')->from('{{tags}}')->queryAll();
        if ($arrayTags) {
            foreach ($arrayTags as $value) {
                foreach ($value as $id) {
                    Yii::app()->db->createCommand()->update('{{tags}}', array(
                        'count_used' => Yii::app()->db->createCommand()->select('COUNT(tag_id)')->from('{{content_tag}}')->where('tag_id = ' . $id)->queryScalar(),
                    ), 'id=:id', array(':id' => $id));
                }

            }
        }
    }

}