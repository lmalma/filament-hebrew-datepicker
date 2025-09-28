<?php

namespace EliSheinfeld\HebrewDatePicker\Tests;

use EliSheinfeld\HebrewDatePicker\Forms\Components\HebrewDatePicker;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Form;
use Illuminate\Support\Facades\Config;

class HebrewDatePickerTest extends TestCase
{
    /** @test */
    public function it_can_create_hebrew_date_picker_component()
    {
        $component = HebrewDatePicker::make('hebrew_date');

        $this->assertInstanceOf(HebrewDatePicker::class, $component);
        $this->assertEquals('hebrew_date', $component->getName());
    }

    /** @test */
    public function it_has_correct_default_view()
    {
        $component = HebrewDatePicker::make('hebrew_date');

        $this->assertEquals('hebrew-date-picker::hebrew-date-picker', $component->getView());
    }

    /** @test */
    public function it_can_set_and_get_locale()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->locale('en');

        $this->assertEquals('en', $component->getLocale());
    }

    /** @test */
    public function it_has_hebrew_as_default_locale()
    {
        $component = HebrewDatePicker::make('hebrew_date');

        $this->assertEquals('he', $component->getLocale());
    }

    /** @test */
    public function it_can_enable_time_selection()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->hasTime();

        $this->assertTrue($component->getHasTime());
    }

    /** @test */
    public function it_can_enable_seconds()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->hasTime()
            ->hasSeconds();

        $this->assertTrue($component->getHasTime());
        $this->assertTrue($component->getHasSeconds());
    }

    /** @test */
    public function it_can_set_display_format()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->displayFormat('j M Y');

        $this->assertEquals('j M Y', $component->getDisplayFormat());
    }

    /** @test */
    public function it_has_default_display_format()
    {
        $component = HebrewDatePicker::make('hebrew_date');

        $this->assertEquals('j בM Y', $component->getDisplayFormat());
    }

    /** @test */
    public function it_can_set_min_and_max_dates()
    {
        $minDate = '2024-01-01';
        $maxDate = '2024-12-31';

        $component = HebrewDatePicker::make('hebrew_date')
            ->minDate($minDate)
            ->maxDate($maxDate);

        $this->assertEquals($minDate, $component->getMinDate());
        $this->assertEquals($maxDate, $component->getMaxDate());
    }

    /** @test */
    public function it_can_set_disabled_dates()
    {
        $disabledDates = ['2024-01-01', '2024-01-02'];

        $component = HebrewDatePicker::make('hebrew_date')
            ->disabledDates($disabledDates);

        $this->assertEquals($disabledDates, $component->getDisabledDates());
    }

    /** @test */
    public function it_can_set_first_day_of_week()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->firstDayOfWeek(1); // Monday

        $this->assertEquals(1, $component->getFirstDayOfWeek());
    }

    /** @test */
    public function it_has_sunday_as_default_first_day_of_week()
    {
        $component = HebrewDatePicker::make('hebrew_date');

        $this->assertEquals(0, $component->getFirstDayOfWeek());
    }

    /** @test */
    public function it_can_set_close_on_date_selection()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->closeOnDateSelection(false);

        $this->assertFalse($component->getCloseOnDateSelection());
    }

    /** @test */
    public function it_has_close_on_date_selection_enabled_by_default()
    {
        $component = HebrewDatePicker::make('hebrew_date');

        $this->assertTrue($component->getCloseOnDateSelection());
    }

    /** @test */
    public function it_can_set_custom_placeholder()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->placeholder('Custom placeholder');

        $this->assertEquals('Custom placeholder', $component->getPlaceholder());
    }

    /** @test */
    public function it_has_localized_default_placeholder()
    {
        $hebrewComponent = HebrewDatePicker::make('hebrew_date')
            ->locale('he');

        $englishComponent = HebrewDatePicker::make('hebrew_date')
            ->locale('en');

        $this->assertEquals('בחר תאריך עברי', $hebrewComponent->getPlaceholder());
        $this->assertEquals('Select Hebrew date', $englishComponent->getPlaceholder());
    }

    /** @test */
    public function it_can_be_disabled()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->disabled();

        $this->assertTrue($component->isDisabled());
    }

    /** @test */
    public function it_can_be_required()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->required();

        $this->assertTrue($component->isRequired());
    }

    /** @test */
    public function it_handles_null_state_correctly()
    {
        $component = HebrewDatePicker::make('hebrew_date');

        $this->assertNull($component->getState());
    }

    /** @test */
    public function it_validates_hebrew_date_format()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->required();

        // Test with invalid date format
        $component->state('invalid-date');
        $this->assertFalse($component->isValid());

        // Test with valid ISO date
        $component->state('2024-01-01T00:00:00Z');
        $this->assertTrue($component->isValid());
    }

    /** @test */
    public function it_respects_min_max_date_constraints()
    {
        $component = HebrewDatePicker::make('hebrew_date')
            ->minDate('2024-01-01')
            ->maxDate('2024-12-31');

        // Test date before min
        $component->state('2023-12-31T00:00:00Z');
        $this->assertFalse($component->isValid());

        // Test date after max
        $component->state('2025-01-01T00:00:00Z');
        $this->assertFalse($component->isValid());

        // Test valid date within range
        $component->state('2024-06-15T00:00:00Z');
        $this->assertTrue($component->isValid());
    }

    /** @test */
    public function it_can_be_used_in_form()
    {
        $form = Form::make()
            ->schema([
                HebrewDatePicker::make('hebrew_birthday')
                    ->label('Hebrew Birthday')
                    ->required()
                    ->hasTime(),
            ]);

        $container = ComponentContainer::make($form);
        
        $this->assertInstanceOf(ComponentContainer::class, $container);
        
        $component = $container->getComponent('hebrew_birthday');
        $this->assertInstanceOf(HebrewDatePicker::class, $component);
        $this->assertEquals('Hebrew Birthday', $component->getLabel());
        $this->assertTrue($component->isRequired());
        $this->assertTrue($component->getHasTime());
    }
}
