<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>
<div class="widget" style="margin-top: 70px;">
    <div class="header">
    </div><!-- End header -->	
    <div class="content">


        <!--<form id="validation_demo" action="">--> 
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'post-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => "multipart/form-data")
                ));
        ?>
        <!-- Third / Half column-->
        <div class="widgets">
            <div class="oneThree">
                <div class="profileSetting block_callback" style="text-align: center;">
                    <div class="avartar block_callback_img">
                        <?php if ($model->thumbnail != null) { ?>
                            <img src="<?php echo Yii::app()->createAbsoluteUrl($model->thumbnail) ?>" width="180" height="180" alt="avatar">
                        <?php } ?>
                    </div>
                    <?php echo CHtml::button('remove', array('class' => 'remove_thumbnail uibutton special')) ?>
                    <div class="avartar">

                        <?php echo $form->textField($model, 'thumbnail', array('class' => 'fileDialogCustom ', 'title' => 'fileimport')) ?>
 
                        <?php echo $form->error($model, 'thumbnail'); ?>
                       
                        <p align="center" ><?php echo $form->labelEx($model, 'thumbnail'); ?></p>
                        
                    </div>
                </div>
            </div>

            <div class="twoOne">

                <p class="note">Fields with <span class="required">*</span> are required.</p>

                <?php echo $form->errorSummary($model); ?>

                <div class="section ">
                    <?php echo $form->labelEx($model, 'title'); ?> 
                    <div> 
                        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 128)); ?>
                        <?php echo $form->error($model, 'title'); ?>
                    </div>

                </div>
                <div class="section">
                    <?php echo $form->labelEx($model, 'content', array('style' => 'float: none;')); ?>
                    <div>
                        <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 30, 'class' => 'redactor')); ?>
                        <?php echo $form->error($model, 'content'); ?>
                    </div>
                </div>

                <div class="section ">
                    <?php echo $form->labelEx($model, 'tags'); ?>   
                    <div> 
                        <?php echo $form->textArea($model, 'tags', array('rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'tags'); ?>
                    </div>
                </div>
                <div class="section ">
                    <?php echo $form->labelEx($model, 'status'); ?>
                    <div> 
                        <?php echo $form->dropDownList($model, 'status', Posts::getArrayStatusPosts()); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
                <?php if(!$model->isNewRecord){?>
                    <div class="section ">
                    <?php echo $form->labelEx($model,'permalink'); ?>
                    <div> 
                        <?php echo $form->textField($model, 'permalink', array('size'=>50, 'maxlength'=>255)); ?>
                        <?php echo $form->error($model, 'permalink'); ?>
                    </div>
                </div>
               <?php }?>
                    
                <div class="section ">
                    <?php echo $form->labelEx($model, '_category_checkboxList'); ?>
                    <div>
                        <?php
                        $postcategoryrelation = Postcategoryrelation::model()->findAllByAttributes(array('post_id' => $model->id));
                        if ($postcategoryrelation) {
                            $model->_category_checkboxList = CHtml::listData($postcategoryrelation, 'category.id', 'category.id');
                        }
                        echo $form->checkBoxList($model, '_category_checkboxList', CHtml::listData(Categories::model()->findAll(), 'id', 'name'), $model->_category_checkboxList)
                        ?>
                    </div> 
                </div>
                <div class="section last">
                    <?php echo $form->labelEx($model, 'author_id'); ?>
                    <div>

                        <?php // echo $form->textField($model, 'author_id');  ?>
                        <?php echo $form->error($model, 'author_id'); ?>

                        <?php
                        if ($model->author_id == null) {
                            $checked = '($data->id==' . Yii::app()->user->id . ')?true:false';
                        } else {
                            $checked = '($data->id==' . $model->author_id . ')?true:false';
                        }
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'user-grid',
                            'dataProvider' => $model_user->search(),
                            'filter' => $model_user,
                            'columns' => array(
//              array(
//                                'class' => 'CCheckBoxColumn',
//                                'selectableRows' => 1,
//                                'checkBoxHtmlOptions' => array('class' => 'checked_for_user',
//                                    'name'=>'Posts[author_id]',
////                                    'disabled'=>'($data->id==24)?"disabled":"disabled"',
//                                    'checked'=>0,
////                                    'sdfsdf'=>'sfsdfs',
////                                    'checked'=>true,
//                                    ),
//                  
//                            ),

                                array(
                                    'name' => '',
                                    'value' => 'CHtml::radioButton("_author_id", ' . $checked . ' ,array("value"=>$data->id,"id"=>"cid_".$data->id))',
                                    'type' => 'raw',
                                    'htmlOptions' => array('width' => 5),
                                    //'visible'=>false,
                                    'filter' => false,
                                ),
                                'id',
                                'email',
                                array(
                                    'name' => 'role_id',
                                    'value' => 'Options::item("UserRole",$data->role_id)',
                                    'filter' => Options::items("UserRole"),
                                ),
                                'first_name',
                                'last_name',
                                'phone',
//                array(
//                        'name' => 'date_create',
//                        'value' => 'User::getTimeUSA($data->date_create)',
//                ),
//                array(
//                        'class' => 'CButtonColumn',
//                ),
                            ),
                        ));
                        ?>

                    </div>
                </div>

            </div>
            <!--<hr>-->
            <div class="oneThree" style="width: 98%; text-align: center;" >
                <h2>Custom filds</h2>
                <?php echo CHtml::label('Show custom filds', '') ?>
                <?php echo CHtml::checkBox("Custom filds", false, array('id' => 'show_or_hide')) ?>
            </div>
            <div class="oneThree  custom_filds" style="width: 98%; text-align: center; display: none;">
                <h2>Custom file fields</h2>
                <div class="postmeta postmetafile">
                    <?php
                    $postmeta_file = PostMeta::model()->findAllByAttributes(array('type' => 'file', 'post_id' => $model->id));
                    if (empty($postmeta_file) && isset($_POST['postmeta']['file']) && !empty($_POST['postmeta']['file'])) {
                        $postmeta_file = array_diff($_POST['postmeta']['file'], array(''));
                    }
                    if (count($postmeta_file)) {
                        foreach ($postmeta_file as $element) {
                            if (!isset($element->value)) {
                                $value = $element;
                            } else {
                                $value = $element->value;
                            }
                            ?>
                            <div class="row block_callback" >
                                <div class="block_callback_img" >
                                    <img  src="<?php echo Yii::app()->createAbsoluteUrl($value) ?>"  width="180" height="180" alt="avatar" />
                                </div>
                                <?php echo CHtml::textField('postmeta[file][]', $value, array('class' => 'element fileDialogCustom', 'title' => 'fileimport')); ?>                                <?php // echo CHtml::fileField('postmeta[file][]', '',array('class'=>'element'))  ?>
                                <?php echo CHtml::button('remove', array('class' => 'remove uibutton special')) ?>
                            </div>
                        <?php } ?>
                    <?php }
                    ?>
                    <div class="row block_callback" id="not_move" >
                        <div class="block_callback_img" >
                        </div>
                        <?php echo CHtml::textField('postmeta[file][]', '', array('class' => 'element fileDialogCustom', 'title' => 'fileimport')) ?>
                        <?php echo CHtml::button('add', array('class' => 'add uibutton')) ?>
                    </div>

                </div>
                <hr>
                <h2>Custom text filds</h2>
                <div class="postmeta postmetafield">
                    <?php
                    $postmeta_field = PostMeta::model()->findAllByAttributes(array('type' => 'field', 'post_id' => $model->id));
                    if (empty($postmeta_field) && isset($_POST['postmeta']['field']) && !empty($_POST['postmeta']['field'])) {
                        $postmeta_field = array_diff($_POST['postmeta']['field'], array(''));
                    }
                    if (count($postmeta_field)) {
                        foreach ($postmeta_field as $element) {
                            if (!isset($element->value)) {
                                $value = $element;
                            } else {
                                $value = $element->value;
                            }
                            ?>
                            <div class="row">
                                <?php echo CHtml::textField('postmeta[field][]', $value, array('class' => 'element')) ?>
                                <?php echo CHtml::button('remove', array('class' => 'remove uibutton special')) ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="row"> 
                        <?php echo CHtml::textField('postmeta[field][]', '', array('class' => 'element')) ?>
                        <?php echo CHtml::button('add', array('class' => 'add uibutton')) ?>
                    </div>

                </div>
                <hr>
                <h2>Custom redactor filds</h2>
                <div class="postmeta postmetaarea">
                    <?php
                    $postmeta_area = PostMeta::model()->findAllByAttributes(array('type' => 'area', 'post_id' => $model->id));
                    if (empty($postmeta_area) && isset($_POST['postmeta']['area']) && !empty($_POST['postmeta']['area'])) {
                        $postmeta_area = array_diff($_POST['postmeta']['area'], array(''));
//                       $postmeta_area = $_POST['postmeta']['area'];
                    }
                    if (count($postmeta_area)) {
                        foreach ($postmeta_area as $element) {
                            if (!isset($element->value)) {
                                $value = $element;
                            } else {
                                $value = $element->value;
                            }
                            ?>
                            <div class="row">
                                <?php echo CHtml::textArea('postmeta[area][]', $value, array('rows' => 6, 'cols' => 30, 'class' => 'redactor element', 'style' => 'height:200px; width: 500px;')) ?>
                                <?php echo CHtml::button('remove', array('class' => 'remove uibutton special')) ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="row">
                        <?php echo CHtml::textArea('postmeta[area][]', '', array('rows' => 6, 'cols' => 30, 'class' => 'redactor element', 'style' => 'height:200px; width: 500px;')) ?>
                        <?php echo CHtml::button('add', array('class' => 'add uibutton')) ?>
                    </div>
                </div>
                <hr>

            </div>
            <div class="" style="float: right; margin: 20px;">
                <div>
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'uibutton submit_form', 'style' => 'background-color: #9BC652; border-color:#9BC652;')); ?>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($){ 
                    $('.postmetafile  .row .add , .postmetafield .row .add').live('click',function(){
                        var clone = $(this).parent('.row').clone();
                        //                        console.log(clone,$(this));
                        $(this).val('remove').removeClass('add').addClass('remove').addClass('special');
                 
                        clone.children('.element').val('');
                        clone.find('.block_callback_img').html('');
                        $(this).parent('.row').after(clone)
                    });
                    $('.postmetaarea .row .add').live('click',function(){
//                        console.log('test');
                        var clone = $(this).parent('.row').clone();
                        $(this).val('remove').removeClass('add').addClass('remove').addClass('special');

                        clone.children('.element').val('');
                        var clone2 = $('<?php echo '<div class="row">' . CHtml::textArea('postmeta[area][]', '', array('rows' => 6, 'cols' => 30, 'class' => 'redactor element', 'style' => 'height:200px;')) . CHtml::button('add', array('class' => 'add uibutton')) . '</div>' ?>')
                        $(this).parent('.row').after(clone2)
                        $('.redactor').redactor(
                       /* {'convertDivs':false,
                            'imageUpload':'<?php //Yii::app()->createAbsoluteUrl('/admin/posts/imageupload'); ?>',
                            'buttons':['html','|','formatting','|','bold','italic','deleted','|','unorderedlist','orderedlist','outdent','indent','|','filemanager','table','link','|','fontcolor','backcolor','|','alignleft','aligncenter','alignright','justify','|','horizontalrule'],'buttonsCustom':{'filemanager':{'title':'filemanager','func':'fileDialogCallback'}}}*/
                        );
                    });
                    
                    $('.row .remove').live('click',function(){
                        $(this).parent('.row').remove();
                    })

                    $(".postmetafield,").sortable({ revert:true,items:"div:not(#not_move)" });
                    $(".postmetafile").sortable({ revert:true,items:"> .row"});
                    $('.postmetaarea').sortable({
                            revert:true,items:"> .row",
                            cancel:".redactor_box", 
                            stop: function(event, ui) {
                                $('.postmeta .redactor').each(function(indx, element){
                                        $(this).destroyEditor();
                                });
                                $('.postmeta .redactor').redactor();
                            }
                        });
                   
                    $('#show_or_hide').live('click',function(){
                        $('.custom_filds').slideToggle();            
                    });   
                    
                    $('.remove_thumbnail').live('click',function(){
                        $(this).parents('.profileSetting').find('.fileDialogCustom').val('');
                        $(this).parents('.profileSetting').find('.block_callback_img').html('');
//                        console.log('remove_thumbnail');
                    });
                });

                   
            </script>



        </div><!-- End Third / Half column-->
        <?php $this->endWidget(); ?>
        <!--</form>-->

        <!-- clear fix -->
        <div class="clear"></div>

    </div><!-- End content -->
</div>



<?php
$this->widget('ext.yiiext-imperavi-redactor-widget.ImperaviRedactorWidget', array(
    'selector' => '.redactor',
    'options' => array('convertDivs' => false,
        'height' => 350,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/posts/imageupload'),
        'buttons' => array(
            'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', /* 'image', */ 'filemanager', /* 'video', */ 'table', 'link', '|', 'fontcolor', 'backcolor', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule'
        ),
        'buttonsCustom' => array('filemanager' => array('title' => 'filemanager', 'func' => "fileDialogCallback")),
//        'callback' =>TRUE
    ),
));
?>
