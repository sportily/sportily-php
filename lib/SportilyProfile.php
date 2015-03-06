<?php
namespace Sportily\Api;

abstract class SportilyProfile {

    /**
     * Retrieve the profile of the currently authenticated user. This request
     * will fail when using a client-credentials token.
     *
     * @return array details of the user's profile
     */
    public static function retrieve() {
        return SportilyRequester::get('profile');
    }

}
