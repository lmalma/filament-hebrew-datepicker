<?php

namespace Eli Sheinfeld\HebrewDatePicker\Commands;

use Illuminate\Console\Command;

class HebrewDatePickerCommand extends Command
{
    public $signature = 'hebrew-date-picker';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
