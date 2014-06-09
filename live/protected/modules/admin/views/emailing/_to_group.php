




<div class="widget">
    <?php
    var_dump($user_roles, $is_confirmed);
    ?>
    <div class="header"> <span ><span class="ico gray random "></span>UI DualListbox</span></div>
    <div class="content" >

        <!-- Third width -->
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


                <!-- clear fix -->
                <div class="clear"></div>


                <span id="box1Counter" class="countLabel"></span>
                <select id="box1Storage"></select>

            </div><!-- End Third width column -->

            <div class="oneThree" align="center">
                <div class="boxMove">
                    <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/eArrow.png" id="to2" alt="first"/> </a>
                    <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/eeArrow.png" id="allTo2" alt="first"/> </a>

                    <!-- clear fix -->
                    <div class="clear"></div>
                    <br />

                    <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/wwArrow.png" id="allTo1" alt="first"/> </a>
                    <a class="uibutton confirm" > <img src="<?= Yii::app()->baseUrl ?>/images/wArrow.png" id="to1" alt="first"/> </a>
                </div>
            </div><!-- End Third width column -->


            <div class="oneThree">

                <input type="text" id="box2Filter" placeholder="Filter" /><br /><br />
                <select id="box2View" multiple="multiple" style="height:300px;width:100%;"></select>

                <!-- clear fix -->
                <div class="clear"></div>

                <span id="box2Counter" class="countLabel"></span>
                <select id="box2Storage"></select>

            </div><!-- End Third width column -->

        </div><!-- End Third width widgets -->

        <!-- clear fix -->
        <div class="clear"></div>

    </div><!-- End content -->
    <div class="content" >
        <!-- Third width -->
        <div class="widgets">

            <div class="oneThree">

                <input type="text" id="box1Filter"placeholder="Filter" /><br /><br />
                <?php echo CHtml::dropDownList('box1View', array(), $user_roles, array('multiple' => 'multiple', 'style' => 'height:300px;width:100%;')); ?>
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
                    <option value="1" selected="selected" >Admin</option>
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
