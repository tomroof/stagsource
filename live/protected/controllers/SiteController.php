<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }



    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        $this->breadcrumbs = array('Contact us');
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {

                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->IsSMTP();
                $mailer->FromName = Yii::app()->name;
                $mailer->From =Yii::app()->params['adminEmail'];
                $mailer->AddReplyTo(Yii::app()->params['adminEmail']);
                $mailer->Subject =  'Contact Form ' . Yii::app()->name;
                $mailer->Body = Functions::renderEmailNotif('contactForm', $model, '');
                $mailer->AddAddress(Yii::app()->params['adminEmail']);
                if($mailer->Send())
                    Yii::app()->user->setFlash('contact', Settings::model()->getSettingValue('notification_contact_sucsess'));
                else
                    Yii::app()->user->setFlash('contact', 'Not sent, please try later');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionCalendarMovement()
    {

        $Banner1 = Settings::getSettingValue('calendarPageBannerMovement1');
        $Banner2 = Settings::getSettingValue('calendarPageBannerMovement2');
        $URL1 = Settings::getSettingValue('calendarPageBannerMovementURL1');
        $URL2 = Settings::getSettingValue('calendarPageBannerMovementURL2');


        $calendar = Settings::getSettingValue('CalendarMovement');
        $this->render('calendarTemplate',compact('calendar','Banner1','Banner2','URL1','URL2'));
    }

    public function actionCalendarMillennium()
    {
        $Banner1 = Settings::getSettingValue('calendarPageBannerMillennium1');
        $Banner2 = Settings::getSettingValue('calendarPageBannerMillennium2');
        $URL1 = Settings::getSettingValue('calendarPageBannerMillenniumURL1');
        $URL2 = Settings::getSettingValue('calendarPageBannerMillenniumURL2');
        $calendar=Settings::getSettingValue('CalendarMillennium');
        $this->render('calendarTemplate',compact('calendar','Banner1','Banner2','URL1','URL2'));
    }

    public function actionCalendarDebbie()
    {
        $Banner1 = Settings::getSettingValue('calendarPageBannerDebbie1');
        $Banner2 = Settings::getSettingValue('calendarPageBannerDebbie2');
        $URL1 = Settings::getSettingValue('calendarPageBannerDebbieURL1');
        $URL2 = Settings::getSettingValue('calendarPageBannerDebbieURL2');
        $calendar=Settings::getSettingValue('CalendarDebbie');
        $this->render('calendarTemplate',compact('calendar','Banner1','Banner2','URL1','URL2'));
    }

    public function actionCalendarEdge()
    {
        $Banner1 = Settings::getSettingValue('calendarPageBannerEdge1');
        $Banner2 = Settings::getSettingValue('calendarPageBannerEdge2');
        $URL1 = Settings::getSettingValue('calendarPageBannerEdgeURL1');
        $URL2 = Settings::getSettingValue('calendarPageBannerEdgeURL2');
        $calendar=Settings::getSettingValue('CalendarEdge');
        $this->render('calendarTemplate',compact('calendar','Banner1','Banner2','URL1','URL2'));
    }
    public function actionCalendarViewAll(){
        $Banner1 = Settings::getSettingValue('calendarPageBanner1');
        $Banner2 = Settings::getSettingValue('calendarPageBanner2');
        $URL1 = Settings::getSettingValue('calendarPageBanner1URL');
        $URL2 = Settings::getSettingValue('calendarPageBanner2URL');
        $calendar=Settings::getSettingValue('CalendarViewAll');
        $this->render('calendarTemplate',compact('calendar','Banner1','Banner2','URL1','URL2'));
    }

}