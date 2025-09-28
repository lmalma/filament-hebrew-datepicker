<?php

// config for EliSheinfeld/HebrewDatePicker
return [
    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | This option controls the default locale for the Hebrew date picker.
    | You can set it to 'he' for Hebrew or 'en' for English.
    |
    */
    'default_locale' => 'he',

    /*
    |--------------------------------------------------------------------------
    | First Day of Week
    |--------------------------------------------------------------------------
    |
    | This option controls which day is considered the first day of the week.
    | 0 = Sunday (Hebrew calendar default)
    | 1 = Monday
    |
    */
    'first_day_of_week' => 0,

    /*
    |--------------------------------------------------------------------------
    | Date Format
    |--------------------------------------------------------------------------
    |
    | This option controls the default display format for Hebrew dates.
    | Available formats:
    | - 'j בM Y' (Hebrew: 15 בתשרי 5784)
    | - 'j M Y' (English: 15 Tishri 5784)
    |
    */
    'display_format' => 'j בM Y',

    /*
    |--------------------------------------------------------------------------
    | Close on Date Selection
    |--------------------------------------------------------------------------
    |
    | This option controls whether the date picker should automatically close
    | after a date is selected (when time is not enabled).
    |
    */
    'close_on_date_selection' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Time Selection
    |--------------------------------------------------------------------------
    |
    | This option controls whether time selection is enabled by default.
    |
    */
    'enable_time' => false,

    /*
    |--------------------------------------------------------------------------
    | Enable Seconds
    |--------------------------------------------------------------------------
    |
    | This option controls whether seconds are shown in time selection.
    | Only applies when enable_time is true.
    |
    */
    'enable_seconds' => false,

    /*
    |--------------------------------------------------------------------------
    | Hebrew Calendar Options
    |--------------------------------------------------------------------------
    |
    | These options control various aspects of the Hebrew calendar display.
    |
    */
    'calendar' => [
        /*
        |--------------------------------------------------------------------------
        | Show Hebrew Year in Gematria
        |--------------------------------------------------------------------------
        |
        | When enabled, Hebrew years will be displayed using Hebrew letters
        | instead of numbers (e.g., התשפ״ד instead of 5784).
        |
        */
        'show_year_in_gematria' => false,

        /*
        |--------------------------------------------------------------------------
        | Show Day in Hebrew
        |--------------------------------------------------------------------------
        |
        | When enabled, day numbers will be displayed using Hebrew letters
        | instead of Arabic numerals.
        |
        */
        'show_day_in_hebrew' => false,

        /*
        |--------------------------------------------------------------------------
        | Use Ashkenazi Pronunciation
        |--------------------------------------------------------------------------
        |
        | When enabled, month names will use Ashkenazi pronunciation
        | (e.g., Tishrei instead of Tishri).
        |
        */
        'use_ashkenazi_pronunciation' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | These options control validation behavior for the Hebrew date picker.
    |
    */
    'validation' => [
        /*
        |--------------------------------------------------------------------------
        | Minimum Year
        |--------------------------------------------------------------------------
        |
        | The minimum Hebrew year that can be selected.
        |
        */
        'min_year' => 5000,

        /*
        |--------------------------------------------------------------------------
        | Maximum Year
        |--------------------------------------------------------------------------
        |
        | The maximum Hebrew year that can be selected.
        |
        */
        'max_year' => 6000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Assets
    |--------------------------------------------------------------------------
    |
    | Configuration for CSS and JavaScript assets.
    |
    */
    'assets' => [
        /*
        |--------------------------------------------------------------------------
        | Load Default Styles
        |--------------------------------------------------------------------------
        |
        | Whether to load the default CSS styles for the Hebrew date picker.
        |
        */
        'load_default_styles' => true,

        /*
        |--------------------------------------------------------------------------
        | RTL Support
        |--------------------------------------------------------------------------
        |
        | Whether to include RTL (Right-to-Left) CSS support for Hebrew text.
        |
        */
        'rtl_support' => true,
    ],
];
