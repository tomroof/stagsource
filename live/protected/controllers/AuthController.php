<?php

class AuthController extends Controller {

    const USER_CONFIRM = 1;
    const USER_NOT_CONFIRM = 2;
    const ROLE_USER = 2;
    const ROLE_ADMIN = 1;

    public $title = null;

    public function actionLogin() {
        $model = new LoginForm;
        //if is FB user
        $fb_data = User::getFBUser();

        if ($fb_data) {
            $modelUser = new User;
            if (!$modelUser->findByAttributes(array('email' => $fb_data["email"]))) { // its new email
                $modelUser->first_name = $fb_data["first_name"];
                $modelUser->last_name = $fb_data["last_name"];
                $modelUser->email = $fb_data["email"];
                $modelUser->fb_id = $fb_data["id"];
                $modelUser->status = self::USER_CONFIRM;
                $modelUser->confirm_email = $fb_data["email"];
                $modelUser->passwd = $fb_data["email"];
                if ($modelUser->save('false')) {
                    $identity = new UserIdentity(null, null, $modelUser->id);
                    Yii::app()->user->login($identity);
                    echo CHtml::script('window.location.reload()');
                }
            } else { // its old email
                $user = $modelUser->findByAttributes(array('email' => $fb_data["email"]));
                $id = $user->id;
                $identity = new UserIdentity(null, null, $id);
                Yii::app()->user->login($identity);
                echo CHtml::script('window.location.href="'.Yii::app()->request->hostInfo.'"');
            }
        }



        // if it is ajax validacion request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                echo $login = 'true';
                Yii::app()->end();
            } else {
                $this->renderPartial('login', array('model' => $model));
                Yii::app()->end();
            }
        }
