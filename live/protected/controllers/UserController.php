<?php

class UserController extends Controller {

    protected function beforeAction($action) {
        Yii::import('like.models.Like');
        return true;
    }

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('dashboard', 'message', 'messaging', 'publicProfile', 'addmessage', 'profile', 'accountSettings', 'calendar', 'documents', 'comments', 'favorites', 'InviteFriends',
                    'AjaxGetCityList', 'UploadAvatar', 'RecentActivity', 'AjaxInviteFriends', 'ajaxProRequest','UploadSlideshowProfile', 'ConfirmCloseAccount'),
                'expression' => '!Yii::app()->user->isGuest',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * mail notification after registartion
     */
    public function regMail() {
        $email = $_POST['User']['email'];
        $message = "Congratulations!
                  \nYou are registred in accounting.
                  \nGo to login page http://" . $_SERVER['HTTP_HOST'] . $this->createUrl('/users/auth/login') . "
                  \nLogin: " . $email . "
                  \nPasswd: " . $_POST['User']['passwd'];
        Yii::app()->mailer->Host = 'localhost';
        Yii::app()->mailer->IsSMTP();
        Yii::app()->mailer->From = 'accounting@devserverca.org.ua';
        Yii::app()->mailer->FromName = 'Accounting';
        //Yii::app()->mailer->AddReplyTo($mail);
        Yii::app()->mailer->AddAddress($email);
        Yii::app()->mailer->Subject = 'accounting registration';
        Yii::app()->mailer->Body = $message;
        Yii::app()->mailer->Send();
    }

    public function actionDashboard() {

        $this->breadcrumbs = array('Dashboard');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);


