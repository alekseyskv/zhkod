<?php
$parent = '';
$section = '';
?>
<?php ob_start() ?>
<?php foreach ($articles as $article) : ?>
    <?php if ($section != $article['section_number']) : ?>
        <h3 class="text-center"><?= $article['section_title'] ?></h3>
        <p><?= $article['section_note'] ?></p>
        <?php $section = $article['section_number']; ?>
    <?php endif; ?>
    <?php if ($parent != $article['parent_number'] && $article['parent_title'] != $article['section_title']) : ?>
        <h5><?= $article['parent_title'] ?></h5>
        <p><?= $article['parent_note'] ?></p>
        <?php $parent = $article['parent_number']; ?>
    <?php endif; ?>
    <p><a href="/code/<?= $article['section_number'] ?>/<?= $article['number'] ?>/"><?= $article['title'] ?></a></p>
<?php endforeach; ?>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
