   <?php use \App\Http\Controllers\MainController; ?>
   @extends('admin/mainpage/adminmain')

   @section('admincontents')
     @foreach($post as $posts)
     <?php $stdid = $posts->student_id; $hfid = $posts->hfId; ?>
     @endforeach

    <div class="row page-titles">
      <div class="col-md-12">
        <div class="d-flex">
          <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
                <li class="breadcrumb-item"><a href="{{route('Families.index')}}">HSCC Details</a></li>
                <li class="breadcrumb-item"><a href="{{route('HSCCFamilyStudents',['ColonyStudents'])}}">HSCC Students Details</a></li>
                <li class="breadcrumb-item active">HSCC Student Profile</li>
              </ol>
        </div>

      </div>
    </div>
    <div class="row contents">
          @if($stdid != null)
          <div class="col-md-3"><div>
          <?php $count = 0;$counts = 0; ?>
          @foreach($post as $posts)
          @if($posts->fname !== null) 
          <?php $pid = $posts->student_id; $count++; ?>
          @endif
          @if($count == 1)
          <div class="card box-shadow-gradient br-5 p-10-0" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
              <center class="m-t-30">
                 @if($posts->image != null  || $posts->image != null )
                 <img src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$posts->image)}}" class="img-circle mt-m-25" width="150">
                 @else
                     @if($posts->gender == 'Male')
                     <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle mt-m-25" width="150">
                     @else
                     <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="img-circle mt-m-25" width="150">
                     @endif
                 @endif
                <h4 class="card-title m-t-10 text-white">{{$posts->fname}}</h4>
              </center>
               <div class="card br-b-l-5 m-b-0 p-5 box-shadow-e" style="background: #00000061;color: white;">
                  <div class="row text-center ">
                     <div class="col-md-6 border-right">
                        <div>
                           <h5 class="font-Trirong font-14 font-w-900">HF-Id <br><small style="font-size: 100%">{{($posts->hfId != null) ? $posts->hfId : 'Not provided'}}</small></h5>
                           
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div>
                           <h5 class="font-Trirong font-14 font-w-900">Adhar No <br><small style="font-size: 100%">{{($posts->adhar_no != null) ? $posts->adhar_no : 'Not provided'}}</small></h5>
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
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Age : <span class="font-open-sans font-w-100">{{MainController::age($posts->dob)}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Gender : <span class="font-open-sans font-w-100">{{$posts->gender}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Contact Number : <span class="font-open-sans font-w-100">{{($posts->mobile != null) ? $posts->mobile : 'Not provided'}}</span></h5>
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
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Hobbies : <span class="font-open-sans font-w-100">{{($posts->hobbies != null) ? $posts->hobbies : 'Not provided'}}</span></h5>
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Area of Interest/ Goal  <p class="font-open-sans p-5 font-w-100">{{($posts->goal != null) ? $posts->goal : 'Not provided'}}</p></h5>
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
                     <p>01, Kavalkatte, Bantval, Karnataka 574231</p>
                     <!-- p>{{$posts->presentFamilyDoor}}, {{$posts->street}}, {{$posts->taluk}} ,{{$posts->state}} <br> {{$posts->postcode}}</p> -->
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
                    <h5 class="mt-0 mb-0 font-Trirong">Present Address:</h5>
                     <p>1-05, Belthangady, Bantval, Karnataka 574231</p>
                    <!-- p>{{$posts->presentFamilyDoor}}, {{$posts->street}}, {{$posts->taluk}} ,{{$posts->state}} <br> {{$posts->postcode}}</p> -->
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
                    @foreach($educations as $education)
                    <?php $eval = $posts->eval_id; ?>
                    @endforeach
                    @if($eval != null)
                    <div class="table-responsive">
                      <table id="StudentEducationTable" class="table table table m-t-30 table-hover contact-list footable-loaded footable">
                        <thead>
                          <tr>
                            <?php $i=1; ?>
                            <th>#</th>
                            <th>Grade /Standard</th>
                            <th>School/ College Stage</th>
                            <th>School/ College-Name</th>
                            <th>Weak Subjects</th>
                            <th>Strong Subjects</th>
                            <th>Perfomance</th>
                            <th>Year</th>
                            <th>More</th>
                          </tr>
                        </thead>
                        <tbody id="std_tbl_body">
                         @foreach($educations as $education)
                          <tr class="text-center btn-block-inline">
                            <td>{{$i++}}</td>
                            <td>{{$education->grade}}</td>
                            <td>{{$education->school_type}}</td>
                            <td>{{$education->school}}</td>
                            <td>{{$education->weak}}</td>
                            <td>{{$education->strong}}</td>
                            <td>{{$education->perfomance}}</td>
                            <td>{{$education->year}}</td>
                            <td>More</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    @else
                    @include('admin/Error_Pages/error_page2')
                    @endif
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
                        @if(count($FamilyMembers) !== 0)
                        @foreach($FamilyMembers as $obj)
                        @if($obj->id != $pid)
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
                                       <h4 class="font-Trirong font-16"><b>{{$obj->fname}}</b></h4>
                                       <p>({{MainController::findRelation($obj->relation)}})</p>
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
                        @else
                          @include('admin/Error_Pages/error_page2')
                        @endif
                      </div>
                  </div>
                </div>
                <!--*************************End Family Info. Tab **************************-->
            </div>
         </div>
      </div>

      <!--**************************************************************************************-->
                                       <!-- Start Model -->
        <!--**************************************************************************************-->
        <?php $j =1; ?>
        @foreach($FamilyMembers as $posts)
        <div class="modal fade" id="familyProfile{{$posts->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
          <div class="modal-dialog" role="document">
            <div class="modal-content w-1000 m-l-m-100 bg-transparent b-none" style=";;">
              <div>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 40px"><span aria-hidden="true">&times;</span></button>
              </div>

              <div class="modal-body">
                <div class="row m-t-50" style="color:white">

                <div class="col-md-12">

                  <div class="card famCard br-t-r-5 mb-m-10" style="background:linear-gradient(rgba(109, 255, 91, 0.3), rgba(0, 0, 0, 0.98)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
                    <div class="card-body">
                      <div class="row">
                        
                        <div class="col-md-10 offset-md-2">
                          <h3 class="card-title m-t-10 text-white">{{$posts->fname}}  </h3>
                          <div class="modelHead">
                            <h4 class="text-muted">{{ MainController::findRelation($posts->relation)}}<small>({{$posts->role}})</small></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- Column -->
                <div class="col-md-12">
                  <div class="card br-b-l-5 box-shadow mt-m-15">
                    <!-- Nav tabs -->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="mt-m-90">
                          @if($posts->image != null || $posts->image != '')
                            <img src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$posts->image)}}" class="m-l-15" style="width:140px;border: 5px solid white;border-radius: 70px">
                          @else
                            @if($posts->gender == 'Male')
                            <img src="{{asset('adminAssets/images/default/default1.png')}}" class="m-l-15" style="width:140px;border: 5px solid white;border-radius: 70px">
                            @else
                            <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="m-l-15" style="width:140px;border: 5px solid white;border-radius: 70px">
                            @endif
                          @endif
                        </div>
                     </div>

                     <div class="col-md-12">
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                          <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#headProfile{{$posts->id}}" role="tab" aria-selected="true">Profile</a> </li>
                          @if($posts->role == 'Head')
                          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#History{{$posts->id}}" role="tab" aria-selected="true">History</a> </li>
                          @endif
                          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#headAddress{{$posts->id}}" role="tab" aria-selected="false">Address</a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                          <!--second tab-->
                          <div class="tab-pane active show" id="headProfile{{$posts->id}}" role="tabpanel">
                            <div class="card-body">
                              <div class="col-md-12">
                                <div class="d-flex m-b-30 no-block">

                                  <div class="row memberProfileRow familyProfileRow font-open-sans">
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db font-Trirong"><b> HF Id :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{$posts->hfId}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    @if($posts->email != null && $posts->email != 'null')
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db font-Trirong"><b> E-mail address :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{($posts->email == null) ? 'Not-provided' : $posts->email}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db font-Trirong"><b> Phone number :</b> </small>
                                        </div>
                                        <div class="media-body">
                                          <h6 class="font-open-sans"> {{($posts->mobile == null) ? 'Not provided' : $posts->mobile}}</h6>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                       <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b> Gender :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{$posts->gender}}</h6>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b> Qualification :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{($posts->qualification == null) ? 'Not-provided' : $posts->qualification}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b> Occupation :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{($posts->occupation == null) ? 'Not-provided' : $posts->occupation}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Age :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{MainController::age($posts->dob)}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Marital Status :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{($posts->marital_status == null) ? 'Not-provided' : $posts->marital_status}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Annual Income :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{($posts->income == null && $posts->income == 0) ? 'Not-provided' : $posts->income}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    @if($posts->role == 'Head')
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Helps needed :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{($posts->helps == null) ? 'Not-provided' : $posts->helps}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                    <div class="col-md-12">
                                      <hr>
                                      <h4>Document Details</h4>
                                    </div>
                                    @if($posts->ration_no != '' && $posts->ration_no != null)
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Ration Card number :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{ $posts->ration_no}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    @endif

                                    @if($posts->adhar_no != '' && $posts->adhar_no != null)
                                    <div class="col-md-6">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Adhar Card number :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{ $posts->adhar_no}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- History Tab Start -->
                          <div class="tab-pane" id="History{{$posts->id}}" role="tabpanel">
                            <div class="card-body">
                              <div class="d-flex m-b-30 no-block">
                                <div class="row memberProfileRow familyProfileRow font-open-sans">
                                  <div class="col-md-4">
                                    <div class="media">
                                      <div class="media-left">
                                        <small class="p-t-30 db font-Trirong"><b> Date of Join :</b></small>
                                      </div>
                                      <div class="media-body">
                                        <h6> {{$posts->dojHSCC}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                  @if($posts->reason != null && $posts->reason != 'null')
                                  <div class="col-md-8">
                                    <div class="media">
                                      <div class="media-body">
                                        <small class="p-t-30 db font-Trirong"><b> Reason/Desperation :</b></small>
                                        <h6> {{($posts->reason == null) ? 'Not-provided' : $posts->reason}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                  <div class="col-md-12">
                                    <hr>
                                    <h4>Previous Status</h4>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="media">
                                      <div class="media-left">
                                        <small class="p-t-30 db font-Trirong"><b> Familial/ Realtionship :</b> </small>
                                      </div>
                                      <div class="media-body">
                                        <h6 class="font-open-sans"> {{($posts->familial == null) ? 'Not provided' : $posts->familial}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                  @if($posts->income_source != null && $posts->income_source != '')
                                  <div class="col-md-6">
                                     <div class="media">
                                      <div class="media-left">
                                        <small class="p-t-30 db"><b> Income source :</b></small>
                                      </div>
                                      <div class="media-body">
                                        <h6> {{$posts->income_source}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                  <div class="col-md-6">
                                    <div class="media">
                                      <div class="media-left">
                                        <small class="p-t-30 db"><b> Health Status :</b></small>
                                      </div>
                                      <div class="media-body">
                                        <h6> {{($posts->healthstatus == null) ? 'Not-provided' : $posts->healthstatus}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="media">
                                      <div class="media-left">
                                        <small class="p-t-30 db"><b> Shelter :</b></small>
                                      </div>
                                      <div class="media-body">
                                        <h6> {{($posts->shelter == null) ? 'Not-provided' : $posts->shelter}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="media">
                                      <div class="media-left">
                                        <small class="p-t-30 db"><b>Self Reliant :</b></small>
                                      </div>
                                      <div class="media-body">
                                        <h6> {{$posts->selfReliant}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="media">
                                      <div class="media-body">
                                        <small class="p-t-30 db"><b>Services obtained upto now from HSCC  :</b></small>
                                        @if($posts->services != null)
                                        <?php $service = explode(',',$posts->services); ?>
                                        @foreach($service as $serve)
                                        <h6> <i class="ti-angle-double-right"></i>{{$serve}}</h6>
                                        @endforeach
                                        @else
                                        {{'Not-provided'}}
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <hr>
                                    <h4>Present status</h4>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="media">
                                      <div class="media-body">
                                        <h6> {{($posts->presentStatus == null && $posts->presentStatus == '') ? 'Not-provided' : $posts->presentStatus}}</h6>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--  History tab end-->
                          <div class="tab-pane" id="headAddress{{$posts->id}}" role="tabpanel">
                            <div class="card-body">
                                <div class="col-md-12">
                                  <div class="d-flex m-b-30 no-block">
                                    <div class="row memberProfileRow familyProfileRow">
                                      <div class="col-md-6">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <h4>Present Address</h4>
                                            <hr>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b> Door Number</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: {{$posts->presentFamilyDoor}}</h6>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b>Street</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: Kavalkatte</h6>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-12">
                                             <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b> State</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: Karnataka</h6>
                                              </div>
                                             </div>
                                          </div>

                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b> Taluk</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: Bantval</h6>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b>Posatal Code :</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6> 574265</h6>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <h4>Previous Address</h4>
                                            <hr>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b> Door Number</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: {{($posts->previousFamilyDoor != '-' && $posts->previousFamilyDoor != '') ? $posts->previousFamilyDoor : 'not provided'}}</h6>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b>Street</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: {{$posts->previousStreet}}</h6>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-12">
                                             <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b> State</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: {{$posts->previousState}}</h6>
                                              </div>
                                             </div>
                                          </div>

                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b> Taluk</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6>: {{$posts->previousCity}}</h6>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="media">
                                              <div class="media-left">
                                                <small class="p-t-30 db"><b>Posatal Code :</b></small>
                                              </div>
                                              <div class="media-body">
                                                <h6> {{$posts->previousPin}}</h6>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $j++; ?>
    @endforeach
     @else
       @include('admin.Error_Pages.error_page2')
     @endif
   </div>  
   @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._evaluationChartDataJs')
@endsection
