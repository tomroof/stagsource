<?php

class SettingsController extends Controller {

    public function accessRules()
	{
		 return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'expression' => '!Yii::app()->user->isAdmin()',
            ),
        );
	}
    
    public function actionIndex() {
        if (isset($_POST['slider_home1']) && !empty($_POST['slider_home1'])) {
            $mass_slider = serialize($_POST['slider_home1']);
            $_POST['Settings']['slider_home1'] = $mass_slider;
        }

        $request = Yii::app()->request;
        $configPostData = $request->getPost('Settings');
        $criteria = new CDbCriteria();
        $criteria->index = 'key';

        if ($configPostData) {
            foreach ($configPostData as $key => $value) {
                $model = Settings::model()->findByPk($key);
                $model->value = $value;
                $model->save();
            }
            Yii::app()->user->setFlash('message', Settings::model()->getSettingValue('notification_admin_settings_save'));
            $this->redirect(array('/admin/settings/index'));
        }

        $this->render('index');
    }

}