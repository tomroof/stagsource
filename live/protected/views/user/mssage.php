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
                                <label>Subject:</label>
                                <?php echo $form->textField($data, 'title'); ?>


                            </div>

                        </div>
                        <button class="btn-big send" type="submit" onclick="jQuery('#user-messaging-form').submit()"><span>Send</span></button> 
                        <div class="control-group text-2">   
                            <div class="control-group">
                                <p class="label">
                                    <label for="hide13">Write your message here.</label>
                                    <?php echo $form->textArea($new_message, 'content', array('rows' => 6, 'cols' => 50, 'id' => 'hide13')); ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                    <div id="messages_list_div" class="list-view">
                        <table class="tab-color" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <th><div>Sent</div></th>
                            <th><div>Message</div></th>
                            <th><div>Date/Time</div></th>
                            </tr>
                            <tr class="<?php echo ($data->read_status == 0) ? '' : 'read'; ?>">
                                <?php $user_from = User::model()->findByPk($data->from_user_id); ?>
                                <td>
                                    <div class="img-mes"> <?php echo CHtml::link($user_from->getUserAvatar(), Yii::app()->createUrl('user/publicProfile/' . $user_from->id))
                                ?></div>
                                    <b><?php echo CHtml::link($user_from->first_name . ' ' . $user_from->last_name, Yii::app()->createUrl('user/publicProfile/' . $user_from->id)) ?></b>

                                </td>
                                <td>
                                    <b><?= $data->title ?></b>
                                    <p><?= $data->content ?></p>
                                </td>
                                <td>
                                    <b><?= date('F d, Y', strtotime($data->date)) ?></b>
                                    <p><?= date('g:i A', strtotime($data->date)) ?></p>
                                </td>
                            </tr>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
