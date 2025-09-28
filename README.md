# Hebrew Date Picker for Filament / בורר תאריכים עבריים עבור Filament

[English](#english) | [עברית](#hebrew)

---

## English

A comprehensive Hebrew date picker component for Filament PHP that provides full Hebrew calendar support with seamless integration into your Filament forms.

### Features

- 🗓️ **Full Hebrew Calendar Support**: Display and select dates using the Hebrew calendar system with accurate calculations
- 🌐 **Multilingual**: Supports both Hebrew and English interfaces
- ⏰ **Time Selection**: Optional time picker with hours, minutes, and seconds
- 🎨 **Filament Native**: Built using Filament's component architecture for perfect integration
- 📱 **RTL Support**: Full Right-to-Left language support for Hebrew text
- 🔧 **Highly Configurable**: Extensive configuration options for customization
- ♿ **Accessible**: Built with accessibility in mind following WCAG guidelines
- 🎯 **Validation**: Built-in validation for date ranges and disabled dates
- 🚀 **Performance**: Optimized for fast loading and smooth interactions
- 📅 **Accurate Calculations**: Uses PHP's IntlCalendar for precise Hebrew calendar conversions

### Installation

You can install the package via composer:

```bash
composer require eli-sheinfeld/hebrew-date-picker
```

**Note**: For accurate Hebrew calendar calculations, ensure the `intl` PHP extension is installed:
```bash
# Ubuntu/Debian
sudo apt-get install php-intl

# CentOS/RHEL
sudo yum install php-intl

# macOS with Homebrew
brew install php@8.1-intl
```

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag="hebrew-date-picker-config"
```

Publish the assets:

```bash
php artisan vendor:publish --tag="hebrew-date-picker-assets"
```

### Usage

#### Basic Usage

```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;

HebrewDatePicker::make('hebrew_birthday')
    ->label('Hebrew Birthday')
    ->required()
```

#### With Time Selection

```php
HebrewDatePicker::make('hebrew_event_datetime')
    ->label('Event Time')
    ->hasTime()
    ->hasSeconds()
    ->required()
```

#### Hebrew Interface

```php
HebrewDatePicker::make('hebrew_date')
    ->label('תאריך עברי')
    ->locale('he')
    ->placeholder('בחר תאריך עברי')
```

#### Date Constraints

```php
HebrewDatePicker::make('hebrew_date')
    ->label('Date')
    ->minDate(now()->subYears(100))
    ->maxDate(now()->addYears(5))
    ->disabledDates([
        '2024-01-01',
        '2024-12-25'
    ])
```

#### Custom Display Format

```php
HebrewDatePicker::make('hebrew_date')
    ->label('Date')
    ->displayFormat('j בM Y') // For Hebrew: "15 בתשרי 5784"
    // or
    ->displayFormat('j M Y')   // For English: "15 Tishri 5784"
```

#### Display Only (Read-Only Mode)

For displaying Hebrew dates in read-only forms:

```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDateDisplay;

HebrewDateDisplay::make('created_at')
    ->label('Created Date')
    ->locale('he')
    ->showGregorianDate() // Shows: "15 בתשרי 5784 (30/09/2023)"
    ->showYearInGematria() // Shows year in Hebrew letters
```

### Configuration

The package comes with a comprehensive configuration file:

```php
// config/hebrew-date-picker.php

return [
    'default_locale' => 'he',
    'first_day_of_week' => 0,
    'display_format' => 'j בM Y',
    'close_on_date_selection' => true,
    'enable_time' => false,
    'enable_seconds' => false,
    
    'calendar' => [
        'show_year_in_gematria' => false,
        'show_day_in_hebrew' => false,
        'use_ashkenazi_pronunciation' => false,
    ],
    
    'validation' => [
        'min_year' => 5000,
        'max_year' => 6000,
    ],
    
    'assets' => [
        'load_default_styles' => true,
        'rtl_support' => true,
    ],
];
```

### Hebrew Calendar Features

#### Month Names

**Hebrew Interface:**
- תשרי, חשון, כסלו, טבת, שבט, אדר, ניסן, אייר, סיון, תמוז, אב, אלול

**English Interface:**
- Tishri, Cheshvan, Kislev, Tevet, Shevat, Adar, Nissan, Iyar, Sivan, Tammuz, Av, Elul

#### Leap Year Support

The component automatically handles Hebrew leap years (שנה מעוברת) with proper Adar I and Adar II support.

### Testing

Run the tests with:

```bash
composer test
```

---

## Hebrew

רכיב מקיף לבחירת תאריכים עבריים עבור Filament PHP שמספק תמיכה מלאה בלוח השנה העברי עם אינטגרציה חלקה בטפסי Filament שלכם.

### תכונות

- 🗓️ **תמיכה מלאה בלוח השנה העברי**: הצגה ובחירה של תאריכים באמצעות מערכת הלוח העברי עם חישובים מדויקים
- 🌐 **רב לשוני**: תמיכה בממשקים בעברית ובאנגלית
- ⏰ **בחירת זמן**: בורר זמן אופציונלי עם שעות, דקות ושניות
- 🎨 **מקורי של Filament**: בנוי באמצעות ארכיטקטורת הרכיבים של Filament לאינטגרציה מושלמת
- 📱 **תמיכה ב-RTL**: תמיכה מלאה בכיוון כתיבה מימין לשמאל לטקסט עברי
- 🔧 **ניתן להתאמה אישית**: אפשרויות קונפיגורציה נרחבות להתאמה אישית
- ♿ **נגיש**: בנוי עם נגישות בחשבון בהתאם להנחיות WCAG
- 🎯 **וולידציה**: וולידציה מובנית לטווחי תאריכים ותאריכים חסומים
- 🚀 **ביצועים**: מותאם לטעינה מהירה ואינטראקציות חלקות
- 📅 **חישובים מדויקים**: משתמש ב-IntlCalendar של PHP להמרות מדויקות של לוח עברי

### התקנה

ניתן להתקין את החבילה דרך composer:

```bash
composer require eli-sheinfeld/hebrew-date-picker
```

**הערה**: לחישובים מדויקים של לוח עברי, וודאו שהרחבת `intl` של PHP מותקנת:
```bash
# Ubuntu/Debian
sudo apt-get install php-intl

# CentOS/RHEL
sudo yum install php-intl

# macOS עם Homebrew
brew install php@8.1-intl
```

פרסום קובץ הקונפיגורציה (אופציונלי):

```bash
php artisan vendor:publish --tag="hebrew-date-picker-config"
```

פרסום הנכסים:

```bash
php artisan vendor:publish --tag="hebrew-date-picker-assets"
```

### שימוש

#### שימוש בסיסי

```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;

HebrewDatePicker::make('hebrew_birthday')
    ->label('תאריך לידה עברי')
    ->required()
```

#### עם בחירת זמן

```php
HebrewDatePicker::make('hebrew_event_datetime')
    ->label('זמן האירוע')
    ->hasTime()
    ->hasSeconds()
    ->required()
```

#### ממשק באנגלית

```php
HebrewDatePicker::make('hebrew_date')
    ->label('Hebrew Date')
    ->locale('en')
    ->placeholder('Select Hebrew date')
```

#### הגבלות תאריך

```php
HebrewDatePicker::make('hebrew_date')
    ->label('תאריך')
    ->minDate(now()->subYears(100))
    ->maxDate(now()->addYears(5))
    ->disabledDates([
        '2024-01-01',
        '2024-12-25'
    ])
```

#### פורמט תצוגה מותאם אישית

```php
HebrewDatePicker::make('hebrew_date')
    ->label('תאריך')
    ->displayFormat('j בM Y') // לעברית: "15 בתשרי תשפ״ד"
    // או
    ->displayFormat('j M Y')   // לאנגלית: "15 Tishri 5784"
```

#### הצגה בלבד (מצב קריאה)

להצגת תאריכים עבריים בטפסים במצב קריאה בלבד:

```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDateDisplay;

HebrewDateDisplay::make('created_at')
    ->label('תאריך יצירה')
    ->locale('he')
    ->showGregorianDate() // מציג: "15 בתשרי תשפ״ד (30/09/2023)"
    ->showYearInGematria() // מציג שנה באותיות עבריות
```

### קונפיגורציה

החבילה מגיעה עם קובץ קונפיגורציה מקיף:

```php
// config/hebrew-date-picker.php

return [
    'default_locale' => 'he',
    'first_day_of_week' => 0,
    'display_format' => 'j בM Y',
    'close_on_date_selection' => true,
    'enable_time' => false,
    'enable_seconds' => false,
    
    'calendar' => [
        'show_year_in_gematria' => false,
        'show_day_in_hebrew' => false,
        'use_ashkenazi_pronunciation' => false,
    ],
    
    'validation' => [
        'min_year' => 5000,
        'max_year' => 6000,
    ],
    
    'assets' => [
        'load_default_styles' => true,
        'rtl_support' => true,
    ],
];
```

### תכונות לוח עברי

#### שמות חודשים

**ממשק בעברית:**
- תשרי, חשון, כסלו, טבת, שבט, אדר, ניסן, אייר, סיון, תמוז, אב, אלול

**ממשק באנגלית:**
- Tishri, Cheshvan, Kislev, Tevet, Shevat, Adar, Nissan, Iyar, Sivan, Tammuz, Av, Elul

#### תמיכה בשנה מעוברת

הרכיב מטפל אוטומטית בשנים מעוברות עבריות עם תמיכה נכונה באדר א׳ ואדר ב׳.

### מתודות זמינות

#### קונפיגורציה של תאריך

- `locale(string $locale)` - הגדרת שפת הממשק ('he' או 'en')
- `displayFormat(string $format)` - הגדרת פורמט התצוגה לתאריכים
- `firstDayOfWeek(int $day)` - הגדרת היום הראשון בשבוע (0-6)
- `placeholder(string $placeholder)` - הגדרת טקסט מותאם אישית

#### קונפיגורציה של זמן

- `hasTime(bool $condition = true)` - הפעלת בחירת זמן
- `hasSeconds(bool $condition = true)` - הפעלת שניות בבחירת זמן

#### הגבלות תאריך

- `minDate(string|\DateTimeInterface $date)` - הגדרת תאריך מינימלי לבחירה
- `maxDate(string|\DateTimeInterface $date)` - הגדרת תאריך מקסימלי לבחירה
- `disabledDates(array $dates)` - הגדרת מערך של תאריכים חסומים

#### התנהגות

- `closeOnDateSelection(bool $condition = true)` - סגירה אוטומטית של הבורר בבחירת תאריך

### דוגמאות

#### ב-Filament Resource

```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->label('שם')
                ->required(),
                
            HebrewDatePicker::make('hebrew_birthday')
                ->label('תאריך לידה עברי')
                ->locale('he')
                ->required(),
                
            HebrewDatePicker::make('bar_mitzvah_date')
                ->label('תאריך בר מצווה')
                ->locale('he')
                ->minDate(now()->subYears(50))
                ->maxDate(now()->addYears(5)),
        ]);
}
```

#### בטופס מותאם אישית

```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;

