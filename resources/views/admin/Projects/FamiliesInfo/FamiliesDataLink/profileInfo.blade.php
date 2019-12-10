@include('admin.mainpage.pages.profile-loader')
<div class="row contents" style="display: none;">
   <div class="col-md-2">
      <div class="card famCard br-5 m-b-0" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
         <div class="card-body p-0">
            <div class="row">
               <div class="col-md-12 text-center">
                  <img src="{{asset('adminAssets/images/default/girl.jpg')}}" style="width:160px;border-radius: 70px;">
               </div>
               <div class="col-md-12">
                  <div class="modelHead text-center">
                     <h3 class="card-title m-t-10 text-white font-16">{{$posts->fname}} {{$posts->lname}}</h3>
                     <h4 class="text-muted font-14">{{$posts-> role}}
                        <small>({{$posts->relation}})</small>
                     </h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="col-md-10">
      <ul class="nav nav-tabs bg-white m-l-0" role="tablist" style="border-bottom: 0.5px solid #0001;">
         <li class="nav-item"> <a class="nav-link nav-a active show text-dark" data-toggle="tab" href="#personal{{$posts->id}}" role="tab" aria-selected="true">Personal Information</a> </li>
         @if($posts->role == 'Head')
         <li class="nav-item"> <a class="nav-link nav-a text-dark" data-toggle="tab" href="#headHistory{{$posts->id}}" role="tab" aria-selected="true">History</a></li>
         @endif
         <li class="nav-item"> <a class="nav-link nav-a text-dark" data-toggle="tab" href="#edu{{$posts->id}}" role="tab" aria-selected="true">General Eductaion</a></li>
      </ul>
      <div class="card-body">
         <div class="tab-content">
            <!--personal tab-->
            <div class="tab-pane active show" id="personal{{$posts->id}}" role="tabpanel">
               <div class="row familyProfileRow">
                  <div class="col-md-12">
                     <h4 class="font-14 font-w-700" style="color: #6c757d">FAMILY {{($posts->role == 'Head') ? "HEAD'S" : "MEMBER'S"}} PERSONAL DETAILS</h4>
                     <hr>
                  </div>
                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                          <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Full Name :</span> {{$posts->fname}} {{$posts->lname}}</h6>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights">
                              <span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark"> Date of Birth. :</span> {{$posts->dob}}
                           </h6>
                        </div>
                     </div>
                  </div>
                  @if(ifAnd($posts->birth_place))
                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"> <span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark"> Birth Place :</span> {{$posts->birth_place}}</h6>
                        </div>
                     </div>
                  </div>
                  @endif
                  <div class="col-md-2">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"> <span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Gender :</span>{{$posts->gender}}</h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Nationality :</span> {{$posts->nationality}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Relegion :</span> {{$posts->relegion}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Mother Tongue :</span> {{$posts->mother_tongue}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Marital Status :</span> {{$posts->marital_status}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Blood Group :</span> {{ifAnd($posts->blood_group) ? $posts->blood_group : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Adhar Card No. :</span> {{ifAnd($posts->adhar_no) ? $posts->adhar_no : 'N/A'}}   <span><small>
                              <a href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Adhar{{$posts->id}}" class="text-lowercase font-w-700 ">{{ifAnd($posts->adhar_image) ? 'view' : 'upload'}} adhar card</a>
                           </small></span></h6>
                        </div>
                     </div>
                     @error('adhar_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>

                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Mobile :</span> {{ifAnd($posts->mobile) ? $posts->mobile : 'N/A'}}</h6>
                        </div>
                     </div>
                  </div>

                  @if(ifAnd($posts->phone))
                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Phone  :</span> {{ $posts->phone }} </h6>
                        </div>
                     </div>
                  </div>
                  @endif
                  @if(ifAnd($posts->email))
                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Email  :</span> {{ $posts->email }} </h6>
                        </div>
                     </div>
                  </div>
                  @endif

                  @if(ifAnd($posts->occupation_name))
                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Occupation  :</span> {{ $posts->occupation_name }} </h6>
                        </div>
                     </div>
                  </div>
                  @endif

                  @if(ifAnd($posts->hobbies))
                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Hobbies  :</span> {{ $posts->hobbies }} </h6>
                        </div>
                     </div>
                  </div>
                  @endif

                  @if(ifAnd($posts->goal))
                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Goal  :</span> {{ $posts->goal }} </h6>
                        </div>
                     </div>
                  </div>
                  @endif
               </div>
            </div>
            <!-- end personal tab -->
            @if($posts->role == 'Head')
            <!--history tab-->
            <div class="tab-pane" id="headHistory{{$posts->id}}" role="tabpanel">
               <div class="row familyProfileRow">
                  <div class="col-md-12">
                     <h4 class="font-14 font-w-700" style="color: #6c757d">{{($posts->role == 'Head') ? "HEAD'S" : "MEMBER'S"}} HISTORY INFO.</h4>
                     <hr>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Health Status  :</span> {{ifAnd($posts->health_status) ? $posts->health_status : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Familial Relation  :</span> {{$posts->familial_relation}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Shelter  :</span> {{$posts->shelter}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Self Reliant  :</span> {{$posts->self_reliant}} </h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end history tab -->
            @endif
            <!--general education tab-->
            <div class="tab-pane" id="edu{{$posts->id}}" role="tabpanel">
               <div class="row familyProfileRow">
                  <div class="col-md-12">
                     <h4 class="font-14 font-w-700" style="color: #6c757d">{{($posts->role == 'Head') ? "HEAD'S" : "MEMBER'S"}} GENERAL EDUCATION INFO.</h4>
                     <hr>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Qualification :</span> {{ifAnd($posts->qualification) ? $posts->qualification : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>
                  @if(ifAnd($posts->course_name))
                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Course Name :</span> {{$posts->course_name}} </h6>
                        </div>
                     </div>
                  </div>
                  @endif
                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Standard/ Grade  :</span> {{ifAnd($posts->standard_grade) ? $posts->standard_grade : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>
                  @if(ifAnd($posts->stage))
                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Stage  :</span> {{$posts->stage}} </h6>
                        </div>
                     </div>
                  </div>
                  @endif
                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Performance :</span> {{ifAnd($posts->performance) ? $posts->performance : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <hr>
                     <h4 class="font-14 font-w-700" style="color: #6c757d">INSTITUTION'S INFO.</h4>
                  </div>

                  <div class="col-md-9">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Institution Name :</span> {{ifAnd($posts->institution_name) ? $posts->institution_name : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Sector :</span> {{ifAnd($posts->sector) ? $posts->sector : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Institution Category :</span> {{ifAnd($posts->institution_category) ? $posts->institution_category : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Community Type :</span> {{ifAnd($posts->community_type) ? $posts->community_type : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Street :</span> {{ifAnd($posts->inst_street) ? $posts->inst_street : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">City :</span> {{ifAnd($posts->inst_city) ? $posts->inst_city : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">District :</span> {{ifAnd($posts->inst_district) ? $posts->inst_district : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">State :</span> {{ifAnd($posts->inst_state) ? $posts->inst_state : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="media p-5 border-bottom">
                        <div class="media-body">
                           <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Pin Code :</span> {{ifAnd($posts->pin_code) ? $posts->pin_code : 'N/A'}} </h6>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
            <!-- end general education tab -->
         </div>
      </div>
   </div>
</div>