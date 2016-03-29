<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="/authentifier/admin/users_management_update_action" method="post">
        <input type="hidden" name="user_id" value="<?= $data['user_id'] ?>"/>

        <label for="user_name">Username :</label>
        <input class="form-control" type="text" id="user_name" name="user_name" value='<?= $data['user_name']?>' autocomplete="off" placeholder="Type your name ..."/>

        <label for="user_mail">Email adress:</label>
        <input class="form-control" type="email" id="user_mail" name="user_mail" value='<?= $data['user_email']?>' autocomplete="off" placeholder="Type your email ..."/>

        <label for="user_new_password">New password:</label>
        <input class="form-control" min="4" type="password" id="user_new_password" name="user_new_password"  value='<?= $data['user_new_password']?>' autocomplete="off" placeholder="Type your new password ..."/>

        <label for="user_new_account_type">New account type:</label>
        <input class="form-control" type="text" id="user_new_account_type" name="user_new_account_type"  value='<?= $data['user_new_account_type']?>' autocomplete="off" placeholder="Type your account type ..."/>

        <label for="user_new_suspension_timestamp">New suspension time:</label>
        <input class="form-control" type="text" id="user_new_suspension_timestamp" name="user_new_suspension_timestamp"  value='<?= $data['user_new_suspension_timestamp']?>' autocomplete="off" placeholder="Type your suspension ..."/>

        <br/>
        <input class="form-control btn btn-primary" type="submit" value="Update">

    </form>
</div>