        $this->render('dashboard', compact('userModel'));
    }

    public function actionPublicProfile($id) {
        $this->breadcrumbs = array('View Profile');
        $userModel = User::model()->findByPk($id);

        if (!$userModel)
            throw new CHttpException(404);


        $this->render('public_profile', compact('userModel', 'criteria'));
    }

    public function actionComments() {
        $request = Yii::app()->request;
        $this->breadcrumbs = array('Dashboard');
        $userId = Yii::app()->user->id;

        $userModel = User::model()->findByPk($userId);
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(
                array('author_id' => $userId), 'AND'
        );
        $criteria->compare('status', '<>2');
//        $pagination = new CPagination(ContentComments::model()->count($criteria));
//        $pagination->pageSize = 10;
//        $pagination->applyLimit($criteria);
        $dataProvider = new CActiveDataProvider('ContentComments', array('criteria' => $criteria, 'pagination' => array(
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
        $this->render('comments', compact('userModel', 'dataProvider', 'criteria'));
    }

    public function actionConfirmCloseAccount()
    {

        $this->layout = 'popup';
        $request = Yii::app()->request->getPost('close');
        $accountId = md5(Yii::app()->user->id);
        if ($request && $request == $accountId) {
            $model = User::model()->findByPk(Yii::app()->user->id);

            $model->delete();


//            Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_user_confirm_close_account'));

            echo CHtml::script("top.location.href = '". Yii::app()->createUrl('/auth/logout') . "';");
            Yii::app()->end();

        }
//        else{
//            throw new CHttpException(500,'Not valid account id.');
//        }


        $this->render('close_account');
    }


    public function actionFavorites() {


        if (Yii::app()->request->getQuery('id')) {
            $this->breadcrumbs = array('Favorites');
            $view = 'public_favorites';
            $userId = Yii::app()->request->getQuery('id');
        } else {
            $this->breadcrumbs = array('Dashboard');
            $view = 'favorites';
            $userId = Yii::app()->user->id;
        }

        $userModel = User::model()->findByPk($userId);
        if (!$userModel)
            throw new CHttpException(404);

        $criteria = new CDbCriteria;
//        $criteria->with = array('contents_type_favorite');
        $criteria->compare('t.like_type','favorite');
        $criteria->compare('user_id', $userId);
        $dataProvider = new CActiveDataProvider('Like', array('criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 10,
                    ), 'sort' => array(
                        'defaultOrder' => array(
                            'created_at' => CSort::SORT_DESC,
                        )
                    ),
                ));

        $this->render($view, compact('userModel', 'dataProvider'));
    }

    public function actionMessage() {

        $request = Yii::app()->request;
        $mid = $request->getQuery('mid');
        if (!$mid) {
            $this->redirect(Yii::app()->createUrl('/user/messaging'));
        }
        $this->breadcrumbs = array('Dashboard');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);
        $new_message = new Messages;
        $message = Messages::model()->findByPk($mid);

        if ($message->to_user_id == $userId and $message->read_status == 0) {
            $message->read_status = 1;
            $message->save();
        }

        if ($request->getPost('Messages')) {
            $new_message->attributes = $request->getPost('Messages');
            $new_message->from_user_id = $userId;
            $new_message->to_user_id = $message->from_user_id;
            if ($new_message->validate()) {
                $new_message->save();
                $this->redirect(Yii::app()->createUrl('/user/messaging'));
                die();
            }
        }
        $this->render('mssage', array(
            'new_message' => $new_message,
            //   'dataProvider' => $dataProvider,
            'data' => $message,
            'userModel' => $userModel
        ));
    }

    public function actionAddMessage() {


        $this->breadcrumbs = array('Dashboard');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);
        $touserId = Yii::app()->request->getQuery('uid');
        $tousermodel = User::model()->findByPk($touserId);
        if(!$touserId || !$tousermodel){
            throw new CHttpException(404);
        }

        $new_message = new Messages;
        $request = Yii::app()->request;
        if ($request->getPost('Messages')) {
            $new_message->attributes = $request->getPost('Messages');
            $new_message->from_user_id = $userId;
            $new_message->to_user_id = $touserId;

            if ($new_message->validate()) {
                $new_message->save();
                $this->redirect(Yii::app()->createUrl('/user/messaging'));
                die();
            }
        }
        $this->render('add_message', array(
            'new_message' => $new_message,
            'userModel' => $userModel,
            'tousermodel'=>$tousermodel
        ));
    }

    public function actionMessaging() {
        $this->breadcrumbs = array('Dashboard');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);
        $criteria = new CDbCriteria;
        $request = Yii::app()->request;
        $messFilter = $request->getQuery('mess_filter');
        if ( $messFilter == 'received') {
            $criteria->addColumnCondition(
                    array('to_user_id' => $userId)
            );
        } elseif ($messFilter == 'sent') {
            $criteria->addColumnCondition(
                    array('from_user_id' => $userId)
            );
        } else {
            $messFilter = 'all';
            $criteria->addColumnCondition(
                    array('from_user_id' => $userId, "to_user_id" => $userId), 'OR'
            );
        }
        $allMessages = Messages::model()->findAll($criteria);
        $pagination = new CPagination(Messages::model()->count($criteria));
        $pagination->pageSize = 20;
        $pagination->applyLimit($criteria);
        $dataProvider = new CActiveDataProvider('Messages', array('criteria' => $criteria, 'pagination' => array(
                        'pageSize' => 20,
                    ), 'sort' => array(
                        'attributes' => array(
                            'date' => array(
                                'asc' => 'date ASC',
                                'desc' => 'date DESC',
                                'default' => 'desc',
                            ),
                        ),
                        'defaultOrder' => array(
                            'date' => CSort::SORT_DESC,
                        )
                    ),
                ));
        $this->render('messaging', array(
            'dataProvider' => $dataProvider,
            'allMessages' => $allMessages,
            'mess_filter' => $messFilter,
            'userModel' => $userModel,
            'pagination' => $pagination
        ));
    }

    public function actionProfile() {
        $this->breadcrumbs = array('Profile');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);
        $userModel->scenario = 'createProfile';

        #Change Profile
        $request = Yii::app()->request;
        $profileData = $request->getPost('User');
        $cityArray = $userModel->getUserCityList();
        if ($profileData) {
            $userModel->attributes = $profileData;
            if(!isset($profileData['slideshow'])){
                $userModel->slideshow='';
            }
            if ($userModel->validate()) {
                $userModel->save();
                Yii::app()->user->setFlash('success', Settings::model()->getSettingValue('notification_user_profile_saved_sucsess'));
                $this->refresh();
            }
        }
        #end Change Profile

        $this->render('profile', compact('userModel', 'cityArray','contentModel'));
    }

    public function actionAccountSettings() {
        $this->breadcrumbs = array('Account Settings');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);
