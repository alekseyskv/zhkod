<?php

use App\Controller\AdminController;
use App\Controller\CodeController;
use App\Controller\PageController;
use App\Controller\IndexController;
use App\Controller\InstallController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('index_route', '/')
        ->controller([IndexController::class, 'indexAction']);

    $routes->add('login_route', '/login')
        ->controller([IndexController::class, 'loginAction'])
        ->methods(['GET', 'POST']);

    $routes->add('pager_route', '/pager/{alias}')
        ->controller([PageController::class, 'showAction'])
        ->defaults(['alias' => 'pager-default-value']);

//    $routes->add('page_route', '/{page}')
//        ->controller([IndexController::class, 'pageAction']);


    $routes->add('code_route', '/code/')
        ->controller([CodeController::class, 'showAction']);
    $routes->add('index_code_route', '/code/index.htm')
        ->controller([CodeController::class, 'showAction']);

    $routes->add('section_code_route', '/code/{section}/')
        ->controller([CodeController::class, 'showSectionAction']);
    $routes->add('index_section_code_route', '/code/{section}/index.htm')
        ->controller([CodeController::class, 'showSectionAction']);

    $routes->add('article_code_route', '/code/{section}/{article}/')
        ->controller([CodeController::class, 'showArticleAction']);
    $routes->add('index_article_code_route', '/code/{section}/{article}/index.htm')
        ->controller([CodeController::class, 'showArticleAction']);



    $routes->add('install_route', '/install/{action}')
        ->controller([InstallController::class, 'indexAction']);











    $routes->add('admin_index_route', '/admin')
        ->controller( [AdminController::class, 'indexAction']);

    $routes->add('admin_page_route', '/admin/page/{action}')
        ->controller( [AdminController::class, 'pageAction'])
        ->defaults(['action' => 'list']);

    $routes->add('admin_article_route', '/admin/article/{action}')
        ->controller( [AdminController::class, 'articleAction'])
        ->defaults(['action' => 'list'])
        ->methods(['GET', 'POST']);

    $routes->add('admin_heading_route', '/admin/heading/{action}')
        ->controller( [AdminController::class, 'headingAction'])
        ->defaults(['action' => 'list'])
        ->methods(['GET', 'POST']);

    $routes->add('admin_comment_route', '/admin/comment/{action}')
        ->controller( [AdminController::class, 'commentAction'])
        ->defaults(['action' => 'list']);
};