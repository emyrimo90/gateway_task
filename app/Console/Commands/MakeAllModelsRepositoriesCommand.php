<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class MakeAllModelsRepositoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:all-repositories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate all models related files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $models = Storage::disk('app')->files('Models');
        foreach ($models as $model) {
            $model= str_replace(array('.php', '/', 'Models'), array(null, '\\', ''), $model);
            Artisan::call('make:repository '.$model.' --namespace="Dashboard\\\V1" --api="V1"');
            $this->info('files related to '.$model.' has been created');
        }
        return 0;
    }
}
