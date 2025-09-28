# Hebrew Date Picker for Filament

A comprehensive Hebrew date picker component for Filament PHP that provides full Hebrew calendar support with seamless integration into your Filament forms.

## Features

- 🗓️ **Full Hebrew Calendar Support**: Display and select dates using the Hebrew calendar system
- 🌐 **Multilingual**: Supports both Hebrew and English interfaces
- ⏰ **Time Selection**: Optional time picker with hours, minutes, and seconds
- 🎨 **Filament Native**: Built using Filament's component architecture for perfect integration
- 📱 **RTL Support**: Full Right-to-Left language support for Hebrew text
- 🔧 **Highly Configurable**: Extensive configuration options for customization
- ♿ **Accessible**: Built with accessibility in mind following WCAG guidelines
- 🎯 **Validation**: Built-in validation for date ranges and disabled dates
- 🚀 **Performance**: Optimized for fast loading and smooth interactions

## Installation

You can install the package via composer:

```bash
composer require eli-sheinfeld/hebrew-date-picker
```

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag="hebrew-date-picker-config"
```

Publish the assets:

```bash
php artisan vendor:publish --tag="hebrew-date-picker-assets"
```

## Usage

### Basic Usage

```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;

HebrewDatePicker::make('hebrew_birthday')
    ->label('תאריך לידה עברי')
    ->required()
```

### With Time Selection

```php
HebrewDatePicker::make('hebrew_event_datetime')
    ->label('זמן האירוע')
    ->hasTime()
    ->hasSeconds()
    ->required()
```

### English Interface

```php
HebrewDatePicker::make('hebrew_date')
    ->label('Hebrew Date')
    ->locale('en')
    ->placeholder('Select Hebrew date')
```

### Date Constraints

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

### Custom Display Format

```php
HebrewDatePicker::make('hebrew_date')
    ->label('תאריך')
    ->displayFormat('j בM Y') // For Hebrew: "15 בתשרי 5784"
    // or
    ->displayFormat('j M Y')   // For English: "15 Tishri 5784"
```

### Advanced Configuration

```php
HebrewDatePicker::make('hebrew_date')
    ->label('תאריך עברי')
    ->locale('he')
    ->firstDayOfWeek(0) // 0 = Sunday, 1 = Monday
    ->closeOnDateSelection(true)
    ->hasTime()
    ->displayFormat('j בM Y')
    ->placeholder('בחר תאריך עברי')
    ->helperText('בחר תאריך בלוח העברי')
    ->required()
```

## Configuration

The package comes with a comprehensive configuration file that allows you to customize various aspects:

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

## Available Methods

### Date Configuration

- `locale(string $locale)` - Set the interface language ('he' or 'en')
- `displayFormat(string $format)` - Set the display format for dates
- `firstDayOfWeek(int $day)` - Set the first day of the week (0-6)
- `placeholder(string $placeholder)` - Set custom placeholder text

### Time Configuration

- `hasTime(bool $condition = true)` - Enable time selection
- `hasSeconds(bool $condition = true)` - Enable seconds in time selection

### Date Constraints

- `minDate(string|\DateTimeInterface $date)` - Set minimum selectable date
- `maxDate(string|\DateTimeInterface $date)` - Set maximum selectable date
- `disabledDates(array $dates)` - Set array of disabled dates

### Behavior

- `closeOnDateSelection(bool $condition = true)` - Auto-close picker on date selection

## Hebrew Calendar Features

### Month Names

**Hebrew Interface:**
- תשרי, חשון, כסלו, טבת, שבט, אדר, ניסן, אייר, סיון, תמוז, אב, אלול

**English Interface:**
- Tishri, Cheshvan, Kislev, Tevet, Shevat, Adar, Nissan, Iyar, Sivan, Tammuz, Av, Elul

### Day Labels

**Hebrew Interface:**
- א׳, ב׳, ג׳, ד׳, ה׳, ו׳, ש׳

**English Interface:**
- Sun, Mon, Tue, Wed, Thu, Fri, Sat

## Validation

The component includes built-in validation for:

- Valid date formats
- Date range constraints (min/max dates)
- Disabled date restrictions
- Required field validation

## Styling

The component uses Filament's native styling system and includes:

- Dark mode support
- RTL (Right-to-Left) support for Hebrew text
- Responsive design for mobile devices
- Custom CSS classes for advanced styling

### Custom Styling

You can customize the appearance by publishing the assets and modifying the CSS:

```bash
php artisan vendor:publish --tag="hebrew-date-picker-assets"
```

## JavaScript Integration

The component uses Alpine.js for frontend functionality and includes:

- Hebrew calendar calculations
- Date conversion between Gregorian and Hebrew calendars
- Keyboard navigation support
- Accessibility features

## Examples

### In a Filament Resource

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

### In a Custom Form

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

## Testing

Run the tests with:

```bash
composer test
```

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

## Support

If you find this package helpful, please consider:
- ⭐ Starring the repository
- 🐛 Reporting bugs
- 💡 Suggesting new features
- 📖 Improving documentation

For support, please [open an issue](https://github.com/eli-sheinfeld/hebrew-date-picker/issues) on GitHub.

---

**Note**: This package provides a basic Hebrew calendar implementation. For more accurate Hebrew date calculations, consider integrating with specialized Hebrew calendar libraries like `hebcal` or similar packages for precise religious and astronomical calculations.
