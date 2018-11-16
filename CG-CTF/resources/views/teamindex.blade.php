@extends('layouts.app')

@section('content')
<div class="container">
    @if(!$team)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$userdata['name']}}" readonly>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $userdata['email']}}" readonly>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-primary" href="{{url('newteam')}}" role="button">创建队伍</a>
                                <a class="btn btn-success" href="{{url('jointeam')}}" role="button">加入队伍</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container">
<table class="table table-hover">
    <h3  style="font-weight:bold;font-size:large;">TEAM:<data-text text="{{ $teamdata['name'] or '' }}"/></h3>
    @if(isset($is_team_member)) 
    @if($is_team_member)
      <h3 style="font-weight:bold;font-size:large;">TEAM TOKEN:<data-text text="{{$token or '' }}"/></h3> 
    @endif
    @endif
    <caption>Team member</caption>
   <thead>
      <tr>
         <th>name</th>
         @if(App\User::isadmin())
          <th>email</th>
          @endif
          <th>姓名</th>
          @if(App\User::isadmin())
          <th>学号</th>
          @endif
      </tr>
   </thead>
   @if(isset($users))
       @foreach($users as $user)
    <tbody>
         <td><data-text text="{{$user['name']}}"/></td>
         @if(App\User::isadmin())
          <td><data-text text="{{$user['email']}}"/></td>
          @endif
          <td><data-text text="{{$user['realname']}}"/></td>
          @if(App\User::isadmin())
          <td><data-text text="{{$user['snumber']}}"/></td>
          @endif
       </tr>
   </tbody>
       @endforeach
    @endif
</table>

<table class="table">
    <caption>Total Score:{{$score or '' }}</caption>
   <thead>
      <tr>
      <th>Title</th>
          <th>score</th>
          <th>solver</th>
          <th>rank</th>
          <th>time</th>
      </tr>
   </thead>
   @if(isset($challenges))
       @foreach($challenges as $challenge)
    <tbody>
      <tr>
      <td><data-text text="{{$challenge['title']}}"/></td>
          <td><data-text text="{{$challenge['score']}}"/></td>
          <td><data-text text="{{$challenge['solver']}}"/></td>
          <td><data-text text="{{$challenge['srank']}}"/></td>
          <td><data-text text="{{$challenge['pivot']['created_at']}}"/></td>
       </tr>
   </tbody>
       @endforeach
    @endif
</table>

    @endif
</div>
@endsection