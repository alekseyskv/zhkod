<?php ob_start() ?>
    <script src="/assets/ckeditor/4.14.0/standard/ckeditor.js"></script>
<?php $styles = ob_get_clean() ?>


<?php ob_start() ?>
    <h2><?= $title ?></h2>
    <form action="/admin/comment/save" method="post">
        <input type="hidden" name="id" value="<?= $comment['id'] ?>">
        <div class="form-group">
            <label for="article_id">Статья кодекса</label>
            <select class="form-control" id="article_id" name="article_id">
                <?php foreach ($articles as $article) : ?>
                <option value="<?= $article['id'] ?>" <?= ($article['id'] == $comment['article_id']) ? 'selected' : '' ?>><?= $article['title'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $comment['title'] ?>">
        </div>
        <div class="form-group">
            <label for="content">Текст</label>
            <textarea class="form-control" id="content" name="content"><?= $comment['content'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="note">Примечание</label>
            <input type="text" class="form-control" id="note" name="note" value="<?= $comment['note'] ?>">
        </div>
        <div class="form-group">
            <label for="date_begin">Актуально с</label>
            <input type="date" class="form-control" id="date_begin" name="date_begin" value="<?= $comment['date_begin'] ?>">
        </div>
        <div class="form-group">
            <label for="date_end">Актуально по</label>
            <input type="date" class="form-control" id="date_end" name="date_end" value="<?= $comment['date_end'] ?>">
        </div>
        <div class="form-group">
            <label for="author_name">Автор</label>
            <input type="text" class="form-control" id="author_name" name="author_name" value="<?= $comment['author_name'] ?>">
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