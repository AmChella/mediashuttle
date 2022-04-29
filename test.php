<?php

class Test {
    static $app;
    private $resources;
    public function __construct() {
        $this->setup();
    }

    public static function getApp() {
        if (!self::$app) {
            self::$app = new Test();
        }

        return self::$app;
    }

    public function get(String $key) {
        if (isset($this->resources[$key])) {
            return call_user_func($this->resources[$key]);
        }

        return "no object";
    }

    private function setup() {
        $this->resources['test'] = (function () {
            return "Hello Test Function Closure";
        });
    }
}

$app = Test::getApp();
var_dump($app->get("test"));