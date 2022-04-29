<?php
namespace Pocmedia\Shuttle\Util;
use Exception;

class Util {
    private $config;
    public function __construct(Array $config) {
        $this->config = $config;
    }

    public function keys() {
        return [
            'api_key' => $this->config['api_key'],
            'portal_id' => $this->config['portal_id']
        ];
    }
}