<section class="grid_12 no-box" >

    <h1>Manage Menu: <?php echo Yii::app()->params['menus'][$_GET['menu_key']]; ?></h1>


<?php //  echo CHtml::form('/admin/menu/menu?menu_key=' . $_GET['menu_key'], 'get', array('class' => 'lang')); ?>

<!--        <div class="members_filter" style="margin-left: 30px;">

    <div class="members_filter_in">
        <label>Visa Type</label>
         <?php


//        echo CHtml::dropDownList('language',  Yii::app()->language,  Yii::app()->params->languages );
        ?>
           </div>

    <div class="members_filter_in">
        <label>&nbsp;</label>
        <div class="row buttons">
           <?php //      echo  CHtml::submitButton(); ?>

        </div>
    </div>
</div>-->
    <?php
//  echo CHtml::endForm();
?>






    <div class="row buttons">



</div>

<div class="row buttons" style="float: right; width: auto;">

    <?php echo CHtml::link('Create page', array('/admin/page/create'), array('class' => 'uibutton confirm')); ?>
    <?php echo CHtml::link('Create link', array('/admin/menu/admin'), array('class' => 'uibutton confirm')); ?>
</div>
  <div class="block-menu-all">
    <div class="widget block-menu">
        <div class="header">
          <span>In Menu</span>
        </div>
        <div class="content">

          <?php


            $this->widget('zii.widgets.jui.CJuiSortable', array(
                'id'=>'sortable1',
                'items'=> $inMenu,
                'options'=>array(
                    'cursor'=>'n-resize',
                    'connectWith' => '.connectedSortable',
                ),
                'htmlOptions' => array(
                    'class' => 'connectedSortable'
                ),
                'itemTemplate'=>'<li id="{id}" class="menu-dept_{lvl}">{content}</li>'
            ));

            echo CHtml::ajaxButton('Submit Changes', array('/admin/menu/AjaxChangeOrder'), array(
                    'type' => 'GET',
                    'success' => 'function(data){alert("Menu Saved")}',
//                    'success' => 'function(data){console.log(data);alert("Menu Saved")}',
                    'data' => array(
                        // Turn the Javascript array into a PHP-friendly string
                        'language' => $_GET['language'],
                        'id' => 'js:$("#sortable1").sortable("serialize").toString()',
                        'level' => 'js:$("#sortable1").sortable("serialize" , { key: "lvl[]",  attribute : "class"}).toString()',
                        'menu_key' => $_GET['menu_key'],
                    )

                ),
                   array('class'=>'submit_bt uibutton confirm')
                     );
            ?>
        </div>
    </div>
    <div class="widget block-menu">
        <div class="header">
          <span>Pages/Links</span>
        </div>
        <div class="content">
          <?php
          $this->widget('zii.widgets.jui.CJuiSortable', array(
              'id'=>'sortable2',
              'items'=> $notInMenu,
              'options'=>array(
                  'cursor'=>'n-resize',
                  'connectWith' => '.connectedSortable',
              ),
              'itemTemplate' =>'<li id="{id}" class="menu-dept_0">{content}</li>',
              'htmlOptions' => array(
                  'class' => 'connectedSortable'
              )
          ));

          ?>
        </div>
    </div>
  </div>




  <div class="oneThree" style="float: left;">
 <h3>Menus</h3>
    <?php
    $menus = Yii::app()->params['menus'];
    ?>
                    <ol class="rectangle-list">
                       <?php foreach($menus as $key=>$menu):
                         $class = ($_GET['menu_key'] != $key)?'uibutton':'';
                         ?>
                      <li><?php echo CHtml::link($menu, Yii::app()->createUrl('/admin/menu/menu', array('menu_key'=>$key)), array('class'=>$class)); ?></li>
                       <?php endforeach; ?>


                  </ol>
              </div>





</section>