<?php
/* @var $this ContentsController */
/* @var $model Contents */
/* @var $form CActiveForm */
?>
<?php
    $this->renderPartial('content_types/_' . $model->content_type, compact('model'));

?>