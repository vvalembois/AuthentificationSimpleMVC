<div class="row">
    <section class="col-xs-4">
        <img id="avatar" class="img img-thumbnail" src="<?= $data['user_avatar'] ?>" alt="User's avatar" />
    </section>
    <section class="col-xs-8">
        <ul class="list-group">
            <li class="list-group-item">Name : <?= $data['user_name'] ?></li>
            <li class="list-group-item">Email : <?= $data['user_email'] ?></li>
            <li class="list-group-item">Last connection : <?= $data['last_connection'] ?></li>
            <li class="list-group-item">Register time : <?= $data['time_register'] ?></li>
            <li class="list-group-item">Administrator level : <?= $data['user_account_type'] ?></li>
        </ul>
    </section>
</div>