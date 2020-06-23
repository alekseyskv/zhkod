<?php ob_start() ?>
    <script src="/assets/ckeditor/4.14.0/standard/ckeditor.js"></script>
<?php $styles = ob_get_clean() ?>


<?php ob_start() ?>

    <h2><?= $title ?></h2>
    <form action="/admin/page/save" method="post">
        <input type="hidden" name="id" value="<?= $page['id'] ?>">
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $page['title'] ?>">
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control" id="url" name="url" value="<?= $page['url'] ?>">
        </div>
        <div class="form-group">
            <label for="content">Текст страницы</label>
            <textarea class="form-control" id="content" name="content"><?= $page['content'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?= $page['description'] ?>">
        </div>
        <div class="form-group">
            <label for="keywords">Keywords</label>
            <input type="text" class="form-control" id="keywords" name="keywords" value="<?= $page['keywords'] ?>">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php $content = ob_get_clean() ?>

<?php ob_start() ?>
    <script>
        CKEDITOR.replace('content');
    </script>
<?php $scripts = ob_get_clean() ?>

<?php include 'layout.php' ?>