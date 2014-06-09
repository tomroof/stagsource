<?php
$this->breadcrumbs = array(
    'Emailing' => array('/admin/emailing'),
    'Emailing',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<form action="<?php echo Yii::app()->createUrl('/admin/emailing/emailing'); ?>" method="post">
    <table>
<!--	<tr>
            <td>Subject</td>
            <td></td>
        </tr>-->
        <tr>
            <!--<td>Body</td>-->
            <td>
                <div class=" grid1 formEl_b">
                    <fieldset>
                        <legend>Mass Emailing : Subject</legend>

                        <div>
                            <input type="text" name="Mail[emailing_subj]" id="emailing_subj" />
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Mass Emailing : Body</legend>

                        <div>
                            <textarea name="Mail[emailing_body]" class="emailing_body" id="emailing_body"></textarea>
                        </div>
                    </fieldset>
                </div>
                <div class="clear"></div>

            </td>
        </tr>
    </table>
    <!--    <div class="box-line">
            <p class="label inp-1">
                <label>Subject</label>
            </p>
            <input type="text" name="Mail[emailing_subj]" id="emailing_subj" />
        </div>
        <div class="box-line">
            <p class="label inp-1">
                <label>Body</label>
            </p>
            <textarea name="Mail[emailing_body]" id="emailing_body"></textarea>
        </div>-->

    <?php ob_start(); ?>
    <table class="emailing_to_users">
        <tbody>
            <tr>
                <td width="60%">
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'resources-grid',
                        'dataProvider' => $user->search(),
//			'filter' => $user,
                        'columns' => array(
                            array(
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
                                'checkBoxHtmlOptions' => array('class' => 'checked_for_emailing'),
                            ),
                            array(
                                'name' => 'id',
                                'htmlOptions' => array('width' => '50px')
                            ),
//	array(
//	    'name' => '',
//	    'value' => 'CHtml::checkBox("cid[]",null,array("value"=>$data->id,"id"=>$data->id))',
//	    'type' => 'raw',
//	    'htmlOptions' => array('width' => 5),
//	//'visible'=>false,
//	),
//			'email',
                            array(
                                'name' => 'first_name',
                                'htmlOptions' => array('class' => 'u_first_name')
                            ),
                            array(
                                'name' => 'last_name',
                                'htmlOptions' => array('class' => 'u_last_name')
                            ),
//		'phone',
//	'date_create',
//		'date_last_login',
                            array(
                                'name' => 'type',
                                'value' => 'Options::item("UserRole",$data->role_id)',
//            'filter'=>Lookup::items('UserRole'),
                            ),
//		'confirmation_key',
//		'is_confirmed',
//		'address',
//		'zip',
//		'area_code',
//		'website',
//		'description',
//		'status',
//		'countryID',
//		'zoneID',
//		'city',
//		'activkey',
//		'howfound',
//		'work_phone',
//		'mobile_phone',
//		'alt_email',
//		'skype_name',
//		'about_me',
//		'cpc',
//		'leads_day',
//		'avatar',
//		'business_name',
//		'area_code_mob',
//		'imdb',
//		'years_in_indastry',
//		'message_day',
//		'message_day_date',
//		'budget',
//		'average_rate',
//	array(
//	    'class' => 'CButtonColumn',
//	),
                        ),
//		    'htmlOptions' => array('style' => 'width: 70%'),
                    ));
                    ?>
                </td>
                <td width="10%">
                    <div>
                        <a class="add_to_emailing_list" href="#">Add >></a>
                    </div>
                    <div>
                        <a class="rm_from_emailing_list" href="#"><< Remove</a>
                    </div>
                    <div>
                        <a class="rm_all_from_emailing_list" href="#"><< Remove All</a>
                    </div>
                </td>
                <td>
                    <label>Your Selection</label>
                    <div class="box-line box-sel-multiple">

                        <?= CHtml::dropDownList('Mail[selected_users][]', array(), CHtml::listData(array(), 'id', 'firs_name'), array('id' => 'users_list', 'multiple' => 'multiple')); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="but">
                        <?php echo CHtml::submitButton('Send', array('name' => 'to_users')); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    ?>
    <?php ob_start(); ?>





    <div class="widget">
        <?php
