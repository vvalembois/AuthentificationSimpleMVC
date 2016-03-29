<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="/authentifier/loginAction" method="post">

        <div class="form-group col-xs-12">
            <div class="col-xs-12">
            <label for="user_name">User name :</label>
            <input class="form-control" type="text" name="user_name" placeholder="Type your user name"/>
</div>
            <div class="col-xs-12">
            <label for="user_password">Password :</label>
            <input class="form-control" type="password" name="user_password" placeholder="Type your password"/>
        </div></div>

        <div class="form-group col-xs-12">
            <div class="col-xs-8">
                <label for="remember_me">Remember me  (you accept the use of cookies) : </label>
                <input class="form-constrol" type="checkbox" name="remember_me" value="false"/>
            </div>
            <div class="col-xs-4">
                <input class="form-control btn-primary" type="submit" value="Login"/>
            </div>
        </div>
    </form>
</div>