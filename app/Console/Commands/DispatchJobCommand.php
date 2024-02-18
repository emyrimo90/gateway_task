<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DispatchJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:dispatch {job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch job';

    /**
     * Execute the console command.
     *
     */
    public function handle(): void
    {
        $class = '\\App\\Jobs\\' . $this->argument('job');
        dispatch(new $class());
    }
}
