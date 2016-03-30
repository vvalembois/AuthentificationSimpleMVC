<div>
    <h3>Users list</h3>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">Stats : </h4>
        </div>
        <div class="panel-body">
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th class="header">Information</th>
                        <th class="header">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total account</td>
                        <td><?= $data['count_users'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">Users : </h4>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th class="header">Name</th>
                        <th class="header">Email</th>
                        <th class="header">Rights level</th>
                        <th class="header">Actions</th>
                    </tr>
                </thead>
                <tbody>