<?php
if (Yii::app()->user->id) {
    $form = $this->beginWidget('CActiveForm'
        ,array(
            'id' => 'poll',
            'htmlOptions'=>array('class'=>'poll_class_'.$this->model->getPrimaryKey().'_'.$this->fixed_issues_type))
    );
}
?>
<?php
echo CHtml::hiddenField('poll[model_id]', $content_model_id);
echo CHtml::hiddenField('poll[return_url]', $return_url);
//echo '<pre>';
//$data= CHtml::listData($model,'item_id','content');
//echo CHtml::radioButtonList('name','',$data);
//echo '</pre>';
//die();
?>


<?php foreach ($model as $key => $data) {
    if ($data->is_checkedUser) {
        echo CHtml::hiddenField('poll[old_poll_item_id]', $data->item_id);
    }
    ?>
    <?php $this->render($view, array('data' => $data, 'sum' => $sum, 'key' => $key)) ?>
<?php
}
?>
<?php
if (Yii::app()->user->id && $this->submit) {

    echo CHtml::submitButton('Submit', array('class' => 'btn'));
}
?>

<?php
if (Yii::app()->user->id) {
    $this->endWidget();
}
?>