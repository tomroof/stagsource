<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $email
 * @property string $passwd
 * @property string $first_name
 * @property string $last_name
 * @property integer $phone
 * @property string $date_create
 * @property string $date_last_login
 * @property integer $role_id
 * @property string $date_leave
 * @property integer $status
 * @property integer $pro_status
 */
class User extends CActiveRecord {

    const ADMIN_ROLE = 1;
    const WEBUSER_ROLE = 2;
    const GENDER_MALE = 0;
	const GENDER_FEMALE = 1;


    const PROFESSION_DENCER=1;
    const PROFESSION_СHOREOGRAPHER=2;
    const PROFESSION_TEACHER=3;


    const DanceStyleHipHop=1;
    const DanceStyleJazzFunk=2;
    const DanceStyleJazz=3;
    const DanceStyleContemporary=4;
    const DanceStyleBallet=5;
    const DanceStyleFreestyle=6;
    const DanceStyleBreaking=7;
    const DanceStylePopping=8;
    const DanceStyleLocking=9;
    const DanceStyleHouse=10;
    const DanceStyleTap=11;

    public $passwd2;
    public $confirm_email;
    public $terms = false;
    public $salt;
    public $validacion;
    public $genders = array(
        'Male',
        'Female',
    );

	const STATUS_USER_PRO = '1';
	const STATUS_USER_PRO_REQUEST = '2';
    const STATUS_USER_NOT_PRO= '3';
    public $mess_filter;

//	public $FB_login;// check FB login option status on||off
//	public function __construct() {
//		 $this->FB_login = Options::model()->findByAttributes(array('type' => 'FB_login'))->code;
//	}

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tsn_user';
    }

    public function beforeSave() {

        if(!empty($this->slideshow)){
            $this->slideshow = serialize($this->slideshow);
        }
        if(!empty($this->profession)){
            $this->profession=implode(':',$this->profession);

        }
        if(!empty($this->dence_style)){
            $this->dence_style=implode(':',$this->dence_style);
        }

        if ($this->birthday) {
            $this->birthday = date('Y-m-d', strtotime($this->birthday));
        }
        return parent::beforeValidate();
    }

    public function afterSave()
    {
//        $contentModel = Contents::model()->findByAttributes(array('dancer_author' => Yii::app()->user->id, 'content_type' => Contents::TYPE_VENDOR));
//        if (empty($contentModel)) {
//            $contentModel = new Contents();
//        }
//        $contentModel->content_title =$this->first_name . ' ' . $this->last_name;
//        $contentModel->content_type = Contents::TYPE_VENDOR;
//        $contentModel->content_author = Yii::app()->user->id;
//        $contentModel->dancer_author = Yii::app()->user->id;
//        if ($contentModel->validate()) {
//            $contentModel->save(false);
//            $celebrity_model = Celebrities::model()->findByAttributes(array('celebrity_post_id' => $contentModel->id));
//            if (empty($celebrity_model)) {
//                $celebrity_model = new Celebrities;
//            }
//            $celebrity_model->celebrity_name =$contentModel->content_title;
//            $celebrity_model->celebrity_permalink = $contentModel->content_slug;
//            $celebrity_model->celebrity_post_id = $contentModel->id;
//            if($contentModel->validate()){
//                $celebrity_model->save();
//
//            }
//        }
        return parent::afterSave();
    }

    public function afterFind() {

        if (!empty($this->slideshow)){
            $this->slideshow = unserialize($this->slideshow);
        }

        if ($this->birthday) {
            $this->birthday = date('m/d/Y', strtotime($this->birthday));
        }
        if($this->profession){
            $this->profession=explode(':',$this->profession);

        }
        if($this->dence_style){
            $this->dence_style=explode(':',$this->dence_style);
        }
        return parent::afterFind();
    }



    public static function getProfessionList(){
        return array(
            self::PROFESSION_DENCER=>'Dancer',
            self::PROFESSION_СHOREOGRAPHER=>'Choreographer',
            self::PROFESSION_TEACHER=>'Teacher'
        );
    }
    public function getProfession($key){
        $AllArray = self::getProfessionList();
        $Type = $AllArray[$this->profession[$key]];
        return $Type;
    }
    public function getProfessionString(){
        $delimeter='';
        $result='';
        foreach((array)$this->profession as $key=>$value){
            $result=$result.$delimeter.$this->getProfession($key);
            $delimeter=', ';
        }
        return $result;
    }

    public static function getDanceStyleList()
    {
        return array(
            self::DanceStyleHipHop => 'Hip Hop',
            self::DanceStyleJazzFunk => 'JazzFunk',
            self::DanceStyleJazz => 'Jazz',
            self::DanceStyleContemporary => 'Contemporary',
            self::DanceStyleBallet => 'Ballet',
            self::DanceStyleFreestyle => 'Freestyle',
            self::DanceStyleBreaking => 'Breaking',
            self::DanceStylePopping => 'Popping',
            self::DanceStyleLocking => 'Locking',
            self::DanceStyleHouse => 'House',
            self::DanceStyleTap => 'Tap',
        );
    }
    public function getDenceStyle($key){
        $AllArray = self::getDanceStyleList();
        $Type = $AllArray[$this->dence_style[$key]];
        return $Type;
    }

    public function getDenceStyleString(){
        $delimeter='';
        $result='';
        foreach((array)$this->dence_style as $key=>$value){
            $result=$result.$delimeter.$this->getDenceStyle($key);
            $delimeter=', ';
        }
        return $result;
    }

    /**
     * @return array validacion rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, passwd, first_name, last_name', 'required'),
            array('confirm_email', 'compare', 'compareAttribute' => 'email', 'message' => 'Email don\'t match', 'on' => array('registration')),
            array('confirm_email', 'required', 'on' => array('registration')),
//				array('passwd2, zip, city', 'required', 'on' => 'registerwcaptcha'),
//				array('passwd2', 'compare', 'compareAttribute' => 'passwd', 'message' => 'Passwords don\'t match', 'on' => array('registerwcaptcha')),
//				array('terms', 'compare', 'compareValue' => 1, 'message' => 'You must agree with terms', 'on' => array('registerwcaptcha')),
            array('role_id, status, zip, pro_status', 'numerical', 'integerOnly' => true),
            array('email, passwd', 'length', 'max' => 255, 'min' => 6),
            array('first_name, last_name, city_id', 'length', 'max' => 255),
            array('date_create, date_last_login,date_leave,
				country_id, state_id, city_id,
				fb_id, phone, sports_teams, athletes, music, movies,mess_filter,service', 'safe'),
            array('email', 'email'),
            array('email', 'unique'),
            array('sports_teams, athletes, music, movies', 'length', 'max' => 255),
            array('state_id,city', 'required', 'on' => 'createProfile'),
            array('social_links_w,social_links_t,social_links_f,social_links_g,social_links_p,social_links_i, agency_url, studio_url,url', 'url', 'on' => 'createProfile'),
//            array('dence_style, profession, resume','required', 'on' => 'createProfile'),
            array('video','validateiframe', 'on' => 'createProfile'),
            array('teaching_schedule, agency_name, studio_name,url, thoughts, years_dencing, favorites_1, favorites_2, favorites_3, favorites_4','safe','on'=>'createProfile'),
            array('slideshow', 'validateSliderImages', 'on' => 'createProfile'),
//				array('validacion',
//						'application.extensions.recaptcha.EReCaptchaValidator',
//						'privateKey' => '6LcJwtYSAAAAAMhe_siwVr1UKLZWPKnEaI3sjllT',
//						'on' => 'registerwcaptcha'
//				),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, passwd, first_name, last_name,  date_create, role_id, country_id, state_id, fb_id, confirm_email,service, pro_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'country' => array(self::BELONGS_TO, 'Countries', array('id' => 'country_id')),
            'state' => array(self::BELONGS_TO, 'States', array('state_code' => 'state_id')),
            'zipareas' => array(self::BELONGS_TO, 'Zipareas', 'city_id'),
            'danser' => array(self::BELONGS_TO, 'Contents', array('id'=>'dancer_author')),
        );
    }
    public function validateiframe($attribute, $params) {
        if ((substr_count($this->video, 'iframe') != 2 ||
            substr_count($this->video, 'width') != 1 ||
            substr_count($this->video, 'height') != 1)&&
            !empty($this->video)

        ){
            $this->addError($attribute, 'This is not the iframe or not correct');
        }
    }

    public function validateSliderImages($attribute, $params) {
        $images = $this->slideshow;
        $result_images = array();
        if(!empty($images)){

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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {

        return array(
            'id' => 'ID',
            'fb_id' => 'Facebook Id',
            'email' => 'Email:',
            'passwd' => 'Password:',
            'first_name' => 'First Name:',
            'last_name' => 'Last Name:',
            'date_create' => 'Date Create',
            'date_last_login' => 'Date Last Login',
            'role_id' => 'Type',
            'date_leave' => 'Date Leave',
            'status' => 'Status',
            'country_id' => 'Country',
            'state_id' => 'State:',
            'city_id' => 'City:',
            'passwd2' => 'Confirm Password',
            'gender' => 'Gender:',
            'terms' => 'I agree with <a href="' . Yii::app()->createUrl('page/page/infopage/', array('name' => 'terms')) . '">Terms of Use</a>',
            'confirm_email' => 'Confirm Email',
            'sports_teams' => 'Sports Team',
            'athletes' => 'Athletes',
            'music' => 'Music',
            'movies' => 'Movies/Tv',
            'years_dencing'=>'Years Dancing',
            'agency_name'=>'Agency Name',
            'agency_url'=>'Agency URL',
            'studio_neme'=>'Studio Name',
            'studio_url'=>'Studio URL',
            'pro_status' => 'Pro Status',
            'thoughts'=>'Status'
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
//         $criteria->condition = 'status=0';
        $criteria->compare('id', $this->id);
        $criteria->compare('fb_id', $this->fb_id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('passwd', $this->passwd, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('date_create', $this->date_create, true);
        $criteria->compare('date_last_login', $this->date_last_login, true);
        $criteria->compare('pro_status', $this->pro_status);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('date_leave', $this->date_leave);
        $criteria->order = "id DESC";
        $pagination = (Yii::app()->user->StateKeyPrefix == '_admin') ? array('pageSize' => 50) : array();

        // $criteria->compare('status', $this->status);
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => $pagination,
                ));
    }

    /**
     * validate password auth
     */
    public function validatePassword1($password) {
        return $this->passwd === $password;
    }

    // Get username
    public function getUsername() {
        Yii::app()->getModule('users');
        $username = User::model()->findAllByAttributes(array('email' => $this->email));
        return $username;
    }
    

    /**
     * Может уберем эту функцию не удобно каждый раз модель передавать?
     * @param $userModel
     * @return formatted username
     */
    public static function getUserFullName($userModel) {
        return $userModel->first_name . '&nbsp;' . substr($userModel->last_name, 0, 1) . '.';
//        return $userModel->first_name . '&nbsp;' . $userModel->last_name;
    }

    /**
     * @param $userID
     * @return formatted username
     */
    public static function getUserFullNameById($user_id) {
        $userModel = User::model()->findByPk($user_id);
        if ($userModel)
            if (Yii::app()->user->getStateKeyPrefix() == '_admin') {
                return $userModel->first_name . '&nbsp;' . $userModel->last_name;
            } else {
                return $userModel->first_name . '&nbsp;' . substr($userModel->last_name, 0, 1) . '.';
            }
    }

   /**
     * @param $userID
     * @return formatted userUrl
     */
    public static function getUserUrlById($user_id) {
        return Yii::app()->createUrl('user/PublicProfile/' . $user_id);
    }
    
    public function getUserFullNameByModel() {
        return $this->first_name . '&nbsp;' . $this->last_name;
    }

    /**
     * @param $key_type
     * @internal param string $out
     * @return string representation of the type of user.
     */
    public static function getTextTypeUser($key_type) {
        $label = self::getArrayTypesUser();
        return $label[$key_type];
    }

    /**
     * $param empty.
     * @return array_types_users.
     */
    public static function getArrayTypesUser() {
        return array(
            self::ADMIN_ROLE => 'Admin',
            self::WEBUSER_ROLE => 'User',
        );
    }
    
    public static function getArrayTypesUserPro() {
        return array(
            self::STATUS_USER_NOT_PRO=> 'Standart',
            self::STATUS_USER_PRO_REQUEST => 'Request Pro',
            self::STATUS_USER_PRO => 'Pro',
        );
    }
    public static function getTestTypesUserPro($key_type) {
        $label = self::getArrayTypesUserPro();
        return $label[$key_type];
    }
    public static function getYearsDencing(){
        $questions = range(0, 50, 1);
        return $questions;
    }

    /**
     * @param $key_status
     * @internal param string $out
     * @return string representation of the status of user.
     */
	public static function getTextStatusUser($key_status) {
        $label = self::getArrayStatusUser();
        return $label[$key_status];
    }

    /**
     * $param empty.
     * @return array_status_users.
     */
    public static function getArrayStatusUser() {
        return array(
			self::STATUS_USER_PRO => 'Pro',
			self::STATUS_USER_PRO_REQUEST => 'Active',
        );
    }

    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->passwd;
    }

    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }

    static function countUsers($attrs) {
        $model = User::model()->countByAttributes($attrs);

        return $model;
    }

    public static function getTimeUSA($date) {
        $time = date('m/d/Y H:i:s', strtotime($date));
        return $time;
    }

    /*     * **********************************************
     * @return
     * FB_user  - info about user
     * *********************************************** */

    public static function getFBUser() {
        $login = false;
        $data;
//		$this->FB_login = Options::model()->findByAttributes(array('type' => 'FB_login'))->code;
        # if  FB_login option on

        try {
            $FB_id = Yii::app()->facebook->getUser(); // try get facebook user id
            if ($FB_id) {
                $login = true;
            }
        } catch (FacebookApiException $e) {
            $login = false;
        }


        if ($login === true)
            $data = Yii::app()->facebook->api('/me'); // if isset facebook user id -> get user information
        else
            $data = false;



        return $data;
    }

    public static function FB_isActive() {
        return Options::model()->findByAttributes(array('type' => 'FB_login'))->code;
    }

    public function checkPassword($password) {
//        $systemSalt = MainConfig::model()->getSetting('system_salt');
        $generatedPassword = md5($password);
        return ($generatedPassword === $this->passwd);
    }

    public function generatePassword() {
        $this->passwd = md5($this->passwd);
    }

    public function getUserCityList() {
        if ($this->state_id) {
            $criteria = new CDbCriteria();
            $criteria->condition = 't.state = :state';
            $criteria->params = array(':state' => $this->state_id);
            $criteria->group = 't.city';
            $cityArray = Zipareas::model()->findAll($criteria);
            return $cityArray = CHtml::listData($cityArray, 'id', 'city');
        }
        return array();
    }

    public function getUserAvatar($userId = false,$htmlOption=array()) {
        $itemDirectory = Yii::app()->request->hostInfo . '/avatar/';
        if (!$userId) {
            if ($fb_data = User::getFBUser() && empty($this->avatar)) {
                return CHtml::image(Yii::app()->facebook->getProfilePicture('large'),'',$htmlOption);
            }
            if (file_exists(Yii::getPathOfAlias('webroot.avatar') . '/' . $this->avatar) && $this->avatar) {
                return CHtml::image($itemDirectory . $this->avatar,'',$htmlOption);
            }
        } else {
            if ($this->fb_id && !$this->avatar) {
                return CHtml::image('https://graph.facebook.com/' . $this->fb_id . '/picture','',$htmlOption);
            } elseif ($this->avatar)
                return CHtml::image($itemDirectory . $this->avatar,'',$htmlOption);
        }
        return CHtml::image(Yii::app()->request->hostInfo . '/images/profile.jpg','',$htmlOption);
    }

    public function link($params = array()) {

        return Yii::app()->createUrl('user/' . $this->id, $params);
    }

    public static function getArrayMessFilter() {
        return array(
            'all' => 'All',
            'sent' => 'Sent',
            'received' => 'Received',
        );
    }

    /*
     * @return object CActiveDataProvider
     * */

    public function getUserComments() {
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(
                array('author_id' => $this->id), 'AND'
        );
        $criteria->compare('status', '<>2');
        return new CActiveDataProvider('ContentComments', array('criteria' => $criteria, 'pagination' => array(
                        'pageSize' => 10,
                    ), 'sort' => array(
                        'attributes' => array(
                            'date' => array(
                                'asc' => 'created_at ASC',
                                'desc' => 'created_at DESC',
                                'default' => 'desc',
                            ),
                        ),
                        'defaultOrder' => array(
                            'date' => CSort::SORT_DESC,
                        )
                    ),
                ));
    }

    public function getFullFormat() {
        return $this->first_name . ' ' . $this->last_name . ', ' . $this->email;
    }

    public function beforeDelete() {
        $criteria = new CDbCriteria();
        $criteria->condition = "user_reported = " . $this->id;
        SpamReport::model()->deleteAll($criteria);

        $criteriaComments = new CDbCriteria();
        $criteriaComments->condition = 'author_id = ' . $this->id;
        ContentComments::model()->deleteAll($criteriaComments);
        $criteriaMessages = new CDbCriteria();
        $criteriaMessages->addCondition('from_user_id = ' . $this->id);
        $criteriaMessages->addCondition('to_user_id = ' . $this->id);
        Messages::model()->deleteAll($criteriaMessages);
        $criteriaContents = new CDbCriteria();
        $criteriaContents->addCondition('content_author = ' . $this->id);
        Contents::model()->deleteAll($criteriaContents);

        return parent::beforeDelete();
    }

}
