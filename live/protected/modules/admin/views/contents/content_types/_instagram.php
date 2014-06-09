<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contents-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="widgets">
        <div class="twoOne">
            <div class="widget">
                <div class="header"><span><span class="ico gray window"></span>  Main Information   </span></div>
                <div class="content">
                    <div class="row">

                        <?php echo $form->errorSummary($model); ?>

                        <div class="row">
                                    <?php echo CHtml::label('Instagram URL <span class="required">*</span>', 'content_source'); ?>
                                    <?php echo $form->textField($model, 'content_source'); ?>
                        </div>

                        <?php
                        if (!empty($model->content_title)) {
                            ?>
                            <h2>Preview get content</h2>
                            <?php
                            echo $form->labelEx($model, 'content_title');
                            echo $form->textField($model, 'content_title', array('disabled' => "disabled"));
                        }
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        if (!empty($model->content_content)) {
                            echo CHtml::label('Image', 'img');
                            echo CHtml::image($model->content_content, '', array('height' => 250, 'width' => 250));
                        }
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <?php
        $this->renderpartial('_right_content_block', array('model' => $model, 'form' => $form));
        ?>
        <div class="clear"></div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
