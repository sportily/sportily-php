<?php
namespace Sportily;

abstract class OAuth {

    /**
     * Request a new access token from the OAuth service. Either by exchanging
     * an auth code obtained through the user the regular authorization flow,
     * or by simply asking for an application-wide token.
     *
     * @deprecated this method does not support the 'refresh_token' grant type,
     * use getToken($grant_type, $data) instead
     *
     * @param string $auth_code an auth code to exchange for an access token
     *
     * @return string a valid access token
     */
     public static function token($auth_code = null) {
         $grant_type = null;
         $data = [];

         if ($auth_code) {
             $grant_type = 'authorization_code';
             $data['code'] = $auth_code;
             $data['redirect_uri'] = Api::$redirect_url;
         } else {
             $grant_type = 'client_credentials';
         }

         return self::getToken($grant_type, $data);
     }

     /**
      * Retrieve an access token for the given grant_type and payload.
      *
      * @param string $grant_type the grant type to use
      * @param array $data extra data to send to the oauth server
      *
      * @return string a valid access token
      */
     public static function getToken($grant_type, $data) {
         $payload = array_merge([
             'grant_type' => $grant_type,
             'client_id' => Api::$client_id,
             'client_secret' => Api::$client_secret
         ], $data);

         if ($grant_type == 'authorization_code') {
             $payload['redirect_uri'] = Api::$redirect_url;
         }

         return Requester::post('oauth/token', $payload);
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
