<h1>User Details</h1>
<div class="row">
    <section class="col-xs-12">
        <ul class="list-group">
            <li class="list-group-item">Name : <?= $data['user_name'] ?></li>
            <li class="list-group-item">Email : <?= $data['user_email'] ?></li>
            <li class="list-group-item">Register time : <?= $data['time_register'] ?></li>
            <li class="list-group-item">Administrator level : <?= $data['user_account_type'] ?></li>
            <li class="list-group-item">Compte actif : <?= $data['user_active'] ?></li>
            <li class="list-group-item">Last connection : <?= $data['user_last_login_timestamp'] ?></li>
            <li class="list-group-item">Suspension : <?= $data['user_suspension_timestamp'] ?></li>
            <li class="list-group-item">Temps d'attente après erreur de log : <?= $data['user_failed_logins'] ?></li>
            <li class="list-group-item">Temps depuis le derniere echec (??) : <?= $data['user_last_failed_logins'] ?></li>
        </ul>
    </section>
 </div>