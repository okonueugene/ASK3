<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Patrol;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateHistoryStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:history-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status on histories table';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::alert("Command started - updating status");
        $companies = Company::all();

        if ($companies) {
            foreach ($companies as $company) {
                $sites = Site::where('company_id', $company->id)->get();

                $now = Carbon::now();
                $today = $now->toDateString();
                // Loop through all sites
                foreach ($sites as $site) {
                    $nowInSiteTimezone = $now->copy()->setTimezone($site->timezone);

                    $patrols = Patrol::where('site_id', $site->id)
                        ->where('type', 'scheduled')
                        ->where('end', '<', $nowInSiteTimezone->toDateTimeString())
                        ->whereRelation('history', 'date', $today)
                        ->get();

                    // Loop through all patrols
                    foreach ($patrols as $patrol) {
                        $nowInSiteTimezone = Carbon::now()->timezone($patrol->site->timezone);

                        // Get all upcoming history entries for the current patrol and current day
                        $histories = $patrol->history()
                            ->whereDate('date', $nowInSiteTimezone->toDateString())
                            ->where('status', 'upcoming')
                            ->get();

                        // Update each history entry to "missed"
                        foreach ($histories as $history) {
                            $history->update([
                                'status' => 'missed',
                                'updated_at' => Carbon::now()->toDateTimeString(),
                            ]);
                        }
                    }
                }

            }

            Log::info("Command ended - updated status");
        }
    }
}
