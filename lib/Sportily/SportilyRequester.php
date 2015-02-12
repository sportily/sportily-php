<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class SportilyRequester {

    private static $client = null;

    private static function client() {
        if (self::$client == null) {
            self::$client = new Client([ 'base_url' => Sportily::getBaseUrl() ]);
        }

        return self::$client;
    }

    public static function get($url, $query = []) {
        return self::request('get', $url, [ 'query' => $query ]);
    }

    public static function post($url, $body = []) {
        return self::request('post', $url, [ 'body' => $body ]);
    }

    public static function request($method, $url, $payload) {
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
