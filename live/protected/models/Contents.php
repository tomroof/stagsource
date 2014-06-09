<?php

/**
 * This is the model class for table "{{contents}}".
 *
 * The followings are the available columns in table '{{contents}}':
 * @property string $id
 * @property string $content_author
 * @property string $created_at
 * @property string $content_content
 * @property string $content_title
 * @property string $content_excerpt
 * @property string $content_status
 * @property string $content_comment_status
 * @property string $content_password
 * @property string $content_name
 * @property string $content_modified
 * @property string $content_parent
 * @property integer $content_menu_order
 * @property string $content_type
 * @property string $content_comment_count
 * @property string $content_celebrity_social_links
 * @property string $content_question
 * @property string $content_answer
 * @property string $product_price
 */
class Contents extends CActiveRecord {

    const DEFAULT_IMAGE_SMALL = '/images/default_image_small.png';
    const DEFAULT_IMAGE_WIDE = '/images/default_image_wide.png';
    const DEFAULT_IMAGE_BIG = '/images/default_image_big.png';
    const TYPE_IMAGE = 'image';
    const TYPE_SLIDESHOW_ALBUM = 'slideshow_album';
    const TYPE_QUOTE = 'quote';
    const TYPE_QUESTION_ANSWER = 'question_answer';
    const TYPE_VIDEO = 'video';
    const TYPE_ARTICLE = 'article';
    const TYPE_FACEBOOK = 'facebook';
    const TYPE_TWITTER = 'twitter';
    const TYPE_INSTAGRAM = 'instagram';
    const TYPE_POLL = 'poll';
    const TYPE_PICTURE_POLL = 'picture_poll';
    const TYPE_PRODUCT = 'product';
    // const TYPE_FEATURED = 'dancer';
    const TYPE_COMMUNITY = 'community';
//    const TYPE_DANCER = 'dancer';
    const TYPE_VENDOR = 'vendor';
    const TYPE_EVENT = 'event';
    const SIZE_IMAGE_508x508 = '508_508';
    const SIZE_IMAGE_508x250 = '508_250';
    const SIZE_IMAGE_250x250 = '250_250';
    const STATUS_PUBLISHED = 'publish';
    const STATUS_DRAFT = 'draft';
    const STATUS_ARCHIVED = 'archive';
    const COMMENT_STATUS_OPEN = 'open';
    const COMMENT_STATUS_CLOSE = 'close';

