<?php use \App\Http\Controllers\MainController;$main = new MainController;?>
@extends('admin/mainpage/adminmain')

@section('admincontents')
<div class="row page-titles">
    <div class="col-md-12">
        <div class="d-flex">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('viewMembers',[encrypt($type),encrypt($unit),encrypt($page)])}}">Organisation</a></li>
              <li class="breadcrumb-item"><a href="{{route('getMemberProfile',[encrypt($id),encrypt($type),encrypt($unit),encrypt($page)])}}">{{$type}} {{$main->find_field_data('unit_details','unit_name',$id)[0]->unit_name}} </a></li>
              <li class="breadcrumb-item"><a href="{{route('performanceIndicator',[encrypt($id),encrypt($type),encrypt($unit),encrypt($page),encrypt('Planner')])}}">Perfomance Indicators</a></li>
              <li class="breadcrumb-item active">Yearly Planner</li>
          </ol>
      </div>
  </div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<img src="{{asset('adminAssets/images/calendar.png')}}">
		</div>
	</div>
</div>
<!-- <div class="card"> -->
		<!-- <div id="event-modal"></div> -->

</div>
@endsection
