<?php

abstract class SportilyOrganisation extends SportilyApiResource {

    public function all() {
        return self::get('organisations');
    }

}
