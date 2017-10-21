<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\time;
use Carbon\Carbon;
use App\User;
use App\challenge;
class timecontroller extends Controller
{
    public function index(){
    	return view('manage');
    }
    public function over(){
    	if(User::isadmin()){
    	$challenges=challenge::where([])->update(['info' => 'over']);
    	DB::table('jobs')->truncate();
        return '比赛结束！！！';
    	}
    	else return redirect()->route('login');	
    }
    public function gamestart(Request $data){
    	$min=$data['min'];
    	if(User::isadmin()){
    	$challenges=challenge::where([])->update(['info' => 'start']);
    	$job = (new time())->delay(Carbon::now()->addMinute($min));
        dispatch($job);
        return '比赛开始！！！';
    	}
    	else return redirect()->route('login');
    }
}
