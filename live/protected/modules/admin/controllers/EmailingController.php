<?php

class EmailingController extends Controller {

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('emailing', 'groups', 'editMessageNotification', 'previewEmailTemplate'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'expression' => '!Yii::app()->user->isAdmin()',
            ),
        );
    }

    public function actionEmailing() {

        if (Yii::app()->user->hasFlash('message')) {
            PopupFancy::showMessage('<div class="block-popup"  >
                 <div class="block-registration">
                    <div class="block-popup-in">
                        <p><b></b></p>
                        <p>' . Yii::app()->user->getFlash('message') . '</p>
                     </div>
                     <div class="but">
                        <a href="javascript:;" class="popup_button" onclick="$.fancybox.close()">OK</a>
                        <div class="but-in">&nbsp;</div>
                     </div>
                 </div>
            </div>');
        }

        //-----------------------------emailing-----------------------------------


        Yii::app()->getModule('messages');
//	$user_roles = Lookup::model();
        $user = User::model();

//----------------------------------------------------------------


        if (isset($_POST['Mail'])) {
            if (!empty($_POST['Mail']['emailing_subj']) && !empty($_POST['Mail']['emailing_body'])) {
                $subject = $_POST['Mail']['emailing_subj'];
                $body = $_POST['Mail']['emailing_body'];
            } else {
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_email_error_subject'));
                $this->redirect(Yii::app()->createUrl('/admin/emailing/emailing'));
            }
            if (isset($_POST['to_users']) && !empty($_POST['Mail']['selected_users'])) {
                $uid = array_values($_POST['Mail']['selected_users']);
                $uid = implode(',', $uid);
                $criteria = new CDbCriteria();
                $criteria->select = 'email, id';
                $criteria->condition = 'id IN (' . $uid . ')';
                $all_selected_users = $user->findAll($criteria);
                $all_selected_users = CHtml::listData($all_selected_users, 'id', 'email');
                $this->SaveMassMailer($all_selected_users, $subject, $body);
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_email_sucsess'));
                $this->redirect(Yii::app()->createUrl('/admin/emailing/emailing'));
            } elseif (isset($_POST['to_groups']) && !empty($_POST['Mail']['selected_groups'])) {
                $temp = $_POST['Mail']['selected_groups'];
                if (in_array('is confirmed', $temp)) {
                    unset($temp[array_search('is confirmed', $temp)]);
                    $criteria = new CDbCriteria();
                    $criteria->select = 'email, id ,confirmation_key';
                    $criteria->condition = 'is_confirmed = 0 ';
                    $all_selected_users_is_confirmed = $user->findAll($criteria);
                    $all_selected_users_is_confirmed = CHtml::listData($all_selected_users_is_confirmed, 'confirmation_key', 'email');
                    $this->SaveMassMailer($all_selected_users_is_confirmed, $subject, $body, true);
                }
//                if (!empty($temp)) {
//                    $gid = array_values($temp);
//                    $gid = implode(',', $gid);
//                    $criteria = new CDbCriteria();
//                    $criteria->select = 'email, id';
//                    $criteria->condition = 'type IN (' . $gid . ')';
//                    $criteria->condition = 'is_confirmed = 1 ';
//
//                    $all_selected_users = $user->findAll($criteria);
//                    $all_selected_users = CHtml::listData($all_selected_users, 'id', 'email');
//                    $this->SaveMassMailer($all_selected_users, $subject, $body);
//                }
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_email_sucsess'));
                $this->redirect(Yii::app()->createUrl('/admin/emailing/emailing'));
            } else {
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_email_error_user'));
                $this->redirect(Yii::app()->createUrl('/admin/emailing/emailing'));
            }

//	    if(!empty($all_selected_users)){
//                $this->SaveMassMailer();
//		foreach ($all_selected_users as $email) {
//		    if(!empty($email)){
//			$MassMailer = new MassMailer();
//			$MassMailer->user_email = $email;
//			$MassMailer->subject = $subject;
//			$MassMailer->body = $body;
//			$MassMailer->save();
//		    }
//		}
////		    die('dead');
//		$subject;
//		$body;
//		Yii::app()->user->setFlash('message', 'Success');
//		$this->redirect(Yii::app()->createUrl('/admin/emailing/emailing'));
//	    }
        }

//--------------------------groups--------------------------------------
        Yii::app()->getModule('messages');

        $criteria = new CDbCriteria;
        $criteria->select = ' value, code ';  // выбираем только поле 'title'
        $criteria->condition = 'type=:UserRole';
        $criteria->params = array(':UserRole' => 'UserRole');

        $user_roles_groups = Options::model()->findAll($criteria);
        $user_roles_groups = CHtml::listData($user_roles_groups, "code", "value");

//
//        $criteria = new CDbCriteria;
//        $criteria->select = '*';  // выбираем только поле 'title'
//        $criteria->condition = 'is_confirmed=:is_confirmed';
//        $criteria->params = array(':is_confirmed' => '0');
//        
////$criteria->limit = "5";
////$criteria->offset = '0';
        $is_confirmed = FALSE;
//        $is_confirmed = User::model()->find($criteria);


        if (!empty($is_confirmed)) {
            $user_roles_groups['is confirmed'] = 'Not confirmed';

            $is_confirmed = true;
        }
//----------------------------------------------------------------


        $this->render('emailing', compact('user', 'user_roles', 'user_roles_groups', 'is_confirmed'));
    }

    public function SaveMassMailer($all_selected_users, $subject, $body, $confirmation = false) {
        $model_registration_producer = new User('registration_producer');
        foreach ($all_selected_users as $key => $email) {
            if (!empty($email)) {
                $MassMailer = new MassMailer();
                $MassMailer->user_email = $email;
                $MassMailer->subject = $subject;
                if ($confirmation == true) {
                    $url = $this->createAbsoluteUrl('/users/auth/email_confirmation', array('key' => $key));
                    $MassMailer->body = $body . "<p style=\"margin-bottom:1em; margin-top:1em;\">You still haven't confirmed your email! Please click the following link to confirm your email address and get started browsing our network of outstanding film professionals.</p>
                    <p style=\"margin-bottom:1em; margin-top:1em;\"><a href=\"$url\">$url</a></p>";
                } else {
                    $MassMailer->body = $body;
                }


                $MassMailer->save();
            }
        }

        $subject;
        $body;
    }

    public function actionGroups() {

        Yii::app()->getModule('messages');

        $criteria = new CDbCriteria;
        $criteria->select = ' name, code ';  // выбираем только поле 'title'
        $criteria->condition = 'type=:UserRole';
        $criteria->params = array(':UserRole' => 'UserRole');

        $user_roles = Lookup::model()->findAll($criteria);
        $user_roles = CHtml::listData($user_roles, "code", "name");

//        echo '<pre>';
//        var_dump($user_roles);
//        echo '</pre>';
//        die;
        $criteria = new CDbCriteria;
        $criteria->select = '*';  // выбираем только поле 'title'
        $criteria->condition = 'is_confirmed=:is_confirmed';
        $criteria->params = array(':is_confirmed' => '0');

//$criteria->limit = "5";
//$criteria->offset = '0';
        $is_confirmed = FALSE;
        $is_confirmed = User::model()->find($criteria);


        if (!empty($is_confirmed)) {
            $user_roles[] = 'is confirmed';
//            echo '<pre>';
//            var_dump($user_roles);
//            echo '</pre>';
//            die;
//            echo"<pre>";
            $is_confirmed = true;
//            echo"</pre>";
        }



        $this->renderPartial('_to_group', compact('user_roles', 'is_confirmed'));
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */



    public function actionEditMessageNotification() {

        $exclude_list = array(".", "..", ".svn");

        $directories = array_diff(scandir(Yii::getPathOfAlias('webroot') . '/protected/views/email_template/', 1), $exclude_list);


        $files_in_dir = $directories; //array_splice($directories, 0, -1);
//         $files_in_dir = array_splice((scandir(Yii::getPathOfAlias('webroot') . '/protected/views/email_template/', 1)), 0, -2);
        if (isset($_GET['fname'])) {
            $fname = $_GET['fname'];
            $path_file = Yii::getPathOfAlias('webroot') . '/protected/views/email_template/' . $_GET['fname'];
        } else {
            $fname = $files_in_dir[0];
            $path_file = Yii::getPathOfAlias('webroot') . '/protected/views/email_template/' . $fname;
        }
        if (isset($_POST['file_content'])) {
            $handle = fopen($path_file, 'w');
            fwrite($handle, $_POST['file_content']);
            fclose($handle);
        }


        $tmp = file_get_contents($path_file);

        $this->render('view_file', array(
            'tmp' => $tmp,
            'files_in_dir' => $files_in_dir,
            'fname' => $fname
        ));
    }

    public function actionPreviewEmailTemplate() {
        $model_u = new User;
        $model_u->id = 1623761;
        $model_u->email = 'example@example.com';
        $model_u->activkey = 'http://example.com/auth/recoverypass?activkey=7fe2131f53136861602043d3b91918ea&email=example@example.com';
        $model_u->first_name = 'John';
        $model_u->last_name = 'Abramovich';
        $model_u->passwd = 'cg8635';


        $f_name = substr($_GET['fname'], 0, strlen($_GET['fname']) - 4);
        echo Functions::renderEmailNotif($f_name, $model_u, $model_u->passwd);
    }

}