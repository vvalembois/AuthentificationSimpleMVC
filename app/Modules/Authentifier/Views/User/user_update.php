<form action="/modifier/profileAction" method="post">
    <label for="user_name">Nom :</label>
    <input type="text" id="user_name" name="user_name" value=<?= $data['user']['user_name'] ?>/>

    <label for="user_mail">Adresse mail :</label>
    <input type="email" id="user_mail" name="user_mail" value=<?= $data['user']['user_mail'] ?> />

    <label for="user_mail_repeat">Répétez votre adresse mail :</label>
    <input type="email" id="user_mail_repeat" name="user_mail_repeat" value=<?= $data['user']['user_mail_repeat'] ?>/>

    <label for="user_password">Mot de passe :</label>
        <ul>
            <li><input type="password" id="new_password" name="new_password" value="nouveau mot de passe"]/></li>
            <li><input type="password" id="new_password_repeat" name="new_password_repeat" value="Repeter votre nouveau mot de passe"]/></li>
        </ul>

    <label for="user_password_repeat">Mot de passe Actuel :</label>
         <input type="password" id="user_password" name="user_password" value=<?= $data['user']['user_password'] ?>/>

    <div class="button">
        <button type="submit">Envoyer</button>
    </div>

</form>