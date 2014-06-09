    <p>If you have any suggestions in regards to our website, products or company, we'd love to hear from you!
        Please fill in the short form below. Required text is denoted by a red star.
    </p>

    
    <form action="<?php htmlspecialchars($_SERVER['REQUEST_URI'],ENT_QUOTES); ?>" method="post">

        <input type="hidden" name="feedback" value="suggestion" />

        <fieldset>
        <legend>Your Suggestions</legend>
        <span class="required">* </span>Important: Upon submitting your suggestions and ideas, you agree that we may act upon them however we wish.
        <textarea name="suggestionText" class="text_entry" cols="20" rows="3" ><?php print $_POST['suggestionText']; ?></textarea>
        <br/>
        </fieldset>
        
        <fieldset>
        <legend>Your Details</legend>
        <strong>Your name:</strong><br/>
        <input name="name" class="text_entry" value="<?php print $_POST['name']; ?>" />
        <strong>Your email address:</strong><br/>
        By providing your email address, we can get in contact with you to discuss your suggestions, if necessary.
        <input name="email" class="text_entry" value="<?php print $_POST['email']; ?>" />
        <br/>
        </fieldset>

        <fieldset>
        <legend>Send your suggestions</legend>
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