<?php

namespace Humble\Exception;

use Throwable;

/**
 * Class HumbleException
 * @package Exception
 */
class HumbleException extends \Exception
{
    /**
     * HumbleException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message = "", $code = 500)
    {
        parent::__construct(sprintf('Humble stoped work with message: %s', $message), $code);
    }
}