<?php ob_start() ?>
    <a href="/code/<?= $section['number'] ?>/"><?= $section['title'] ?></a>
    <h3><?= $article['title'] ?></h3>
    <?= $article['content'] ?>

<?php if ($comments) : ?>
    <h3>Комментарии к статье</h3>
    <hr>
    <?php foreach ($comments as $comment) : ?>
        <?= $comment['title'] ?>
        <?= $comment['content'] ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
