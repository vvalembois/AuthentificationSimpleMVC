<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="/authentifier/profileUpdateAction" method="post">
        <label for="user_name">Username :</label>
        <input class="form-control" type="text" id="user_name" name="user_name" value='<?= $data['user']['user_name']?>' autocomplete="off" placeholder="Saisissez votre nom ..."/>

        <label for="user_mail">Email adress:</label>
        <input class="form-control" type="email" id="user_mail" name="user_mail" value='<?= $data['user']['user_email']?>' autocomplete="off" placeholder="Saisissez votre adresse mail ..."/>

        <label for="user_new_password">New password:</label>
        <input class="form-control" min="4" type="password" id="user_new_password" name="user_new_password"  value='<?= $data['user_new_password']?>' autocomplete="off" placeholder="Saisissez votre nouveau mot de passe ..."/>

        <label for="user_new_password_repeat">New password repeat:</label>
        <input class="form-control" type="password" id="user_new_password_repeat" name="user_new_password_repeat" value='<?= $data['user_new_password_repeat']?>' value='<?= $data['user_']?>' autocomplete="off" placeholder="Retapez votre nouveau mot de passe ..."/>


        <label for="user_password">Old password :</label>
        <input class="form-control" min="4" type="password" id="user_password" name="user_password"  value='<?= $data['user_password']?>' autocomplete="off" placeholder="Saisissez votre ancien mot de passe ..." required/>

        <br/>
        <input class="form-control btn btn-primary" type="submit" value="Effectuer les modifications">

    </form>
</div>