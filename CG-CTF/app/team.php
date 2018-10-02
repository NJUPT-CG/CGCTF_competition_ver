<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class team extends Model
{	
	protected $table = 'teams';
	protected $fillable = [
        'name', 'password', 'fresh', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   public function members()
    {
        return $this->hasMany('App\User');
    }

    public static function teamscore($id){
    	$team = team::find($id);
    	$member=$team->members;
        $total=0;
        foreach ($member as $user) {
            $total+=User::userscore($user['id']);
        }
        $candy = $team->candy;
    	//print $member['id'];
    	return $total+$candy;
    }

    // public static function teammember($id){
    // 	return team::find($id)->members()->get();
    // }

    public static function solvedchallenges($id)
    {
         if(!$id) return [];
         $team = team::find($id);
         $users = $team->members;
         $challenges =collect([]);
         foreach ($users as $user) {
            $c = $user->challenges()->get();
            foreach ($c as $ch) {
                $ch = collect($ch);
                $ch->put('solver',$user->name);
                $challenges->push($ch);
            }         
         }
         $sorted = $challenges->sortByDesc('pivot.created_at');
        return $sorted->values();

    }


    public function challengePassed($challenge)
    {
        return !!team::solvedchallenges($this->id)->where('id', $challenge)->count();
    }

    public static function scoreboard($type)
    {
        $scores = collect([]);

        if($type=='fresh'){$users = team::where('fresh','fresh')->get();}
        if($type=='old'){$users = team::where('fresh','old')->get();}
        if($type=='all'){$users = team::where([])->get();}
        foreach ($users as $user) {
            #echo $user;
            $id = $user->id;
            $name = $user->name;
            $fresh = $user->fresh;
            $totalScore = team::teamscore($id);
            $lastsubtime = $user->updated_at;
            #pivot['created_at'];
            $scores->push(array('id' => $id, 'name' => $name,'fresh'=>$fresh, 'totalScore' => $totalScore, 'lastsubtime' => $lastsubtime));
            #echo $totalScore;
            #echo '<br>';
            #$user->put('totalScore',$totalScore);
        }
        //echo $scores;
        //$sorted = $scores->sortBy('lastsubtime')->sortByDesc('totalScore');
        $sorted = $scores->sort(
            function ($a, $b) {
                return ($b['totalScore'] - $a['totalScore']) ?: strcmp($a['lastsubtime'], $b['lastsubtime']);
            }
        );
        //echo $sorted;
        $rank = 0;
        foreach ($sorted as $sort => $v) {
            $temp = collect($sorted[$sort]);
            $temp->put('rank', ++$rank);
            $sorted[$sort] = $temp->toArray();
        }
        return $sorted->values();
    }


}
