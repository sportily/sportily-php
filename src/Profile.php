<?php
namespace Sportily;

abstract class Profile {

    /**
     * Retrieve the profile of the currently authenticated user. This request
     * will fail when using a client-credentials token.
     *
     * @return array details of the user's profile
     */
    public static function retrieve() {
        return Requester::get('profile');
    }

}
