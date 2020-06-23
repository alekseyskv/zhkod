<?php ob_start() ?>
    <h3><?= $title ?></h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Заголовок</th>
            <th scope="col">Примечание</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($headings)) : ?>
        <?php foreach ($headings as $heading): ?>
            <tr>
                <td><?= $heading['parent_id'] ? '' : $heading['number'] ?></td>
                <td><?= $heading['title'] ?></td>
                <td><?= $heading['note'] ?></td>
                <td><a href="/admin/heading/edit?id=<?= $heading['id'] ?>"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i></a></td>
            </tr>
        <?php endforeach; ?>
        <?php endif ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php ob_start() ?>

<?php $scripts = ob_get_clean() ?>



<?php include 'layout.php' ?>