#Change Pass
        $request = Yii::app()->request;
        $changePasswordPost = $request->getPost('UserChangePassword');
        $changePasswordModel = new UserChangePassword;
        if ($changePasswordPost) {
            $changePasswordModel->attributes = $changePasswordPost;
            $changePasswordModel->user = $userModel;
            if ($changePasswordModel->validate()) {
                $userModel->passwd = $changePasswordModel->passwd;
                $userModel->generatePassword();
                if ($userModel->save()) {
                    Yii::app()->user->setFlash('success', Settings::model()->getSettingValue('notification_user_accountSettings_saved_sucsess'));
                    $this->refresh();
                }
            }
        }
#Change Contact info
//        $cityArray = array();
        $cityArray = $userModel->getUserCityList();
        $userPostData = $request->getPost('User');
        if ($userPostData) {
            $userModel->attributes = $userPostData;
            if ($userModel->save()) {
                Yii::app()->user->setFlash('success', Settings::model()->getSettingValue('notification_user_accountSettings_info_saved_sucsess'));
                $this->refresh();
            }
        }
        #render View
        $this->render('account_settings', compact('userModel', 'changePasswordModel', 'cityArray'));
    }

    public function actionCalendar() {
        $this->breadcrumbs = array('Calendar');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);

        $this->render('calendar', compact('userModel'));
    }

    public function actionInviteFriends() {
//        Yii::app()->getModule('comments');
//        Yii::app()->getModule('blog');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);

        $this->render('invite_friends', compact('userModel'));
    }

