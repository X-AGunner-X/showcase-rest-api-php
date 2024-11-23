<?php

use App\Components\Application\Bootstrap;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/define.php';

$bootstrap = new Bootstrap();
$bootstrap->createSlimApi($bootstrap->buildContainer())->run();
