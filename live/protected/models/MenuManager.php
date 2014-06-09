<?php

/**
 * This is the model class for table "{{menu_manager}}".
 *
 * The followings are the available columns in table '{{menu_manager}}':
 * @property integer $id
 * @property string $menu_key
 * @property string $page_id
 * @property integer $lvl
 * @property integer $menu_order
 *
 * The followings are the available model relations:
 * @property Pages $page
 */
class MenuManager extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenuManager the static model class
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
		return '{{menu_manager}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_key, page_id, lvl, menu_order', 'required'),
			array('lvl, menu_order', 'numerical', 'integerOnly'=>true),
			array('menu_key', 'length', 'max'=>32),
			array('page_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, menu_key, page_id, lvl, menu_order', 'safe', 'on'=>'search'),
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
			'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menu_key' => 'Menu Key',
			'page_id' => 'Page',
			'lvl' => 'Lvl',
			'menu_order' => 'Menu Order',
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
		$criteria->compare('menu_key',$this->menu_key,true);
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('lvl',$this->lvl);
		$criteria->compare('menu_order',$this->menu_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

      public static function checkMenuPositions($menu_key) {

        $menu_items = MenuManager::model()->findAllByAttributes(array('menu_key'=>$menu_key));

        foreach ($menu_items as $menu_order => $item) {
            if (isset($menu_items[$menu_order + 1])) {
                $next_menu_item = $menu_items[$menu_order + 1];
                if ($next_menu_item->lvl > $item->lvl && ($next_menu_item->lvl - 1) > $item->lvl) {
                    $next_menu_item_obj = MenuManager::model()->findByPk($next_menu_item->id);
                    $next_menu_item_obj->lvl = $next_menu_item_obj->lvl - 1;
                    if ($next_menu_item_obj->save()) {
                        MenuManager::checkMenuPositions();
                        return TRUE;
                    }
                }
            }
        }

    }
}