    // const CONTENT VIDEO SIZE
    const VIDEO_SIZE_250x250 = '250x174';
    const VIDEO_SIZE_508x250 = '508x174';
    const VIDEO_SIZE_508x508 = '508x320';
    const VIDEO_SIZE_508x508_DENSER = '508x508';

//    - Variables for search -
    public $type_recent_activity = 'recent_activity';
    public $type_duscussion = 'Discussion';
    public $content_celebrity_name;
    public $content_event_name;
    public $content_vendor_id;
    public $content_event_id;
    public $celebrity_post_id;
    public $celebrity_validate;
    public $author_name_1;
    public $author_name_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Contents the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        $controller = 'contents';
        $url = '';
        $params = array();
        $ContentTitle = str_replace(array('/', ',', ' ', '%', '?', '!', ':', '"', "'"), '-', trim($this->content_title));
        if ($this->inCommunity()) {
            $controller = 'Community';
        }
        if ($this->content_type == self::TYPE_VENDOR) {
            $url = 'vendor/' . $this->content_slug;
        }
        return array(
            'permalinkBehavior' => array(
                'class' => 'PermalinkGeneratorBehavior',
                'controller' => $controller,
                'action' => 'view',
                'params' => $params,
                'ContentTitle' => $ContentTitle,
                'url' => $url
            ),
            'SlugBehavior' => array(
                'class' => 'application.components.SlugBehavior',
                'sourceAttribute' => 'content_title',
                'slugAttribute' => 'content_slug',
//                'mode' => 'translate',
            ),
            'pollBehavior' => array(
                'class' => 'application.modules.poll.components.PollSaveBehavior',
                'model' => $this,
//                'action' => 'view',
//                'params'=>$params
            ),
            'SeoPack' => array(
                'class' => 'application.modules.seopack.components.SeoPackBeforeSaveBehavior',
            ),
        );
    }

    public function beforeSave() {
        $this->created_at = ($this->created_at != '0000-00-00 00:00:00') ? date('Y-m-d H:i:s', strtotime($this->created_at)) : date('Y-m-d H:i:s');
        if (!empty($this->content_slider_images) && is_array($this->content_slider_images))
            $this->content_slider_images = serialize($this->content_slider_images);
        if($this->content_celebrity_social_links){
            $this->content_celebrity_social_links = serialize($this->content_celebrity_social_links);
        }
        return parent::beforeSave();
    }

    public function afterFind() {
        if (!empty($this->content_slider_images)){
            $this->content_slider_images = unserialize($this->content_slider_images);
            if(!empty($this->content_slider_images) && !is_array($this->content_slider_images))
               $this->content_slider_images = unserialize($this->content_slider_images);
        }
        if (Yii::app()->controller->getAction()->getId() !== 'RecentActivity')
            $this->created_at = date('m/d/Y H:i:s', strtotime($this->created_at));
        if ($this->content_celebrity_social_links) {
            $this->content_celebrity_social_links = unserialize($this->content_celebrity_social_links);
        }
        return parent::afterFind();
    }

    public function beforeDelete() {
        if ($this->content_type == self::TYPE_VENDOR) {
            Celebrities::model()->deleteAllByAttributes(array('celebrity_post_id' => $this->id));
        }

        Yii::import('application.modules.like.models.Like');
        $criteria = new CDbCriteria();
        $criteria->condition = 'model_name = "Contents" AND model_id = ' . $this->id;
        Like::model()->deleteAll($criteria);

        $criteria = new CDbCriteria();
        $criteria->condition = 'model = "ContentComments" AND model_id = ' . $this->id;
        SpamReport::model()->deleteAll($criteria);

        $criteria = new CDbCriteria();
        $criteria->condition = 'model_name = "Contents" AND model_id = ' . $this->id;
        PollItem::model()->deleteAll($criteria);

        $criteria = new CDbCriteria();
        $criteria->condition = 'model_name = "Contents" AND object_id = ' . $this->id;
        SeoPack::model()->deleteAll($criteria);
        return parent::beforeDelete();
    }

    public function afterSave() {

        PostVendorRelation::addPostVendorRelation($this->id, $this->content_vendor_id);

        $tagsContent = Yii::app()->request->getPost('tags');
        if ($tagsContent)
            Tags::model()->addTags($tagsContent, $this->id);
        else
            Yii::app()->db->createCommand()->delete('{{content_tag}}', 'content_id=:content_id', $params = array(':content_id' => $this->id));
        return parent::afterSave();
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{contents}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content_author, content_title', 'required', 'except' => array('content_facebook_url', 'content_instagram_url', 'content_twitter_url', 'community', 'content_image', 'content_facebook', 'vendor')),
            array('content_menu_order, content_category_id', 'numerical', 'integerOnly' => true),
            array('content_author', 'length', 'max' => 255),
            array('content_status, content_comment_status, content_password, content_parent, content_type, content_comment_count', 'length', 'max' => 20),
            array('content_name', 'length', 'max' => 200),
            array('created_at, content_modified, content_is_premium, content_celebrity_name,content_vendor_id, content_event_id, content_event_name
            celebrity_post_id, celebrity_validate,content_thumbnail, content_slider_images, content_video_embed,
             content_celebrity_social_links, content_excerpt,content_sub_title', 'safe'),
            array('content_author, content_title, content_thumbnail', 'required', 'on' => 'content_image'),
            array('content_thumbnail', 'validateimg', 'on' => array('content_image','product')),
            array('content_slider_images', 'required', 'on' => 'content_slideshow'),
            array('content_slider_images', 'validateSliderImages', 'on' => 'content_slideshow'),
            array('content_video_embed', 'required', 'on' => 'content_video'),
            array('content_video_embed', 'validateiframe', 'on' => 'content_video'),
            array('content_question, content_answer', 'required', 'on' => 'content_type_question_answer'),
            array('quote_author', 'length'),
//            array('content_content', 'validateContentSerialize', 'on' => 'community'
            /* , 'except' => array('content_facebook_url', 'content_instagram_url', 'content_poll', 'content_twitter_url','picture_poll','content_image','content_slideshow') */
//        ),
            array('content_author', 'default', 'value' => Yii::app()->user->id),
//            array('content_source', 'required'),
            array('content_source', 'validateFacebookUrl', 'on' => 'content_facebook_url'),
            array('content_facebook_link, instagram_author', 'length'),
            array('content_author, content_content, content_title, content_source, content_facebook_link', 'required', 'on' => 'content_facebook'),
            array('content_source', 'validateInstagram', 'on' => 'content_instagram_url'),
            array('content_author, content_title', 'required', 'on' => 'community'),
            array('content_source', 'validateTwitter', 'on' => 'content_twitter_url'),
            array('content_slider_images', 'validateEventSliderImages', 'on' => 'event'),
            array('content_video_embed', 'validateiframe', 'on' => 'event'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('content_source', 'url'),
            array('content_slug','unique'),
            array('content_content,content_slug, product_price', 'safe'),
            array('content_title, content_content', 'required', 'on' => 'vendor'),
            array('id, content_author, created_at, content_content, content_title, content_excerpt, content_status,
             content_comment_status, content_password, content_name, celebrity_validate, celebrity_post_id,
             content_modified, content_parent, content_menu_order, content_type, content_comment_count,
              content_category_id, content_is_premium, content_celebrity_name,content_vendor_id,content_thumbnail,
               content_slider_images, content_video_embed, content_celebrity_social_links, content_question, content_answer,
                quote_author, content_source, content_facebook_link,content_sub_title', 'safe', 'on' => 'search'),
        );
    }

    public function validateimg($attribute, $params) {
        //        $webPathFile = Yii::app()->request->hostInfo . $this->content_thumbnail;
        $webPathFile = $this->content_thumbnail;
        $servPathFile = Yii::getPathOfAlias('webroot') . $this->content_thumbnail;

        if (!empty($this->content_thumbnail) && file_exists($servPathFile)) {
            $etalon = 508;
            $image = getimagesize('.' . $webPathFile);
            $width = $image[0];
            $height = $image[1];
            if ($width < $etalon)
                $this->addError($attribute, 'Width must be more than ' . $etalon . 'px.');
            if ($height < $etalon)
                $this->addError($attribute, 'Height must be more than ' . $etalon . 'px.');
        } else {
            $this->addError($attribute, 'File not exists');
        }
    }

    public function validateSliderImages($attribute, $params) {
        $images = $this->content_slider_images;
        $result_images = array();
        if (!empty($images)) {
            foreach ($images as $img) {
                if ($img != '') {
                    $servPathFile = Yii::getPathOfAlias('webroot') . $img;
                    if (file_exists($servPathFile)) {
                        $result_images[] = $img;
                    } else {
                        $this->addError($attribute, 'File not exists');
                    }
                }
            }
        }
        if (!count($result_images)) {
            $this->addError($attribute, 'Can not be empty.');
        } elseif (count($result_images) < 3) {
            $this->addError($attribute, 'Slideshow must contain 3 or more images.');
        }
    }

    public function validateEventSliderImages($attribute, $params) {
        $images = $this->content_slider_images;
        $result_images = array();
        if (!empty($images)) {
            foreach ($images as $img) {
                if ($img != '') {
                    $webPathFile = Yii::app()->request->hostInfo . $img;
                    $servPathFile = Yii::getPathOfAlias('webroot') . $img;
                    if (file_exists($servPathFile)) {
                        $result_images[] = $img;
                    } else {
                        $this->addError($attribute, 'File not exists');
                    }
                }
            }
            if (!count($result_images)) {
                $this->addError($attribute, ' Can not be empty.');
            } elseif (count($result_images) < 3) {
                $this->addError($attribute, 'Slideshow must contain 3 or more images.');
            }
        }
    }

    public function validateiframe($attribute, $params) {
        if (!empty($this->content_video_embed)) {
            if (substr_count($this->content_video_embed, 'iframe') != 2 ||
                    substr_count($this->content_video_embed, 'width') != 1 ||
                    substr_count($this->content_video_embed, 'height') != 1
            )
                $this->addError($attribute, 'This is not the iframe or not correct');
        }
    }

//    public function validateContentSerialize($attribute, $params) {
//        if (empty($this->content_content)) {
//            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' can not be empty.');
//        }
//    }

    public function validateFacebookUrl($attribute, $params) {
        $patern = '/^(http|https):\/\/(www\.)?facebook\.com\/stagsource\/posts\/(\d)+/ ';
        if (preg_match($patern, $this->content_source) == false)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' can not be empty or url not correct');
    }

    public function validateInstagram($attribute) {
        $patern = '/^(http|https):\/\/(www\.)?instagram\.com\/(\w)+\/(\w)+/ ';
        if (preg_match($patern, $this->content_source) == false)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' url not correct');
    }

    public function validateTwitter($attribute) {
        $paternUrl = '/^(http|https):\/\/(www\.)?twitter\.com\/.*(\d)+$/';
        if (preg_match($paternUrl, $this->content_source) == false)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' url not correct');
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user_rel' => array(self::BELONGS_TO, 'User', 'content_author'),
            'dancer' => array(self::BELONGS_TO, 'User', 'dancer_author'),
            'content_category_rel' => array(self::BELONGS_TO, 'ContentCategories', 'content_category_id'),
            'content_celebrity_rel' => array(self::BELONGS_TO, 'PostVendorRelation', array('id' => 'post_id')),
            'tag_rel' => array(self::BELONGS_TO, 'ContentTag', array('id' => 'content_id')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'id',
            'content_author' => 'Author',
            'created_at' => 'Created',
            'content_content' => 'Content',
            'content_title' => 'Title',
            'content_excerpt' => 'Excerpt',
            'content_status' => 'Status',
            'content_comment_status' => 'Comment status',
            'content_password' => 'Password',
            'content_name' => 'Name',
            'content_modified' => 'Modified',
            'content_parent' => 'Parent',
            'content_menu_order' => 'Menu order',
            'content_type' => 'Type',
            'content_comment_count' => 'Comment count',
            'content_category_id' => 'Category:',
            'content_is_premium' => 'Premium',
            'content_vendor_id' => 'Vendor',
            'content_thumbnail' => 'Thumbnail',
            'content_event_id' => 'Event',
            'content_video_embed' => 'Video embed',
            'content_celebrity_social_links' => 'Social links',
            'content_celebrity_description' => 'Description',
            'content_question' => 'Question',
            'content_answer' => 'Answer',
            'quote_author' => 'Quote Author',
            'content_source' => 'URL',
            'content_sub_title' => 'Sub Title',
            'product_price' => 'Price',
            'content_slug'=>'Permalink'
        );
    }

    public static function get_type_list() {
        return array(
            self::TYPE_IMAGE => 'Image',
            self::TYPE_SLIDESHOW_ALBUM => 'Slideshow Album',
            self::TYPE_QUOTE => 'Quote',
            self::TYPE_QUESTION_ANSWER => 'Question answer',
//            self::TYPE_COMMUNITY =>'Community',
            self::TYPE_VIDEO => 'Video',
//            self::TYPE_DANCER => 'Dancer',
//            self::TYPE_EVENT => 'Event',
            self::TYPE_ARTICLE => 'Article',
            self::TYPE_FACEBOOK => 'Facebook',
            self::TYPE_TWITTER => 'Twitter',
            self::TYPE_INSTAGRAM => 'Instagram',
            self::TYPE_POLL => 'Poll',
            self::TYPE_PICTURE_POLL => 'Picture Poll',
//            self::TYPE_EVENT => 'Event',
            self::TYPE_PRODUCT => 'Product',
                // self::TYPE_FEATURED => 'Featured',
                //  self::TYPE_DANCER => 'Celebrity',
        );
    }

    public function get_type() {
        $type_arr = self::get_type_list();
        $content_type = $type_arr[$this->content_type];
        return $content_type;
    }

    public static function get_status_list() {
        return array(
            self::STATUS_PUBLISHED => 'Publish',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_ARCHIVED => 'Archive',
        );
    }

    public static function get_comment_status_list() {
        return array(
            self::COMMENT_STATUS_OPEN => 'Open',
            self::COMMENT_STATUS_CLOSE => 'Close',
        );
    }

    public static function get_size_type() {
        return array(
            1 => 'small',
            2 => 'small',
            3 => 'small',
            4 => 'small',
            5 => 'wide',
            6 => 'big',
            7 => 'small',
            8 => 'small',
            9 => 'small',
            10 => 'wide',
            11 => 'small',
            12 => 'small',
            13 => 'small',
            14 => 'small',
            15 => 'small',
            16 => 'wide',
            17 => 'big',
            18 => 'small',
            19 => 'small',
            20 => 'small',
            21 => 'wide',
            22 => 'small',
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
        $criteria->compare('content_author', $this->content_author, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('content_content', $this->content_content, true);
        $criteria->compare('content_title', $this->content_title, true);
        $criteria->compare('content_excerpt', $this->content_excerpt, true);
        $criteria->compare('content_status', $this->content_status, true);
        $criteria->compare('content_comment_status', $this->content_comment_status, true);
        $criteria->compare('content_password', $this->content_password, true);
        $criteria->compare('content_name', $this->content_name, true);
        $criteria->compare('content_modified', $this->content_modified, true);
        $criteria->compare('content_parent', $this->content_parent, true);
        $criteria->compare('content_menu_order', $this->content_menu_order);
        $criteria->compare('content_type', $this->content_type, true);
        $criteria->compare('content_comment_count', $this->content_comment_count, true);
        $criteria->compare('content_category_id', $this->content_category_id, true);
        $criteria->compare('content_is_premium', $this->content_is_premium, true);
        $criteria->compare('content_thumbnail', $this->content_thumbnail, true);
        $criteria->compare('content_video_embed', $this->content_video_embed, true);
        $criteria->compare('content_question', $this->content_question, true);
        $criteria->compare('content_answer', $this->content_answer, true);
        $criteria->compare('content_source', $this->content_source, true);
        // $criteria->compare('content_vendor_id', $this->content_vendor_id, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchNotCommunity($limit = "") {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('content_author', $this->content_author, true);
        $criteria->compare('content_source', $this->content_source, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('content_content', $this->content_content, true);
        $criteria->compare('content_title', $this->content_title, true);
        $criteria->compare('content_excerpt', $this->content_excerpt, true);
        $criteria->compare('content_status', $this->content_status, true);
        $criteria->compare('content_comment_status', $this->content_comment_status, true);
        $criteria->compare('content_password', $this->content_password, true);
        $criteria->compare('content_name', $this->content_name, true);
        $criteria->compare('content_modified', $this->content_modified, true);
        $criteria->compare('content_parent', $this->content_parent, true);
        $criteria->compare('content_menu_order', $this->content_menu_order);
        $criteria->compare('content_type', $this->content_type);
        $criteria->compare('content_comment_count', $this->content_comment_count, true);
        $criteria->compare('content_category_id', $this->content_category_id, true);
        $criteria->compare('content_is_premium', $this->content_is_premium, true);
        $criteria->compare('content_thumbnail', $this->content_thumbnail, true);
        $criteria->compare('content_vendor_id', $this->content_vendor_id, true);
        $criteria->compare('content_video_embed', $this->content_video_embed, true);
        $criteria->compare('content_question', $this->content_question, true);
        $criteria->compare('content_answer', $this->content_answer, true);
        $criteria->addNotInCondition('content_type', array(self::TYPE_VENDOR, self::TYPE_COMMUNITY));
        $criteria->order = 'created_at DESC';
        if (!empty($limit)) {
            $criteria->limit = $limit;
            $pagination = false;
        } else
            $pagination = (Yii::app()->user->StateKeyPrefix == '_admin') ? array('pageSize' => 50) : array();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => $pagination,
                ));
    }

    public function searchCommunity($limit = "") {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('content_author', $this->content_author, true);

        $criteria->with = 'user_rel';
        $criteria->addSearchCondition('user_rel.first_name', $this->author_name_1, true, 'OR');
        $criteria->addSearchCondition('user_rel.last_name', $this->author_name_1, true, 'OR');
        $criteria->addSearchCondition('user_rel.first_name', $this->author_name_2, true, 'OR');
        $criteria->addSearchCondition('user_rel.last_name', $this->author_name_2, true, 'OR');

        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('content_content', $this->content_content, true);
        $criteria->compare('content_title', $this->content_title, true);
        $criteria->compare('content_excerpt', $this->content_excerpt, true);
        $criteria->compare('content_status', $this->content_status, true);
        $criteria->compare('content_comment_status', $this->content_comment_status, true);
        $criteria->compare('content_password', $this->content_password, true);
        $criteria->compare('content_name', $this->content_name, true);
        $criteria->compare('content_modified', $this->content_modified, true);
        $criteria->compare('content_parent', $this->content_parent, true);
        $criteria->compare('content_menu_order', $this->content_menu_order);
        $criteria->compare('content_type', $this->content_type, true);
        $criteria->compare('content_comment_count', $this->content_comment_count, true);
        $criteria->compare('content_category_id', $this->content_category_id, true);
        $criteria->compare('content_is_premium', $this->content_is_premium, true);
        $criteria->compare('content_thumbnail', $this->content_thumbnail, true);
        $criteria->compare('content_video_embed', $this->content_video_embed, true);
        $criteria->addInCondition('content_type', array(self::TYPE_COMMUNITY));
        $criteria->compare('content_source', $this->content_source, true);
        $criteria->order = 'created_at DESC';
        if (!empty($limit)) {
            $criteria->limit = $limit;
            $pagination = false;
        } else
            $pagination = (Yii::app()->user->StateKeyPrefix == '_admin') ? array('pageSize' => 50) : array();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => $pagination,
                ));
    }

    public function searchCelebrities($limit = "") {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('content_author', $this->content_author, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('content_content', $this->content_content, true);
        $criteria->compare('content_title', $this->content_title, true);
        $criteria->compare('content_excerpt', $this->content_excerpt, true);
        $criteria->compare('content_status', $this->content_status, true);
        $criteria->compare('content_comment_status', $this->content_comment_status, true);
        $criteria->compare('content_password', $this->content_password, true);
        $criteria->compare('content_name', $this->content_name, true);
        $criteria->compare('content_modified', $this->content_modified, true);
        $criteria->compare('content_parent', $this->content_parent, true);
        $criteria->compare('content_menu_order', $this->content_menu_order);
        $criteria->compare('content_comment_count', $this->content_comment_count, true);
        $criteria->compare('content_category_id', $this->content_category_id, true);
        $criteria->compare('content_is_premium', $this->content_is_premium, true);
        $criteria->addInCondition('content_type', array(self::TYPE_VENDOR));
        $criteria->compare('content_video_embed', $this->content_video_embed, true);
        $criteria->compare('content_source', $this->content_source, true);
        $criteria->order = 'created_at DESC';
        if (!empty($limit)) {
            $criteria->limit = $limit;
            $pagination = false;
        } else
            $pagination = (Yii::app()->user->StateKeyPrefix == '_admin') ? array('pageSize' => 50) : array();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => $pagination,
                ));
    }

    public function inCommunity() {
        if ($this->content_type == self::TYPE_COMMUNITY) {
            return true;
        } else {
            return false;
        }
    }

    public function getContentTypes() {
        return array(
            $this->type_recent_activity => 'Recent activity',
            self::TYPE_ARTICLE => 'Articles',
            self::TYPE_VIDEO => 'Videos',
            self::TYPE_QUOTE => 'Quote',
            self::TYPE_POLL => 'Polls',
            self::TYPE_COMMUNITY => 'Discussion',
        );
    }

    public function getCheckedTypes($type_search, $value) {
        if (!empty($type_search) && in_array($value, $type_search)) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function getIsPremiumType() {
        if (!empty($this->content_is_premium)) {
            if ($this->content_is_premium == '1') {
                return '<div class="premium"> &nbsp; </div>';
            } elseif ($this->content_is_premium == '2') {
                return '<div class="premium-white"> &nbsp; </div>';
            }
        }
    }

    public function getCommunityThumbnail() {
        if ($this->content_thumbnail != null) {
            echo '<div class="img-wrap">';
            echo '<a href="' . $this->permalink . '">';
            echo '<img src="' . $this->content_thumbnail . '" alt=""/>';
            echo '</a>';
            echo '</div>';
        }
    }

    public function getCommunityResizedThumbnail($width, $height, $params = array()) {
        if ($this->content_thumbnail != null) {
            $resized_image = ResizeImage::resizeImg($this->content_thumbnail, $width, $height, $params);
            echo '<div class="img-wrap">';
            echo '<a href="' . $this->permalink . '">';
            echo '<img src="' . $resized_image . '" alt=""/>';
            echo '</a>';
            echo '</div>';
        }
    }

    public function searchTopSubMenu($category_id = false) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = 'content_category_rel';
        $criteria->addCondition('content_category_rel.id=' . $category_id, 'or');
        $criteria->addCondition('content_category_rel.parent=' . $category_id, 'or');
        $criteria->addCondition('content_thumbnail IS NOT NULL ');
        $criteria->addCondition('content_thumbnail !="" ');
        $criteria->order = ' t.created_at desc ';
        $criteria->limit = 4;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false
                ));
    }

    public function searchTagsTopSubMenu($category_id = false) {

//  $sql= "SELECT *
//        FROM (
//            SELECT  t.tag ,  tsn_content_tag.created_at
//FROM  tsn_tags  t
//INNER JOIN  tsn_content_tag ON t.id = tsn_content_tag.tag_id
//INNER JOIN  tsn_contents ON tsn_content_tag.content_id = tsn_contents.id
//WHERE tsn_contents.content_category_id =$category_id
//ORDER BY tsn_content_tag.created_at ASC
//) AS new_teble
//WHERE 1 =1
//GROUP BY new_teble.tag
//ORDER BY new_teble.created_at DESC
//LIMIT 6";
//
//      return $result = Yii::app()->db->createCommand($sql)->queryAll();
//        echo '<pre>';
//        var_dump($result);
//        echo '</pre>';
//        die();

        $criteria = new CDbCriteria;

        $criteria->join = 'INNER JOIN `tsn_content_tag` ON t.id = tsn_content_tag.tag_id
                           INNER JOIN `tsn_contents` ON tsn_content_tag.content_id = tsn_contents.id';
        $criteria->addCondition('tsn_contents.content_category_id=' . $category_id);
        $criteria->order = 't.count_used DESC ';
        $criteria->group = 't.tag';
        $criteria->limit = 6;

        return Tags::model()->findAll($criteria);
    }

    public function sliceContentImage($source_img, $image_resize = array('big' => '508_508', 'medium' => '508_250', 'small' => '250_250')) {
        $array_path = explode("/", $source_img);
        $name = end($array_path);
        $ih = new CImageHandler();
//        if(!file_exists(Yii::getPathOfAlias('webroot') . $source_img)){
//
//            return ;
//        }
        $ih->load(Yii::getPathOfAlias('webroot') . $source_img);
        $width = $ih->getWidth();
        $height = $ih->getHeight();
        $ratio = $height / $width;
        foreach ($image_resize as $value) {
            $ih->reload();
            $arraySize = explode('_', $value);
            $new_h = $arraySize[0];
            $new_w = $arraySize[1];
            if ($ratio > 0)
                $ih->resize($new_h, false, true);
            else
                $ih->resize(false, $new_w, true);
            $width = $ih->getWidth();
            $height = $ih->getHeight();
            $xDiff = $width - $arraySize[0] > 0 ? $width - $arraySize[0] : 0;
            $yDiff = $height - $arraySize[1] > 0 ? $height - $arraySize[1] : 0;
            $ih->crop($arraySize[0], $arraySize[1], false, $yDiff / 2);
            if (!file_exists(Yii::getPathOfAlias('webroot') . '/uploads/contentsTypeImage/' . $arraySize[0] . '_' . $arraySize[1])) {
                if (!mkdir(Yii::getPathOfAlias('webroot') . '/uploads/contentsTypeImage/' . $arraySize[0] . '_' . $arraySize[1], 0777, true)) {
                    die('Unable to create directory. Check the rights to the folder uploads 0777');
                }
            }
            $ih->save(Yii::getPathOfAlias('webroot') . '/uploads/contentsTypeImage/' . $arraySize[0] . '_' . $arraySize[1] . '/' . $name, false, 75, false);
        }
        return true;
    }

    public static function getContentImage($size, $name, $default_image = self::DEFAULT_IMAGE_BIG) {
        $array_path = explode("/", $name);
        $fileName = end($array_path);
        if ($fileName != null) {
            if (file_exists(Yii::getPathOfAlias('webroot') . '/uploads/contentsTypeImage/' . $size . '/' . $fileName)) {
                return CHtml::image(Yii::app()->request->hostInfo . '/uploads/contentsTypeImage/' . $size . '/' . $fileName);
            }
        }
        return CHtml::image($default_image);
    }

    public function getContentThumbnail($src) {
        echo '<div class="img-wrap">';
        if ($src != null) {
            echo CHtml::image($src, '');
        } else {
            echo CHtml::image(self::DEFAULT_IMAGE_BIG, '');
        }
        echo '</div>';
    }

    public function getTimeFormatAmPm($datetime) {
        $datetime = strtotime($datetime);
        echo '<p class="time">';
        echo date('g:i A', $datetime);
        echo '</p>';
    }

    public function getImageSrc() {
        if ($this->content_thumbnail != null) {
            if (file_exists(Yii::getPathOfAlias('webroot') . $this->content_thumbnail)) {

                return Yii::app()->request->hostInfo . $this->content_thumbnail;
            } else {

                return self::DEFAULT_IMAGE_BIG;
            }
        } else {
            return self::DEFAULT_IMAGE_BIG;
        }
    }

    public static function getContentVideoSizeLink($src, $sizeVideo) {
        $arraySize = explode("x", $sizeVideo);
//        $width = 'width="' . $arraySize[0] . '"';
//        $height = 'height="' . $arraySize[1] . '"';
//        $link = preg_replace("/height=\"[0-9]*\"/", $height, preg_replace("/width=\"[0-9]*\"/", $width, $src));
        preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $src, $matches);
        $link = '<iframe width="' . $arraySize[0] . '" height="' . $arraySize[1] . '" src="' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
        return $link;
    }

    public function explodeCommynityContent($str, $words = 10) {
        $arrayStr = explode(' ', strip_tags($str));
        $countWords = count($arrayStr);
        $arrayContent = array();
        if ($countWords <= $words) {
            $arrayContent[] = implode(" ", $arrayStr);
            return $arrayContent;
        } else {
            $keyAr = 0;
            do {
                $arrayContent[] = implode(' ', array_slice($arrayStr, $keyAr, $words));
                $keyAr = $keyAr + $words;
                $countWords = $countWords - $keyAr;
            } while ($countWords >= 0);
            return $arrayContent;
        }
    }

    public static function getHotTopics($limit = 4) {

        $criteria = new CDbCriteria();
        $criteria->order = 'content_comment_count DESC';
        $criteria->limit = $limit;

        return Contents::model()->findAll($criteria);
    }

    public static function getRecentPosts($limit = 4) {

        $criteria = new CDbCriteria();
        $criteria->addCondition('content_type !="'.Contents::TYPE_VENDOR.'"' );
        $criteria->order = 'created_at DESC';
        $criteria->limit = $limit;

        return Contents::model()->findAll($criteria);
    }

    public function isErrorFBMessage($message)
    {
        $objectVars = get_object_vars($message);
        foreach ($objectVars as $var => $value) {
            if ($var === 'error') {
                $message = print_r($value, true);
                throw new CHttpException($message);

            }
        }

        return false;
    }
    public function getFacebookContentData($postUrl) {
        $arrayUrl = explode('/', $postUrl);
        $postID   = end($arrayUrl);
        if(Yii::app()->facebook->getUser() == false){
            throw new CHttpException('You should login through the "Facebook login" on the site in order to publish this content type.');
        }
        $accessToken = Yii::app()->facebook->accessToken;
        Yii::app()->facebook->setAccessToken($accessToken);
        $urlGetPostData = 'https://graph.facebook.com/' . $postID . '?access_token=' . $accessToken;
        $ch = curl_init(); // setup a curl
        curl_setopt($ch, CURLOPT_URL, $urlGetPostData); // set url to send to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
        $returnData = curl_exec($ch); // execute the curl
        curl_close($ch); // close the curl
        if (!empty($returnData)) {
            $postData = json_decode($returnData);

            $this->isErrorFBMessage($postData);

            if (isset($postData->message)) {
                $this->content_content = $postData->message;
            } elseif (!isset($postData->message)
                && isset($postData->description)
            ) {
                $this->content_content = $postData->description;
            } else {
                $this->content_content = 'No message and description not found';
            }

            if (isset($postData->name)) {
                $this->content_title = $postData->name;
            } else {
                $this->content_content = 'No title found';
            }
            if(isset($postData->link)){
                $this->content_facebook_link = $postData->link;
            }else{
                $this->content_facebook_link = $postUrl;
            }
        }
//        $arrayUrl = explode('/', $postUrl);
//        $postID = end($arrayUrl);
//        $urlAccessToken = 'https://graph.facebook.com/oauth/access_token?client_id=' . Yii::app()->facebook->appId . '&client_secret=' . Yii::app()->facebook->secret . '&grant_type=client_credentials';
//
//        $ch = curl_init(); // setup a curl
//        curl_setopt($ch, CURLOPT_URL, $urlAccessToken); // set url to send to
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
//        $answer = curl_exec($ch); // execute the curl
//        curl_close($ch); // close the curl
//        $access_token = substr($answer, 13);
//
//        $urlGetPostData = 'https://graph.facebook.com/' . $postID . '?access_token=' . $access_token;
//        $ch = curl_init(); // setup a curl
//        curl_setopt($ch, CURLOPT_URL, $urlGetPostData); // set url to send to
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
//        $returnData = curl_exec($ch); // execute the curl
//        curl_close($ch); // close the curl
//
//        if (!empty($returnData)) {
//            $postData = json_decode($returnData);
//            if (isset($postData->message))
//                $this->content_content = $postData->message;
//            elseif (!isset($postData->message) && isset($postData->description))
//                $this->content_content = $postData->description; else
//                $this->content_content = 'No message and description not found';
//
//            if (isset($postData->name))
//                $this->content_title = $postData->name;
//            else
//                $this->content_content = 'No title found';
//            $this->content_facebook_link = $postData->link;
//        }
    }

    public function getInstagramContent($url) {
        $urlGetInstagramData = 'http://api.instagram.com/oembed?url=' . $url;
        $ch = curl_init(); // setup a curl
        curl_setopt($ch, CURLOPT_URL, $urlGetInstagramData); // set url to send to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
        $returnData = curl_exec($ch); // execute the curl
        curl_close($ch); // close the curl
        $dataObj = json_decode($returnData);
        $this->content_title = $dataObj->title;
        $this->content_content = $dataObj->url;
        $this->instagram_author = $dataObj->author_name;
    }

    public function getTweetContent($tweetUrl) {
        Yii::import('webroot.protected.modules.admin.components.TwitterApplication');
        $arrayTweetUrl = explode('/', $tweetUrl);
        $tweetId = end($arrayTweetUrl);
        $twitter = new TwitterApplication();
        $tweetData = $twitter->getDataTweetById($tweetId);
        $this->content_content = preg_replace("/[^A-Za-z ]/i", "", $tweetData->text);
        $this->content_title = $tweetData->user->screen_name;
    }

    public static function getlistEventDateJson() {
        $data = Contents::model()->findAllByAttributes(array('content_type' => Contents::TYPE_EVENT));
        $str_json = null;
        $bool = '';
        foreach ($data as $key => $value) {
            $str_json = $str_json . $bool . CJSON::encode(array('value' => $value->id, 'label' => $value->content_title));
            $bool = ",";
        }
        return $str_json;
    }
    public static function getlistStoreDateJson() {

        $data = Contents::model()->findAllByAttributes(array('content_type'=>Contents::TYPE_VENDOR));
        $str_json = null;
        $bool = '';
        foreach ($data as $key => $value) {
            $str_json = $str_json . $bool . CJSON::encode(array('value' => $value->id, 'label' => $value->content_title));
            $bool = ",";
        }
        return $str_json;
    }

}
