<script>
    $(function() {
        celebritiesAutoComplite()
    });

    function celebritiesAutoComplite(){
        var projects =[<?php echo Contents::getlistStoreDateJson() ?>];
        jQuery('.repeatable-row').each(function()
        {
            var element =  jQuery(this);
            element.children('.content_celebrity_name').autocomplete({
                minLength: 0,
                source: projects,
                focus: function( event, ui ) {
                    element.children( ".content_celebrity_name" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    element.children( ".content_celebrity_name" ).val( ui.item.label );
                    element.children( ".content_celebrity_id" ).val( ui.item.value );
                    return false;
                }
            })
        })
    }
</script>

<div class="oneThree">
    <div class="widget">
        <div class="header"><span><span class="ico gray window"></span>  Action & additional options   </span>
        </div>
        <div class="content">
            <div class="row" >
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Publish' : 'Update', array('style' => ' margin: 0px; background-color: #9bc652; color: #ffffff;', 'class' => 'uibutton')); ?>

                <?php
                if (!$model->content_type = Contents::TYPE_FACEBOOK)
                    echo CHtml::submitButton($model->isNewRecord ? 'Save as Draft & Preview' : 'Save & Preview', array('style' => ' margin: 5px; background-color: #aa3a35; color: #ffffff;', 'class' => 'uibutton special', 'name' => 'preview_button'));
                ?>

            </div>
            <div class="row" >
                <?php echo $form->labelEx($model, 'content_category_id'); ?>
                <?php echo $form->dropDownList($model, 'content_category_id', CHtml::listData(ContentCategories::model()->findAll(), 'id', 'name', 'parent_name'), array('prompt' => 'Select Category')); ?>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    $('#Contents_content_is_premium').change(function(){
                        if($(this).is(":checked")) {
                            $('#content_is_premium_color_span').show();
                            $('#content_is_premium_hidden').remove();
                        } else {
                            $('#content_is_premium_color_span').after('<input type="hidden" name="Contents[content_is_premium]" value="0" id="content_is_premium_hidden" />');
                            $('#content_is_premium_color_span').hide();
                            $('#content_is_premium_color_span input[type=radio]').each(function(){
                                $(this).attr('checked', false);
                            });
                        }
                    })
                });
            </script>
            <div class="row" >
                <?php
                ?>
                <?php echo $form->labelEx($model, 'content_is_premium'); ?>
                <?php echo CHtml::checkBox('content_is_premium_checkbox', ($model->content_is_premium != '0') ? true : false, array('id' => 'Contents_content_is_premium', 'value' => 0)); ?>

            </div>
            <div class="row">
                
                
                    <span id="content_is_premium_color_span" <?php echo ($model->content_is_premium != '0') ? 'style="display: block;"' : 'style="display: none;"' ?>>
                        <label>Color</label>
                        <div class="row-in">
                            <?php echo CHtml::radioButton('Contents[content_is_premium]', ($model->content_is_premium == '1') ? true : false, array('value' => '1')) ?><label>Dark</label>
                            <?php echo CHtml::radioButton('Contents[content_is_premium]', ($model->content_is_premium == '2') ? true : false, array('value' => '2')) ?><label>Light</label>
                        </div>
                    </span>

            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'content_author'); ?>
                <?php echo $form->dropDownList($model, 'content_author', CHtml::listData(User::model()->findAll(array('order'=>'first_name ASC', 'condition'=>'role_id = 1')), 'id', 'UserFullNameByModel'), array('prompt' => 'Select Author')); ?>
            </div>

            <div class="repeatable-celebrity">
                <div  class="row">

                    <?php
                    $contentCelebritysArr = PostVendorRelation::model()->findAllByAttributes(array('post_id' => $model->id));
                    if (!empty($contentCelebritysArr) and count($contentCelebritysArr) > 0):
                        foreach ($contentCelebritysArr as $key => $celebrity) :
                                $data = Contents::model()->findByPk($celebrity->vendor_id);
                                echo '<div class="repeatable-row">';
                                echo $form->labelEx($model, 'content_vendor_id'); ?>
                                <input type="hidden" name="Contents[content_vendor_id][]" value="<?= $celebrity->vendor_id ?>" class="content_celebrity_id" />
                                <?php
                                echo Chtml::textField(
                                    'Contents[content_celebrity_name][]', $data->content_title, array('class' => 'content_celebrity_name')
                                );
                                echo CHtml::button(
                                    'Remove', array('class' => 'uibutton special left-space',
                                        'onclick' => 'js:$(this).parent().remove();return false;')
                                );
                                echo Chtml::closeTag('div');
                        endforeach;
                    else:
                        ?>
                        <div class="row repeatable-row">
                            <?php echo $form->labelEx($model, 'content_vendor_id'); ?>
                            <input type="hidden" name="Contents[content_vendor_id][]" value="" class="content_celebrity_id" />
                            <?php
                            echo Chtml::textField(
                                'Contents[content_celebrity_name][]', '', array('class' => 'content_celebrity_name')
                            );
                            ?>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <div class="row">
                <?php
                echo CHtml::button(
                    'Add Vendor', array('style' => ' background-color: #9bc652;
                             color: #ffffff;', 'class' => 'uibutton', 'id' => 'addBlock',
                        'onclick' => 'repeatableCelebrity(this)')
                );
                ?>
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
                    'options' => array('dateFormat' => 'mm/dd/yy', 'timeFormat' => 'hh:mm:ss', 'showSecond'=>true), // jquery plugin options
                    'language' => 'en-GB'
                ));
                ?>
            </div>

            <div class="row">
                <?php
                echo CHtml::label('Tags','tags');
                echo CHtml::textArea('tags', (isset($_GET['id']))?ContentTag::getContentTags($_GET['id']):'') ;
                ?>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>
