<?php
namespace Sportily;

use ArrayAccess;
use GuzzleHttp\Exception\ClientException;
use JsonSerializable;

class Response implements ArrayAccess, JsonSerializable {

    private $response = null;

    private $json = null;

    private $lookup = null;

    public function __construct($response) {
        $this->response = $response;
    }

    public function wait() {
        $this->response->wait();
        return $this;
    }

    private function process() {
        if ($this->json == null) {
            try {
                $this->json = $this->response->json();

            } catch (ClientException $e) {
                self::processClientException($e);
            }
        }
    }

    private function generateLookup() {
        if ($this->lookup == null) {
            $this->process();
            $this->lookup = array_reduce($this->json['data'], function($v, $w) {
                $v[$w['id']] = $w;
                return $v;
            }, []);
        }
    }

    public function __get($key) {
        if ($key == 'lookup') {
            $this->generateLookup();
            return $this->lookup;
        }
    }

    public function offsetExists($offset) {
        $this->process();
        return isset($this->json[$offset]);
    }

    public function offsetGet($offset) {
        $this->process();
        return $this->json[$offset];
    }

    public function offsetSet($offset, $value) {
        // not supported
    }

    public function offsetUnset($offset) {
        // not supported
    }

    public function jsonSerialize() {
        $this->process();
        return $this->json;
    }

    /**
     * Inspect the provided Guzzle ClientException, and transform it into an
     * appropriate Sportily Error.
     *
     * @param GuzzleHttp\Exception\ClientException $e the client exception to inspect
     */
    private static function processClientException($e) {
        $json = $e->getResponse()->json();

        switch ($json['error']) {

            case 'invalid_data':
                throw new Error\Validation($json['error_description'], $json['validation_messages']);

            default:
                throw new Error\Base(json_encode($json));

        }
    }

}
