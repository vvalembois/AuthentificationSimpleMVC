<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="update_action" method="post">
        <label for="art_title">Title :</label>
        <input class="form-control" type="text" id="art_title" name="art_title" value='<?= $data['art_title']?>' autocomplete="off" placeholder="Type your title ..."/>

        <label for="art_content">Content :</label>
        <textarea class="form-control" rows="5" id="art_content" name="art_content" autocomplete="off" placeholder="Type your content..." required><?= $data['art_content']?></textarea>
        <br/>
        <input class="form-control btn btn-primary" type="submit" value="Update">

    </form>
</div>
