<?php
/**
 *
 */
class ProfileSidebarWidget extends CWidget
{
    /**
     * @var User - модель профиля пользователя
     */
    public $model;
    public $active;

    public function run()
    {

        $this->render('application.views.ProfileSidebarWidget.profile_sidebar');
    }

//    public function getActive(){
//        return $this->active;
//    }
    }
