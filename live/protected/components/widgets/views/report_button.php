<?php
$csrfToken = '';
if(Yii::app()->request->enableCsrfValidation) {
      $csrfToken = Yii::app()->request->csrfToken;
}

$cs = Yii::app()->clientScript;
$id = str_replace('.', '_', $this->model . '_' . $this->model_id);

$url = Yii::app()->createUrl('/SpamReport/ajax_add_item');

?>

<script type="text/javascript">
    $(function () {
        $('#report_spam_button_<?php echo $id?>').PESpamReportButton({
            url : '<?php echo $url?>',
            model_id : '<?php echo $this->model_id?>',
            model : '<?php echo $this->model?>',
            csrfToken : '<?php echo $csrfToken?>',
            containerId : '#report_spam_container_<?php echo $id?>'
        });
    });
</script>
<div class="report_spam_button" id="report_spam_button_<?php echo $id?>" style="display: inline">

    <div style="position: absolute; left: -9999px;">
        <div id="report_spam_container_<?php echo $id?>" class="block-popup report-popup spam_rep">
            <div id="block-flag" class="block-popup-in">
                <div class="title-popup-in">
                    <h2>Flag as inappropriate</h2>
                </div>

                <div class="block-popup-in-2">
                    <form action="" method="post">
                        <div>
                            <div class="line">
                                <?php if($this->model == 'Contents'): ?>
                                    Report this Topic due to:
                                <?php elseif($this->model == 'ContentComments'): ?>
                                    Report this Comment due to:
                                <?php else: ?>
                                    Report this Item due to:
                                <?php endif; ?>
                           </div>


                            <div class="line">
                                <p>
                                    <input name="report_cause" value="1" type="checkbox"/>
                                    <span>Explicit language</span>
                                </p>

                                <p>
                                    <input name="report_cause" value="2" type="checkbox"/>
                                    <span>Attacks on groups or individual</span>
                                </p>

                                <p>
                                    <input name="report_cause" value="3" type="checkbox"/>
                                    <span>Invades my privacy</span>
                                </p>

                                <p>
                                    <input  name="report_cause" value="4" type="checkbox"/>
                                    <span>Hateful speech or symbols</span>
                                </p>

                                <p>
                                    <input name="report_cause" value="5" type="checkbox"/>
                                    <span>Spam or scam</span>
                                </p>

                                <p>
                                    <input  name="report_cause" value="6" type="checkbox"/>
                                    <span>Other</span>
                                </p>
                            </div>
                            <div class="line error" style="color:red; display: none;">
                                Please select one or more report causes
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block-popup-in-2">
                    <p class="guidelines-links">Read our <a href="<?php echo Yii::app()->createUrl('/page/code-of-conduct') ;?>" target="_blank">Code of Conduct</a></p>
                </div>
                <div class="block-popup-bot">
                    <a href="#" class="report but-big but-green">Report</a>
                </div>
            </div>
        </div>
    </div>
    <a class="link-flag spam_report" href="#report_spam_container_<?php echo $id?>">&nbsp;</a>
</div>