<?php

namespace App\Console\Commands;

use App\Services\JobService;
use Illuminate\Console\Command;

class FetchJobs extends Command
{
    protected $signature   = 'jobs:fetch';
    protected $description = 'Fetch all jobs from the external API and sync to the database';

    public function handle(JobService $jobService): int
    {
        $this->info('Fetching jobs from external API...');

        $total = $jobService->fetchAndSync();

        $this->info("✅ Done! {$total} job(s) synced to the database.");

        return Command::SUCCESS;
    }
}
