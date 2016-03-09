<?php
use Helpers\Session;
use Modules\Authentifier\Helpers\Feedback;
$feedback = Session::get('feedback');
?>

<?php if (isset($feedback) && $feedback->count() > 0) { ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Warning</h3>
        </div>
        <div class="panel-body">
            <ul>
                <?php foreach ($feedback->get() as $info) {
                    echo "<li>" . $info . "</li>";
                }?>
            </ul>
        </div>
    </div>
<?php } ?>

<?php if (isset($feedback) && $feedback->count('good') > 0) { ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Information</h3>
        </div>
        <div class="panel-body">
            <ul>
                <?php foreach ($feedback->get('good') as $info) {
                    echo "<li>" . $info . "</li>";
                }?>
            </ul>
        </div>
    </div>
<?php } ?>

