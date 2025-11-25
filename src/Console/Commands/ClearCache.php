<?php

namespace FeatureKit\Console\Commands;

use App\Console\BaseCommand;

class ClearCache extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'features:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean cached features';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if(!config('featurekit.cache.enabled')){
            $this->warn('Features cache is disabled');
            return;
        }
    }
}
