# Troubleshooting Hebrew Date Picker / פתרון בעיות בבורר תאריכים עבריים

## Common Issues / בעיות נפוצות

### 1. "Call to undefined method make()" Error

**English:**
If you get an error like `Call to undefined method EliSheinfeld\HebrewDatePicker\HebrewDatePicker::make()`, you're importing the wrong class.

**❌ Wrong:**
```php
use EliSheinfeld\HebrewDatePicker\HebrewDatePicker; // This is a Facade!
```

**✅ Correct:**
```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;
```

**עברית:**
אם אתם מקבלים שגיאה כמו `Call to undefined method EliSheinfeld\HebrewDatePicker\HebrewDatePicker::make()`, אתם מייבאים את המחלקה הלא נכונה.

**❌ לא נכון:**
```php
use EliSheinfeld\HebrewDatePicker\HebrewDatePicker; // זה Facade!
```

**✅ נכון:**
```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;
```

---

### 2. Assets Not Loading / נכסים לא נטענים

**English:**
If the date picker appears but doesn't work properly:

1. Make sure you've published the assets:
```bash
php artisan vendor:publish --tag="hebrew-date-picker-assets"
```

2. Clear your cache:
```bash
php artisan view:clear
php artisan config:clear
```

**עברית:**
אם בורר התאריכים מופיע אבל לא עובד כראוי:

1. וודאו שפרסמתם את הנכסים:
```bash
php artisan vendor:publish --tag="hebrew-date-picker-assets"
```

2. נקו את המטמון:
```bash
php artisan view:clear
php artisan config:clear
```

---

### 3. Hebrew Text Not Displaying Correctly / טקסט עברי לא מוצג נכון

**English:**
If Hebrew text appears garbled or in the wrong direction:

1. Make sure your database supports UTF-8:
```sql
-- Check your database charset
SHOW VARIABLES LIKE 'character_set%';
```

2. Ensure your HTML has proper charset:
```html
<meta charset="UTF-8">
```

3. Check your CSS supports RTL:
```css
.hebrew-text {
    direction: rtl;
    text-align: right;
}
```

**עברית:**
אם הטקסט העברי מופיע מעוות או בכיוון הלא נכון:

1. וודאו שמסד הנתונים תומך ב-UTF-8:
```sql
-- בדיקת charset של מסד הנתונים
SHOW VARIABLES LIKE 'character_set%';
```

2. וודאו ש-HTML שלכם עם charset נכון:
```html
<meta charset="UTF-8">
```

3. בדקו שה-CSS תומך ב-RTL:
```css
.hebrew-text {
    direction: rtl;
    text-align: right;
}
```

---

### 4. IntlCalendar Extension Missing / הרחבת IntlCalendar חסרה

**English:**
If you get errors related to `IntlCalendar`:

**Install the PHP intl extension:**

Ubuntu/Debian:
```bash
sudo apt-get install php-intl
sudo service apache2 restart  # or nginx
```

CentOS/RHEL:
```bash
sudo yum install php-intl
sudo service httpd restart
```

macOS (with Homebrew):
```bash
brew install php@8.1-intl
```

Windows (XAMPP):
1. Open `php.ini`
2. Uncomment: `extension=intl`
3. Restart Apache

**עברית:**
אם אתם מקבלים שגיאות הקשורות ל-`IntlCalendar`:

**התקינו את הרחבת PHP intl:**

Ubuntu/Debian:
```bash
sudo apt-get install php-intl
sudo service apache2 restart  # או nginx
```

CentOS/RHEL:
```bash
sudo yum install php-intl
sudo service httpd restart
```

macOS (עם Homebrew):
```bash
brew install php@8.1-intl
```

Windows (XAMPP):
1. פתחו `php.ini`
2. הסירו הערה מ: `extension=intl`
3. הפעילו מחדש את Apache

---

### 5. Validation Issues / בעיות וולידציה

**English:**
If date validation isn't working:

1. Check your date format:
```php
HebrewDatePicker::make('date')
    ->displayFormat('j בM Y') // For Hebrew
    ->required()
    ->rules(['date']) // Add Laravel date validation
```

2. Verify min/max dates:
```php
HebrewDatePicker::make('date')
    ->minDate(now()->subYears(100))
    ->maxDate(now()->addYears(5))
```

**עברית:**
אם וולידציה של תאריכים לא עובדת:

1. בדקו את פורמט התאריך:
```php
HebrewDatePicker::make('date')
    ->displayFormat('j בM Y') // לעברית
    ->required()
    ->rules(['date']) // הוספת וולידציה של Laravel
```

2. וודאו תאריכים מינימליים/מקסימליים:
```php
HebrewDatePicker::make('date')
    ->minDate(now()->subYears(100))
    ->maxDate(now()->addYears(5))
```

---

### 6. Component Not Found / רכיב לא נמצא

**English:**
If Filament can't find the component:

1. Make sure the package is installed:
```bash
composer require eli-sheinfeld/hebrew-date-picker
```

2. Clear Laravel cache:
```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

3. Check your import statement:
```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDateDisplay;
```

**עברית:**
אם Filament לא מוצא את הרכיב:

1. וודאו שהחבילה מותקנת:
```bash
composer require eli-sheinfeld/hebrew-date-picker
```

2. נקו מטמון Laravel:
```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

3. בדקו את הייבוא:
```php
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;
use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDateDisplay;
```

---

## Getting Help / קבלת עזרה

**English:**
If you're still having issues:

1. Check the [GitHub Issues](https://github.com/eli-sheinfeld/hebrew-date-picker/issues)
2. Create a new issue with:
   - PHP version
   - Laravel version
   - Filament version
   - Complete error message
   - Code that reproduces the problem

**עברית:**
אם עדיין יש לכם בעיות:

1. בדקו ב-[GitHub Issues](https://github.com/eli-sheinfeld/hebrew-date-picker/issues)
2. צרו issue חדש עם:
   - גרסת PHP
   - גרסת Laravel
   - גרסת Filament
   - הודעת שגיאה מלאה
   - קוד שמשחזר את הבעיה
