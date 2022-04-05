<?php

namespace FilamentPro\Features\Commands;

use Illuminate\Console\Command;

class FeaturesCommand extends Command
{
    public $signature = 'filament-features';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
