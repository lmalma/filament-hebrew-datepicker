<?php

namespace EliSheinfeld\HebrewDatePicker\Support;

use Carbon\Carbon;
use IntlCalendar;

class HebrewCalendar
{
    /**
     * Convert Gregorian date to Hebrew date
     */
    public static function gregorianToHebrew(Carbon $gregorianDate): array
    {
        // Use PHP's IntlCalendar for accurate Hebrew calendar calculations
        if (class_exists('IntlCalendar')) {
            return self::convertUsingIntl($gregorianDate);
        }

        // Fallback to manual calculation
        return self::convertManually($gregorianDate);
    }

    /**
     * Convert Hebrew date to Gregorian date
     */
    public static function hebrewToGregorian(int $hebrewYear, int $hebrewMonth, int $hebrewDay): Carbon
    {
        if (class_exists('IntlCalendar')) {
            return self::convertFromHebrewUsingIntl($hebrewYear, $hebrewMonth, $hebrewDay);
        }

        return self::convertFromHebrewManually($hebrewYear, $hebrewMonth, $hebrewDay);
    }

    /**
     * Get Hebrew month names
     */
    public static function getHebrewMonthNames(string $locale = 'he'): array
    {
        if ($locale === 'he') {
            return [
                1 => 'תשרי',
                2 => 'חשון',
                3 => 'כסלו',
                4 => 'טבת',
                5 => 'שבט',
                6 => 'אדר',
                7 => 'ניסן',
                8 => 'אייר',
                9 => 'סיון',
                10 => 'תמוז',
                11 => 'אב',
                12 => 'אלול',
                13 => 'אדר ב׳', // Leap year month
            ];
        }

        return [
            1 => 'Tishri',
            2 => 'Cheshvan',
            3 => 'Kislev',
            4 => 'Tevet',
            5 => 'Shevat',
            6 => 'Adar',
            7 => 'Nissan',
            8 => 'Iyar',
            9 => 'Sivan',
            10 => 'Tammuz',
            11 => 'Av',
            12 => 'Elul',
            13 => 'Adar II', // Leap year month
        ];
    }

    /**
     * Get Hebrew day names
     */
    public static function getHebrewDayNames(string $locale = 'he'): array
    {
        if ($locale === 'he') {
            return [
                0 => 'א׳',
                1 => 'ב׳',
                2 => 'ג׳',
                3 => 'ד׳',
                4 => 'ה׳',
                5 => 'ו׳',
                6 => 'ש׳',
            ];
        }

        return [
            0 => 'Sun',
            1 => 'Mon',
            2 => 'Tue',
            3 => 'Wed',
            4 => 'Thu',
            5 => 'Fri',
            6 => 'Sat',
        ];
    }

    /**
     * Check if Hebrew year is a leap year
     */
    public static function isHebrewLeapYear(int $hebrewYear): bool
    {
        // Hebrew leap year cycle: 7 leap years in every 19 years
        // Leap years are: 3, 6, 8, 11, 14, 17, 19 in the cycle
        $yearInCycle = $hebrewYear % 19;

        return in_array($yearInCycle, [3, 6, 8, 11, 14, 17, 0]);
    }

    /**
     * Get number of days in Hebrew month
     */
    public static function getDaysInHebrewMonth(int $hebrewYear, int $hebrewMonth): int
    {
        $isLeapYear = self::isHebrewLeapYear($hebrewYear);

        // Standard month lengths
        $monthLengths = [
            1 => 30,  // Tishri
            2 => 29,  // Cheshvan (can be 30)
            3 => 29,  // Kislev (can be 30)
            4 => 29,  // Tevet
            5 => 30,  // Shevat
            6 => 29,  // Adar (30 in leap year for Adar I)
            7 => 30,  // Nissan
            8 => 29,  // Iyar
            9 => 30,  // Sivan
            10 => 29, // Tammuz
            11 => 30, // Av
            12 => 29, // Elul
            13 => 29, // Adar II (leap year only)
        ];

        // Handle variable months and leap year
        if ($hebrewMonth === 6 && $isLeapYear) {
            return 30; // Adar I in leap year
        }

        if ($hebrewMonth === 13 && ! $isLeapYear) {
            return 0; // Adar II doesn't exist in regular years
        }

        // Handle Cheshvan and Kislev variable lengths
        if ($hebrewMonth === 2 || $hebrewMonth === 3) {
            // This would require more complex calculations to determine
            // For now, return standard length
            return $monthLengths[$hebrewMonth];
        }

        return $monthLengths[$hebrewMonth] ?? 29;
    }

    /**
     * Convert using PHP's IntlCalendar (more accurate)
     */
    private static function convertUsingIntl(Carbon $gregorianDate): array
    {
        try {
            $hebrewCalendar = IntlCalendar::createInstance(null, '@calendar=hebrew');
            $hebrewCalendar->setTime($gregorianDate->timestamp * 1000);

            return [
                'year' => $hebrewCalendar->get(IntlCalendar::FIELD_YEAR),
                'month' => $hebrewCalendar->get(IntlCalendar::FIELD_MONTH) + 1,
                'day' => $hebrewCalendar->get(IntlCalendar::FIELD_DAY_OF_MONTH),
                'dayOfWeek' => $hebrewCalendar->get(IntlCalendar::FIELD_DAY_OF_WEEK) - 1,
                'gregorianDate' => $gregorianDate,
            ];
        } catch (\Exception $e) {
            return self::convertManually($gregorianDate);
        }
    }

