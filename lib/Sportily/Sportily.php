<?php

abstract class Sportily {

    public static $access_token;

    public static $base_url = 'http://localhost:8000';

    public static function getAccessToken() {
        return self::$access_token;
    }

    public static function setAccessToken($access_token) {
        self::$access_token = $access_token;
    }

    public static function getBaseUrl() {
        return self::$base_url;
    }

}
