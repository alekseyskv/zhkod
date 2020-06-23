<?php
/** @var string $title */
$title = isset($title) ? $title : '';
/** @var string $styles */
$styles = isset($styles) ? $styles : '';
/** @var string $scripts */
$scripts = isset($scripts) ? $scripts : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/site.css">
    <title><?= $title ?></title>
    <?= $styles ?>
</head>
<body>
<div class="layout">
    <div class="container">
        <?= $content ?>
    </div>
</div>
<script src="/assets/jquery/3.4.1/jquery-3.4.1.slim.min.js"></script>
<script src="/assets/popper/1.16.0/popper.min.js"></script>
<script src="/assets/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<?= $scripts ?>
</body>
</html>