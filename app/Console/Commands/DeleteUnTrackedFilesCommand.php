<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Repositories\Contracts\FileContract;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DeleteUnTrackedFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'untracked_files:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete files where has no relations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        app(FileContract::class)->deleteFiles(File::whereNull('fileable_type')->get());
        return CommandAlias::SUCCESS;
    }
}
