<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="/authentifier/loginAction" method="post">

        <label for="user_name">Nom d'utilisateur ou adresse mail :</label>
        <input class="form-control" type="text" name="user_name" placeholder="Type your login"/>

        <label for="user_password">Mot de passe :</label>
        <input class="form-control" type="password" name="user_password" placeholder="Type your password"/>

        <br/>
        <input class="form-control btn-primary" type="submit" value="Se connecter"/>
    </form>
</div>