<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class SportilyApiResource {

    private static $client = null;

    private static function client() {
        if (!self::$client) {
            self::$client = new Client([ 'base_url' => Sportily::getBaseUrl() ]);
        }
    }

    protected static function get($url) {
        return self::request('get', $url, []);
    }

    protected static function request($method, $url, $payload) {
        $query = isset($payload['query']) ? $payload['query'] : [];
        $query['access_token'] = Sportily::getAccessToken();

        $payload['query'] = $query;

        $request = self::client()->createRequest($method, $url, $payload);
        $response = null;

        try {
            $response = self::client()->send($request)->json();
        } catch (ClientException $e) {
            $response = $e->getResponse()->json();
        }

        return $response;
    }
}
