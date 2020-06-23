<?php ob_start() ?>
    <h3><?= $title ?></h3>
    <p>
        <a href="/admin/comment/edit" class="btn btn-primary">Новый комментарий</a>
    </p>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Статья</th>
            <th scope="col">Заголовок</th>
            <th scope="col">Автор</th>
            <th scope="col">Актуально с</th>
            <th scope="col">Актуально по</th>
            <th scope="col">Примечание</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?= $comment['number'] ?></td>
                <td><?= $comment['title'] ?></td>
                <td><?= $comment['author_name'] ?></td>
                <td><?= $comment['date_begin'] ?></td>
                <td><?= $comment['date_end'] ?></td>
                <td><?= $comment['note'] ?></td>
                <td><a href="/admin/comment/edit?id=<?= $comment['id'] ?>"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php ob_start() ?>
<?php $scripts = ob_get_clean() ?>

<?php include 'layout.php' ?>