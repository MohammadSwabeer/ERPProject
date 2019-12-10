<?php
  use \App\Http\Controllers\familyController;
  use \App\Http\Controllers\MainController;
?>
@extends('admin/mainpage/adminmain')

@section('admincontents')

       <div class="row page-titles">
        <div class="col-md-12">
          <div class="d-flex">

            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('ATTStaffsView')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('ATTStaffsView')}}">ATT Staffs Details</a></li>
              <li class="breadcrumb-item active">ATT Staffs Profile</li>
            </ol>

          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-12">
         @if(Session::has('success'))
         <div class="alert alert-success">{{Session::get('success')}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button></div>
         @endif

         @if(Session::has('error'))
         <div class="alert alert-danger">{{Session::get('error')}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button></div>
         @endif

       </div>
     </div>

     <div class="row">
      <!-- Column -->
      <div class="col-md-3">
          @foreach($post as $posts)
        <?php $pid = $posts->id; ?>

        <div class="card box-shadow-gradient br-5 p-10-0" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
              <center class="m-t-30">
                 @if(ifAnd($posts->photo) == true)
                 <img src="{{asset('adminAssets/images/OrganizationsProfile/Staffs/'.$posts->photo)}}" class="img-circle mt-m-25" width="150">
                 @else
                    @if($posts->gender == 'Male')
                    <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle" style="width:150px">
                    @else
                    <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="img-circle" style="width:150px">
                    @endif
                 @endif
                <h4 class="card-title m-t-10 text-white">{{$posts->member_fname}} {{$posts->member_mname}}{{ $posts->member_lname}}</h4>
              </center>
               <div class="card br-b-l-5 m-b-0 p-5 box-shadow-e" style="background: #00000061;color: white;">
                  <div class="row text-center ">
                     <div class="col-md-5 border-right">
                        <div>
                           <h5 class="font-Trirong font-14 font-w-900">HF-Id <br><small style="font-size: 100%">{{($posts->hfid != null) ? $posts->hfid : 'Not provided'}}</small></h5>
                           
                        </div>
                     </div>
                     <div class="col-md-7">
                        <div>
                           <h5 class="font-Trirong font-14 font-w-900">Unit <br><small style="font-size: 100%">{{($posts->unit_id != null) ? $posts->unit_id : 'Not provided'}}</small></h5>
                        </div>
                     </div>
                  </div>
               </div>
               
            <!-- </div> -->
            <div>
            </div>
          </div>

          <div class="card box-shadow br-5 m-t-m-10">
             <div class="card-body p-b-0 open-sans">
               <div class="row">
                 <div class="media">
                   <div class="media-left">
                     <i class="fa fa-map-marker text-theme-colored font-25 pr-10"></i>
                   </div>
                   <div class="media-body">
                     <h5 class="mt-0 mb-0 font-Trirong">Permanent Address:</h5>
                     <p>{{$posts->permanent_address}} , {{$posts->p_residence}}</p>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="card box-shadow br-5 m-t-m-10">
            <div class="card-body p-b-0 open-sans">
              <div class="row">
                <div class="media">
                  <div class="media-left">
                    <i class="fa fa-map-marker text-theme-colored font-25 pr-10"></i>
                  </div>
                  <div class="media-body">
                    <h5 class="mt-0 mb-0 font-Trirong">Residence Address:</h5>
                     <p>{{$posts->residence_address}}, {{$posts->r_residence}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>
      @foreach($post as $posts)
          <!-- Tabs  data for chart or student evaluation data-->
      <div class="col-md-9">
           <!-- <ul class="nav nav-tabs profile-tab" role="tablist">
            <li class="nav-item"> <a class="nav-link active show bg-white font-w-700" data-toggle="tab" href="#Profiles" role="tab" aria-selected="true">Profile</a> </li>
          </ul> -->

           <!-- Tab panes -->
          <div class="tab-content box-shadow br-5 bg-white m-t-10">

            <!-- first tab -->
            <div class="tab-pane active show" id="Profiles" role="tabpanel">
              <div class="card br-5 m-b-10 bg-white ">
                <ul class="nav nav-tabs profile-tab" role="tablist">
                  <li class="nav-item"> <a class="nav-link active show bg-white br-5" data-toggle="tab" href="#Personal" role="tab" aria-selected="true">Personal Details</a> </li>
                  <li class="nav-item">
                    <a class="nav-link bg-white br-5" data-toggle="tab" href="#Company" role="tab"  aria-selected="false">Professional Info.</a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link bg-white br-5" data-toggle="tab" href="#address" role="tab"  aria-selected="false">Address</a>
                  </li> -->
                </ul>
              </div>

              <div class="tab-content">
                <div class="tab-pane active show" id="Personal" role="tabpanel">
                  <div class="card  p-0-0-10-30">
                    <div class="card-body">
                      <div class="row attProfile memberProfileRow familyProfileRow ">

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b>Date of Birth :</b></small>
                          </div>
                          <div class="media-body">
                            <p>{{$posts->dob}}</p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b>Date of Join HF :</b></small>
                          </div>
                          <div class="media-body">
                            <p>{{$posts->doj}}</p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b>Email :</b></small>
                          </div>
                          <div class="media-body">
                            <p>{{$posts->email}}</p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b>Contact Number:</b></small><br>
                            <small class="p-t-30"><b>Phone:</b></small><br>
                            <small class="p-t-30"><b>Cell:</b></small><br>
                          </div>
                          <div class="media-body">
                            <p><br>
                            @if($posts->contact != null)
                            {{$posts->contact}}
                            @endif
                            <br>
                            @if($posts->mobile != null)
                            {{$posts->mobile}}
                            @endif
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b>Qualification :</b></small>
                          </div>
                          <div class="media-body">
                            <p>{{$posts->qualification}}</p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b>Area of Expertise :</b></small>
                          </div>
                          <div class="media-body">
                            <p>{{$posts->expertise}}</p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-body">
                            <small class="p-t-30 db"><b>Contributable Skills :</b></small>
                            <p>
                            <?php $skill = explode(',',$posts->skills); ?>
                            @foreach($skill as $i)
                            <i class="ti-minus"></i> {{ucfirst($i)}}<br>
                            @endforeach
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

                <div class="tab-pane" id="Company" role="tabpanel">
                  <div class="card  p-0-0-10-30">
                    <div class="card-body">
                      <div class="row memberProfileRow familyProfileRow">
                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Company Name :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->company_name}} </p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Designation :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->designation}} </p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Position Held :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->position}} </p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Working Since :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{($posts->working_since == 0 || $posts->working_since == null) ? 'not provided' : $posts->working_since}} </p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Area of Expertise :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->expertise}} </p>
                            </div>
                          </div>
                        </div>

                      </div>

                      @if($posts->other_organisation != null || other_organisation != '')
                      <div class="row memberProfileRow familyProfileRow">
                        <div class="col-md-12">
                          <hr>
                          <h4>Other Organizations Info.</h4>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Company Name :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->other_organisation}} </p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Member Since :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->member_since}} </p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Position Held :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->position_held}} </p>
                            </div>
                          </div>
                        </div>

                      </div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="address" role="tabpanel">
                  <div class="card  p-0-0-10-30">
                    <div class="card-body">
                      <div class="row memberProfileRow familyProfileRow">
                        <div class="col-md-12">
                          <div class="p-0-0-10-30">
                            <h3 class="font-18"> <i class="fa fa-map-marker text-theme-colored font-18 pr-10"></i>Permanent Address</h3>
                            <hr>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db"><b>Full Address :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->permanent_address}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db"><b>Residence :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->p_residence}}</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--second tab-->
          </div>
        <!-- </div> -->
      </div>
      @endforeach
    </div>
  </div>
        <!-- End PAge Content -->

@endsection
