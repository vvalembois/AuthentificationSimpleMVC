<tr>
    <td><?= $data['user_name'] ?></td>
    <td><?= $data['user_email'] ?></td>
    <td>
        <form action="/authentifier/admin/users_management_panel_action" method="post">
            <input type="hidden" name="user_id" value="<?= $data['user_id']?>"/>
            <button class="btn btn-info" type="submit" name="action" value="details">Details</button>
            <button class="btn btn-warning" type="submit" name="action" value="update">Update</button>
            <button class="btn btn-danger" type="submit" name="action" value="delete">Delete</button>
        </td>
    </form>

</tr>