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
        return $this->belongsToMany('App\User', 'challenge_users', 'challengeid', 'userid')->withPivot('created_at');
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
        $teams = collect([]);
        foreach ($users as $user) {
            $team=$user->team()->first();
            if(!$team){$teams->push(array('name'=>$user['name'],'updated_at'=>$user['pivot']['created_at']));}            
            else {$teams->push(array('name'=>$team['name'],'updated_at'=>$team['updated_at']));}
        }
        $grouped = $teams->keyBy('name');
        return $grouped->values()->sortBy('updated_at');
    }
}