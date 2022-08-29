<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeUserStatus
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
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
		if ( !is_null($event->user->email_verified_at) ) {
			User::where('id', $event->user->id)->update(['status' => 'verified']);
		}
    }
}
