<?php

namespace Phobrv\CoreAdmin\Facades;

use Illuminate\Support\Facades\Facade;

class CoreAdmin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'coreadmin';
    }
}
