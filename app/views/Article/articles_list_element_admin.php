<tr>
    <td><?= $data['art_title'] ?></td>
    <td><?= $data['art_author']?></td>
    <td><?= $data['art_creation_date']?></td>
    <td><?= $data['art_update_date']?></td>
    <td><?= $data['art_reader_counter']?></td>

    <td>
        <form method="post">
            <input type="hidden" name="art_id" value="<?= $data['art_id']?>"/>
            <button class="btn btn-info" type="submit" formaction="article_details"> Read</button>
            <button class="btn btn-warning" type="submit" formaction="article_update_form" >Update</button>
            <button class="btn btn-danger" type="submit" formaction="article_delete" >Delete</button>
        </form>
    </td>
</tr>