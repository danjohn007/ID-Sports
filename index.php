<?php
define('ROOT', __DIR__);
require_once ROOT . '/config/config.php';

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/core/Model.php';
require_once ROOT . '/core/View.php';
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/core/App.php';

foreach (glob(ROOT . '/app/models/*.php') as $model) {
    require_once $model;
}

$app = new App();
