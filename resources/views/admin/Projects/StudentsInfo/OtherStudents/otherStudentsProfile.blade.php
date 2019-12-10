<?php
  use \App\Http\Controllers\familyController;
  use \App\Http\Controllers\MainController;
?>
@extends('admin/mainpage/adminmain')

@section('admin/mainpage/admincontents')

<html lang="en">
<body class="skin-blue fixed-layout lock-nav">

  <!-- Main wrapper - style you can find in pages.scss -->
  <div id="main-wrapper">
    @include('admin/mainpage/_leftnav')
    <div class="page-wrapper">
      <!-- Container fluid  -->
      <div class="container-fluid">
       <div class="row page-titles">
        <div class="col-md-12">
          <div class="d-flex">

            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('student.index')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
              <li class="breadcrumb-item"><a href="{{route('OtherStudentsView')}}">Other Students Details</a></li>
              <li class="breadcrumb-item active">Other Students Profile</li>
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
        <div>
        @foreach($post as $posts)
        <?php
          $pid = $posts->id;
          ?>
        <div class="card box-shadow-gradient p-10-0 m-b-0">
          <div class="card-body std-card-body m-t-m-10 br-5" style="background:linear-gradient(rgba(5, 5, 53, 0.41), rgba(0, 2, 18, 0.92)),url('{{asset('adminAssets/images/big/img11.jpg')}}') no-repeat center center fixed;">
            <center class="m-t-30">
              @if($posts->gender == 'Male')
              <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle" style="width:150px">
              @else
              <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="img-circle" style="width:150px">
              @endif
              <h4 class="card-title m-t-10 text-white">{{$posts->student_name}}</h4>
            </center>
          </div>
          <div>
          </div>
        </div>
        @endforeach
        </div>
        <!-- <div class="row"> -->
          <!-- <div class="col-md-12"> -->
         <!--    <ul class="nav nav-tabs profile-tab" role="tablist">
            <li class="nav-item w-100"> <a class="nav-link active show bg-white br-5 font-w-700" data-toggle="tab" href="#Profiles" role="tab" aria-selected="true">Profile</a> </li>
            <li class="nav-item w-100"> <a class="nav-link bg-white br-5 font-w-700" href="{{route('StudentAssesmentPage',[$pid]) }}" aria-selected="true" >Assesment</a> </li>
            <li class="nav-item w-100">
              <a class="nav-link bg-white br-5 font-w-700" href="{{route('student.showChart',[$pid])}}"  aria-selected="false">Perfomance</a>
            </li>
          </ul> -->
          <!-- </div> -->
        <!-- </div> -->
      </div>
          <!-- Tabs  data for chart or student evaluation data-->
      <div class="col-md-9">
           <ul class="nav nav-tabs profile-tab" role="tablist">
            <li class="nav-item"> <a class="nav-link active show bg-white font-w-700" data-toggle="tab" href="#Profiles" role="tab" aria-selected="true">Profile</a> </li>
            <!-- <li class="nav-item "> <a class="nav-link bg-white font-w-700" href="{{route('HSCCFamilyStudentAssessment',[$pid]) }}" aria-selected="true" >Assesment</a> </li> -->
            <!-- <li class="nav-item ">
              <a class="nav-link bg-white font-w-700" href="{{route('showHSCCStudentEvalChart',[$pid])}}"  aria-selected="false">Perfomance</a>
            </li> -->
          </ul>

           <!-- Tab panes -->
          <div class="tab-content box-shadow br-5 bg-white m-t-10">

            <!-- first tab -->
            <div class="tab-pane active show" id="Profiles" role="tabpanel">
              <div class="card br-5 m-b-10 bg-white ">
                <ul class="nav nav-tabs profile-tab" role="tablist">
                  <li class="nav-item"> <a class="nav-link active show bg-white br-5" data-toggle="tab" href="#Personal" role="tab" aria-selected="true">Personal Details</a> </li>
                  <!-- <li class="nav-item"> <a class="nav-link bg-white br-5" data-toggle="tab" href="#family" role="tab" aria-selected="false">Family Details</a> </li> -->
                  <li class="nav-item">
                    <a class="nav-link bg-white br-5" data-toggle="tab" href="#Education" role="tab"  aria-selected="false">Educational Information</a>
                  </li>
                 <!--  <li class="nav-item">
                    <a class="nav-link bg-white br-5" href="{{route('basicSkillData',[$pid,'student']) }}"  aria-selected="false">Basic Skills Details</a>
                  </li> -->
                  <li class="nav-item">
                    <a class="nav-link bg-white br-5" data-toggle="tab" href="#address" role="tab"  aria-selected="false">Address</a>
                  </li>
                </ul>
              </div>

              <div class="tab-content">
                <div class="tab-pane active show" id="Personal" role="tabpanel">
                  <div class="card  p-0-0-10-30">
                    <div class="card-body">
                      <div class="row memberProfileRow familyProfileRow ">

                      <div class="col-md-12">
                        <div class="p-0-0-10-30">
                          <h3 class="font-18"> <i class="fa fa-user text-theme-colored font-18 pr-10"></i> Personal Information</h3>
                          <hr>
                        </div>
                      </div>
                      @foreach($post as $posts)

                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b> Full Name :</b></small>
                          </div>
                          <div class="media-body">
                            <p>{{$posts->student_name}} </p>
                          </div>
                        </div>
                      </div>

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
                            <small class="p-t-30 db"><b>Gender :</b></small>
                          </div>
                          <div class="media-body">

                            <p>{{$posts->gender}}</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="media">
                          <div class="media-left">
                            <small class="p-t-30 db"><b>Contact :</b></small>
                          </div>
                          <div class="media-body">
                            <p>
                            @if($posts->s_contact != null)
                            {{$posts->s_contact}}
                            @endif
                            </p>
                          </div>
                        </div>
                      </div>
                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db"><b>Area of Interest/ Future Goal/Plan :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{($posts->future_goal != null || $posts->future_goal != '') ? $posts->future_goal : 'not provided'}}</p>
                            </div>
                          </div>
                        </div>
                      @endforeach
                      </div>
                      <div class="row memberProfileRow familyProfileRow ">
                        <div class="col-md-12">
                          <div class="p-0-0-10-30">
                            <hr>
                            <h3 class="font-18"> <i class="fa fa-user text-theme-colored font-18 pr-10"></i> Family Information</h3>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Father Name :</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->father_name == null) ? 'Not-provided' : $posts->father_name}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Father Occupation :</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->father_occupation == null) ? 'Not-provided' : $posts->father_occupation}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Mother Name :</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->mother_name == null) ? 'Not-provided' : $posts->mother_name}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Mother Occupation :</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->mother_occupation == null) ? 'Not-provided' : $posts->mother_occupation}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Parent's Contatc Number:</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->parents_contact == null) ? 'Not-provided' : $posts->parents_contact}}</p>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="Education" role="tabpanel">
                  <div class="card  p-0-0-10-30">
                    <div class="card-body">
                      <div class="row memberProfileRow familyProfileRow">
                        <div class="col-md-12">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> College Name :</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->college_name == null) ? 'Not-provided' : $posts->college_name}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Present Course :</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->present_course == null) ? 'Not-provided' : $posts->present_course}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b> Perfomance :</b></small>
                            </div>
                            <div class="media-body">
                              <p> {{($posts->perfomance == null) ? 'Not-provided' : $posts->perfomance}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db font-Trirong"><b>  Entrance : </b><br>
                                <?php
                                  $rank = explode(',',$posts->rank_name);
                                ?>
                                @foreach($rank as $ranks)
                                  {{$ranks}}
                                  <br>
                                @endforeach
                             </small>
                            </div>
                            <div class="media-body">
                              <p><br>
                                <?php
                                $lists = explode(',',$posts->rank_list);
                                ?>
                                @foreach($lists as $list)
                                  {{$list}}
                                  <br>
                                @endforeach
                              </p>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="address" role="tabpanel">
                  <div class="card  p-0-0-10-30">
                    <div class="card-body">
                      <div class="row memberProfileRow familyProfileRow">

                        <div class="col-md-12">
                          <div class="p-0-0-10-30">
                            <h3 class="font-18"> <i class="fa fa-map-marker text-theme-colored font-18 pr-10"></i>Address</h3>
                            <hr>
                          </div>
                        </div>
                        @foreach($post as $posts)


                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db"><b>Street :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->street}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db"><b>State :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->state}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db"><b>City :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->city}}</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="media">
                            <div class="media-left">
                              <small class="p-t-30 db"><b>Pin Code :</b></small>
                            </div>
                            <div class="media-body">
                              <p>{{$posts->pincode}}</p>
                            </div>
                          </div>
                        </div>
                        @endforeach
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
    </div>
  </div>
        <!-- End PAge Content -->

    </div>
    <!-- End Container fluid  -->
  </div>
  <!-- End Page wrapper  -->
</div>
  <script type="text/javascript">

  </script>
</body>
</html>
@endsection
