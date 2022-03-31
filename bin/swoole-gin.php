<?php

declare(strict_types=1);

use SwooleGin\Gin\Context\Context;
use SwooleGin\Gin\Context\ContextHandlerFuncInterface;
use SwooleGin\Gin\Gin;
use SwooleGin\Gin\Middleware\FaviconMiddleware;
use SwooleGin\Options;
use SwooleGin\Server;
use SwooleGin\Utils\HTTPStatus;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('memory_limit', '1G');

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

!defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
!defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

require BASE_PATH . '/vendor/autoload.php';

$routes = require BASE_PATH . '/config/routes.php';


$servOpts = new Options();
$servOpts->setAddr('0.0.0.0:8082');

$serv = new Server($servOpts);

$engine = new Gin();

$engine->use((new FaviconMiddleware));

$engine->GET('/hello', (new class implements ContextHandlerFuncInterface {
    public function __invoke(Context $context)
    {
        $context->Raw(HTTPStatus::StatusOK, 'hello world');
    }
}));

foreach ($routes as $method => $handlers) {
    foreach ($handlers as $path => $handler) {
        $engine->{strtoupper($method)}($path, $handler);
    }
}

$engine->setOnNotFound((new class implements ContextHandlerFuncInterface {
    public function __invoke(Context $context)
    {
        $context->JSON(HTTPStatus::StatusOK, ['code' => HTTPStatus::StatusNotFound, 'msg' => 'not found']);
    }

}));

$serv->setHandler($engine);
$serv->serve();