//    var_dump($user_roles_groups, $is_confirmed);
        ?>
    <!--    <div class="header"> <span ><span class="ico gray random "></span>UI DualListbox</span></div>
        <div class="content" >
    
             Third width 
            <div class="widgets">
    
                <div class="oneThree">
    
                    <input type="text" id="box1Filter"placeholder="Filter" /><br /><br />
    
                    <select id="box1View" multiple="multiple" style="height:300px;width:100%;">
                        <option value="501649">2008-2009 "Mini" Baja</option>
                        <option value="501497" selected="selected">AAPA - Asian American Psychological Association</option>
                        <option value="501053">Academy of Film Geeks</option>
                        <option value="500001">Accounting Association</option>
                        <option value="501227">ACLU</option>
                        <option value="501610" selected="selected">Active Minds</option>
                        <option value="501514" selected="selected">Activism with A Reel Edge (A.W.A.R.E.)</option>
                        <option value="501656" selected="selected">Adopt a Grandparent Program</option>
                        <option value="501050">Africa Awareness Student Organization</option>
                        <option value="501075">African Diasporic Cultural RC Interns</option>
                        <option value="501493" selected="selected">Agape</option>
                        <option value="501562">AGE-Alliance for Graduate Excellence</option>
                        <option value="500676">AICHE (American Inst of Chemical Engineers)</option>
                        <option value="501460">AIDS Sensitivity Awareness Project ASAP</option>
                        <option value="500004">Aikido Club</option>
                        <option value="500336">Akanke</option>
                    </select>
    
    
                     clear fix 
                    <div class="clear"></div>
    
    
                    <span id="box1Counter" class="countLabel"></span>
                    <select id="box1Storage"></select>
    
                </div> End Third width column 
    
                <div class="oneThree" align="center">
                    <div class="boxMove">
                        <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/eArrow.png" id="to2" alt="first"/> </a>
                        <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/eeArrow.png" id="allTo2" alt="first"/> </a>
    
                         clear fix 
                        <div class="clear"></div>
                        <br />
    
                        <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/wwArrow.png" id="allTo1" alt="first"/> </a>
                        <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/wArrow.png" id="to1" alt="first"/> </a>
                    </div>
                </div> End Third width column 
    
    
                <div class="oneThree">
    
                    <input type="text" id="box2Filter" placeholder="Filter" /><br /><br />
                    <select id="box2View" multiple="multiple" style="height:300px;width:100%;"></select>
    
                     clear fix 
                    <div class="clear"></div>
    
                    <span id="box2Counter" class="countLabel"></span>
                    <select id="box2Storage"></select>
    
                </div> End Third width column 
    
            </div> End Third width widgets 
    
             clear fix 
            <div class="clear"></div>
    
        </div> End content -->

        <div class="content" >
            <!-- Third width -->
            <div class="widgets">

                <div class="oneThree">

                    <input type="text" id="box1Filter"placeholder="Filter" /><br /><br />
                    <?php echo CHtml::dropDownList('box1View', array(), $user_roles_groups, array('multiple' => 'multiple', 'style' => 'height:300px;width:100%;')); ?>
                    <div class="clear"></div>


                    <span id="box1Counter" class="countLabel"></span>
                    <select id="box1Storage"></select>

                </div><!-- End Third width column -->

                <div class="oneThree" align="center">
                    <div class="boxMove">
                        <a class="uibutton confirm" > <img src="/freelanceyii/images/eArrow.png" id="to2" alt="first"/> </a>
                        <a class="uibutton confirm" > <img src="/freelanceyii/images/eeArrow.png" id="allTo2" alt="first"/> </a>

                        <!-- clear fix -->
                        <div class="clear"></div>
                        <br />

                        <a class="uibutton confirm" > <img src="/freelanceyii/images/wwArrow.png" id="allTo1" alt="first"/> </a>
                        <a class="uibutton confirm" > <img src="/freelanceyii/images/wArrow.png" id="to1" alt="first"/> </a>
                    </div>
                </div><!-- End Third width column -->


                <div class="oneThree">

                    <input type="text" id="box2Filter" placeholder="Filter" /><br /><br />
                    <select id="box2View" multiple="multiple" name="Mail[selected_groups][]" style="height:300px;width:100%;">
                        <!--<option value="1" selected="selected" >Admin</option>-->
                    </select>

                    <!-- clear fix -->
                    <div class="clear"></div>

                    <span id="box2Counter" class="countLabel"></span>
                    <select id="box2Storage"></select>

                </div><!-- End Third width column -->

            </div><!-- End Third width widgets -->
            <div class="but">
                <?php echo CHtml::submitButton('Send', array('name' => 'to_groups')); ?>
            </div>
            <!-- clear fix -->
            <div class="clear"></div>

        </div><!-- End content -->

    </div><!-- End full width -->

    <?php
    $content_groups = ob_get_contents();
    ob_end_clean();
    ?>
    <div id="mass_emailing">
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'To Users' => $content,
//		'To Groups' => array('content'=>Yii::app()->createUrl('/admin/emailing/groups')),
                'To Groups' => $content_groups,
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => false,
//	    'cookie' => array('expires' => 1)
            ),
        ));
        ?>
    </div>
