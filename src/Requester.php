<?php
namespace Sportily;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Handles the details of actually makeing requests to the API, making sure
 * that the access token is including automatically.
 */
abstract class Requester {

    /**
     * The raw guzzle http client instance.
     *
     * @var GuzzleHttp\Client
     */
    private static $client = null;

    /**
     * Retrieve the guzzle http client singleton. Lazily create one if not
     * already created.
     *
     * @return GuzzleHttp\Client
     */
    private static function client() {
        if (self::$client == null) {
            self::$client = new Client([ 'base_url' => Api::$base_url ]);
        }

        return self::$client;
    }

    /**
     * Use the guzzle client to perform a GET request to the API service.
     *
     * @param string $url the URL of the resource to request
     * @param array $query query string parameters
     *
     * @return array the raw JSON response
     */
    public static function get($url, $query = []) {
        return self::request('get', $url, [ 'query' => $query ]);
    }

    /**
     * Use the guzzle client to perform a POST request to the API service.
     *
     * @param string $url the URL of the resource to request
     * @param array $body the body data to send
     *
     * @return array the raw JSON response
     */
    public static function post($url, $body = []) {
        return self::request('post', $url, [ 'body' => $body ]);
    }

    /**
     * Use the guzzle client to perform a PUT request to the API service.
     *
     * @param string $url the URL of the resource to request
     * @param array $body the body data to send
     *
     * @return array the raw JSON response
     */
    public static function put($url, $body = []) {
        return self::request('put', $url, [ 'body' => $body ]);
    }

    /**
     * Use the guzzle client to perform a DELETE request to the API service.
     *
     * @param string $url the URL of the resource to request
     *
     * @return array the raw JSON response
     */
    public static function delete($url) {
        return self::request('delete', $url);
    }

    /**
     * User the guzzle client to perform a request to the API service.
     *
     * @param string $method one of 'get', 'post', 'put', or 'delete'
     * @param string $url the URL of the resource to request
     * @param array $payload the request body and/or query parameters
     *
     * @return array the raw JSON response
     */
    public static function request($method, $url, $payload) {
        # ensure the access token is present in the headers.
        $token = Api::getAccessToken();
        $payload['headers'] = [ 'Authorization' => 'Bearer ' . $token ];

        # create the request
        $request = self::client()->createRequest($method, $url, $payload);
        $response = null;

        try {
            # perform the request.
            $response = self::client()->send($request)->json();

        } catch (ClientException $e) {
            # pull the details out of 40x responses.
            throw new \Exception(json_encode($e->getResponse()->json()));
        }

        return $response;
    }
}
