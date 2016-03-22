<div class="row">


    <p></p>
<form class="form-inline col-xs-8 col-xs-offset-2 form-group-sm" action="/authentifier/admin/users_management_delete_action" method="post">

    <input type="hidden" name="user_id" value="<?= $data['user_id'] ?>"/>
    <label for="confirmed">You are about to remove the user <?= $data['user_name'] ?>, are you sure?</label>
    <button class="form-control btn btn-danger" type="submit" name="confirmed" value="true">Confirm</button>
    <button class="form-control btn btn-default" type="submit" name="confirmed" value="false">Cancel</button>
    </form>
</div>