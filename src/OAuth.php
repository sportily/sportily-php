<?php
namespace Sportily;

abstract class OAuth {

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

        $payload = [
            'grant_type' => $grant_type,
            'client_id' => Api::$client_id,
            'client_secret' => Api::$client_secret
        ];

        if ($auth_code) {
            $payload['grant_type'] = 'authorization_code';
            $payload['code'] = $auth_code;
            $payload['redirect_uri'] = Api::$redirect_url;
        } else {
            $payload['grant_type'] = 'client_credentials';
        }

        $response = Requester::post('oauth/token', $payload);
        return $response['access_token'];
    }

    /**
     * Helper function to generate the URL that the user should be sent to in
     * order to login via the OAuth flow.
     *
     * @return string the url to send the user to
     */
    public static function url() {
        return Api::$base_url . '/oauth/authorize?response_type=code'
            . '&client_id=' . Api::$client_id
            . '&redirect_uri=' . Api::$redirect_url;
    }

}
