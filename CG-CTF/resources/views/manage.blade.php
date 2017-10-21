@extends('layouts.app')

@section('content')
    <div class="container">  
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">比赛</div>
                <div class="panel-body">
                    <form action="{{ url('time')}}" method="POST">
                        {!! csrf_field() !!}

                        <br>
                        比赛时间（分钟）
                        <input type="integer" name="min" class="form-control" placeholder="min" >
                    
                        <br>
                        <button class="btn btn-lg btn-info">开始</button>
                        <a class="btn btn-lg btn-danger" href="{{url('gameover')}}" role="button">结束</a>
                     </form>
                     <br>
                    
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection 