@extends('layouts.app')
@section('content')
<div class="container">
<table class="table" style="table-layout:fixed">
   <thead>
      <tr>
      <th>team</th>
		  <th>challenge</th>
		  <th>time</th>
      </tr>
   </thead>
   @if(isset($challenges))
       @foreach($challenges as $challenge)
    <tbody>
      <tr>
      <td style="overflow:hidden" >{{$challenge['name']}}</td>
		  <td style="overflow:hidden" >{{$challenge['challenge']}}</td>
		  <td>{{$challenge['time']}}</td>
	   </tr>
   </tbody>
       @endforeach
    @endif
</table>
</div>
@endsection