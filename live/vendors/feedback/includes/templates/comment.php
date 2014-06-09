    <p>If you have any comments about our website, products or company, we'd love to hear from you!
        Please fill in the short form below. Required text is denoted by a red star.
    </p>


    <form action="<?php htmlspecialchars($_SERVER['REQUEST_URI'],ENT_QUOTES); ?>" method="post">

        <input type="hidden" name="feedback" value="comment" />

        <fieldset>
        <legend>Your Comments</legend>
        <span class="required">* </span>Your comments are kept completely private but nevertheless you should not share confidential details below.
        <textarea name="commentText" class="text_entry" cols="20" rows="3"><?php print $_POST['commentText']; ?></textarea>
        <br/>
        </fieldset>

        <fieldset>
        <legend>Your Details</legend>
        <strong>Your name:</strong><br/>
        <input name="name" class="text_entry" value="<?php print $_POST['name']; ?>" />
        <strong>Your email address:</strong><br/>
        By providing your email address, we can get in contact with you to discuss your comments, if necessary.
        <input name="email" class="text_entry" value="<?php print $_POST['email']; ?>" />
        <br/>
        </fieldset>

        <fieldset>
        <legend>Send your comments</legend>    
        <span class="required">* </span>Please help us prevent automated responses and fill in the below:<br/><br/>
        <?php
            $captcha = new basicCaptcha();
            $captcha->generate();
            echo $captcha->display('html') . ' = ';
        ?>
        <input name="captchaAnswer" class="text_entry" style="width:20px" />
        <br/><br/>
        <input class="submit" type="submit" name="submit" value="Submit"/>
        </fieldset>
    </form>

</div>