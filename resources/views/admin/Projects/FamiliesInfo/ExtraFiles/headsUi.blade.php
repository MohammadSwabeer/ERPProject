<div class="col-md-6">
        @foreach($post as $posts)
        @if($posts->role == 'Head')
        <?php $pid = $posts->id; $mod[] =$pid;$hfid = $posts->hfid;?>
          @include('admin.mainpage.pages.profile-loader')
        <div class="row contents" style="display: none;">
          <div class="col-md-12" >
            <div class="card famCard br-t-r-5 m-b-0" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div>
                      @if($posts->image != '' || $posts->image != null)
                      <a href="#" data-toggle="modal" data-target="#familyProfile{{$posts->id}}"><img src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$posts->image)}}" class="m-l-15 box-shadow-Fam" style="width:110px;border-radius: 70px;height: 110px;"></a>
                      @else
                        @if($posts->gender == 'Male')
                        <img src="{{asset('adminAssets/images/default/default1.png')}}" class="m-l-15 box-shadow-Fam" style="width:110px;border-radius: 70px;height: 110px;">
                        @else
                        <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="m-l-15 box-shadow-Fam" style="width:110px;border-radius: 70px;height: 110px;">
                        @endif
                      @endif
                    </div>
                  </div>
                  <div class="col-md-10">
                    <div class="modelHead m-l-50">
                      <h3 class="card-title m-t-10 text-white">{{$posts->fname}} {{$posts->lname}}</h3>
                      <h4 class="text-muted">{{ $posts->role}}
                        <small>({{$posts->relation}})</small>
                        <div class="btn-group pull-right btnGroup">
                          <!-- <a class="btn btn-circle bg-white box-shadow-e" style="border-radius: 50px;"  data-toggle="tooltip" aria-haspopup="true" aria-expanded="true" title="Edit Profile" data-placement="left"><i class="ti-more-alt text-dark"></i>
                          </a> -->
                          <button type="button" class="btn btn-circle bg-white box-shadow-e" style="border-radius: 50px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-more-alt text-dark"></i>
                          </button>
                          <div class="dropdown-menu animated flipInY">
                            <a class="dropdown-item" href="{{route('HSCCFamilyEdit',[encrypt($posts->id),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}">Edit Profile</a>
                            <a class="dropdown-item" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#{{$posts->id}}helps">Add Helps Needed</a>
                            <a class="dropdown-item" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#{{$posts->id}}service">Add Services Provided</a>
                          </div>
                        </div>
                      </h4>
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

                <div class="col-md-12">
                  <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#headProfile" role="tab" aria-selected="true">Profile</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#History" role="tab" aria-selected="true">History</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#headAddress" role="tab" aria-selected="false">Address</a> </li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!--second tab-->
                    <div class="tab-pane active show" id="headProfile" role="tabpanel">
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
                                    <h6> {{$posts->hfid}}</h6>
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
                                    <h6> {{($posts->occupation_name == null) ? 'Not-provided' : $posts->occupation_name}}</h6>
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
                    <div class="tab-pane" id="History" role="tabpanel">
                      <div class="card-body">
                        <div class="d-flex m-b-30 no-block">
                          <div class="row memberProfileRow familyProfileRow font-open-sans">
                            <div class="col-md-4">
                              <div class="media">
                                <div class="media-left">
                                  <small class="p-t-30 db font-Trirong"><b> Date of Join :</b></small>
                                </div>
                                <div class="media-body">
                                  <h6> {{$posts->doj}}</h6>
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
                                  <h6 class="font-open-sans"> {{($posts->familial_relation == null) ? 'Not provided' : $posts->familial_relation}}</h6>
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
                                  <h6> {{($posts->health_status == null) ? 'Not-provided' : $posts->health_status}}</h6>
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
                                  <h6> {{$posts->self_reliant}}</h6>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="media">
                                <div class="media-body">
                                  <small class="p-t-30 db"><b>Services obtained upto now from HSCC  :</b></small>
                                  
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
                                  <h6></h6>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--  History tab end-->
                    <div class="tab-pane" id="headAddress" role="tabpanel">
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
                                          <h6>: {{$posts->present_door}}</h6>
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
                                          <h6>: {{ifAnd($posts->door_no) ? $posts->door_no : 'Not provided'}}</h6>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Street</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6>: {{ifAnd($posts->street_area) ? $posts->street_area : 'Not provided'}}</h6>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b> Taluk</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6>: {{ifAnd($posts->city) ? $posts->city : 'Not provided'}}</h6>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                       <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b> State</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6>: {{ifAnd($posts->state) ? $posts->state : 'Not provided'}}</h6>
                                        </div>
                                       </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="media">
                                        <div class="media-left">
                                          <small class="p-t-30 db"><b>Posatal Code :</b></small>
                                        </div>
                                        <div class="media-body">
                                          <h6> {{ifAnd($posts->pincode) ? $posts->pincode : 'Not provided'}}</h6>
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
        @endif
        @endforeach
      </div>