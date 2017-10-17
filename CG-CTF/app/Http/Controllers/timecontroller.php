<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\time;
use Carbon\Carbon;
use App\User;
use App\challenge;
class timecontroller extends Controller
{
    public function gamestart($min){
    	if(User::isadmin()){
    	$challenges=challenge::where([])->update(['info' => 'start']);
    	$job = (new time())->delay(Carbon::now()->addMinute($min));
        dispatch($job);
    	}
    	else return redirect()->route('login');
    }
}
