<?php

$mainCfg = [
    'db' => [
        'dbname'    => 'figures',
        'host'      => 'mysql',
        'user'      => 'root',
        'password'  => 'root'
    ],
    'error_level'           => E_ALL,
    'display_errors'        => 'Off',
    'script_version'        => 20,
];

if (file_exists(ROOT_DIR . 'cfg/config.local.php')) {
    require_once ROOT_DIR . 'cfg/config.local.php';
}