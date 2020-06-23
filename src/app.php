<?php

use App\Application;
use App\Config\Config;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;

define('BASEPATH', dirname(__DIR__));

$app = Application::getInstance(BASEPATH);

$config = new Config(BASEPATH . '/config');
//$config->addConfig('app.yaml');
$app->add('config', $config);

try {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = DriverManager::getConnection(
        require BASEPATH . '/config/database.php',
        new Configuration()
    );
} catch (DBALException $e) {
    exit($e->getMessage());
}

$app->add('db', $db);

//dd($config->get('database'));

return $app;