<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\challenge;
use App\challenge_user;
use App\User;
use App\team;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Hash;
use Validator;

class teamcontroller extends Controller
{
    public function teamindex(){
    	if(Auth::check()){
    			$user = Auth::user();
    			if(!$user->team){
    				return view('teamindex')->with(['userdata'=>$user,'team'=>false]);
    			}
    			else {
    				$team=$user->team;
    				$teamates=$team->members()->get();
    				$id = $team->id;
            		$score = team::teamscore($id);
            		$challenges = team::solvedchallenges($id);
    				return view('teamindex')->with(['teamdata'=>$team,
    												'users'=>$teamates,
    												'score' => $score, 
    												'challenges' => $challenges,
    												'team'=> true,
                                                    'is_team_member' =>true,
                                                    'token'=>$team->password,
                                                    ]);
    			}

    	}
    	else return redirect()->route('login');
    }

    public function teamdetail($id,Request $data){
    		$team=team::find($id);
            $team_token = '';
            $IsTeamMember =false;
            if(Auth::check())
                {
                    $user = Auth::user();

                    if($user->team&& strval($user->team->id)===$id)
                    {   
                        $IsTeamMember =true;
                        $team_token = $user->team->password;
                    }
                }
    		if(!$team->members()->count()) return view('teamindex')->with(['team'=>true,'is_team_member'=>$IsTeamMember,'token'=>$team_token]);
    		$teamates=$team->members()->get();
    		$uid=$teamates[0]->id;
    		$score =team::teamscore($id);
    		$challenges = team::solvedchallenges($id);                
    		return view('teamindex')->with(['teamdata'=>$team,
    										'users'=>$teamates,
    										'score' => $score, 
    										'challenges' => $challenges,
    										'team'=> true,
                                            'is_team_member' =>$IsTeamMember,
                                            'token'=>$team_token,
                                            ]);

    }
    public function TeamsDetails(Request $data)
    {
        $ids = $data['list'];
        $ids = collect($ids);
        $teams = collect([]);
        foreach ($ids as $id) 
        {
           //$team = team::find($id);
           $solved = team::solvedchallenges($id);
           foreach ($solved as $s => $v) {
               $time = $solved[$s]['pivot']['created_at'];
               $solved[$s] = $solved[$s]->only('id','score','srank');
               if($solved[$s]['srank'] == 1) $solved[$s]['score'] = round($solved[$s]['score']*1.06);
               if($solved[$s]['srank'] == 2) $solved[$s]['score'] = round($solved[$s]['score']*1.03);
               if($solved[$s]['srank'] == 3) $solved[$s]['score'] = round($solved[$s]['score']*1.02);
               $solved[$s]->put('time',$time);
           }
           //dd($solved);
           $teams->put($id,$solved);
        }
        return $teams;
    }
    public function newteampage(){
    	if(Auth::check()){
    		return view('newteam');
    	}
    	else return redirect()->route('login');
    }
    public function submitsHistory(Request $data){
        $users=User::all();
        $sub=collect([]);
        foreach ($users as $user) {
            $sol=User::solvedchallenges($user->id);
            
            foreach ($sol as $s) {
                $test = array('name'=>$user->team['name'],'challenge'=>$s['title'],'score'=>$s['score'],'class'=>$s['class'],'time'=>$s['pivot']['created_at']->toDateTimeString());
                $sub->push($test);
            }
        }
        
        if($data->has('api')) return $sub->sortByDesc('time')->values();
        return view('results',['challenges'=>$sub->sortByDesc('time')]);
    }
    public function createteam(Request $data){
    		$data->flash();
    	   	if(Auth::check()){
    			$user = Auth::user();
    			if(!$user->team){
    				$request=$data->all();
    				 $v = Validator::make($request, [
                    'name' => 'required|string|max:255|unique:teams',
                    'fresh' =>'required',
                	]);
    				if ($v->fails()) {
               		 return redirect()->to('newteam')->withErrors($v->errors());
            		} else {
            		$myteam=team::create([
            		'name' => $request['name'],
            		'password' => str_random(32),
            		'fresh' => $request['fresh'],
            		'api_token' => str_random(60),
                    'candy' => 0,
        			]);
            		}
            		$user->challenges()->detach();
            		$myteam->members()->save($user);
            		return redirect()->to('team');
            	}
            	else{return redirect()->to('team');}

    		}
    	else return redirect()->route('login');

    }

    public function jointeam(Request $data){
    		$data->flash();
    		$request=$data->all();
    		if(Auth::check()){
    			$user = Auth::user();
    			if(!$user->team){
    			$team = team::where('name',$request['name'])->first();
    			if(!$team) return redirect()->to('jointeam')->withErrors(['name'=>'there is no such team!']);
    			$sum=$team->members()->count();
    			if($sum<4&&$sum>=0){
    				if($request['password']===$team->password){
    					$user->challenges()->detach();
    					// $teamate=$team->members()->first();
         //                if($teamate){
    					// $teamsolved=User::solvedchallenges($teamate->id);
         //                }
         //                else $teamsolved=[];
						$team->members()->save($user);
						// foreach ($teamsolved as $solved) {
						// 	challenge_user::create(['userid' => $user->id, 'challengeid' => $solved->id]);
						// }
    					//return 'mmmm';
    					return redirect()->to('team');
    				}
    				else{
    					return redirect()->to('jointeam')->withErrors(['password'=>'Wrong password!']);
    				}
    			}
    			else{
    				return redirect()->to('jointeam')->withErrors(['name'=>'no more than 4 members!']);
    				}
    			}
    			else {
    				//return 'qqqq';
    				return redirect()->to('team');
    			}
    		}
    		else return redirect()->route('login');
    }

}
