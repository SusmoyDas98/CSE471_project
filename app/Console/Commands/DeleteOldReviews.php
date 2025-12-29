<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Console\Command;

class DeleteOldReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $deleteCount = DB::table('website_reviews')->where('label', 'Deleted')->where('label_markerd_at', "<=", Carbon::now()->subDays(30))->delete();
        $this->info($deleteCount." delted reviews older than 30 days are removed from database.");
    }
}
