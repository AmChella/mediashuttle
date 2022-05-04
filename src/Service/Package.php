<?php
namespace Pocmedia\Shuttle\Service;

use \GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class Package {
    private $client;
    private $config;

    public function __construct(Array $config) {
        $this->client = new Client();
        $this->config = $config;
    }

    public function upload(Array $request): Array {
        $packageInfo = $this->createPackage($request);
        $headers = ['Authorization' => $request['keys']['api_key'], 'Content-Type' => 'application/json'];
        $uri = sprintf("%s/%s/%s",
            $this->config['media_shuttle']['host'],
            $this->config['media_shuttle']['version'],
            $this->config['media_shuttle']['routes']['share']
        );
        $uri = str_replace('{portal_id}', $request['keys']['portal_id'], $uri);
        $uri = str_replace('{package_id}', $packageInfo['id'], $uri);
        $reqBody = [
            "user" => [
                "email" => "chellapandi.soundarapandian@amnet-systems.com"
            ],
            "grants" => ["upload"],
            "destinationPath" => $request['data']['uploadDir'],
            "expiresOn" => "2022-06-21T11:00:45.046Z",
            "notifications" => [
                [
                    "type" => "webhook",
                    "url"=> "http://example.com/hook/catch/abc"
                ]
            ]
        ];
        // return $reqBody;
        $response = $this->client->request('POST', $uri, ["headers" => $headers, "json" => $reqBody]);
        $body = (string) $response->getBody();
        $body = \json_decode($body, true);

        $body['packageId'] = $packageInfo['id'];
        return $body;
    }

    private function createPackage(Array $request): Array {
        $headers = ['Authorization' => $request['keys']['api_key']];
        $uri = sprintf("%s/%s/%s",
            $this->config['media_shuttle']['host'],
            $this->config['media_shuttle']['version'],
            $this->config['media_shuttle']['routes']['create_package']
        );
        $uri = str_replace('{portal_id}', $request['keys']['portal_id'], $uri);
        $response = $this->client->request('POST', $uri, ["headers" => $headers]);
        $body = (string) $response->getBody();

        return \json_decode($body, true);
    }

    public function download(Array $request): Array {
        $headers = ['Authorization' => $request['keys']['api_key'], 'Content-Type' => 'application/json'];
        $uri = sprintf("%s/%s/%s",
            $this->config['media_shuttle']['host'],
            $this->config['media_shuttle']['version'],
            $this->config['media_shuttle']['routes']['share']
        );
        $uri = str_replace('{portal_id}', $request['keys']['portal_id'], $uri);
        $uri = str_replace('{package_id}', $request['data']['packageId'], $uri);
        $reqBody = [
            "user" => [
                "email" => "chellapandi.soundarapandian@amnet-systems.com"
            ],
            "grants" => ["download"],
            "expiresOn" => "2022-05-21T11:00:45.046Z",
            "notifications" => [
                [
                    "type" => "webhook",
                    "url"=> "http://example.com/hook/catch/abc"
                ]
            ]
        ];
        // return $reqBody;
        try {

            $response = $this->client->request('POST', $uri, ["headers" => $headers, "json" => $reqBody]);
            $body = (string) $response->getBody();
            $body = \json_decode($body, true);
        } 
        catch (ClientException $e) {
            throw new Exception(Psr7\Message::toString($e->getResponse()));
        }
        $body['packageId'] = $request['data']['packageId'];
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