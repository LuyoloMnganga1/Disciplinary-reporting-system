<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteOldAudits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-audits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete audits older than one year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Assuming the audits table has a 'created_at' timestamp column
        $oneYearAgo = Carbon::now()->subYear();

        DB::table('audits')
            ->where('created_at', '<', $oneYearAgo)
            ->delete();

        $this->info('Old audits deleted successfully.');

        return 0;
    }
}
