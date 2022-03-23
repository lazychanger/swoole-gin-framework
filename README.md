# swoole-gin-framework

teaching repository

## How to install

```shell
$ composer create-project lazychanger/swoole-gin-framework
```

## How to use

```php
<?php
declare(strict_types=1);

class HelloAction implements \SwooleGin\HandlerFuncInterface
{

    public function __invoke(\Psr\Http\Message\ResponseInterface $rw, \Psr\Http\Message\RequestInterface $req)
    {
        $rw->withBody(new \SwooleGin\Stream\StringStream('Hello World'));
        return $rw;
    }
}
```