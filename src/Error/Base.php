<?php
namespace Sportily\Error;

use Exception;

class Base extends Exception {

    public function __construct($message) {
        parent::__construct($message);
    }
}
