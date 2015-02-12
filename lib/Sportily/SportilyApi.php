<?php

/**
 * The core class for accessing core parts of the API and setting access tokens
 * and API secrets.
 */
abstract class SportilyApi {

    /**
     * The base URL of the API. Can be overridden if necessary.
     *
     * @var string
     */
    public static $base_url = 'http://localhost:8000';

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
     * Returns the current access token, or - if no access token has been
     * provided - makes a request to the OAuth service to get an access token
     * on behalf of the client.
     *
     * @return string an access token
     */
    public static function getAccessToken() {
        if (self::$access_token === null) {
            self::$access_token = '';
            self::$access_token = self::token();
        }

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
     * Request a new access token from the OAuth service. Either by exchanging
     * an auth code obtained through the user the regular authorization flow,
     * or by simply asking for an application-wide token.
     *
     * @param string $auth_code an auth code to exchange for an access token
     *
     * @return string a valid access token
     */
    public static function token($auth_code = null) {
        $grant_type = $auth_code ? 'authorization_code' : 'client_credentials';

        $response = SportilyRequester::post('oauth/token', [
            'code' => $auth_code,
            'grant_type' => $grant_type,
            'client_id' => self::$client_id,
            'client_secret' => self::$client_secret
        ]);

        return $response['access_token'];
    }

    /**
     * Retrieve the profile of the currently authenticated user. This request
     * will fail when using a client-credentials token.
     *
     * @return array details of the user's profile
     */
    public static function profile() {
        return SportilyRequester::get('profile');
    }

}