//    public function actionAjaxInviteFriends() {
//
//        if (isset($_POST['facebook_request'])) {
//            $data = $_POST['facebook_request'];
//            extract($data);
//
//            $userModel = User::model()->findByPk($user_id);
//
//            if ($userModel->fb_id === null) {
//                $userModel->fb_id = $user_facebook_id;
//            }
//
//
//            $callbackMessage = '';
//            $activate_premium_account = false;
//
//
//            if (count($requestTo) < 10) {
//
//                if ($userModel->service !== null) {
//                    $old_invites = unserialize($userModel->service);
//                    $allInvites = array_merge($requestTo, $old_invites);
//                    $allInvites = array_unique($allInvites);
//
//                    if (count($allInvites) < 10) {
//                        $sended_invites = count($allInvites);
//                        $need_more = 10 - count($allInvites);
//                        $callbackMessage = "You send only: {$sended_invites} need
//            send {$need_more} more";
//                        $activate_premium_account = false;
//                    } else {
//                        $callbackMessage
//                                = 'Congratulations! You sent 10 invitations. Premium
//            account will be activated shortly.';
//                        $activate_premium_account = true;
//                    }
//
//                    $userModel->service = serialize($allInvites);
//                } else {
//                    $userModel->service = serialize($requestTo);
//
//                    $sended_invites = count($requestTo);
//                    $need_more = 10 - count($requestTo);
//                    $callbackMessage = "You send only: {$sended_invites} invites, need
//            send {$need_more} more";
//                    $activate_premium_account = false;
//                }
//            } else {
//                $callbackMessage
//                        = 'Congratulations! You sent 10 invitations. Premium
//        account will be activated shortly.';
//                $activate_premium_account = true;
//            }
//
//            $userModel->save(false);
//            echo $callbackMessage;
//
//            if ($activate_premium_account) {
//                #todo: АКТИВИРОВАТЬ ПРЕМИУМ АККАУНТ
//            }
//
//            Yii::app()->end();
//        }
//    }

    public function actionDocuments() {

        $this->breadcrumbs = array('Documents');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);


        $this->render('documents', compact('userModel'));
    }

    public function actionAjaxGetCityList() {
        $request = Yii::app()->request;
        if (!$request->isAjaxRequest) {
            exit();
        }
        $state_code = $request->getQuery('state_code');

        $criteria = new CDbCriteria();
        $criteria->group = 't.city';
        $cityModel = Zipareas::model()->findAllByAttributes(array('state' => $state_code), $criteria);
        echo CHtml::tag('option', array('value' => ''), '- City -');
        foreach ($cityModel as $city) {
            echo CHtml::tag('option', array('value' => $city['id']), CHtml::encode($city['city']), true);
        }
        die;
    }

    public function actionUploadAvatar() {

//        $model->setScenario('step_upload_photo');
        $model = User::model()->findByPk(Yii::app()->user->id);

        if (Yii::app()->request->isAjaxRequest) {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder_tmp = Yii::getPathOfAlias('webroot') . '/avatar/'; // folder for uploaded files
            $folder = Yii::getPathOfAlias('webroot') . '/avatar/'; // folder for uploaded files
            if(!file_exists($folder)){
                mkdir($folder,0777,true);
            }
            $allowedExtensions = array("jpg"); //array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder_tmp);


            $fileSize = filesize($folder_tmp . $result['filename']); //GETTING FILE SIZE
            $fileName = $result['filename']; //GETTING FILE NAME
//            if (file_exists($folder . $fileName)) {
//                unlink($folder . $fileName);
//            }
            $model->avatar = $fileName;
            $model->save(false);
            $new_result = $result;
            $new_result['image'] = '<img width="92px" height="92px" src="' . Yii::app()->request->hostInfo . '/avatar/' . $model->avatar . '"/>';
            $return = json_encode($new_result);

            echo $return; // it's array
        }
    }
    public function actionUploadSlideshowProfile() {


        if (Yii::app()->request->isAjaxRequest) {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder_tmp = Yii::getPathOfAlias('webroot') . '/uploads/slideshowprofile/'.Yii::app()->user->id.'/'; // folder for uploaded files
            $folder = Yii::getPathOfAlias('webroot') . '/uploads/slideshowprofile/'; // folder for uploaded files
            if(!file_exists($folder)){
                mkdir($folder,0777,true);
            }
            if(!file_exists($folder_tmp)){
                mkdir($folder_tmp,0777,true);
            }
            $allowedExtensions = array("jpg"); //array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder_tmp);

            $new_result = $result;
            $new_result['image'] = '/uploads/slideshowprofile/'.Yii::app()->user->id.'/'.$result['filename'];
            $return = json_encode($new_result);

            echo $return; // it's array
        }
    }

    public function actionRecentActivity() {
        $request = Yii::app()->request->getQuery('category');
        $userId = Yii::app()->user->id;
        $userModel = User::model()->findByPk($userId);
        $criteria = new CDbCriteria(array(
            'condition' => "content_author=" . Yii::app()->user->getID(),
            'limit' => 20
        ));
        $contents = Contents::model()->findAll($criteria);
        $criteria1 = new CDbCriteria(array(
            'condition' => "author_id=" . Yii::app()->user->getID(),
            'limit' => 20
        ));
        $comments = ContentComments::model()->findAll($criteria1);

        $criteria2 = $criteria1 = new CDbCriteria(array(
            'condition' => "user_id=" . Yii::app()->user->getID(),
            'limit' => 20
        ));
        $favorites_likes = Like::model()->findAll($criteria2);

        if ($request == 'topics')
            $search_arrays = $contents;
        elseif ($request == 'comments')
            $search_arrays = $comments;
        elseif ($request == 'favorites')
            $search_arrays = $favorites_likes;
        else
            $search_arrays = array_merge($contents, $comments, $favorites_likes);

        $sort = new CSort();

        // One attribute for each column of data
        $sort->attributes = array(
            'created_at',
            'id'
        );
        // Set the default order
        $sort->defaultOrder = array(
            'created_at'=>CSort::SORT_DESC,
            'id'=>CSort::SORT_DESC,
        );

        $dataProvider = new CArrayDataProvider($search_arrays, array(
            'sort'=>$sort,
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                ));



        $this->render('recent_activity', array(
            'dataProvider' => $dataProvider,
            'userModel' => $userModel,
        ));
    }
	
	public function actionAjaxProRequest()
	{
		$sql = 'UPDATE  tsn_user SET  pro_status = 2 WHERE id = ' . $_GET['id'];
		Yii::app()->db->createCommand($sql)->query();
		Yii::app()->end();
	}
}
