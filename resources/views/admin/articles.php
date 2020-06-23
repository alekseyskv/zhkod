<?php ob_start() ?>
    <h3><?= $title ?></h3>
    <div class="card">
        <div class="card-body">
            <p><i class="fa fa-info-circle" aria-hidden="true"></i> Для загрузки необходимо использовать RTF-файл от Консультант+</p>
            <form action="/admin/article/upload" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputFile"  name="codex-file" lang="ru">
                        <label class="custom-file-label" for="inputFile">Выберите файл</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Статья</th>
            <th scope="col">Обновлено</th>
            <th scope="col"><i class="fa fa-eye" aria-hidden="true"></i></th>
            <th scope="col">Description</th>
            <th scope="col">Keywords</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article['title'] ?></td>
            <td><?= $article['updated'] ?></td>
            <td><?= $article['views'] ?></td>
            <td><?= $article['description'] ? 'Есть' : 'Нет' ?></td>
            <td><?= $article['keywords'] ? 'Есть' : 'Нет' ?></td>
            <td><a href="/admin/article/edit?id=<?= $article['id'] ?>"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i></a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean() ?>

<?php ob_start() ?>
    <script src="/assets/js/bs-custom-file-input.min.js"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })
    </script>
<?php $scripts = ob_get_clean() ?>



<?php include 'layout.php' ?>