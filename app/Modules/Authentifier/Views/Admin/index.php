<?php $users = $data['users'];?>

<div>
    <h3>Liste des utilisateurs</h3>

    <?php if (!empty($users)) { ?>
    <table class="table">
        <tr>
            <td class="header">Name</td>
            <td class="header">Email</td>
        </tr>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php if (isset($user->user_name)) {
                        echo $user->user_name;
                    } ?></td>
                <td><?php if (isset($user->user_email)) {
                        echo $user->user_email;
                    } ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php }?>
</div>
