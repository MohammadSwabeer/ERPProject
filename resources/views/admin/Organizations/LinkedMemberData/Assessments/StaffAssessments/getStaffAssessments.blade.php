<?php use \App\Http\Controllers\MainController;$main = new MainController;?>
@extends('admin/mainpage/adminmain')

@section('admincontents')

@foreach($post as $posts)
<div class="row">
  <div class="col-md-4">
    <div class="card box-shadow-gradient p-10-0  m-t-m-10">
      <div class="card-body std-card-body m-t-m-10 br-5 p-15" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
          <div class="media">
            <div class="media-left">
              <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle" width="65">
            </div>
            <div class="media-body p-10">
              <h4 class="card-title m-t-10 text-white">{{$posts->member_fname}} {{$posts->member_mname}} {{$posts->member_lname}}</h4>
            </div>
          </div>
      	</div>
      <div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card box-shadow br-5 m-t-m-10">
      <div class="card-body p-b-0 open-sans">
        <div class="row">
          <div class="media">
            <div class="media-left">
              <i class="ti-calendar text-theme-colored font-25 pr-10"></i>
            </div>
            <div class="media-body">
              <h5 class="mt-0 mb-0 font-Trirong">Department:</h5>
              <p>ATT Staff</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card box-shadow br-5 m-t-m-10">
      <div class="card-body p-b-0 open-sans">
        <div class="row">
          <div class="media">
            <div class="media-left">
              <i class="ti-calendar text-theme-colored font-25 pr-10"></i>
            </div>
            <div class="media-body">
              <h5 class="mt-0 mb-0 font-Trirong">Week:</h5>
              <p>2<sup>nd</sup> Week</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card-body bg-white br-5 box-shadow-e">
			<div class="table-responsive">
				<table class="table table-bordered table-hover assessTable">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Day</th>
                      <th>09am - 10am</th>
                      <th>10am - 11am</th>
                      <th>11am - 12am</th>
                      <th>12am - 01pm</th>
                      <th>01pm - 02pm</th>
                      <th>02pm - 03pm</th>
                      <th>03pm - 04pm</th>
                      <th>04pm - 05pm</th>
                      <th>05pm - 06pm</th>
                      <th>Office Hours</th>
                      <th>Remarks Achivement</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<tr>
                  		<td style="background: #dee2e6;">5/8/19</td>
                  		<td style="background: #f2f5f8">Monday</td>
                  		<td colspan="3">Administrative Work</td>
                  		<td colspan="2">Class Taken</td>
                  		<td colspan="4">PPT Work</td>
                  		<td style="background: #f8f8f8">9 Hours</td>
                  		<td style="background: #f8f8f8">Completed Class, Completed PPT, Completed Admin Work</td>
                  	</tr>
                  	<tr>
                  		<td style="background: #dee2e6;">6/8/19</td>
                  		<td style="background: #f2f5f8">Tuesday</td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td style="background: #f8f8f8">9 Hours</td>
                  		<td style="background: #f8f8f8">25 Shops Visited</td>
                  	</tr>
                  	<tr>
                  		<td style="background: #dee2e6;">7/8/19</td>
                  		<td style="background: #f2f5f8">Wednesday</td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td style="background: #f8f8f8">9 Hours</td>
                  		<td style="background: #f8f8f8">25 Shops Visited</td>
                  	</tr>
                  	<tr>
                  		<td style="background: #dee2e6;">8/8/19</td>
                  		<td style="background: #f2f5f8">Thursday</td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td style="background: #f8f8f8">9 Hours</td>
                  		<td style="background: #f8f8f8">25 Shops Visited</td>
                  	</tr>
                  	<tr>
                  		<td style="background: #dee2e6;">9/8/19</td>
                  		<td style="background: #f2f5f8">Friday</td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td style="background: #f8f8f8">9 Hours</td>
                  		<td style="background: #f8f8f8">25 Shops Visited</td>
                  	</tr>
                  	<tr>
                  		<td style="background: #dee2e6;">10/8/19</td>
                  		<td style="background: #f2f5f8">Saturday</td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td></td>
                  		<td style="background: #f8f8f8">9 Hours</td>
                  		<td style="background: #f8f8f8">25 Shops Visited</td>
                  	</tr>
                  </tbody>
              </table>
			</div>
		</div>
	</div>
</div>
@endforeach

@endsection
