      <div class="col-md-6">
        @foreach($post as $posts)
        @if($posts->relation == 'Father' || $posts->relation == 'Mother')
        @if($posts->id != $pid)
          @include('admin.mainpage.pages.profile-loader')

        <div class="row contents" style="display: none;">
          <div class="col-md-12 ">
            <div class="card famCard br-t-r-5 m-b-0" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div>
                      @if($posts->image != '' || $posts->image != null)
                      <a href="#" data-toggle="modal" data-target="#familyProfile{{$posts->id}}"><img src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$posts->image)}}" class="m-l-15 br-5" style="width:80px"></a>
                      @else
                        @if($posts->gender == 'Male')
                        <img src="{{asset('adminAssets/images/default/default1.png')}}" class="m-l-15 br-5" style="width:80px">
                        @else
                        <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="m-l-15 br-5" style="width:80px">
                        @endif
                      @endif
                    </div>
                  </div>
                  <div class="col-md-10">
                    <div class="modelHead m-l-50">
                      <h3 class="card-title m-t-10 text-white">{{$posts->full_name}}</h3>
                      <h4 class="text-muted">{{ $posts->relation}}
                        <small>({{$posts->relation}})</small>
                        <div class="btn-group pull-right btnGroup">
                          <a class="btn btn-circle bg-white box-shadow-e" style="border-radius: 50px;" href="{{route('HSCCFamilyEdit',[encrypt($posts->id),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="true" title="Edit Profile" data-placement="left">
                            <i class="ti-more-alt text-dark"></i>
                          </a>
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

                <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#profile" role="tab" aria-selected="true">Profile</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#address" role="tab" aria-selected="false">Address</a> </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!--second tab-->
                <div class="tab-pane active show" id="profile" role="tabpanel">
                  <div class="card-body">
                    <div class="col-lg-12">
                      <div class="d-flex m-b-30 no-block">

                        <div class="row memberProfileRow familyProfileRow font-open-sans">
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
                          <div class="col-md-6">
                            <div class="media">
                              <div class="media-left">
                                <small class="p-t-30 db font-Trirong"><b> Phone number :</b> </small>
                              </div>
                              <div class="media-body">
                                <h6 class="font-open-sans"> {{($posts->mobile == null) ? 'Not-provided' : $posts->mobile}}</h6>
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
                                <h6> {{($posts->income == null || $posts->income == 0) ? 'Not-provided' : $posts->income}}</h6>
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
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="address" role="tabpanel">
                  <div class="card-body">
                      <div class="col-lg-12">
                        <div class="d-flex m-b-30 no-block">
                          <div class="row memberProfileRow familyProfileRow">
                            <div class="col-md-6">
                              <div class="media">
                                <div class="media-left">
                                  <small class="p-t-30 db"><b> Door Number</b></small>
                                </div>
                                <div class="media-body">
                                  <h6>: {{$posts->presentFamilyDoor}}</h6>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="media">
                                <div class="media-left">
                                  <small class="p-t-30 db"><b>Street</b></small>
                                </div>
                                <div class="media-body">
                                  <h6>: Kavalkatte</h6>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                               <div class="media">
                                <div class="media-left">
                                  <small class="p-t-30 db"><b> State</b></small>
                                </div>
                                <div class="media-body">
                                  <h6>: Karnataka</h6>
                                </div>
                               </div>
                            </div>

                            <div class="col-md-6">
                              <div class="media">
                                <div class="media-left">
                                  <small class="p-t-30 db"><b> Taluk</b></small>
                                </div>
                                <div class="media-body">
                                  <h6>: Bantval</h6>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="media">
                                <div class="media-left">
                                  <small class="p-t-30 db"><b>Posatal Code :</b></small>
                                </div>
                                <div class="media-body">
                                  <h6> 574231</h6>
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
        @endif
        @endforeach
      </div>