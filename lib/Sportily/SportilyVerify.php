<?php

abstract class SportilyVerify {

    /**
    * Post the verification_token. This request
    * will fail when using a client-credentials token.
    *
    * @return
    */
    public static function post($data) {
        return SportilyRequester::post('verify', $data);
    }

}
