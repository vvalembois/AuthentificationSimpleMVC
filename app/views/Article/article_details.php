<input type="hidden" name="art_id" value="<?= $data['art_id']?>"/>
<div class="row">
    <section class="col-xs-12">
        <ul class="list-group">
            <li class="list-group-item">Title : <?= $data['art_title'] ?></li>
            <li class="list-group-item">Content : <?= $data['art_content'] ?></li>
            <li class="list-group-item">Id Author : <?= $data['art_author'] ?></li>
            <li class="list-group-item">Creation Date : <?= $data['art_creation_date'] ?></li>
            <li class="list-group-item">Update Date : <?= $data['art_update_date'] ?></li>
            <li class="list-group-item">How many people read this article : <?= $data['art_reader_counter'] ?></li>
            <br>
        </ul>
    </section>
</div>