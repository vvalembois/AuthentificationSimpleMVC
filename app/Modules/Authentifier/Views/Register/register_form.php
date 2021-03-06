<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="/authentifier/registerAction" method="post">
        <label for="user_name">Name :</label>
        <input class="form-control" type="text" id="user_name" name="user_name" value='<?= $data['user_name']?>' autocomplete="off" placeholder="Type your name ..." required/>

        <label for="user_mail">Email :</label>
        <input class="form-control" type="email" id="user_mail" name="user_mail" value='<?= $data['user_mail']?>' autocomplete="off" placeholder="Type your email ..." required/>

        <label for="user_mail_repeat">Email repeat :</label>
        <input class="form-control" type="email" id="user_mail_repeat" name="user_mail_repeat" value='<?= $data['user_mail_repeat']?>' autocomplete="off" placeholder="Type your email again (validation) ..." required/>

        <label for="user_password">Password :</label>
        <input class="form-control" min="4" type="password" id="user_password" name="user_password"  value='<?= $data['user_password']?>' autocomplete="off" placeholder="Type your password ..." required/>

        <label for="user_password_repeat">Password repeat :</label>
        <input class="form-control" type="password" id="user_password_repeat" name="user_password_repeat" value='<?= $data['user_password_repeat']?>' value='<?= $data['user_']?>' autocomplete="off" placeholder="Type your password again (validation) ..." required/>

        <br/>
        <div class="form-group col-xs-12">
            <div class="col-xs-6">
                <label class="" for="user_captcha">Copy the text from the image :</label>
                <input class="form-control" type="text" id="user_captcha" name="user_captcha" autocomplete="off" placeholder="Copy the text from the image ..." required/>
                <button class="form-control btn btn-primary" type="button" onclick="document.getElementById('captcha').src = '<?php $captcha = new \Helpers\RainCaptcha(); echo $captcha->getImage(); ?>&morerandom=' + Math.floor(Math.random() * 10000);">Get another CAPTCHA image</button>
            </div>
            <div class="col-xs-6">
                <img id ="captcha" class="img-thumbnail" src= <?= $data['captcha_url'] ?>>
            </div>
        </div>
        <input class="form-control btn btn-primary" type="submit" value="Register">

    </form>
</div>