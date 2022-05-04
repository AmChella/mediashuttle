<?php
namespace Pocmedia\Shuttle\Service;

use \GuzzleHttp\Client;

class Home {
    public function homePage(Array $request): String {
        return file_get_contents(__DIR__ . "/../View/Home.html");
    }
}