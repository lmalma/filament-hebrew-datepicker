<?php

namespace Eli Sheinfeld\HebrewDatePicker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Eli Sheinfeld\HebrewDatePicker\HebrewDatePicker
 */
class HebrewDatePicker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Eli Sheinfeld\HebrewDatePicker\HebrewDatePicker::class;
    }
}
