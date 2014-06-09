<div class="item">

    <?php echo CHtml::hiddenField(get_class($model) . '[id][]', $model->item_id, array('class' => 'id_poll_item'));
    if ($this->img == true) {
        ?>
        <div class="row_poll block_callback">
            <div class="block_callback_img row-in">
                <?php if ($model->img) {
                    echo CHtml::image($model->img, '', array('width' => "180", 'height' => "180"));
                } ?>
            </div>
            <?php
            echo CHtml::label($model->getAttributeLabel('img'), '');
            echo CHtml::textField(get_class($model) . '[img][]', $model->img, array('class' => 'img', 'class' => "fileDialogPoll ", 'title' => "fileimport"));
            ?>
        </div>
    <?php
    }?>
    <div class="row_poll">
        <?php
        echo CHtml::label($model->getAttributeLabel('content'), '');
        echo CHtml::textField(get_class($model) . '[content][]', $model->content, array('class' => 'hidden_input'));?>
    </div>
    <div class="row-in"><?php echo CHtml::link('remove', '#', array('class' => 'delete_poll_item button-delete uibutton special')); ?></div>
</div>