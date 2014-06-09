<div class="oneThree">
    <div class="widget">
        <div class="header"><span><span class="ico gray window"></span>  Action & additional options   </span>
        </div>
        <div class="content">
            <div class="row">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('style' => ' margin: 0px; background-color: #9bc652; color: #ffffff;', 'class' => 'uibutton')); ?>
            </div>


            <div class="row">
                <?php echo $form->labelEx($model, 'author_id'); ?>
                <?php echo $form->dropDownList($model, 'author_id', CHtml::listData(User::model()->findAll(), 'id', 'UserFullNameByModel')); ?>

            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'content_id'); ?>
                <?php echo $form->dropDownList($model, 'content_id', CHtml::listData(Contents::model()->findAll(), 'id', 'content_title')); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->dropDownList($model, 'status', ContentComments::get_comment_status_list()); ?>

            </div>


            <div class="row">
                <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                echo $form->labelEx($model, 'created_at');
                $this->widget('CJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'attribute' => 'created_at', //attribute name
                    'value' => $model->created_at,
                    'mode' => 'datetime', //use "time","date" or "datetime" (default)
                    'options' => array('dateFormat' => 'mm/dd/yy', 'timeFormat' => 'hh:mm:ss', 'showSecond' => true), // jquery plugin options
                    'language' => 'en-GB'
                ));
                ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
