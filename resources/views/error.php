<?php ob_start() ?>
<h1><?= $message ?></h1>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
