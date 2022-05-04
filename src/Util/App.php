<?php
namespace Pocmedia\Shuttle\Util;

use Exception;

use Symfony\Component\Yaml\Yaml;
use Pocmedia\Shuttle\Service\{Package, Home};
use Pocmedia\Shuttle\Util\Util;
use Pocmedia\Shuttle\Exception\AppInitializerException;


class App {
    static $app;
    private $resources;

    private  function __construct() {
       $this->setup();
    }

    public static function getApp() {
        if (!self::$app) {
            self::$app = new App();
        }

        return self::$app;
    }

    public function get($key, ...$args) {
        if (isset($this->resources[$key]) === false) {
            throw new AppInitializerException("$key.object.does.not.exist");
        }

        return call_user_func($this->resources[$key], $args);
    }

    public function setup() {
        $resources = [];
        $resources['config'] = function() {
            return Yaml::parseFile(__DIR__ . "/../Config/config.yaml");
        };

        $resources['router'] = function() {
            return Yaml::parseFile(__DIR__ . "/../Config/routes.yaml");
        };

        $resources['util'] = function() use($resources) {
            return new Util(call_user_func($resources['config']));
        };

        $resources['package'] = function() use($resources) {
            return new Package(call_user_func($resources['config']));
        };

        $resources['home'] = function() use($resources) {
            return new Home(call_user_func($resources['config']));
        };

        $this->resources = $resources;
    }
}