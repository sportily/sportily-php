<?php
namespace Sportily;

/**
 * The core class for accessing core parts of the API and setting access tokens
 * and API secrets.
 */
abstract class Api {

    /**
     * The base URL of the API. Can be overridden if necessary.
     *
     * @var string
     */
    public static $base_url;

    /**
     * The access token that should be sent along with each request. If not
     * provided, when a call is made the client will automatically request an
     * access token using the client credentials
     *
     * @var string
     */
    public static $access_token;

    /**
     * The unique identifier for your application. Required to request access
     * tokens from the OAuth service.
     *
     * @var string
     */
    public static $client_id;

    /**
     * The secret key of your application. Required to request access token
     * from the OAuth service.
     *
     * @var string
     */
    public static $client_secret;

    /**
     * The redirect URL where the user we be sent to (with an auth code) once
     * they have completed the OAuth login flow.
     *
     * @var string
     */
    public static $redirect_url;

    /**
     * Specifies the base URL to use.
     *
     * @param string $base_url the base URL to use
     */
    public static function setBaseUrl($base_url) {
        self::$base_url = $base_url;
    }

    /**
     * Returns the current access token, or - if no access token has been
     * provided - makes a request to the OAuth service to get an access token
     * on behalf of the client.
     *
     * @return string an access token
     */
    public static function getAccessToken() {
        return self::$access_token;
    }

    /**
     * Specifies the access token to use in future requests.
     *
     * @param string $access_token the access token to use from now on
     */
    public static function setAccessToken($access_token) {
        self::$access_token = $access_token;
    }

    /**
     * Specifies the client id and secret to use when requesting access tokens.
     *
     * @param string $client_id the publishable client identifier
     * @param string $client_secret the secret client key
     */
    public static function setApiKeys($client_id, $client_secret) {
        self::$client_id = $client_id;
        self::$client_secret = $client_secret;
    }

    /**
     * Specifies the redirect URL where the user we be sent to (with an auth
     * code) once they have completed the OAuth login flow.
     *
     * @param string $redirect_url the redirect url
     */
    public static function setRedirectUrl($redirect_url) {
        self::$redirect_url = $redirect_url;
    }

}
