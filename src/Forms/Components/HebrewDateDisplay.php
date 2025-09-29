<?php

namespace EliSheinfeld\HebrewDatePicker\Forms\Components;

use Carbon\Carbon;
use EliSheinfeld\HebrewDatePicker\Support\HebrewCalendar;
use Filament\Forms\Components\Placeholder;

class HebrewDateDisplay extends Placeholder
{
    protected string $view = 'hebrew-date-picker::hebrew-date-display';

    protected string $locale = 'he';

    protected string $displayFormat = 'j בM Y';

    protected bool $showGregorianDate = false;

    protected bool $showYearInGematria = false;

    public function locale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function displayFormat(string $format): static
    {
        $this->displayFormat = $format;

        return $this;
    }

    public function showGregorianDate(bool $condition = true): static
    {
        $this->showGregorianDate = $condition;

        return $this;
    }

    public function showYearInGematria(bool $condition = true): static
    {
        $this->showYearInGematria = $condition;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getDisplayFormat(): string
    {
        return $this->displayFormat;
    }

    public function getShowGregorianDate(): bool
    {
        return $this->showGregorianDate;
    }

    public function getShowYearInGematria(): bool
    {
        return $this->showYearInGematria;
    }

    public function getHebrewDateText(): string
    {
        $state = $this->getState();

        if (! $state) {
            return '';
        }

        try {
            $gregorianDate = Carbon::parse($state);
            $hebrewDate = HebrewCalendar::gregorianToHebrew($gregorianDate);

            $formattedDate = HebrewCalendar::formatHebrewDate(
                $hebrewDate,
                $this->locale,
                $this->displayFormat
            );

            // הצגת שנה בגימטריה
            if ($this->showYearInGematria) {
                $gematriaYear = HebrewCalendar::getHebrewYearInGematria($hebrewDate['year']);
                $formattedDate = str_replace($hebrewDate['year'], $gematriaYear, $formattedDate);
            }

            // הוספת תאריך גיאורגיאני
            if ($this->showGregorianDate) {
                $gregorianText = $gregorianDate->format('d/m/Y');
                $formattedDate .= $this->locale === 'he'
                    ? " ({$gregorianText})"
                    : " ({$gregorianText})";
            }

            return $formattedDate;

        } catch (\Exception $e) {
            return '';
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->content(fn (): string => $this->getHebrewDateText());
    }
}
