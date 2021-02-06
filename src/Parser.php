<?php

namespace Router;

class Parser {

    public function parseUri($uri, $accumulator = []) {
        // Find {
        if ($start = strpos($uri, '{')){
            // Now find }
            $end = strpos($uri, '}', $start);
            if (!$end){
                throw new \Exception('Mismatched curly brackets in uri string');
            }
            array_push($accumulator, substr($uri, $start + 1, $end - $start - 1));

            return $this->parseUri(substr($uri, $end), $accumulator);
        } else {
            // there are no more values
            return $accumulator;
        }
    }    

}
