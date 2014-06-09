<?php

/**
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $tags
 */
class Page extends CActiveRecord {

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_ARCHIVED = 3;

    const SIDEBAR_DISABLED = 0;
    const SIDEBAR_ENABLED = 1;

    public $link;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Page the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{pages}}';
    }

    public function rules() {
        return array(
            array('title, content, status, permalink', 'required'),
            array('title', 'length', 'max' => 128),
            array('status, sidebar_enable', 'in', 'range' => array(0, 1, 2, 3)),
            array('url', 'required', 'on' => 'add_update_link'),
            array('tags', 'match', 'pattern' => '/^[\w\s,]+$/',
                'message' => 'In the tags you can use only letters.'),
//            array('link','url'),
            array('title, status, url, lvl, links_icon, sidebar_enable', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'tags' => 'Tags',
            'permalink' => 'Permalink',
            'links_icon' => 'Links Icon',
            'sidebar_enable' => 'Sidebar'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', '<>link', true);
        $criteria->compare('status', $this->status);
        $criteria->compare('tags', $this->tags, true);
        $criteria->compare('permalink', $this->permalink, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('links_icon', $this->links_icon, true);
        $criteria->compare('sidebar_enable', $this->sidebar_enable, true);
//        $criteria->condition = "content <> 'link'";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchlinks() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content = 'link', true);
        $criteria->compare('status', $this->status);
        $criteria->compare('tags', $this->tags, true);
        $criteria->compare('permalink', $this->permalink, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('links_icon', $this->links_icon, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getMenu() {
        $sql = "SELECT id,title,in_menu,lvl FROM tsn_pages  WHERE STATUS = 2 ORDER BY menu_order";
        $mymenu = Yii::app()->db->createCommand($sql)->queryAll();
        return $mymenu;
    }

    public function getMenuItems() {
        $sql = "SELECT id,title,url,lvl,menu_order FROM tsn_pages  WHERE STATUS = 2 AND in_menu = 1 ORDER BY menu_order";
        $mymenu = Yii::app()->db->createCommand($sql)->queryAll();
        return $mymenu;
    }

    public function getUrl() {
        return Yii::app()->createUrl('page/page/view', array(
                    'id' => $this->id,
                    'title' => $this->title,
                ));
    }

    public static function checkMenuPositions() {

        $menu_items = Page::model()->getMenuItems();
        foreach ($menu_items as $menu_order => $item) {
            if (isset($menu_items[$menu_order + 1])) {
                $next_menu_item = $menu_items[$menu_order + 1];
                if ($next_menu_item['lvl'] > $item['lvl'] && ($next_menu_item['lvl'] - 1) > $item['lvl']) {
                    $next_menu_item_obj = Page::model()->findByPk($next_menu_item['id']);
                    $next_menu_item_obj->lvl = $next_menu_item_obj->lvl - 1;
                    if ($next_menu_item_obj->save()) {
                        Page::checkMenuPositions();
//                        $message = '<script type="text/javascript">alert("Please check menu order.");</script>';
                        return TRUE;
                    }
                }
            }
        }
    }

    /**
     * @param $key_type
     * @internal param string $out
     * @return string representation of the status of page.
     */
    public static function getTextStatusPage($key_type) {
        $label = self::getArrayStatusPages();
        return $label[$key_type];
    }

    /**
     * $param empty.
     * @return array_status_Pages.
     */
    public static function getArrayStatusPages() {
        return array(
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_ARCHIVED => 'Archived',
        );
    }

}
