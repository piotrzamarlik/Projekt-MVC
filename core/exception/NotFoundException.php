<?php

namespace app\core\exception;

use app\core\middlewares\BaseMiddleware;

/**
 * Class NotFoundException
 */
class NotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Nie znaleziono';
}