    /**
     * Convert from Hebrew using PHP's IntlCalendar
     */
    private static function convertFromHebrewUsingIntl(int $hebrewYear, int $hebrewMonth, int $hebrewDay): Carbon
    {
        try {
            $hebrewCalendar = IntlCalendar::createInstance(null, '@calendar=hebrew');
            $hebrewCalendar->set(IntlCalendar::FIELD_YEAR, $hebrewYear);
            $hebrewCalendar->set(IntlCalendar::FIELD_MONTH, $hebrewMonth - 1);
            $hebrewCalendar->set(IntlCalendar::FIELD_DAY_OF_MONTH, $hebrewDay);
            $hebrewCalendar->set(IntlCalendar::FIELD_HOUR_OF_DAY, 0);
            $hebrewCalendar->set(IntlCalendar::FIELD_MINUTE, 0);
            $hebrewCalendar->set(IntlCalendar::FIELD_SECOND, 0);

            return Carbon::createFromTimestamp($hebrewCalendar->getTime() / 1000);
        } catch (\Exception $e) {
            return self::convertFromHebrewManually($hebrewYear, $hebrewMonth, $hebrewDay);
        }
    }

    /**
     * Manual conversion (approximation for fallback)
     */
    private static function convertManually(Carbon $gregorianDate): array
    {
        // This is a simplified approximation
        // Hebrew year roughly = Gregorian year + 3760/3761
        $year = $gregorianDate->year;
        $month = $gregorianDate->month;
        $day = $gregorianDate->day;

        // Calculate approximate Hebrew year
        $hebrewYear = $year + 3760;
        if ($month >= 9) { // After September, it's usually the next Hebrew year
            $hebrewYear += 1;
        }

        // Approximate month mapping (Tishri starts around September)
        $monthMapping = [
            9 => 1,   // September -> Tishri
            10 => 2,  // October -> Cheshvan
            11 => 3,  // November -> Kislev
            12 => 4,  // December -> Tevet
            1 => 5,   // January -> Shevat
            2 => 6,   // February -> Adar
            3 => 7,   // March -> Nissan
            4 => 8,   // April -> Iyar
            5 => 9,   // May -> Sivan
            6 => 10,  // June -> Tammuz
            7 => 11,  // July -> Av
            8 => 12,  // August -> Elul
        ];

        $hebrewMonth = $monthMapping[$month] ?? 1;

        return [
            'year' => $hebrewYear,
            'month' => $hebrewMonth,
            'day' => $day,
            'dayOfWeek' => $gregorianDate->dayOfWeek,
            'gregorianDate' => $gregorianDate,
        ];
    }

    /**
     * Manual conversion from Hebrew (approximation for fallback)
     */
    private static function convertFromHebrewManually(int $hebrewYear, int $hebrewMonth, int $hebrewDay): Carbon
    {
        // Approximate Gregorian year
        $gregorianYear = $hebrewYear - 3760;

        // Approximate month mapping
        $monthMapping = [
            1 => 9,   // Tishri -> September
            2 => 10,  // Cheshvan -> October
            3 => 11,  // Kislev -> November
            4 => 12,  // Tevet -> December
            5 => 1,   // Shevat -> January
            6 => 2,   // Adar -> February
            7 => 3,   // Nissan -> March
            8 => 4,   // Iyar -> April
            9 => 5,   // Sivan -> May
            10 => 6,  // Tammuz -> June
            11 => 7,  // Av -> July
            12 => 8,  // Elul -> August
        ];

        $gregorianMonth = $monthMapping[$hebrewMonth] ?? 1;

        // Adjust year for months after Tishri
        if ($hebrewMonth >= 5) {
            $gregorianYear += 1;
        }

        try {
            return Carbon::create($gregorianYear, $gregorianMonth, min($hebrewDay, 28));
        } catch (\Exception $e) {
            return Carbon::now();
        }
    }

    /**
     * Format Hebrew date for display
     */
    public static function formatHebrewDate(array $hebrewDate, string $locale = 'he', string $format = 'j בM Y'): string
    {
        $monthNames = self::getHebrewMonthNames($locale);

        if ($locale === 'he') {
            if ($format === 'j בM Y') {
                return $hebrewDate['day'] . ' ב' . $monthNames[$hebrewDate['month']] . ' ' . $hebrewDate['year'];
            }
        }

        return $hebrewDate['day'] . ' ' . $monthNames[$hebrewDate['month']] . ' ' . $hebrewDate['year'];
    }

    /**
     * Get Hebrew year in Gematria format
     */
    public static function getHebrewYearInGematria(int $hebrewYear): string
    {
        // Hebrew letters for numbers
        $gematria = [
            1000 => 'א׳',
            900 => 'תת״',
            800 => 'ת״',
            700 => 'ש״',
            600 => 'ר״',
            500 => 'ק״',
            400 => 'ת׳',
            300 => 'ש׳',
            200 => 'ר׳',
            100 => 'ק׳',
            90 => 'צ׳',
            80 => 'פ׳',
            70 => 'ע׳',
            60 => 'ס׳',
            50 => 'נ׳',
            40 => 'מ׳',
            30 => 'ל׳',
            20 => 'כ׳',
            19 => 'יט׳',
            18 => 'יח׳',
            17 => 'יז׳',
            16 => 'טז׳',
            15 => 'טו׳', // Special case to avoid יה (God's name)
            10 => 'י׳',
            9 => 'ט׳',
            8 => 'ח׳',
            7 => 'ז׳',
            6 => 'ו׳',
            5 => 'ה׳',
            4 => 'ד׳',
            3 => 'ג׳',
            2 => 'ב׳',
            1 => 'א׳',
        ];

        $result = '';
        $remaining = $hebrewYear;

        foreach ($gematria as $value => $letter) {
            while ($remaining >= $value) {
                $result .= $letter;
                $remaining -= $value;
            }
        }

        return $result;
    }
}
