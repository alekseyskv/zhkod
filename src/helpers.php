<?php

use App\Application;
use App\Config\Config;

if (!function_exists('app')) {
    /**
     * @return Application
     */
    function app() {
        return App\Application::getInstance(BASEPATH);
    }
}

if (!function_exists('db')) {
    /**
     * @return \Doctrine\DBAL\Connection
     */
    function db() {
        return app()->get('db');
    }
}

if (!function_exists('config')) {
    /**
     * @return mixed
     */
    function config($keyValue) {
        /** @var Config $config */
        $config = app()->get('config');
        return $config->get($keyValue);
    }
}