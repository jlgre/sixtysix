<?php

use PHPUnit\Framework\TestCase;
use Router\Parser;

class ParserTest extends TestCase {
    private $parser;

    protected function setUp() : void {
        $this->parser = new Parser();
    }

    /** @test */
    public function mismatched_braces_error() {
        $this->expectExceptionMessage('Mismatched curly brackets in uri string');
        $bad_uri = '/uri/{with}/mismatched/{braces';
        $this->parser->parseUri($bad_uri);
    }

    /** @test */
    public function can_parse_interpolation_out_of_uri() {
        $vars = ['id', 'test', 'num'];
        $uri = '/uri';
        foreach($vars as $var) {
            $uri = $uri . '/{' . $var . '}';
        }

        $parsed_vals = $this->parser->parseUri($uri);

        $this->assertEquals($vars, $parsed_vals);
    }
}
