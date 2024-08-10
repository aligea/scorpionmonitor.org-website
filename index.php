<?php
session_start();
//session_cache_limiter(false);
//error_reporting(E_USER_DEPRECATED);
//require 'libraries/class/izyredbean.php';
require 'libraries/Slim-2.6.2/Slim/Slim.php';
require 'config.php';
require 'modules/AppModules.php';

$app = new \Slim\Slim();
$app->config('debug', true);
$app->log->setEnabled(true);
$app->error(function (\Exception $e) use ($app) {
    $app->halt(500, $e->getMessage());
});

$app->hook('slim.before', 'AppModules::init_helpers');
$app->hook('slim.before', 'AppModules::init_models');
$app->hook('slim.before', 'AppModules::init_controllers');
$app->hook('slim.before', 'AppModules::init_routers');

$app->run();
?>
