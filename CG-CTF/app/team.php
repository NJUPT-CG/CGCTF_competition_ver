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
    	$member=$team->members()->first();
    	//print $member['id'];
    	return User::userscore($member['id']);
    }

    // public static function teammember($id){
    // 	return team::find($id)->members()->get();
    // }

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
            $totalScore = team::teamscore($id);
            $lastsubtime = $user->updated_at;
            #pivot['created_at'];
            $scores->push(array('id' => $id, 'name' => $name, 'totalScore' => $totalScore, 'lastsubtime' => $lastsubtime));
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
