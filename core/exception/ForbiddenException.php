<?php

namespace app\core\exception;

use app\core\middlewares\BaseMiddleware;

/**
 * Class ForbiddenException
 */
class ForbiddenException extends \Exception
{
    protected $code = 403;
    protected $message = 'Brak uprawnień';
}
