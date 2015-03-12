<?php
namespace Sportily\Error;

class Validation extends Base {

    public $messages;

    public function __construct($message, $messages) {
        parent::__construct($message);
        $this->messages = $messages;
    }
}
