<?php
/* @var $this ContentsController */
/* @var $model Contents */
/* @var $form CActiveForm */
?>
<?php
$postType = Yii::app()->request->getQuery('type');

if (in_array('_'. $model->content_type, $this->content_type_templates)) {

    $this->renderPartial('content_types/_' . $model->content_type, compact('this', 'model', 'index', 'widget'));

} else {
    die('view file "_'. $model->content_type .'" not find');
//    $this->renderPartial('content_types/_video' , compact('this', 'model', 'index', 'widget'));

}

?>