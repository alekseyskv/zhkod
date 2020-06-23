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
    <link rel="stylesheet" href="/assets/css/admin.css">
    <title><?= $title ?></title>
    <?= $styles ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/admin">Панель управления</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Кодекс</a>
                    <div class="dropdown-menu">
                          <a class="dropdown-item" href="/admin/article">Статьи</a>
                          <a class="dropdown-item" href="/admin/heading">Оглавление</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/comment">Комметарии</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/page">Страницы</a>
                </li>
            </ul>
            <ul class="navbar-nav nav">
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Пользователь</a>
                    <div class="dropdown-menu">
                        <!--<a class="dropdown-item" href="/admin/default/index">Админка</a>
                        <a class="dropdown-item" href="/cabinet/default/index">Личный кабинет</a>
                        <div class="dropdown-divider"></div>-->
                        <a class="dropdown-item" href="/logout">Выход</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
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