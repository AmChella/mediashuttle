<?php
namespace Pocmedia\Shuttle\Service;

use \GuzzleHttp\Client;

class Package {
    private $client;
    private $config;

    public function __construct(Array $config) {
        $this->client = new Client();
        $this->config = $config;
    }

    public function create(Array $request): Array {
        return [];
    }

    public function reads(Array $request): Array {
        // return $request;
        $headers = ['Authorization' => $request['keys']['api_key']];
        $uri = sprintf("%s/%s/%s",
            $this->config['media_shuttle']['host'],
            $this->config['media_shuttle']['version'],
            $this->config['media_shuttle']['routes']['read_package']
        );
        $uri = str_replace('{portal_id}', $request['keys']['portal_id'], $uri);
        // return [$uri];
        $response = $this->client->request('GET', $uri, ["headers" => $headers]);
        $body = (string) $response->getBody();
        $body = \json_decode($body, true);

        return $body;
    }

    public function delete(Array $request): Array {
        return [];
    }

    public function share(Array $request): Array {
        // $headers = ['Authorization' => $request['keys']['api_key']];
        // $url = sprintf("%s/")
        return [];
    }
}