</form>
<style type="text/css">
    .box-sel-multiple select{
        height: 250px;
        width: 100%;
    }
    table.emailing_to_groups .box-sel-multiple select{
        height: 140px;
        width: 100%;
    }
    table.emailing_to_groups{
        width: 100%;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function($){
	
        $("#emailing_body").cleditor();
	
        $('.emailing_to_users a.add_to_emailing_list').live('click',function() {
      
            var $this = '';
            var u_name = '';
            $('.emailing_to_users input.checked_for_emailing:checked').each(function(i){
                $this = $(this);
                u_name = $this.parents('tr.even, tr.odd').find('.u_first_name').text();
                u_name = u_name +" "+ $this.parents('tr.even, tr.odd').find('.u_last_name').text();
		  
                var uniq = $('#users_list').find('option[value="' + $this.val() + '"]').val();
                if(uniq !== undefined ){
                } else {
                    $('#users_list').append('<option value="' + $(this).val() + '">' + u_name  + '</option>');
                }
            });
            return false;
        });
        $('.emailing_to_users a.rm_from_emailing_list').live('click',function() {
            $('select#users_list option:selected').remove();
            return false;
        });
        $('.emailing_to_users a.rm_all_from_emailing_list').live('click',function() {
            $('select#users_list option').remove();
            return false;
        });
	
        //==================================================================================================

        $('.emailing_to_groups a.add_to_emailing_list').live('click',function() {
      
            var $this = '';
            var u_name = '';
            var u_name_id= '';
            $('.emailing_to_groups input.checked_for_emailing:checked').each(function(i){
                $this = $(this);
		
                u_name = $this.parents('tr.even, tr.odd').find('.user_role').text();
                u_name_id = $this.parents('tr.even, tr.odd').find('.user_role_id').text();
		  
                var uniq = $('#group_list').find('option[value="' + u_name_id + '"]').val();
                if(uniq !== undefined ){
                    console.log(u_name,u_name_id);
                } else {
                    console.log(u_name_id,u_name);
                    $('#group_list').append('<option value="' + u_name_id + '">' + u_name  + '</option>');
                }
            });
            return false;
        });
        $('.emailing_to_groups a.rm_from_emailing_list').live('click',function() {
            $('select#group_list option:selected').remove();
            return false;
        });
        $('.emailing_to_groups a.rm_all_from_emailing_list').live('click',function() {
            $('select#group_list option').remove();
            return false;
        });
	
        //==================================================================================================	


        $('input[name="to_users"]').live('click',function(){
            $('select#users_list option').attr('selected', 'selected');
            //	   alert('asdasdas'); 
            //	   return false;
        });
        $('input[name="to_groups"]').live('click',function(){
            $('select#group_list option').attr('selected', 'selected');
            //	   alert('asdasdas'); 
            //	   return false;
        });
	
    });
  
</script>  