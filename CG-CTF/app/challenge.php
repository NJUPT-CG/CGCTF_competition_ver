<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class challenge extends Model
{
    //
    protected $table = 'Challenges';
    protected $fillable = ['title', 'class', 'description', 'url', 'flag', 'info', 'score'];
    protected $hidden = ['flag'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'challenge_users', 'challengeid', 'userid')->withPivot('created_at','rank');
    }

    //返回某题目解决的用户
    public static function solvedusers($challengeid)
    {
        $challenge = challenge::find($challengeid);
        $users = $challenge->users()->get();
        $sorted = $users->sortBy('pivot.created_at');
        return $sorted->values();
    }

    public function solvedteams(){
        $users = $this->users()->get();
        $users = $users->sortBy('pivot.created_at');
        $teams = collect([]);
        //$sr = 1;
        foreach ($users as $user) {
            $team=$user->team()->first();
            $sr = $user->pivot->rank;
            if($team){$teams->push(array('name'=>$team['name'],'updated_at'=> $user['pivot']['created_at'],'srank'=>$sr)); }#
           // $sr++;
        }
        return $teams;
    }
}