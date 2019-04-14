<?php

namespace App\Model;

/**
 * Class ErrorMessage
 */
class ErrorMessage
{
    /** @var string */
    private $message;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return ErrorMessage
     */
    public function setMessage(string $message): ErrorMessage
    {
        $this->message = $message;
        return $this;
    }
}