<h2><span>Contact us</span></h2>
<div class="content-in">
    <?php
    $form = $this->beginWidget(
            'CActiveForm', array('id' => 'contact-form-contact-form', 'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),)
    );
    ?>
    <div class="sidebar">
        <div class="sb-block dashboard-menu">
            <h5>Dashboard</h5>
            <div class="sb-block-in">
                <ul>
                    <!-- <li class="sb-icon6"><a href="#" title="">Management Team</a></li>
                    <li class="sb-icon7"><a href="#" title="">Board of Directors</a></li> -->
                    <li class="sb-icon8"><a href="<?php echo Yii::app()->createUrl('/page/about'); ?>" title="">About Us</a></li>
                    <li class="sb-icon9 active"><a href="<?php echo Yii::app()->createUrl('/site/contact'); ?>" title="">Contact Us</a></li>
                    <li class="sb-icon12"><a href="#" title="">FAQ's</a></li>
                    <li class="sb-icon13"><a href="#" title="">Who We Are</a></li>
                    <li class="sb-icon14"><a href="#" title="">What We Do</a></li>
                    <li class="sb-icon15"><a href="#" title="">Terms</a></li>
                    <li class="sb-icon16"><a href="#" title="">Privacy</a></li>
                </ul>
            </div>
        </div>
<!--                <div class="sb-block dashboard-menu">-->
<!--                    <h5>Site</h5>-->
<!--                    <div class="sb-block-in">-->
<!--                        <ul>-->
<!--                            <li class="sb-icon10"><a href="#" title="">Press Release</a></li>-->
<!--                            <li class="sb-icon11"><a href="#" title="">Corporate News</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
    </div>
    <div class="center">
        <div class="center-in block-contact">
            <h2>Let Us Know What You're Thinking!</h2>
            <?php echo $form->errorSummary($model); ?>
            <div class="control-group">
                <label>First Name:</label>                                
                <p class="label">
                    <label for="first_name">First Name</label>
<!--                            <input type="text" id=""/>       -->
                    <?php echo $form->textField($model, 'first_name', array('id' => 'first_name')); ?>
                </p>
            </div>
            <div class="control-group">
                <label>Last Name:</label>                                
                <p class="label">
                    <label for="last_name">Last Name</label>
<!--                            <input type="text" id="last_name"/>      -->
                    <?php echo $form->textField($model, 'last_name', array('id' => 'last_name')); ?>
                </p>
            </div>
            <div class="control-group">
                <label>Phone:</label>                                
                <p class="label">
                    <label for="phone">Phone</label>
                    <?php echo $form->textField($model, 'phone', array('id' => 'phone')); ?>

                </p>
            </div>
            <div class="control-group">
                <label>Email:</label>                                
                <p class="label">
                    <label for="email">Email</label>
                    <?php echo $form->textField($model, 'email', array('id' => 'email')); ?>

                </p>
            </div>
            <div class="control-group">
                <label>Company:</label>                                
                <p class="label">
                    <label for="company">Company</label>
                    <?php echo $form->textField($model, 'company', array('id' => 'company')); ?>

                </p>
            </div>
            <div class="control-group">
                <label>Message:</label>                                
                <p class="label">
                    <label for="message">Message</label>
<!--                            <textarea cols="10" rows="10" id="message"></textarea> -->
                    <?php echo $form->textArea($model, 'body', array('id' => 'message', 'cols' => 10, 'rows' => 10)); ?>
                </p>
            </div>
            <div class="block-line">
                <?php echo CHtml::submitButton('Profile', array('class' => 'but-big but-green')); ?>
                <!--                        <button class="">Submit</button>-->
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
