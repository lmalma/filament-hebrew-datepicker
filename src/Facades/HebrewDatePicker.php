<?php

namespace EliSheinfeld\HebrewDatePicker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EliSheinfeld\HebrewDatePicker\HebrewDatePicker
 */
class HebrewDatePicker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \EliSheinfeld\HebrewDatePicker\HebrewDatePicker::class;
    }
}
