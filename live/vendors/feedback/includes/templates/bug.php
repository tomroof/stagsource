    <p>If you think you have found a bug somewhere on our website, please report it. Please fill in the short form below.
        Required text is denoted by a red star.
    </p>

    <form action="<?php htmlspecialchars($_SERVER['REQUEST_URI'],ENT_QUOTES); ?>" method="post">

        <input type="hidden" name="feedback" value="bug" />

        <fieldset>
        <legend>Bug Details</legend>
        <strong>Bug Category:</strong><br/>
        <span class="required">* </span>Please identify the category this bug can be classed in.<br/>
        <select name="bugCategory" class="text_entry">
          <option value="404Error">Page missing/link broken</option>
          <option value="contentError">Content inaccuracy</option>
          <option value="displayError">Visual issue</option>
          <option value="otherError">Other issue</option>
        </select><br/>
        <strong>Bug Summary:</strong><br/>
        <span class="required">* </span>Please provide a brief description of the bug you encountered.
        <textarea name="bugSummary" class="text_entry" cols="20" rows="3" ><?php print $_POST['bugSummary']; ?></textarea>
        <strong>Bug Detail:</strong><br/>
        Please describe how you encountered the bug and any other details you feel may be important.
        <textarea name="bugDetail" class="text_entry" cols="20" rows="3" ><?php print $_POST['bugDetail']; ?></textarea>
        <br/>
        </fieldset>

        <fieldset>
        <legend>Your Details</legend>
        <strong>Your name:</strong><br/>
        <input name="name" class="text_entry" value="<?php print $_POST['name']; ?>" />
        <strong>Your email address:</strong><br/>
        By providing your email address, we can get in contact with you for futher bug details, if necessary.
        <input name="email" class="text_entry" value="<?php print $_POST['email']; ?>" />
        <br/>
        </fieldset>

        <fieldset>
        <legend>Send your bug report</legend>
        
        <span class="required">* </span>Please help us prevent automated responses and fill in the below:<br/><br/>
        <?php
            $captcha = new basicCaptcha();
            $captcha->generate();
            echo $captcha->display('html') . ' = ';
        ?>
        <input name="captchaAnswer" class="text_entry" style="width:20px" />
        <br/><br/>
        <input class="submit" type="submit" name="submit" value="Submit" />
        </fieldset>
    </form>

</div>