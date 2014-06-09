<div class="wrap">
    <div class="main-content">
        <h2><span>My Dashboard</span></h2>
        <div class="content-in">

            <?php
            $this->widget('application.components.ProfileSidebarWidget', array('active' => 'dashboard', 'model' => $userModel));
            ?>
            <div class="center">
                <?php $this->renderPartial('block_tabs'); ?>
                <div class="center-in">
                    <div class="block-pagination">


                    </div>

                    <div class="form-send-message">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user-messaging-form',
                            'enableAjaxValidation' => false,
                                ));
                        ?>
                        <?php echo $form->errorSummary($new_message); ?>
                        <div class="control-group">
                            <div class="inp-5">
                                <label>User to:</label>
                                        <p style="line-height: 34px;" ><?php echo $tousermodel::getUserFullName($tousermodel)?></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="inp-5">
                                <label>Subject:</label>
                                <?php echo $form->textField($new_message, 'title'); ?>       
                            </div>
                        </div>
                        <button class="btn-big send" onclick="jQuery('#user-messaging-form').submit()" type="submit"><span>Send</span></button>  

                        <!--                        <div class="control-group">
                                                    <div class="inp-5">
                                                         <label>To user:</label>
                        <?php // echo  $form->dropDownList($new_message, 'to_user_id', CHtml::listData(User::model()->findAll(array('order' => 'email')), 'id', 'email')); ?>      
                                                    </div>
                                                </div>-->





                        <div class="control-group text-2">                            
                            <p class="label">
                                <label for="hide13">Write your message here.</label>

                                <?php echo $form->textArea($new_message, 'content', array('rows' => 6, 'cols' => 50, 'id' => 'hide13')); ?>
                            </p>
                        </div>




                        <?php $this->endWidget(); ?>


                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
