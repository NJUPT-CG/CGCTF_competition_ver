@extends('layouts.app')
@section('content')
<div class="container">

{{ $paginator->render() }}

</div>


@endsection