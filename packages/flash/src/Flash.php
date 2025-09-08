<?php

namespace Laracasts\Flash;

use Illuminate\Support\Facades\Facade;

class Flash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'flash';
    }
}
