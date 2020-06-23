<?php ob_start() ?>
    <h3><?= $title ?></h3>
    <p>
        <a href="/admin/page/edit" class="btn btn-primary">Новая страница</a>
    </p>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Заголовок</th>
            <th scope="col">URL</th>
            <th scope="col"><i class="fa fa-eye" aria-hidden="true"></i></th>
            <th scope="col">Description</th>
            <th scope="col">Keywords</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pages as $page): ?>
            <tr>
                <td><?= $page['id'] ?></td>
                <td><?= $page['title'] ?></td>
                <td><?= $page['url'] ?></td>
                <td><?= $page['views'] ?></td>
                <td><?= $page['description'] ? 'Есть' : 'Нет' ?></td>
                <td><?= $page['keywords'] ? 'Есть' : 'Нет' ?></td>
                <td><a href="/admin/page/edit?id=<?= $page['id'] ?>"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php ob_start() ?>

<?php $scripts = ob_get_clean() ?>

<?php include 'layout.php' ?>