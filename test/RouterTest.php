<?php

use PHPUnit\Framework\TestCase;

use Router\Router;

class RouterTest extends TestCase {
    private $router;
    private $supported_methods = [
        'get',
        'post',
        'put',
        'delete'
    ];

    public function setUp() : void {
        $this->router = new Router;
    }

    /** @test */
    public function test_needs_two_arguments() {
        $this->expectExceptionMessage('Required arguments $uri and $callback not provided');

        $this->router->get();
    }

    /** @test */
    public function uri_must_be_string() {
        $this->expectExceptionMessage('First argument $uri must be of type string');

        $this->router->get(8, function() {});
    }

    /** @test */
    public function callback_must_be_callback() {
        $this->expectExceptionMessage('Second argument $callback must a callback');

        $this->router->get('/uri', 'sdfkljh');
    }

    /** @test */
    public function can_add_function_routes() {
        foreach($this->supported_methods as $method) {
            $this->router->$method('/test', function () use($method) {
                return $method . ' route';
            });

            $this->assertEquals($method . ' route', $this->router->run($method, '/test'));
        }
    }

    /** @test */
    public function can_add_invokable_routes() {
        foreach($this->supported_methods as $method) {
            $this->router->$method('/test', new class {
                public function __invoke() {
                    return 'Route';
                }
            });

            $this->assertEquals('Route', $this->router->run($method, '/test'));
        }
    }
}
