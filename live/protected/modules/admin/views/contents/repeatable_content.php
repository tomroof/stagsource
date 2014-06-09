<script type="text/javascript">
    SingleInitTiny_mce();
</script>
<div class="row ">
    <?php
    echo $form->labelEx(
        $model, 'content_content', array('style' => 'float:none;', 'label' => 'Content Part')
    );
    ?>
    <?php
    echo '<div class="tinymce">';
    echo $form->textArea($model, 'content_content', array('rows' => 10, 'cols' => 50, 'class' => 'content_content_tinymce'));
    echo '</div>';
    ?>
    <!--========================= End ========================== -->
</div>
<div class="row">
    <?php echo $form->labelEx($model, 'content_excerpt'); ?>
    <?php echo Chtml::openTag('div', array('class' => 'row-in'));
    echo $form->textArea($model, 'content_excerpt', array('rows' => 10, 'cols' => 50,
        'class' => ''));
    echo Chtml::closeTag('div');
    ?>
</div>