//
//        // display the login form
//        $this->redirect(Yii::app()->user->returnUrl . '/');
        /*        $this->renderPartial('login', array('model' => $model));
          Yii::app()->end(); */
    }

    public function actionLoginPopup() {


        $model = new LoginForm;
        $fb_data = User::getFBUser();
        if ($fb_data) { //FB login mode -> ON && isset FB data
            $modelUser = new User;
            if (!$modelUser->findByAttributes(array('email' => $fb_data["email"]))) { // its new email
                $modelUser->first_name = $fb_data["first_name"];
                $modelUser->last_name = $fb_data["last_name"];
                $modelUser->email = $fb_data["email"];
                $modelUser->fb_id = $fb_data["id"];
                $modelUser->status = self::USER_CONFIRM;
                $modelUser->confirm_email = $fb_data["email"];
                $modelUser->passwd = $fb_data["email"];
                if ($modelUser->save('false')) {
                    $identity = new UserIdentity(null, null, $modelUser->id);
                    Yii::app()->user->login($identity);
                    echo CHtml::script('window.parent.location.reload()');
                }
            } else { // its old email
                $user = $modelUser->findByAttributes(array('email' => $fb_data["email"]));
                $id = $user->id;
                $identity = new UserIdentity(null, null, $id);
                Yii::app()->user->login($identity);
                echo CHtml::script('window.parent.location.href="'.Yii::app()->request->hostInfo.'"');
            }
        }
        // if it is ajax validacion request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate()
                    && $model->login()
            ) { //                $this->redirect(Yii::app()->user->returnUrl . '/');
                echo '<script type="text/javascript">if (location.href == "#login_popup") { parent.location.reload()} else {parent.location.href = "/"};</script>';
            }
        }
        // display the login form
        $this->layout = 'popup';
        $this->render('_login_popup', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    private function mail1($mail, $message, $subject) {
        Yii::app()->mailer->Host = 'localhost';
        Yii::app()->mailer->IsSMTP();
        Yii::app()->mailer->From =Yii::app()->params['adminEmail'];


        Yii::app()->mailer->AddAddress($mail);
        Yii::app()->mailer->Subject = $subject;
        Yii::app()->mailer->Body = $message;
        Yii::app()->mailer->Send();
    }

    public function actionRegistration() {

        if (Yii::app()->user->hasFlash('message')) {
            PopupFancy::showMessage(
                    '<div class="block-popup">
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
            </div>'
            );
        }

        //        $model_countries = Countries::model();
        //        $model_states = States::model();
        //        $countries = $model_countries;
        //        $states = $model_states->findAllByAttributes(array('country_id' => 223));
        //        $model->scenario = 'registerwcaptcha';
        //
        $model = new User;
        $model->scenario = 'registration';
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->status = self::USER_CONFIRM;
            $model->passwd = (!empty($_POST['User']['passwd'])) ? md5($_POST['User']['passwd']) : '';
            $model->passwd2 = (!empty($_POST['User']['passwd2'])) ? md5($_POST['User']['passwd2']) : '';
            $model->role_id = self::ROLE_USER;

            if ($model->save()) {
                $identity = new UserIdentity(null, null, $model->id);
                Yii::app()->user->login($identity);

                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->IsSMTP();
                $mailer->From =Yii::app()->params['adminEmail'];
                $mailer->AddReplyTo(Yii::app()->params['adminEmail']);
                $mailer->Subject = 'Welcome.';
                $mailer->Body = Functions::renderEmailNotif('registration', $model, '');
                $mailer->AddAddress($model->email);
                echo CHtml::script('window.parent.location.href="'.Yii::app()->request->hostInfo.'"');

                if ($mailer->Send())
                echo CHtml::script('window.parent.location.href="'.Yii::app()->createUrl('/user/profile').'"');
            }
            $model->passwd = '';
            $model->passwd2 = '';
        }
        /*
         *  check option FB login status and fb user id
         */
        $fb_data = User::getFBUser();
        if ($fb_data) { //FB login mode -> ON && isset FB data
            if (!$model->findByAttributes(array('email' => $fb_data["email"]))) { // its new email
                $model->first_name = $fb_data["first_name"];
                $model->last_name = $fb_data["last_name"];
                $model->email = $fb_data["email"];
                $model->fb_id = $fb_data["id"];
                $model->status = self::USER_CONFIRM;
                $model->confirm_email = $fb_data["email"];
                $model->passwd = $fb_data["email"];
                if ($model->save('false')) {
                    $identity = new UserIdentity(null, null, $model->id);
                    Yii::app()->user->login($identity);
                    echo CHtml::script('window.parent.location.reload()');
                }
            } else { // its old email
                $user = $model->findByAttributes(array('email' => $fb_data["email"]));
                $id = $user->id;
                $identity = new UserIdentity(null, null, $id);
                Yii::app()->user->login($identity);
                echo CHtml::script('window.parent.location.reload()');
            }
        }
        $this->layout = 'popup';
        $this->render(
                'registration', array('model' => $model,
                )
        );
    }

    public function actionActivation() {
        $model = new User;
        $email = ((isset($_GET['email'])) ? $_GET['email'] : '');
        $activkey = ((isset($_GET['activkey'])) ? $_GET['activkey'] : '');

        if ($email && $activkey) {

            $user = User::model()->findByAttributes(array('email' => $email));
            if (isset($user) && $user->activkey == $activkey) {
                $user->activkey = md5(rand() . microtime());
                $user->status = self::USER_CONFIRM;
                $user->save();


                $subject = 'You confirmed the registration';
                $message = 'You confirmed the registration please login = ' . 'http://' . $_SERVER['HTTP_HOST'];
                $Extra = "From: info@" . $_SERVER['HTTP_HOST'];
                mail($email, $subject, $message, $Extra);
                $this->redirect(Yii::app()->createUrl('/auth/login'));
            }
        } else {
            die('asd');
        }
    }

    public function actionRecoveryPass() {

        $model = new User;
        $email = ((isset($_GET['email'])) ? $_GET['email'] : '');
        $activkey = ((isset($_GET['activkey'])) ? $_GET['activkey'] : '');

        if (isset($_POST['User']['email']) && !$activkey) {
            $email = $_POST['User']['email'];
            $user = User::model()->findByAttributes(array('email' => $email));
            if (isset($user)) {
                $newpass = rand(1000000, 20000000);
                $user->activkey = md5(rand() . microtime());
                $user->save();

                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->IsSMTP();
                $mailer->FromName = Yii::app()->name;
                $mailer->From =Yii::app()->params['adminEmail'];
                $mailer->AddReplyTo(Yii::app()->params['adminEmail']);
                $mailer->Subject = 'Request new password';
                $mailer->Body = Functions::renderEmailNotif('requestNewPassword', $user, $newpass);
                $mailer->AddAddress($email);

                if ($mailer->Send()) {
                    Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_auth_recoverypass_sucsess'));
                } else {
                    Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_auth_recoverypass_failure'));
                }
            } else {
                Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_auth_recoverypass_email_not_found'));
            }
            echo CHtml::script('window.parent.location.href="'. Yii::app()->request->hostInfo .'"');
               Yii::app()->end();
        } else {
            //Проверяем ключ и сбрасываем пароль
            if ($email && $activkey) {

                $user = User::model()->findByAttributes(array('email' => $email));
                if (isset($user) && $user->activkey == $activkey) {
                    $newpass = rand(1000000, 20000000);
                    $user->passwd = md5($newpass);
                    $user->activkey = md5(rand() . microtime());
                    $user->save();

                    $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                    $mailer->IsSMTP();
                    $mailer->FromName = Yii::app()->name;
                    $mailer->From =Yii::app()->params['adminEmail'];
                    $mailer->AddReplyTo(Yii::app()->params['adminEmail']);
                    $mailer->Subject =  'New password';
                    $mailer->Body = Functions::renderEmailNotif('changePassword', $user, $newpass);
                    $mailer->AddAddress($email);


                    if ($mailer->Send())
                        Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_auth_recoverypass_sucsess'));
                    else
                        Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_auth_recoverypass_failure'));
                    $this->redirect(Yii::app()->request->hostInfo);
                }
            }
        }
        $this->layout = 'popup';
        $this->render('recoverypass', array('model' => $model));
    }

    public function actionPassStrong() {

        $password = $_POST['password'];

        //Проверяем, есть ли пробелы в пароле
        if (preg_match("/([\s])/", $password)) {
            $html = "<div class='box-strength'>Invalid characters in a password</div>";
            $html .= '<div class="box-strength-line"><div style="background:#ff0000; width:100%; height:8px;"></div></div>';
        } else {
            if (strlen($password) < 6) {
                $html = "<div class='box-strength'>The password must be at least 6 characters</div>";
                $html .= '<div class="box-strength-line"><div style="background:#ff0000; width:100%; height:8px;"></div></div>';
            } else {
                $strong = 0;
                //Проверяем, есть ли в пароле числа
                if (preg_match("/([0-9]+)/", $password)) {
                    $strong++;
                }
                //Проверяем, есть ли в пароле буквы в нижнем регистре
                if (preg_match("/([a-z]+)/", $password)) {
                    $strong++;
                }
                //Проверяем, есть ли в пароле буквы в верхнем регистре
                if (preg_match("/([A-Z]+)/", $password)) {
                    $strong++;
                }
                //Проверяем, есть ли в пароле спецсимволы
                if (preg_match("/\W/", $password)) {
                    $strong++;
                }
                //В зависимости от сложности пароля выводим полоски
                if ($strong == 1) {
                    $html = "<div class='box-strength'>Strength: <span style='color:#ff0000;'>Weak</span></div>";
                    $html .= '<div class="box-strength-line"><div style="background:#ff0000; width:25%; height:8px;"></div></div>';
                }
                if ($strong == 2) {
                    $html = "<div class='box-strength'>Strength: <span style='color:#edc431;'>Fair</span></div>";
                    $html .= '<div class="box-strength-line"><div style="background:#edc431; width:50%; height:8px;"></div></div>';
                }
                if ($strong == 3) {
                    $html = "<div class='box-strength'>Strength: <span style='color:#edc431;'>Good</span></div>";
                    $html .= '<div class="box-strength-line"><div style="background:#edc431; width:75%; height:8px;"></div></div>';
                }
                if ($strong == 4) {
                    $html = "<div class='box-strength'>Strength: <span style='color:#2dda2f;'>Strong</span></div>";
                    $html .= '<div class="box-strength-line"><div style="background:#2dda2f; width:100%; height:8px;"></div></div>';
                }
            }
        }
        echo $html;
    }

    public function actionSocial() {

        $request = Yii::app()->request;
        $service = $request->getQuery('service');

        if ($service) {

            $authIdentity = Yii::app()->eauth->getIdentity($service);

            $authIdentity->cancelUrl = $this->createAbsoluteUrl('/user/auth/login');

            if ($authIdentity->authenticate()) {

                $identity = new ServiceUserIdentity($authIdentity);

                // Успешный вход
                if ($identity->authenticate()) {
                    $result = Yii::app()->user->login($identity);
                    $profile = UserProfile::model()->findByPk(Yii::app()->user->id);
                    $authIdentity->redirectUrl = $profile->getRedirectUrl(Yii::app()->user->returnUrl);
                    $user = User::model()->findByPk(Yii::app()->user->id);
                    if (!$user->validate() || !$profile->validate()) {
                        return $this->redirect('/user/profile/step-1');
                    }
                    if (!empty($user->email) && ($profile->state != 0) && ($profile->city != 0) && !empty($profile->zip)
                            && !empty($profile->birthday)
                            && !empty($profile->gender)
                            && ($profile->gender != 0)
                    ) {
                        $authIdentity->redirect('/user/profile/workspace');
                    }

                    // Специальный редирект с закрытием popup окна
                    $authIdentity->redirect();
                } else {
                    // Закрываем popup окно и перенаправляем на cancelUrl
                    $authIdentity->cancel();
                }
            }
            //
            // Что-то пошло не так, перенаправляем на страницу входа
            $this->redirect(array('/user/auth/login'));
        }
    }

}
