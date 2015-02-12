<?php

abstract class Sportily {

    public static $access_token;

    public static $base_url = 'http://localhost:8000';

    public static function getAccessToken() {
        if (self::$access_token === null) {
            self::$access_token = '';
            self::$access_token = self::token();
        }

        return self::$access_token;
    }

    public static function setAccessToken($access_token) {
        self::$access_token = $access_token;
    }

    public static function getBaseUrl() {
        return self::$base_url;
    }

    public static function token($auth_code = null) {
        $grant_type = $auth_code ? 'authorization_code' : 'client_credentials';

        $response = SportilyRequester::post('oauth/token', [
            'code' => $auth_code,
            'grant_type' => $grant_type,
            'client_id' => 'app_id',
            'client_secret' => 'app_secret',
            'redirect_uri' => 'http://localhost:9000/callback'
        ]);

        return $response['access_token'];
    }

    public static function profile() {
        return SportilyRequester::get('profile');
    }

}
