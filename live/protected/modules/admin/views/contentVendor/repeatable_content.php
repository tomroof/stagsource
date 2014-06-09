<div class="row">
    <?php
    echo $form->labelEx(
            $model, 'content_content', array('style' => 'float:none;', 'label' => 'Content Part')
    );
    ?>
    <!--====================Content Textarea =================== -->
    <?php if ($model->content_content): ?>

        <?php
        $i = 0;
        foreach ($model->content_content as $content) {
            echo Chtml::openTag('div');
            echo Chtml::textArea(
                    'Contents[content_content][]', $content, array('rows' => 10, 'cols' => 50, 'class' => 'redactor')
            );

            if ($i !== 0) {
                echo CHtml::tag(
                        'input', array('class' => 'uibutton special', 'value' => 'Remove Block',
                    'onclick' => 'js:$(this).parent().remove();return false;')
                );
            }
            echo Chtml::closeTag('div');
            $i++;
        }
        ?>

    <?php else: ?>
        <?php
        echo Chtml::textArea(
                'Contents[content_content][]', $model->content_content, array('rows' => 10, 'cols' => 50, 'class' => 'redactor')
        );
        ?>
<?php endif ?>
    <!--========================= End ========================== -->
</div>

<?php
echo CHtml::button(
        'Add Block', array('style' => ' margin: 5px; background-color: #9bc652;
                             color: #ffffff;', 'class' => 'uibutton', 'id' => 'addBlock',
    'onclick' => 'repeatable(this)')
);
?>