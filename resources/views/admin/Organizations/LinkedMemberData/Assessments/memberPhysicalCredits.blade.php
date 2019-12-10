<?php use \App\Http\Controllers\MainController;$main = new MainController;$meet = ['Regular Meeting','Workshop','Global Meet','Conference','HSCC Visit','Rural Visit','Hospital Visit','Educational Institution Visit','Survey & Distribtion Visit','Addition of Quality Member Network','Adding Potential Donor Network','Resource Persons Network','Group Discussion Intellectual','Project Updates Intellectual','Presentation Intellectual','System Development and Project Design Intellectual','Research Work Intellectual'];?>
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
                  <h5 class="mt-0 mb-0 font-Trirong">Last Evaluated Date:</h5>
                  <p>25 Feb 2019</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach

    	@if($credit == 'Physical')
          <div class="card-body bg-white box-shadow br-5 m-b-10">

            <div class="row el-element-overlay">
              <div class="col-md-12">
                <h3 class="card-title font-NexaRustSans-Black text-center">Physical Contribution : Meetings Credits</h3>
              </div>

              <div class="col-md-7">
                <div class="row">
                  <canvas id="polar-chart"></canvas>
                </div>
              </div>

              	<div class="col-md-5">
		          	<div class="card-body" style="border-right: 1px solid #15141429">

                           <div class="d-flex no -block p-5 align-items-center">
                             	<div class="rounds bg-light text-dark" style="background: #36a2eb !important;"><i class="ti-minus font-16 text-white"></i>
                             	</div>
                             	<div class="m-l-10">
		                         	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Regular Meeting">
		                               	<h4 class="m-b-0 font-Trirong font-w-900 p-5">Regular Meetings</h4>
		                               	<h5 class="m-b-0 font-14 pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
		                                <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
		                            </a>
                               </div>
                             </div>
                             <hr style="margin-top :1px;margin-bottom: 1px">
                             <div class="d-flex no-block p-5 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: #ff6384 !important;"><i class="ti-minus font-16 text-white"></i></div>
                               <div class="m-l-10">
                               	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Workshop">
	                                 <h4 class="m-b-0 font-Trirong font-w-900 p-5">Workshop</h4>
	                                 <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
		                             <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
	                           	</a>
	                            </div>
                             </div>
                             <hr style="margin-top :1px;margin-bottom: 1px">

                             <div class="d-flex no-block p-5 m-b-15 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: #4bc0c0 !important;"><i class="ti-minus font-16 text-white"></i></div>
                               <div class="m-l-10">
                               	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Global Meet">
	                                 <h4 class="m-b-0 font-Trirong font-w-900 p-5">Global Meet</h4>
	                                 <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 200</h5>
		                             <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 200</h5>
	                           	</a>
	                            </div>
                         	</div>

                         	<hr style="margin-top :1px;margin-bottom: 1px">

                             <div class="d-flex no-block p-5 m-b-15 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: rgba(128, 51, 142, 0.92) !important;"><i class="ti-minus font-16 text-white"></i></div>
                               <div class="m-l-10">
                               	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Conference">
	                                 <h4 class="m-b-0 font-Trirong font-w-900 p-5" >Conference National/ International</h4>
	                                 <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 200</h5>
		                             <h5 class="font-14  pull-right" style="color: #6c757d">Earned Credits : 200</h5>
		                         </a>
                               </div>
                         	</div>
                         	<hr>
                             <div class="d-flex no-block p-15 m-b-15 align-items-center">
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong font-w-900">TOTAL : <span class="font-light m-b-0 font-18 font-w-900">600 / 600 </span> </h4>
                               </div>
                         	</div>
		        	</div>
              	</div>
            </div>

          </div>

          <div class="card-body bg-white box-shadow br-5 m-b-10">

            <div class="row el-element-overlay">
              <div class="col-md-12">
                <h3 class="card-title font-NexaRustSans-Black text-center">Physical Contribution : Visit Credits</h3>
              </div>

              <div class="col-md-7">
                <div class="row">
                  <canvas id="polar-chart1"></canvas>
                </div>
              </div>


              	<div class="col-md-5">
		          	<div class="card-body" style="border-right: 1px solid #15141429">

                           <div class="d-flex no -block p-5 align-items-center">
                             <div class="rounds bg-light text-dark" style="background: #e40503 !important;"><i class="ti-minus font-16 text-white"></i></div>
                             <div class="m-l-10 ">
                             	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#HSCC Visit">
	                               	<h4 class="m-b-0 font-Trirong font-w-900 p-5">HSCC</h4>
	                               	<h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
		                             <h5 class="font-light m-b-0 font-14 pull-right" style="color: #6c757d">Earned Credits : 100</h5>
		                         </a>
                               </div>
                             </div>
                             <!-- <hr style="margin-top :1px;margin-bottom: 1px"> -->
                             <div class="d-flex no-block p-5 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: #07b107 !important;"><i class="ti-minus font-16 text-white"></i></div>
                               <div class="m-l-10">
                               	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Rural Visit">
	                                 <h4 class="m-b-0 font-Trirong font-w-900 p-5">Rural</h4>
	                                 <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
		                             <h5 class="font-light m-b-0 font-14 pull-right" style="color: #6c757d">Earned Credits : 0</h5>
		                         </a>
                               </div>
                             </div>
                             <!-- <hr style="margin-top :1px;margin-bottom: 1px"> -->

                             <div class="d-flex no-block p-5 m-b-15 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: rgba(14, 30, 138, 0.89) !important;"><i class="ti-minus font-16 text-white"></i></div>
                               <div class="m-l-10">
                               	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Hospital Visit">
	                                 <h4 class="m-b-0 font-Trirong font-w-900 p-5">Hospital</h4>
	                                 <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
		                             <h5 class="font-light m-b-0 font-14 pull-right" style="color: #6c757d">Earned Credits : 100</h5>
		                         </a>
                               </div>
                         	</div>

                         	<div class="d-flex no-block p-5 m-b-15 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: #69A388 !important;"><i class="ti-minus font-16 text-white"></i></div>
                               <div class="m-l-10">
                               	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Educational Institution Visit">
	                                 <h4 class="m-b-0 font-Trirong font-w-900 p-5">Educational Institution</h4>
	                                 <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
		                             <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
		                         </a>
                               </div>
                         	</div>

                         	<div class="d-flex no-block p-5 m-b-15 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: rgba(128, 51, 142, 0.92) !important;"><i class="ti-minus font-16 text-white"></i></div>
                               <div class="m-l-10">
                               	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Survey & Distribtion Visit">
	                                 <h4 class="m-b-0 font-Trirong font-w-900 p-5">Survey And Distribtion</h4>
	                                 <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
		                             <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
		                         </a>
                               </div>
                         	</div>

                         	<hr>
                             <div class="d-flex no-block p-15 m-b-15 align-items-center">
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong font-w-900">TOTAL : <span class="font-light m-b-0 font-18 font-w-900">400 / 500 </span> </h4>
                               </div>
                         	</div>
		        	</div>
              	</div>
            </div>
          </div>

      <div class="card-body bg-white box-shadow br-5 m-b-10">
        <div class="row el-element-overlay">
          <div class="col-md-12">
            <h3 class="card-title text-center font-NexaRustSans-Black">Physical Contribution : Network Credis</h3>
          </div>
          <div class="col-md-7">
            <div class="row">
              <canvas id="polar-chart2"></canvas>
            </div>
          </div>
          	<div class="col-md-5">
	          	<div class="card-body" style="border-right: 1px solid #15141429">
                   <div class="d-flex no -block p-5 align-items-center">
                     <div class="rounds bg-light text-dark" style="background: #69A388 !important;"><i class="ti-minus font-16 text-white"></i></div>
                     <div class="m-l-10 ">

                     	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Addition of Quality Member Network">
	                       	<h4 class="m-b-0 font-Trirong font-w-900 p-5">Addition of Quality Member</h4>
	                       	<h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 200</h5>
	                        <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
	                    </a>
                       </div>
                     </div>
                     <hr style="margin-top :1px;margin-bottom: 1px">
                     <div class="d-flex no-block p-5 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #07b107 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                       	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Adding Potential Donor Network">
		                     <h4 class="m-b-0 font-Trirong font-w-900 p-5">Adding Potential Donor</h4>
		                     <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 200</h5>
		                     <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 200</h5>
		                </a>
                       </div>
                     </div>
                     <hr style="margin-top :1px;margin-bottom: 1px">
                     <div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: rgba(14, 30, 138, 0.89) !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                       	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Resource Persons Network">
	                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Intellectuals/ Resource Persons</h4>
	                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 200</h5>
	                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 150</h5>
	                     </a>
                       </div>
                 	</div>
                 	<hr>
                 	<div class="d-flex no-block p-15 m-b-15 align-items-center">
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900">TOTAL : <span class="font-light m-b-0 font-18 font-w-900">450 / 600 </span> </h4>
                       </div>
                 	</div>
	        	</div>
          	</div>
        </div>
      </div>
      @endif
    	@if($credit == 'Intellectual')
      <div class="card-body bg-white box-shadow br-5 m-b-10">
        <div class="row el-element-overlay">
          <div class="col-md-12">
            <h3 class="card-title text-center font-NexaRustSans-Black">Intellectual Cpntribution : Project Knowledge Credits</h3>
          </div>
          <div class="col-md-7">
            <div class="row">
              <canvas id="polar-chart3"></canvas>
            </div>
          </div>
          	<div class="col-md-5">
	          	<div class="card-body" style="border-right: 1px solid #15141429">
                   <div class="d-flex no -block p-5 align-items-center">
                     <div class="rounds bg-light text-dark" style="background: #ff6384 !important;"><i class="ti-minus font-16 text-white"></i></div>
                     <div class="m-l-10 ">
                     	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Research Work Intellectual">
	                       	<h4 class="m-b-0 font-Trirong font-w-900 p-5">Research Work</h4>
	                       	<h5 class="m-b-0 font-14  pull-right"  style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 200</h5>
	                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 150</h5>
	                     </a>
                       </div>
                     </div>
                     <!-- <hr style="margin-top :1px;margin-bottom: 1px"> -->
                     <div class="d-flex no-block p-5 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #4bc0c0 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                       	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#System Development and Project Design Intellectual">
	                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">System Development and Project Design</h4>
	                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 200</h5>
	                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 200</h5>
	                     </a>
                       </div>
                     </div>
                     <!-- <hr style="margin-top :1px;margin-bottom: 1px"> -->


                     <div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #ffcd56 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                       	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Presentation Intellectual">
	                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Presentation</h4>
	                         <h5 class="m-b-0 font-14  pull-right"  style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
	                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
	                     </a>
                       </div>
                 	</div>
                 	<div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #e40503 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                       	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Group Discussion Intellectual">
	                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Group Discussion</h4>
	                         <h5 class="m-b-0 font-14  pull-right"  style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 50</h5>
	                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 50</h5>
	                     </a>
                       </div>
                 	</div>

                 	<div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #07b107 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                       	<a href="#0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Project Updates Intellectual">
	                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Project Updates</h4>
	                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 50</h5>
	                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 50</h5>
	                     </a>
                       </div>
                 	</div>

                 	<hr>
                     <div class="d-flex no-block p-15 m-b-15 align-items-center">
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900">TOTAL : <span class="font-light m-b-0 font-18 font-w-900">2400 / 2800 </span> </h4>
                       </div>
                 	</div>
	        	</div>
          	</div>
        </div>
      </div>
      @endif
      @if($credit == 'Financial')
      <div class="card-body bg-white box-shadow br-5 m-b-10">
        <div class="row el-element-overlay">
          <div class="col-md-12">
            <h3 class="card-title text-center font-NexaRustSans-Black">Financial Contribution </h3>
          </div>
          <div class="col-md-8">
            <div class="row">
              <canvas id="polar-chart4"></canvas>
            </div>
          </div>
          	<div class="col-md-4">
	          	<div class="card-body" style="border-right: 1px solid #15141429">
                   <div class="d-flex no -block p-5 align-items-center">
                     <div class="rounds bg-light text-dark" style="background: #ff6384 !important;"><i class="ti-minus font-16 text-white"></i></div>
                     <div class="m-l-10 ">
                       	<h4 class="m-b-0 font-Trirong font-w-900 p-5">Food</h4>
                       	<h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
                       </div>
                     </div>
                     <!-- <hr style="margin-top :1px;margin-bottom: 1px"> -->
                     <div class="d-flex no-block p-5 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #4bc0c0 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Health</h4>
                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
                       </div>
                     </div>
                     <!-- <hr style="margin-top :1px;margin-bottom: 1px"> -->

                     <div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #ffcd56 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Education</h4>
                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
                       </div>
                 	</div>

                 	<div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #e40503 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Self-Reliance</h4>
                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
                       </div>
                 	</div>

                 	<div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: #07b107 !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Infrastructure</h4>
                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 100</h5>
                       </div>
                 	</div>

                 	<div class="d-flex no-block p-5 m-b-15 align-items-center">
                       <div class="rounds bg-light text-dark" style="background: rgba(128, 51, 142, 0.92) !important;"><i class="ti-minus font-16 text-white"></i></div>
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900 p-5">Other</h4>
                         <h5 class="m-b-0 font-14  pull-right" style="color: #6c757d">&nbsp;&nbsp;&nbsp;&nbsp;Total Credits: 100</h5>
                         <h5 class="font-light m-b-0 font-14  pull-right" style="color: #6c757d">Earned Credits : 50</h5>
                       </div>
                 	</div>

                 	<hr>
                     <div class="d-flex no-block p-15 m-b-15 align-items-center">
                       <div class="m-l-10">
                         <h4 class="m-b-0 font-Trirong font-w-900">TOTAL : <span class="font-light m-b-0 font-18 font-w-900">550 / 600 </span> </h4>
                       </div>
                 	</div>
	        	</div>
          	</div>
        </div>
      </div>
      @endif
    <script type="text/javascript">
    	@if($credit == 'Physical')


    var myChart = new Chart(document.getElementById("polar-chart"), {
      type: 'pie',
      options3d: {
	      enabled: true,
	      alpha: 45,
	      beta: 0
	    },
      fullWidth : true,

      data: {
	        a : ["Regular Meetings","Workshop","Global Meet","Conference National/ International"],
	        labels: ["Regular Meetings","Workshop","Global Meet","Conference National/ International"],
	        datasets: [
	        {
	          label: "Physical Credits",
	          backgroundColor: ["#36a2eb", "#ff6384","#4bc0c0","rgba(128, 51, 142, 0.92)"],
	          data: [100,100,200,200]
	        }
        ]
      },
      options: {
     //  	onClick: function(e){
     //  		 // var series= element[0]._model.datasetLabel;
     //  		var activePoints = myChart.getElementsAtEvent(e);
     //  		 var label = activePoints[0]._model.label;
     //  		 var data = this.data.datasets[0].data[selectedIndex];
    	// 	var selectedIndex = activePoints[0]._index;
    	// 	console.log(label);
    	// },
        title: {
          display: true,
          text: 'Meeting Credits'
        },
        legend: {
          display: true,
            labels: {
              mirror : true,
              padding : 2,
                // boxWidth : 15
            }
        },
        tooltips:{
          callbacks: {
            title: function(tooltipItem, data) {
              return data['a'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']];
            },

          }
        }
      }
    });

    var myChart1 = new Chart(document.getElementById("polar-chart1"), {
      type: 'pie',
      fullWidth : true,
      data: {
	        a : ["HSCC","Rural","Hospital","Educational Institution","Survey And Distribtion"],
	        labels: ["HSCC","Rural","Hospital","Educational Institution","Survey And Distribtion"],
	        datasets: [
	        {
	          label: "Physical Credits",
	          backgroundColor: ["#e40503","#07b107","rgba(14, 30, 138, 0.89)","#69A388","rgba(128, 51, 142, 0.92)"],
	          data: [100,0,100,100,100]
	        }
        ]
      },
      options: {
        title: {
          display: true,
          text : "Visit Credits"
        },
        legend: {
          display: true,
            labels: {
              mirror : true,
              padding : 2,
                boxWidth : 15
            }
        },
        tooltips:{
          callbacks: {
            title: function(tooltipItem, data) {
              return data['a'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']];
            },

          }
        }
      }
    });

    var myChart2 = new Chart(document.getElementById("polar-chart2"), {
      type: 'pie',
      fullWidth : true,
      data: {
	        a : ["Addition of Quality Member","Adding Potential Donor","Intellectuals/ Resource Persons"],
	        labels: ["Addition of Quality Member","Adding Potential Donor","Intellectuals/ Resource Persons"],
	        datasets: [
	        {
	          label: "Network Credits",
	          backgroundColor: ["#69A388","#07b107","rgba(14, 30, 138, 0.89)"],
	          data: [100,200,150]
	        }
        ]
      },
      options: {
        title: {
          display: true,
          text : "Network Credits"
        },
        legend: {
          display: true,
            labels: {
              mirror : true,
              padding : 2,
                boxWidth : 15
            }
        },
        tooltips:{
          callbacks: {
            title: function(tooltipItem, data) {
              return data['a'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']];
            },

          }
        }
      }
    });

@endif
    	@if($credit == 'Intellectual')

    var myChart3 = new Chart(document.getElementById("polar-chart3"), {
      type: 'polarArea',
      options3d: {
	      enabled: true,
	      alpha: 45,
	      beta: 0
	    },
      fullWidth : true,
      data: {
	        a : ["Research Work","System Development and Project Design","Presentation","Group Discussion","Project Updates"],
	        labels: ["Research Work","System Development and Project Design","Presentation","Group Discussion","Project Updates"],
	        datasets: [
	        {
	          label: "Project Knowledge",
	          backgroundColor: ["#ff6384","#4bc0c0","#ffcd56","#e40503","#07b107"],
	          data: [150,200,100,50,50]
	        }
        ]
      },
      options: {
        title: {
          display: true,
          text : "Project Knowledge"
        },
        legend: {
          display: true,
            labels: {
              mirror : true,
              padding : 2,
                boxWidth : 15
            }
        },
        tooltips:{
          callbacks: {
            title: function(tooltipItem, data) {
              return data['a'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']];
            },

          }
        }
      }
    });

  @endif

  @if($credit == 'Financial')

    var myChart4 = new Chart(document.getElementById("polar-chart4"), {
      type: 'polarArea',
      options3d: {
	      enabled: true,
	      alpha: 45,
	      beta: 0
	    },
      fullWidth : true,
      data: {
	        a : ["Food","Health","Education","Self-Reliance","Infrastructure","Other"],
	        labels: ["Food","Health","Education","Self-Reliance","Infrastructure","Other"],
	        datasets: [
	        {
	          label: "Financial Knowledge",
	          backgroundColor: ["#ff6384","#4bc0c0","#ffcd56","#e40503","#07b107","rgba(128, 51, 142, 0.92)"],
	          data: [100,100,100,100,100,50]
	        }
        ]
      },
      options: {
        title: {
          display: true,
        },
        legend: {
          display: true,
            labels: {
              mirror : true,
              padding : 2,
                boxWidth : 15
            }
        },
        tooltips:{
          callbacks: {
            title: function(tooltipItem, data) {
              return data['a'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']];
            },

          }
        }
      }
    });

  @endif
</script>
<!-- Model exmple -->

<!-- ******************************start Model********************************* -->
@foreach($meet as $meets)
 <div class="modal fade" id="{{$meets}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
         <div class="modal-dialog" role="document">
           <?php $bg = 'background:transparent'; ?>
            <div class="modal-content" style="{{$bg}};border:unset;width : {{(stripos($meets,'Network') == true) ? '800px' : '500px'}}">
               <div style="">
                  <a class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></a>
               </div>
               <div class="modal-body">

                  <div class="card box-shadow-e br-5">
                  	<div class="modal-header">
			          <h4 class="modal-title" id="exampleModalLabel1">{{(stripos($meets,'Network') == true) ? str_replace('Network', '', $meets) : (stripos($meets,'Intellectual') == true) ? str_replace('Intellectual', '', $meets) : $meets}} Details </h4>
			        </div>
                  	<div class="row p-10">
                  		@if(stripos($meets,'Network') == true)
                  		<div class="col-md-12">
                  			<div class="media">
		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Name : </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> Mohammad Swabeer</p>
		                      </div>

		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Contact No.: </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> +91 9876543210</p>
		                      </div>

		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Occupation : </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> Businessman</p>
		                      </div>
		                    </div>

		                    <div class="media">
		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Name : </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> Mohammad Swabeer</p>
		                      </div>

		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Contact No.: </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> +91 9876543210</p>
		                      </div>

		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Occupation : </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> Businessman</p>
		                      </div>
		                    </div>
                  		</div>
                  		@elseif(stripos($meets,'Intellectual') == true)
                  		<div class="col-md-12">
                  			<div class="media">
		                      <div class="media-body p-5">
		                      	<small class="p-t-30 db font-Trirong font-16"><b> Contribution/ Description : </b></small>
		                        <p style="text-align: justify;"> Here is the description about the meeting . And mention breifed information discussed in the meeting</p>
		                      </div>
		                    </div>
                  		</div>
                  		@else
                  		<div class="col-md-12">
                  			<div class="media">
		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Agenda : </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> Food Distribution</p>
		                      </div>
		                    </div>
                  		</div>

                  		<div class="col-md-12">
                  			<div class="media">
		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Venue : </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> Mangalore</p>
		                      </div>
		                    </div>
                  		</div>

                  		<div class="col-md-12">
                  			<div class="media">
		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Date :</b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p>3<sup>rd</sup> Jan 2019</p>
		                      </div>
		                    </div>
                  		</div>
                  		@if(stripos($meets,'Visit') != true)
                  		<div class="col-md-12">
                  			<div class="media">
		                      <div class="media-left">
		                        <small class="p-t-30 db font-Trirong font-16"><b> Duration : </b></small>
		                      </div>
		                      <div class="media-body p-5">
		                        <p> 1:00pm to 5:00pm</p>
		                      </div>
		                    </div>
                  		</div>
                  		@endif
                  		<div class="col-md-12">
                  			<div class="media">
		                      <div class="media-body p-5">
		                      	<small class="p-t-30 db font-Trirong font-16"><b> Discription : </b></small>
		                        <p style="text-align: justify;"> Here is the description about the meeting . And mention breifed information discussed in the meeting</p>
		                      </div>
		                    </div>
                  		</div>

                  		@endif

                  	</div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @endforeach
<!-- ******************************end Model********************************* -->
@endsection
