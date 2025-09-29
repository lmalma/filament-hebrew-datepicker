<?php

namespace EliSheinfeld\HebrewDatePicker\Forms\Components;

use EliSheinfeld\HebrewDatePicker\Support\HebrewCalendar;
use Filament\Forms\Components\Field;

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

    public function minDate(string | \DateTimeInterface | null $date): static
    {
        $this->minDate = $date;

        return $this;
    }

    public function maxDate(string | \DateTimeInterface | null $date): static
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

    public function getDatalistOptions(): array
    {
        return [];
    }

    public function getExtraAlpineAttributes(): array
    {
        return [];
    }

    public function getExtraAttributes(): array
    {
        return [];
    }

    public function getExtraAttributeBag(): \Illuminate\View\ComponentAttributeBag
    {
        return new \Illuminate\View\ComponentAttributeBag([]);
    }

    public function getExtraTriggerAttributeBag(): \Illuminate\View\ComponentAttributeBag
    {
        return new \Illuminate\View\ComponentAttributeBag([]);
    }

    public function getPrefixIconColor(): ?string
    {
        return null;
    }

    public function getSuffixIconColor(): ?string
    {
        return null;
    }

    public function getPrefixActions(): array
    {
        return [];
    }

    public function getSuffixActions(): array
    {
        return [];
    }

    public function getPrefixIcon(): ?string
    {
        return null;
    }

    public function getSuffixIcon(): ?string
    {
        return null;
    }

    public function getPrefixLabel(): ?string
    {
        return null;
    }

    public function getSuffixLabel(): ?string
    {
        return null;
    }

    public function isPrefixInline(): bool
    {
        return false;
    }

    public function isSuffixInline(): bool
    {
        return false;
    }

    public function isReadOnly(): bool
    {
        return false;
    }

    public function isAutofocused(): bool
    {
        return false;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->default(null);
    }
}
