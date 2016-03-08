<form action="/authentifier/registerAction" method="post">
    <label for="user_name">Nom :</label>
    <input type="text" id="user_name" name="user_name"/>

    <label for="user_mail">Adresse mail :</label>
    <input type="email" id="user_mail" name="user_mail"/>

    <label for="user_mail_repeat">Répétez votre adresse mail :</label>
    <input type="email" id="user_mail_repeat" name="user_mail_repeat"/>

    <label for="user_password">Mot de passe :</label>
    <input type="password" id="user_password" name="user_password"/>

    <label for="user_password_repeat">Répétez votre mot de passe :</label>
    <input type="password" id="user_password_repeat" name="user_password_repeat"/>

    <label for="user_captcha">Recopiez le texte de l'image :</label>
    <img src= <?= $data['captcha_url'] ?>>
    <input type="text" id="user_captcha" name="user_captcha"/>

    <div class="button">
        <button type="submit">Envoyer</button>
    </div>

</form>