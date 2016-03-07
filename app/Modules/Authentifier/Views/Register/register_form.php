<form action="/authentifier/registerAction" method="post">
    <label for="nom">Nom :</label>
    <input type="text" id="user_name" name="user_name"/>

    <label for="courriel">Adresse mail :</label>
    <input type="email" id="user_mail" name="user_mail"/>

    <label for="courriel">Répétez votre adresse mail :</label>
    <input type="email" id="user_mail_repeat" name="user_mail_repeat"/>

    <label for="courriel">Mot de passe :</label>
    <input type="password" id="user_password" name="user_password"/>

    <label for="courriel">Répétez votre mot de passe :</label>
    <input type="password" id="user_password_repeat" name="user_password_repeat"/>

    <label for="courriel">Recopiez le texte de l'image :</label>
    <img src= <?= $data['captcha_url'] ?>>
    <input type="text" id="user_captcha" name="user_captcha"/>

    <div class="button">
        <button type="submit">Envoyer </button>
    </div>

</form>