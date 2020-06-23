<?php ob_start() ?>
    <script src="/assets/ckeditor/4.14.0/standard/ckeditor.js"></script>
<?php $styles = ob_get_clean() ?>


<?php ob_start() ?>

    <h2><?= $title ?></h2>
    <form action="/admin/article/save" method="post">
        <input type="hidden" name="id" value="<?= $article['id'] ?>">
        <div class="form-group">
            <label for="number">Номер статьи</label>
            <input type="text" class="form-control" id="number" name="number" value="<?= $article['number'] ?>">
        </div>
        <div class="form-group">
            <label for="name">Название статьи</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $article['name'] ?>">
        </div>
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $article['title'] ?>">
        </div>
        <div class="form-group">
            <label for="note">Примечание</label>
            <input type="text" class="form-control" id="note" name="note" value="<?= $article['note'] ?>">
        </div>
        <div class="form-group">
            <label for="content">Текст статьи</label>
            <textarea class="form-control" id="content" name="content"><?= $article['content'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?= $article['description'] ?>">
        </div>
        <div class="form-group">
            <label for="keywords">Keywords</label>
            <input type="text" class="form-control" id="keywords" name="keywords" value="<?= $article['keywords'] ?>">
        </div>
        <div class="form-group">
            <label for="updated">Дата обновления</label>
            <input type="text" readonly class="form-control-plaintext" id="updated" value="<?= $article['updated'] ?>">
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