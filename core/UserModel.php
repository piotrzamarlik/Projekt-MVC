<?php

namespace app\core;

/**
 * Class UserModel
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}