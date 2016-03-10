<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="/authentifier/registerAction" method="post">
        <label for="user_name">Nom :</label>
        <input class="form-control" type="text" id="user_name" name="user_name" value='<?= $data['user_name']?>' autocomplete="off" placeholder="Saisissez votre nom ..." required/>

        <label for="user_mail">Adresse mail :</label>
        <input class="form-control" type="email" id="user_mail" name="user_mail" value='<?= $data['user_mail']?>' autocomplete="off" placeholder="Saisissez votre adresse mail ..." required/>

        <label for="user_mail_repeat">Répétez votre adresse mail :</label>
        <input class="form-control" type="email" id="user_mail_repeat" name="user_mail_repeat" value='<?= $data['user_mail_repeat']?>' autocomplete="off" placeholder="Retapez votre adresse mail (verification) ..." required/>

        <label for="user_password">Mot de passe :</label>
        <input class="form-control" min="4" type="password" id="user_password" name="user_password"  value='<?= $data['user_password']?>' autocomplete="off" placeholder="Saisissez votre mot de passe ..." required/>

        <label for="user_password_repeat">Répétez votre mot de passe :</label>
        <input class="form-control" type="password" id="user_password_repeat" name="user_password_repeat" value='<?= $data['user_password_repeat']?>' value='<?= $data['user_']?>' autocomplete="off" placeholder="Retapez votre mot de passe ..." required/>

        <br/>
        <img class="col-xs-4 col-xs-offset-4 img-thumbnail" src= <?= $data['captcha_url'] ?>>
        <label class=" col-xs-offset-4" for="user_captcha">Recopiez le texte de l'image :</label>
        <input class="form-control" type="text" id="user_captcha" name="user_captcha" autocomplete="off" placeholder="Saisissez le texte de l'image ..." required/>

        <br/>
        <input class="form-control btn btn-primary" type="submit" value="S'inscrire">

    </form>
</div>