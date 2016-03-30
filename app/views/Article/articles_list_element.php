<tr>
    <td><?= $data['art_title'] ?></td>
    <td><?= $data['art_content'] ?></td>
    <td><?= $data['art_author']?></td>
    <td><?= $data['art_creation_date']?></td>
    <td><?= $data['art_update_date']?></td>
    <td><?= $data['art_reader_counter']?></td>

    <td>
        <form method="post">
            <input type="hidden" name="art_id" value="<?= $data['art_id']?>"/>
            <button class="btn btn-info" type="submit" formaction="article_details"> Details</button>
        </form>
    </td>
</tr>