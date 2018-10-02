<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('notice');
});
Route::get('/user', 'UserController@index');
//Route::post('/user/login','UserController@login');
Route::get('/user/logout', 'UserController@logout');

Auth::routes();
Route::get('/create', 'ChallengeController@index');
Route::post('/newchallenge', 'ChallengeController@newchallenge');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/edit/{id}', 'ChallengeController@edit');
Route::post('/editchallenge/{id}', 'ChallengeController@editchallenge');
Route::get('/profile','UserController@profile');
Route::post('/ProfileEdit','UserController@ProfileEdit');
Route::delete('/delete/{id}','ChallengeController@delete');
Route::get('/userDetail/{id}','ChallengeController@userDetail');
Route::post('time','timecontroller@gamestart');
Route::get('newteam','teamcontroller@newteampage');
Route::post('createnewteam','teamcontroller@createteam');
Route::post('join','teamcontroller@jointeam');
Route::get('jointeam',function(){return view('jointeam');});
Route::get('team','teamcontroller@teamindex');
Route::get('teamdetail/{id}','teamcontroller@teamdetail');

Route::get('/gamemanage','timecontroller@index');
Route::get('gameover','timecontroller@over');
// 计分板测试
Route::get('/scoreboard/', 'ChallengeController@ShowScoreBoard');

Route::get('/score', 'ChallengeController@ShowScore');

Route::get('about',function(){return view('about');});

Route::get('publishNotice','NoticeController@index');

Route::post('newNotice','NoticeController@newnotice');

Route::get('notice','NoticeController@showNotice')->name('notice');

Route::get('notice/edit/{id}','NoticeController@editIndex');

Route::post('editNotice/{id}','NoticeController@edit');

Route::delete('deleteNotice/{id}','NoticeController@delete');

Route::get('challenges', 'ChallengeController@showChallenges')->name('challenge');   //展示对应版块题目

Route::post('submitflag/{id}', 'ChallengeController@submitFlag');

Route::get('/test', 'ChallengeController@getQuestionsBelongsToClass');

Route::get('SubmitsBoard','teamcontroller@submitsHistory');

Route::get('IN1t4dmin_Cg_c7f_X1c_+1s',function(){return view('regadmin');});

Route::post('regadmin','UserController@regadmin');


// Route::get('lock',function(){
// 	DB::beginTransaction();
// 	$count=App\challenge_user::where([['userid','=',195],['challengeid','=',195]])->lockForUpdate()->count();
//             if($count==0)  {App\challenge_user::create(['userid' => 195, 'challengeid' => 195]);echo 1;}
//             else echo 0;
//     DB::commit();
// });

