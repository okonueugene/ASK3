<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\Patrol;
use App\Models\PatrolHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePatrolHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:patrol-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update patrol history';

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
        Log::alert("Command started");

        $timezones = DB::table('timezones')->select('timezones')->get();


        $midnight = [];

        foreach ($timezones as $timezone) {
            if (now($timezone->timezones)->hour == 0) {
                $midnight[] = $timezone->timezones;
            }
        }

        $sites = Site::whereIn('timezone', $midnight)->get();

        if ($sites) {
            foreach ($sites as $site) {
                $patrols = Patrol::with('tags')->where('site_id', $site->id)->get();

                foreach ($patrols as $patrol) {
                    if ($patrol->owner->shifts()->count() > 0) {
                        //check id owner has a shift for the day
                        $ownerhasshift = $patrol->owner->shifts->where('day', Carbon::now()->format('l'))->first();
                        if ($ownerhasshift) {
                            foreach ($patrol->tags as $tag) {
                                $today = Carbon::now($site->timezone)->toDateString('Y-m-d');

                                PatrolHistory::updateOrCreate([
                                    'company_id' => $site->company->id,
                                    'site_id' => $site->id,
                                    'guard_id' => $patrol->owner->id,
                                    'patrol_id' => $patrol->id,
                                    'tag_id' => $tag->id,
                                    'date' => $today,
                                    'status' => 'upcoming',
                                ]);
                            }
                        }
                    } else {
                        foreach ($patrol->tags as $tag) {
                            $today = Carbon::now($site->timezone)->toDateString('Y-m-d');

                            PatrolHistory::updateOrCreate([
                                'company_id' => $site->company->id,
                                'site_id' => $site->id,
                                'guard_id' => $patrol->owner->id,
                                'patrol_id' => $patrol->id,
                                'tag_id' => $tag->id,
                                'date' => $today,
                                'status' => 'upcoming',
                            ]);
                        }
                    }
                }
            }
        }

        Log::info("Command ended");
    }
}
