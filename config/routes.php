<?php

declare(strict_types=1);


use SwooleGin\Gin\Context\Context;
use SwooleGin\Gin\Context\ContextHandlerFuncInterface;
use SwooleGin\Utils\HTTPStatus;

return [
    'get' => [
        '/' => (new class implements ContextHandlerFuncInterface {
            public function __invoke(Context $context): void
            {
                $context->Raw(HTTPStatus::StatusOK, 'Hello World');
            }
        }),
    ],
    'post' => [
        '/' => (new class implements ContextHandlerFuncInterface {
            public function __invoke(Context $context): void
            {
                $context->Raw(HTTPStatus::StatusOK, sprintf('Hello World, %s',
                    $context->request->getBody()->getContents()));
            }
        }),
    ]

];