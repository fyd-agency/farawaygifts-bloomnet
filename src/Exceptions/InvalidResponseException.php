<?php

namespace BloomNetwork\Exceptions;

class InvalidResponseException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'The response XML was malformed.';
}
