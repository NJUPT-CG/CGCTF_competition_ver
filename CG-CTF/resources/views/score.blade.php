@extends('layouts.app')
@section('content')
<div class="container">
<table class="table">
  <caption  style="font-weight:bold;font-size:large;">User Name:<data-text text="{{$name or '' }}"/></caption>
	<caption>Total Score:{{$score or '' }}</caption>
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
      <td><data-text text="{{$challenge['title']}}"/></td>
		  <td>{{$challenge['score']}}</td>
		  <td>{{$challenge['pivot']['created_at']}}</td>
	   </tr>
   </tbody>
       @endforeach
    @endif
</table>
</div>
@endsection