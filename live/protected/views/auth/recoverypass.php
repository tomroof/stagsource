<div class="block-popup pass-request">
	<div class="block-popup-in">
		<div class="title-popup-in">
            <h2>Password restore</h2>
        </div>
		<div class="block-popup-in-2">
			<div class="block-popup-in-3">
				<?php if (Yii::app()->user->hasFlash('success')) { ?>
				<div class="flash-success">
					<?php echo Yii::app()->user->getFlash('success'); ?>
				</div>
				<?php }; ?>
				<div class="form">
					<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'login-form',
						'enableClientValidation' => true,
						'clientOptions' => array(
							'validateOnSubmit' => true,
						),
							));
					?>
					<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

					<div class="line inp-3">
						<?php echo $form->labelEx($model, 'email'); ?>
						<?php echo $form->textField($model, 'email'); ?>
						<?php echo $form->error($model, 'email'); ?>
					</div>
					<!--<div class="block-popup-bot">
					<?php echo CHtml::submitButton('Restore'); ?>
					</div>-->
			
						<input class="but-big but-green" type="submit" name="" value="Restore" />
					
					<?php $this->endWidget(); ?>
				</div><!-- form -->
			</div>
		</div>
	</div>
</div>