$form = Form::make()
    ->schema([
        HebrewDatePicker::make('event_date')
            ->label('תאריך האירוע')
            ->hasTime()
            ->required()
            ->closeOnDateSelection(false)
            ->placeholder('בחר תאריך ושעה')
            ->helperText('תאריך בלוח העברי'),
    ]);
```

### וולידציה

הרכיב כולל וולידציה מובנית עבור:

- פורמטים תקינים של תאריכים
- הגבלות טווח תאריכים (תאריכים מינימליים/מקסימליים)
- הגבלות תאריכים חסומים
- וולידציה של שדה חובה

### עיצוב

הרכיב משתמש במערכת העיצוב המקורית של Filament וכולל:

- תמיכה במצב כהה
- תמיכה ב-RTL (מימין לשמאל) לטקסט עברי
- עיצוב רספונסיבי למכשירים ניידים
- מחלקות CSS מותאמות אישית לעיצוב מתקדם

### בדיקות

הרצת הבדיקות:

```bash
composer test
```

### רישיון

רישיון MIT. אנא ראו [קובץ רישיון](LICENSE.md) למידע נוסף.

### תמיכה

אם אתם מוצאים את החבילה הזו מועילה, אנא שקלו:
- ⭐ מתן כוכב למאגר
- 🐛 דיווח על באגים
- 💡 הצעת תכונות חדשות
- 📖 שיפור התיעוד

לתמיכה, אנא [פתחו issue](https://github.com/eli-sheinfeld/hebrew-date-picker/issues) ב-GitHub.

---

**הערה חשובה**: החבילה הזו מספקת חישובים מדויקים של לוח עברי באמצעות IntlCalendar של PHP. לחישובים אסטרונומיים ודתיים מדויקים יותר, שקלו שילוב עם ספריות מתמחות כמו `hebcal` או חבילות דומות.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Eli Sheinfeld](https://github.com/eli-sheinfeld)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
