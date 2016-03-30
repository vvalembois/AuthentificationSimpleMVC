<input type="hidden" name="art_id" value="<?= $data['art_id']?>"/>
<div class="row">
    <section class="col-xs-12">
        <h3><?= $data['art_title'] ?></h3>


            <article class="col-xs-12 col-sm-9">Content : <?= $data['art_content'] ?></article>
        <aside class="col-xs-12 col-sm-3">
            <ul>
                <li class="list-group-item">Author : <?= $data['art_author'] ?></li>
                <li class="list-group-item">Creation date : <?= $data['art_creation_date'] ?></li>
                <li class="list-group-item">Last update date : <?= $data['art_update_date'] ?></li>
                <li class="list-group-item">Count of reading: <?= $data['art_reader_counter'] ?></li>
            </ul>
        </aside>
    </section>
</div>