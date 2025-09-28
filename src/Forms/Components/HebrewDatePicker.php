<?php

namespace EliSheinfeld\HebrewDatePicker\Forms\Components;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Blade;
use EliSheinfeld\HebrewDatePicker\Support\HebrewCalendar;

class HebrewDatePicker extends Field
{
    protected string $view = 'hebrew-date-picker::hebrew-date-picker';

    protected bool $hasTime = false;

    protected bool $hasSeconds = false;

    protected ?string $displayFormat = null;

    protected ?string $minDate = null;

    protected ?string $maxDate = null;

    protected array $disabledDates = [];

    protected bool $closeOnDateSelection = true;

    protected ?string $placeholder = null;

    protected string $locale = 'he';

    protected int $firstDayOfWeek = 0; // 0 = Sunday for Hebrew calendar

    public function hasTime(bool $condition = true): static
    {
        $this->hasTime = $condition;

        return $this;
    }

    public function hasSeconds(bool $condition = true): static
    {
        $this->hasSeconds = $condition;

        return $this;
    }

    public function displayFormat(string $format): static
    {
        $this->displayFormat = $format;

        return $this;
    }

    public function minDate(string|\DateTimeInterface|null $date): static
    {
        $this->minDate = $date;

        return $this;
    }

    public function maxDate(string|\DateTimeInterface|null $date): static
    {
        $this->maxDate = $date;

        return $this;
    }

    public function disabledDates(array $dates): static
    {
        $this->disabledDates = $dates;

        return $this;
    }

    public function closeOnDateSelection(bool $condition = true): static
    {
        $this->closeOnDateSelection = $condition;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function locale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function firstDayOfWeek(int $day): static
    {
        $this->firstDayOfWeek = $day;

        return $this;
    }

    public function getHasTime(): bool
    {
        return $this->hasTime;
    }

    public function getHasSeconds(): bool
    {
        return $this->hasSeconds;
    }

    public function getDisplayFormat(): string
    {
        return $this->displayFormat ?? 'j בM Y';
    }

    public function getMinDate(): ?string
    {
        return $this->minDate;
    }

    public function getMaxDate(): ?string
    {
        return $this->maxDate;
    }

    public function getDisabledDates(): array
    {
        return $this->disabledDates;
    }

    public function getCloseOnDateSelection(): bool
    {
        return $this->closeOnDateSelection;
    }

    public function getPlaceholder(): string
    {
        if ($this->placeholder) {
            return $this->placeholder;
        }

        return $this->locale === 'he' 
            ? 'בחר תאריך עברי' 
            : 'Select Hebrew date';
    }

    public function getHebrewMonthNames(): array
    {
        return HebrewCalendar::getHebrewMonthNames($this->locale);
    }

    public function getHebrewDayNames(): array
    {
        return HebrewCalendar::getHebrewDayNames($this->locale);
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getFirstDayOfWeek(): int
    {
        return $this->firstDayOfWeek;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->default(null);
    }
}
