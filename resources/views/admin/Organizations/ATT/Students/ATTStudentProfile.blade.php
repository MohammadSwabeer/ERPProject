<?php  use \App\Http\Controllers\MainController; $main = new MainController;  ?>
   @extends('admin/mainpage/adminmain')

   @section('admincontents')
     @foreach($post as $posts)
     <?php $stdid = $posts->id; $hfid = $posts->hfId; ?>
     @endforeach

    <div class="row page-titles">
      <div class="col-md-12">
        <div class="d-flex">
          <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
                <li class="breadcrumb-item"><a href="{{route('ATTPage')}}">ATT Details</a></li>
                <li class="breadcrumb-item"><a href="{{route('viewATTStudents')}}">ATT Students Details</a></li>
                <li class="breadcrumb-item active">ATT Student Profile</li>
              </ol>
        </div>

      </div>
    </div>
          @if($stdid != null)
    <div class="row contents">
          <div class="col-md-3"><div>
          <?php $count = 0;$counts = 0; ?>
          @foreach($post as $posts)
          @if($posts->full_name !== null) 
          <?php $pid = $posts->id; $count++; ?>
          @endif
          @if($count == 1)
          <div class="card box-shadow-gradient br-5 p-10-0" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
              <center class="m-t-30">
                 @if($posts->stud_image != null  || $posts->stud_image != null )
                 <img src="{{asset('adminAssets/images/FamiliesProfile/OrganizationsProfile/ATT/Student/'.$posts->stud_image)}}" class="img-circle mt-m-25" width="150">
                 @else
                     @if($posts->gender == 'Male')
                     <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle mt-m-25" width="150">
                     @else
                     <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="img-circle mt-m-25" width="150">
                     @endif
                 @endif
                <h4 class="card-title m-t-10 text-white">{{$posts->full_name}}</h4>
              </center>
               <div class="card br-b-l-5 m-b-0 p-5 box-shadow-e" style="background: #00000061;color: white;">
                  <div class="row text-center ">
                     <div class="col-md-12 border-right">
                        <div>
                           <h5 class="font-Trirong font-14 font-w-900">HF-Id : <small style="font-size: 100%">{{($posts->hfId != null) ? $posts->hfId : 'Not provided'}}</small></h5>
                           
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
                     <i class="fa fa-user-circle-o text-theme-colored font-25 pr-10"></i>
                   </div>
                   <div class="media-body">
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Age : <span class="font-open-sans font-w-100">{{$main->age($posts->stud_dob)}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Birth Place : <span class="font-open-sans font-w-100">{{$posts->birth_place}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Nationality : <span class="font-open-sans font-w-100">{{$posts->nationality}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Mother Tongue : <span class="font-open-sans font-w-100">{{$posts->mother_tongue}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Contact Number :<br>
                           <span class="font-open-sans font-w-100"><i class="fa fa-circle m-r-5 color-high"></i>  Phone : {{($posts->stud_phone != null) ? $posts->stud_phone : 'Not provided'}}</span>
                            <br>
                           <span class="font-open-sans font-w-100"><i class="fa fa-circle m-r-5 color-high"></i>  Mobile : {{($posts->stud_cell != null) ? $posts->stud_cell : 'Not provided'}}</span>
                    </h5>
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
                     <i class="fa fa-lightbulb-o text-theme-colored font-25 pr-10"></i>
                   </div>
                   <div class="media-body">
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Collge last Attended : <span class="font-open-sans font-w-100">{{($posts->college_last_attended != null) ? $posts->college_last_attended : 'Not provided'}}</span></h5>
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
                     <h5 class="mt-0 mb-0 font-Trirong">Previous Address:</h5>
                     <p>{{$posts->full_address}}, {{$posts->pincode}}</p>
                   </div>
                 </div>
               </div>
             </div>
           </div>
          @endif
       @endforeach  
          </div>
        </div>

      <div class="col-md-9">
            <ul class="nav nav-tabs profile-tab m-b-5" role="tablist">
               <li class="nav-item"> <a class="nav-link active show bg-white" data-toggle="tab" href="#Profiles" role="tab" aria-selected="true">Profile</a> </li>
               <li class="nav-item"><a class="nav-link bg-white" data-toggle="tab" href="#Education" role="tab"  aria-selected="false">Educational Info.</a></li>
               <li class="nav-item"> <a class="nav-link bg-white" href="javascript:void(0)" aria-selected="false">Skills</a> </li>
               <li class="nav-item ">
                 <a class="nav-link bg-white" href="{{route('showHSCCStudentEvalChart',[$pid,$hfid])}}"  aria-selected="false">Perfomance/ Evaluation</a>
               </li>
               <li class="nav-item"> <a class="nav-link bg-white" data-toggle="tab" href="#family" role="tab" aria-selected="false">Family Details</a> </li>
            </ul>

            <div class="tab-content">
               <div class="tab-pane active show" id="Profiles" role="tabpanel">
               @foreach($post as $posts)
               @if($posts->stdid != null)
<!--*****************************General education chart data**********************************-->
                 <div class="card box-shadow br-5">
                   <div class="card-body">

                     <div class="row">
                       <div class="col-md-12">
                         <div class="d-flex m-b-30 no-block">
                             <h4 class="card-title m-b-0 align-self-center">Genaral Education</h4>
                             <div class="ml-auto">
                               <div class="row">
                                 <div class="col-md-5">
                                   <label class="m-t-10">Select Year</label>
                                 </div>
                                 <div class="col-md-7">
                                   <select class="custom-select w-auto" id="general" onchange="ajaxData(document.getElementById('general').value,'{{route('generalEdu')}}','generalChart','{{$posts->stdid}}')">
                                     @foreach($years as $y)
                                     <option value="{{$y->year}}">{{$y->year}}</option>
                                     @endforeach
                                   </select>
                                 </div>
                               </div>
                             </div>
                           </div>
                       </div>
                     </div>

                     <div class="row" id="generalChart">
                       <div class="col-md-6">
                         <div class="card" style="border-right: 1px solid #15141429">
                           <div class="d-flex no-block p-15 align-items-center">
                             <div class="round bg-light text-dark"><i class="fa fa-institution font-18"></i></div>
                             <div class="m-l-10 ">
                               <h4 class="m-b-0 font-Trirong">School/ College:</h4>
                               <h5 class="font-light m-b-0 font-14">{{$posts->school}}</h5> </div>
                             </div>
                             <hr>
                             <div class="d-flex no-block p-15 align-items-center">
                               <div class="round bg-light text-dark"><i class="fa fa-graduation-cap font-18"></i></div>
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong">Grade/ Standard and Perfomance</h4>
                                 <h5 class="font-light m-b-0 font-14">Grade : {{$posts->grade}}</h5>
                                 <h5 class="font-light m-b-0 font-14">Perfomance : {{$posts->perfomance}}</h5>
                               </div>
                             </div>
                             <hr>
                             <div class="d-flex no-block p-15 m-b-15 align-items-center">
                               <div class="round bg-light text-dark"><i class="fa fa-book font-16"></i></div>
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong">Strength and Weakness</h4>
                                 <h5 class="font-light m-b-0 font-14">Weak : {{$posts->weak}}</h5>
                                 <h5 class="font-light m-b-0 font-14">Strong : {{$posts->strong}}</h5>
                               </div>
                             </div>
                           </div>
                         </div>

                         <div class="col-md-6 text-center">
                           <div id="morris-donut-chart4" class="h-260"></div>
                           <ul class="list-inline text-right">
                             <li>
                               <p><i class="fa fa-circle m-r-5"></i>Need to improve</p>
                             </li>
                             <li>
                               <p><i class="fa fa-circle m-r-5 color-high"></i>General Education</p>
                             </li>
                           </ul>
                         </div>
                       </div>

                     </div>
                   </div>
   <!--******************************Religious Education chart***********************************************-->
                   <div class="card box-shadow br-5 m-t-10">
                     <div class="card-body">

                       <div class="row">
                         <div class="col-md-12">
                           <div class="d-flex m-b-30 no-block">
                             <h4 class="card-title m-b-0 align-self-center">Religious Education</h4>

                             <div class="ml-auto">
                               <div class="row">
                                 <div class="col-md-5">
                                   <label class="m-t-10">Select Year</label>
                                 </div>
                                 <div class="col-md-7">
                                   <select class="custom-select w-auto" id="religiousYear" onchange="ajaxData(this.value,'{{route('religiousEdu')}}','religiousChart','{{$posts->stdid}}')">
                                     @foreach($years as $y)
                                     <option value="{{$y->year}}">{{$y->year}}</option>
                                     @endforeach
                                   </select>
                                 </div>
                               </div>

                             </div>
                           </div>
                         </div>
                       </div>

                       <div class="row" id="religiousChart">
                         <div class="col-md-6">
                           <div id="morris-donut-chart5" class="h-260"></div>
                           <ul class="list-inline text-right">
                             <li>
                               <p><i class="fa fa-circle m-r-5"></i>Need to progress</p>
                             </li>
                             <li>
                               <p><i class="fa fa-circle m-r-5 text-info"></i>Religious Education</p>
                             </li>
                           </ul>
                         </div>

                         <div class="col-md-6">
                           <div class="card" style="border-left: 1px solid #15141429">
                             <div class="d-flex no-block p-15 align-items-center">
                               <div class="round bg-dark"><i class="fa fa-book font-18"></i></div>
                               <div class="m-l-10 ">
                                 <h3 class="m-b-0 font-Trirong">Madrasa : {{$posts->madrasa}} %</h3>
                               </div>
                             </div>
                             <hr>
                             <div class="d-flex no-block p-15 align-items-center">
                               <div class="round bg-dark"><i class="fa fa-book font-18"></i></div>
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong"><b>Huqub-Al-Ibada : {{$posts->ibada}} %</b></h4>
                               </div>
                             </div>
                             <hr>
                             <div class="d-flex no-block p-15 m-b-15 align-items-center">
                               <div class="round bg-dark"><i class="fa fa-book font-16"></i></div>
                               <div class="m-l-10">
                                 <h3 class="m-b-0 font-Trirong">Practices : {{$posts->practices}} %</h3>
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                @else
                  @include('admin.Error_Pages.error_page2')
                @endif
                @endforeach
               </div>
               <!--************************* End Profile Tab **************************-->

               <!--************************* Education Tab **************************-->
               <div class="tab-pane" id="Education" role="tabpanel">
                  <div class="card p-10 br-5 box-shadow-e">
                    <h4>Educational Information</h4>
                    @include('admin/Error_Pages/error_page2')
                  </div>
                </div>
                <!--*************************End Education Info. Tab **************************-->

                <!--*************************Family Info. Tab **************************-->
                <div class="tab-pane" id="family" role="tabpanel">
                  <div class="card-body">
                      <div class="row el-element-overlay">
                        <div class="col-md-12">
                          <h4 class="card-title">Family members</h4>
                          <hr>
                        </div>
                        @foreach($post as $obj)
                        <div class="col-md-6">
                          <div class="card box-shadow bg-white br-5">
                            <div class="message-box">
                              <div class="message-widget message-scroll">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12">
                                    <div class="user-img text-center p-10">
                                      <img src="{{asset('adminAssets/images/default/default1.png')}}" alt="user" class="img-round" style="width: 50px;border-radius: 50%;">
                                    </div>
                                  </div>
                                  <div class="col-md-10">
                                    <div class="mail-contnet w-100">
                                      <span class="btn btn-circle pull-right" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" aria-haspopup="true" aria-expanded="false" style="    margin: 5px 17px 0px 0px;background: none;color: black;">
                                        <i class="ti-more-alt pull-right" style="margin-right: 3px;transform: rotate(90deg);margin-top: 2px;"></i>
                                      </span>
                                      <a ref="#" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" class="text-dark">
                                       <h4 class="font-Trirong font-16"><b>{{$obj->father_name}}</b></h4>
                                       <p>(Father)</p>
                                     </a>
                                   </div>

                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                        </div>

                        <div class="col-md-6">
                          <div class="card box-shadow bg-white br-5">
                            <div class="message-box">
                              <div class="message-widget message-scroll">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12">
                                    <div class="user-img text-center p-10">
                                      <img src="{{asset('adminAssets/images/default/default1.png')}}" alt="user" class="img-round" style="width: 50px;border-radius: 50%;">
                                    </div>
                                  </div>
                                  <div class="col-md-10">
                                    <div class="mail-contnet w-100">
                                      <span class="btn btn-circle pull-right" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" aria-haspopup="true" aria-expanded="false" style="    margin: 5px 17px 0px 0px;background: none;color: black;">
                                        <i class="ti-more-alt pull-right" style="margin-right: 3px;transform: rotate(90deg);margin-top: 2px;"></i>
                                      </span>
                                      <a ref="#" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" class="text-dark">
                                       <h4 class="font-Trirong font-16"><b>{{$obj->mother_name}}</b></h4>
                                       <p>(Mother)</p>
                                     </a>
                                   </div>

                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                        </div>
                        @if($posts->stud_marital == 'Married')
                        <div class="col-md-6">
                          <div class="card box-shadow bg-white br-5">
                            <div class="message-box">
                              <div class="message-widget message-scroll">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12">
                                    <div class="user-img text-center p-10">
                                      <img src="{{asset('adminAssets/images/default/default1.png')}}" alt="user" class="img-round" style="width: 50px;border-radius: 50%;">
                                    </div>
                                  </div>
                                  <div class="col-md-10">
                                    <div class="mail-contnet w-100">
                                      <span class="btn btn-circle pull-right" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" aria-haspopup="true" aria-expanded="false" style="    margin: 5px 17px 0px 0px;background: none;color: black;">
                                        <i class="ti-more-alt pull-right" style="margin-right: 3px;transform: rotate(90deg);margin-top: 2px;"></i>
                                      </span>
                                      <a ref="#" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" class="text-dark">
                                       <h4 class="font-Trirong font-16"><b>{{$obj->husband_name}}</b></h4>
                                       <p>(husband_name)</p>
                                     </a>
                                   </div>

                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                        </div>
                        @endif

                        @if($posts->guardian_name != null)
                        <div class="col-md-6">
                          <div class="card box-shadow bg-white br-5">
                            <div class="message-box">
                              <div class="message-widget message-scroll">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12">
                                    <div class="user-img text-center p-10">
                                      <img src="{{asset('adminAssets/images/default/default1.png')}}" alt="user" class="img-round" style="width: 50px;border-radius: 50%;">
                                    </div>
                                  </div>
                                  <div class="col-md-10">
                                    <div class="mail-contnet w-100">
                                      <span class="btn btn-circle pull-right" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" aria-haspopup="true" aria-expanded="false" style="    margin: 5px 17px 0px 0px;background: none;color: black;">
                                        <i class="ti-more-alt pull-right" style="margin-right: 3px;transform: rotate(90deg);margin-top: 2px;"></i>
                                      </span>
                                      <a ref="#" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" class="text-dark">
                                       <h4 class="font-Trirong font-16"><b>{{$obj->guardian_name}}</b></h4>
                                       <p>(Guardian)</p>
                                     </a>
                                   </div>

                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                        </div>
                        @endif
                        @endforeach
                      </div>
                  </div>
                </div>
                <!--*************************End Family Info. Tab **************************-->
            </div>
         </div>
      </div>
     @else
       @include('admin.Error_Pages.error_page2')
     @endif
   </div>  
   @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._evaluationChartDataJs')
@endsection
