<?php

namespace Ajtarragona\TID\Facades; 

use Illuminate\Support\Facades\Facade;

class TIDFacade extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tid';
    }
}
