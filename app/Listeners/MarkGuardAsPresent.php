<?php

namespace App\Listeners;

use App\Events\MarkAttendance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MarkGuardAsPresent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MarkAttendance  $event
     * @return void
     */
    public function handle(MarkAttendance $event)
    {
        $guard = $event->guard;

        $time_in = Carbon::now($guard->site->timezone)->format('H:i:m');
        $day = Carbon::now($guard->site->timezone)->toDateString();



        $attendance = $guard->attendances()->create([
            'company_id' => $guard->company_id,
            'site_id' => $guard->site_id,
            'day' => $day,
            'time_in' => $time_in,
            'time_out' => NULL,
        ]);

        return $attendance;
    }
}
