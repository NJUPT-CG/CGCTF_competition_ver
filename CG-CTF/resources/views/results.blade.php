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
      <td style="overflow:hidden" ><data-text text="{{$challenge['name']}}"/></td>
		  <td style="overflow:hidden" ><data-text text="{{$challenge['challenge']}}"/></td>
		  <td><data-text text="{{$challenge['time']}}"/></td>
	   </tr>
   </tbody>
       @endforeach
    @endif
</table>
</div>
@endsection