<?php

class NewslatterWidget extends CWidget
{

    public $location;
    public $name='email';

    public function run()
    {
        $this->renderContent();
    }

    public function renderContent()
    {

        $model = new Newsletter;
        if (isset($_POST['Newsletter'][$this->name])&& !empty($_POST['Newsletter'][$this->name])) {
            if (null == Newsletter::model()->findByAttributes(array('email' => $_POST['Newsletter'][$this->name]))
            ) {
                $model->email  = $_POST['Newsletter'][$this->name];
                $model->active = 1;
                if ($model->save()) {
                    Yii::app()->user->setFlash(
                        'notification',
                        Settings::model()->getSettingValue('notification_newslatter_subscription_sucsess')
                    );
                } else {
                    if ($model->hasErrors()) {
                        Yii::app()->user->setFlash('notification', $model->getError('email'));
                    }
                    ?>
                    <!--<script type="text/javascript">
                        jQuery(document).ready(function($){
                            var destination = $("#newslatter").offset().top;
                            if($.browser.safari){
                                $("body").animate( { scrollTop: destination }, 1100 );
                            }else{
                                $("html").animate( { scrollTop: destination }, 1100 );
                            }
                        });
                    </script>-->
                <?php
                }
            } else {
                Yii::app()->user->setFlash(
                    'notification',
                    Settings::model()->getSettingValue('notification_newslatter_already_subscribed')
                );
            }
        }
        if (Yii::app()->user->hasFlash('notification')) {

            PopupFancy::showMessage(
                '<div class="block-popup">
                                 <div class="block-popup-in">
                                    <div class="title-popup-in">
                                        <h2>Subscription confirmation</h2>
                                     </div>
                                     <div class="block-popup-in-2">
                                        <div class="block-newslatter">
                                            <h3>' . Yii::app()->user->getFlash('notification') . '</h3>
                            <p>If you need further assistance please contact us <a href="' . Yii::app()->createUrl(
                    "/site/contact"
                ) . '">here</a>.</p>
                        </div>
                     </div>
                 </div>
            </div>'
            );
        }
        if (!empty($this->location)) {
            $this->render('_view_newsletter_' . $this->location, array('model' => $model));
        } else {
            $this->render('_view_newsletter', array('model' => $model));
        }
    }

}

?>
