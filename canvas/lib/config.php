<?php

// Files needed for base functionality

global $config;

unset($config);

$config = array(
    'foo' => 'bar',
);

#require_once dirname(__FILE__) . '/../config_private.php';
require_once 'AppInfo.php';
require_once 'router.php';
require_once 'controller.php';
require_once 'model.php';
