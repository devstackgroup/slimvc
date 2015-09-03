<?php

namespace Sample\Model;

use Slimvc\Model;

class User extends Model
{
    public function __construct($queryInstance)
    {
        $queryInstance->setTable('user');
        parent::__construct($queryInstance);
    }
}
