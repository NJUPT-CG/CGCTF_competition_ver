@extends('layouts.app')
@section('content')
<div class="container">
<ul id="myTab" class="nav nav-tabs">
  <li class="active">
    <a href="#home" data-toggle="tab">
       萌新组
    </a>
  </li>
  <li><a href="#ios" data-toggle="tab">iOS</a></li>
  <li class="dropdown">
    <a href="#" id="myTabDrop1" class="dropdown-toggle" 
       data-toggle="dropdown">Java 
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
      <li><a href="#jmeter" tabindex="-1" data-toggle="tab">jmeter</a></li>
      <li><a href="#ejb" tabindex="-1" data-toggle="tab">ejb</a></li>
    </ul>
  </li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade in active" id="home">
    <table class="table table-hover">
  <caption>Score Board</caption>
   <thead>
      <tr>
         <th>rank</th>
         <th>name</th>
      <th>score</th>
      <th>time</th>
      </tr>
   </thead>
   @if(isset($users))
       @foreach($users as $user)
    <tbody>
      <tr onclick="location.href='{{ url('teamdetail/'.$user['id'] ) }}';">
         <td>{{$user['rank']}}</td>
         <td>{{$user['name']}}</td>
      <td>{{$user['totalScore']}}</td>
      <td>{{$user['lastsubtime']}}</td>
     </tr>
   </tbody>
       @endforeach
    @endif
</table>
{{ $paginator->render() }}
  </div>
  <div class="tab-pane fade" id="ios">
    <p>iOS 是一个由苹果公司开发和发布的手机操作系统。最初是于 2007 年首次发布 iPhone、iPod Touch 和 Apple 
      TV。iOS 派生自 OS X，它们共享 Darwin 基础。OS X 操作系统是用在苹果电脑上，iOS 是苹果的移动版本。</p>
  </div>
  <div class="tab-pane fade" id="jmeter">
    <p>jMeter 是一款开源的测试软件。它是 100% 纯 Java 应用程序，用于负载和性能测试。</p>
  </div>
  <div class="tab-pane fade" id="ejb">
    <p>Enterprise Java Beans（EJB）是一个创建高度可扩展性和强大企业级应用程序的开发架构，部署在兼容应用程序服务器（比如 JBOSS、Web Logic 等）的 J2EE 上。
    </p>
  </div>
</div>

</div>
@endsection