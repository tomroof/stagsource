<!--#SEO FORM SET-->
<fieldset class="grey-block">
    <div class="row">
        <legend>Seo Settings  (Optional) </legend>
    </div>

    <!--Seo title-->
    <div class="row">
        <?php
        echo CHtml::activeLabelEx($modelSeoPack, 'seo_title', array(
            'class' => 'control-label'
        ))
        ?>
        <div class="row-in">
            <?php echo CHtml::activeTextField($modelSeoPack, 'seo_title'); ?>
        </div>
    </div>
    <!--Seo Description-->
    <div class="row">
        <?php
        echo CHtml::activeLabelEx($modelSeoPack, 'seo_description', array(
            'class' => 'control-label'
        ))
        ?>
        <div class="row-in">
            <?php echo CHtml::activeTextArea($modelSeoPack, 'seo_description'); ?>
        </div>
    </div>
    <!--Seo Keywords-->
    <div class="row">
        <?php
        echo CHtml::activeLabelEx($modelSeoPack, 'seo_keywords', array(
            'class' => 'control-label'
        ))
        ?>
        <div class="row-in">
            <?php echo CHtml::activeTextArea($modelSeoPack, 'seo_keywords'); ?>
        </div>
    </div>
    <!--Seo NOFOLLOW-->
    <div class="row">
        <?php
        echo CHtml::activeLabelEx($modelSeoPack, 'seo_nofollow', array(
            'class' => 'control-label'
        ))
        ?>
        <div class="row-in">
            <?php echo CHtml::activeCheckBox($modelSeoPack, 'seo_nofollow'); ?>
        </div>
    </div>
    <!--Seo NOINDEX-->
    <div class="row">
        <?php
        echo CHtml::activeLabelEx($modelSeoPack, 'seo_noindex', array(
            'class' => 'control-label'
        ))
        ?>
        <div class="row-in">
            <?php echo CHtml::activeCheckBox($modelSeoPack, 'seo_noindex'); ?>
        </div>
    </div>
    <!--Seo NOINDEX-->
    <div class="row">
        <?php
        echo CHtml::activeLabelEx($modelSeoPack, 'seo_canonical', array(
            'class' => 'control-label'
        ))
        ?>
        <div class="row-in">
            <?php echo CHtml::activeTextField($modelSeoPack, 'seo_canonical'); ?>
        </div>
    </div>

</fieldset>