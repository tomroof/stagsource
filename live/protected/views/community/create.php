<div id="block-create-topic" class="block-popup block-popup-signin">
    <div class="block-popup-in">
        <div class="title-popup-in">
            <h2>Create a topic</h2>
        </div>
        <div class="block-popup-in-2">
<!--            --><?php //echo $this->renderPartial('_form', array('model' => $model, 'array_category' => $array_category)); ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'community-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array(
                    'autocomplete' => 'off'
                ),
            ));
            ?>
            <div class="block-popup-in-3">
            <?php echo $form->errorSummary($model); ?>
                <div class="line">
                    <label><b>*</b>Title:</label>

                    <p class="label inp-3">
                        <label for="Contents_content_title">Title</label>
                        <?php echo $form->textField($model, 'content_title', array('size' => 20, 'maxlength' => 255)); ?>
                    </p>
                </div>
                <div class="line">
                    <label><b>*</b>Message:</label>

                    <p class="label text-4">
                        <label for="Contents_content_content">Message</label>
                        <?php
                        echo $form->textArea($model, 'content_content', array('size' => 20));
                        ?>
                    </p>
                </div>
                <div class="line topic-category">
                    <label><b>*</b>Category:</label>
                    <?php echo $form->radioButtonList($model, 'content_category_id',
                        $array_category,
                        array('separator' => '',
                            'template' => '
                    <div class="f-left">
                        <p>
                            {input}
                            {label}
                        </p>
                    </div>'
                        ));?>
                </div>
            </div>
            <div class="guidelines">
                <div class="guidelines-label">Posting Guidelines</div>
                <p class="guidelines-links">Participation in the <?php echo Yii::app()->name; ?> community is subject<br /> to the <a href="<?php echo Yii::app()->createUrl('/page/terms-and-conditions') ;?>" target="_blank">Terms and
                        Conditions</a> and our <a href="<?php echo Yii::app()->createUrl('/page/privacy-policy') ;?>" target="_blank">Privacy Policy.</a></p>
            </div>
        </div>
        <div class="block-popup-bot">
            <input class="but-big but-red" type="submit" value="Submit"/>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

