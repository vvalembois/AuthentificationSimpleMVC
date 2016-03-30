<div class="row">
    <form class="col-xs-8 col-xs-offset-2 form-group-sm" action="article_creation_action" method="post">
        <label for="art_title">Title :</label>
        <input class="form-control" type="text" id="art_title" name="art_title" value='<?= $data['art_title']?>' autocomplete="off" placeholder="Type your title..." required/>

        <label for="art_content">Content :</label>
        <input class="form-control" type="text" id="art_content" name="art_content" value='<?= $data['art_content']?>' autocomplete="off" placeholder="Type your content..." required/>

        <br>

        <input class="form-control btn btn-primary" type="submit" value="Register">

    </form>
</div>