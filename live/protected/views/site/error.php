<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<!-- <h2>Error <?php echo $code; ?></h2>
<div class="error">
<?php echo CHtml::encode($message); ?>
</div> -->

<div class="block-error">
	<big><?php echo $code; ?> error</big>
	<b>oops! the page you were<br /> looking for isn't here.</b>
	<div class="block-error-bot">
		<p>Go back to the <a href="/">Homepage</a></p>
	</div>
</div>