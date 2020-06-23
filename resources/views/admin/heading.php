<?php ob_start() ?>

    <h2><?= $title ?></h2>
    <form action="/admin/heading/save" method="post">
        <input type="hidden" name="id" value="<?= $heading['id'] ?>">
        <div class="form-group">
            <label for="number">Номер</label>
            <input type="text" class="form-control" id="number" name="number" value="<?= $heading['number'] ?>">
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $heading['name'] ?>">
        </div>
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $heading['title'] ?>">
        </div>
        <div class="form-group">
            <label for="note">Примечание</label>
            <input type="text" class="form-control" id="note" name="note" value="<?= $heading['note'] ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?= $heading['description'] ?>">
        </div>
        <div class="form-group">
            <label for="keywords">Keywords</label>
            <input type="text" class="form-control" id="keywords" name="keywords" value="<?= $heading['keywords'] ?>">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>