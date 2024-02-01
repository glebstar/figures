<?php

use App\Controllers\HomeController;

const ROOT_DIR = __DIR__ . '/../';

// загружаем конфиги
require_once ROOT_DIR . 'cfg/config.php';
error_reporting($mainCfg['error_level']);
ini_set('display_errors', $mainCfg['display_errors']);

// загружаем PSR-4
require_once ROOT_DIR . 'vendor/autoload.php';

$c = new HomeController();

if (isset($_GET['action'])) {
    if (method_exists($c, $_GET['action'])) {
        $action = $_GET['action'];
        echo $c->$action();
    } else {
        return $c->action404();
    }
} else {
    return $c->index($mainCfg['script_version']);
}
