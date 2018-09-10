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
    <caption  style="font-weight:bold;font-size:large;">TEAM:{{$teamdata['name'] or '' }}</caption>
    @if(isset($is_team_member))
    @if($is_team_member)
      <caption  style="font-weight:bold;font-size:large;">TEAM TOKEN:{{$token or '' }}</caption> 
    @endif
    @endif
    <caption>Team member</caption>
   <thead>
      <tr>
         <th>name</th>
          <th>email</th>
          <th>姓名</th>
          <th>学号</th>
      </tr>
   </thead>
   @if(isset($users))
       @foreach($users as $user)
    <tbody>
         <td>{{$user['name']}}</td>
          <td>{{$user['email']}}</td>
          <td>{{$user['realname']}}</td>
          <td>{{$user['snumber']}}</td>
       </tr>
   </tbody>
       @endforeach
    @endif
</table>

<table class="table">
    <caption>Total Score:{{$score or '' }}+{{$candy or '0'}}</caption>
   <thead>
      <tr>
      <th>Title</th>
          <th>score</th>
          <th>time</th>
      </tr>
   </thead>
   @if(isset($challenges))
       @foreach($challenges as $challenge)
    <tbody>
      <tr>
      <td>{{$challenge['title']}}</td>
          <td>{{$challenge['score']}}</td>
          <td>{{$challenge['pivot']['created_at']}}</td>
       </tr>
   </tbody>
       @endforeach
    @endif
</table>

    @endif
</div>
@endsection