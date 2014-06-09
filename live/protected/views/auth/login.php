
    <?php
    $form = $this->beginWidget(
        'CActiveForm', array('id' => 'login-form', 'action' => '/auth/login',
            'enableClientValidation' => true, 'clientOptions' => array('validateOnSubmit' => true,))
    );
    ?>

    <p class="label">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
    </p>
    <?php echo $form->error($model, 'email'); ?>

    <p class="label">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>

    </p>
    <?php echo $form->error($model, 'password'); ?>
    <?php
    echo CHtml::ajaxSubmitButton(
        'Login',
        array('/auth/login'),
        array(
            'success' => 'js:function(data){
            if(data == "true")
               window.location.href = "/";
            else {
;                                    $("#login-form").html(data);

                                    if ($.isFunction($.fn.inFieldLabels)) {
                                    $("p.label label").inFieldLabels({
            fadeOpacity: 0
        });
    };};
    }',
        ),
        array('class' => "but-big but-green")
    );
    ?>
    <?php $this->endWidget(); ?>
