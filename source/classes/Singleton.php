<?php

namespace core;

trait Singleton {

    static private $_instance;

    final private function __construct() {}

    final static public function instance(): static
    {
        return static::$_instance ?? static::$_instance = new static();
    }

    private function __sleep() {}
    private function __clone() {}
    private function __wakeup() {}

}