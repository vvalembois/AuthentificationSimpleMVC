<tr class="alert-warning">
    <td><?= $data['user_name'] ?></td>
    <td><?= $data['user_email'] ?></td>
    <td><?= $data['user_account_type']?></td>
    <td>
        <form action="/authentifier/admin/users_management_panel_action" method="post">
            <input type="hidden" name="user_id" value="<?= $data['user_id']?>"/>
            <button class="btn btn-info" type="submit" name="action" value="details" disabled>Details</button>
            <button class="btn btn-warning" type="submit" name="action" value="update" disabled>Update</button>
            <button class="btn btn-danger" type="submit" name="action" value="delete" disabled>Delete</button>
        </form>
    </td>

</tr>