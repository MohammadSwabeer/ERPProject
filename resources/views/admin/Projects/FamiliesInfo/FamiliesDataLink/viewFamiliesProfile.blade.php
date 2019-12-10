<?php use \App\Http\Controllers\MainController; $main = new MainController;$mod=[]; ?>
@extends('admin/mainpage/adminmain')
@section('admincontents')
<div class="row page-titles">
    <div class="col-md-12">
      {{$main->breadCrumbsData($type,$prType,'profile',$personCat,$page,$status)}}
    </div>
</div>
<!-- Start Page Content -->
   @include('admin.mainpage.pages._messages')
   
   <div class="row m-b-25" style="color:white">
      <!-- Column -->
      <!-- <div class="col-md-12">
         <div class="alert alert-danger"> 
            Families <strong>Relation Adjustment</strong> is <strong>Pending </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
         </div>
      </div> -->
      <div class="col-md-12">
         <div class="card br-5 box-shadow p-5">
            @include('admin.mainpage.pages.profile-loader')
            <div class="row contents" style="display: none;">
               <div class="col-md-12">
                  <ul class="nav nav-tabs bg-white m-l-0" role="tablist" style="border-bottom: 0.5px solid #0001;">
                     <li class="nav-item"> <a class="nav-link nav-a active show text-dark" data-toggle="tab" href="#famInfo" role="tab" aria-selected="true">Family Information</a> </li>
                     <li class="nav-item"> <a class="nav-link nav-a text-dark" data-toggle="tab" href="#servConc" role="tab" aria-selected="true">Helps Needed & Services Obtained</a></li>
                  </ul>
               </div>
               <div class="col-md-12">

                  <div class="tab-content">
                     <!--second tab-->
                     <div class="tab-pane active show" id="famInfo" role="tabpanel">
                        <div class="card-body">
                           <div class="row familyProfileRow">
                              <div class="col-md-12">
                                 <h4 class="font-14 font-w-700" style="color: #6c757d">FAMILY HISTORY INFORMATION</h4>
                                 <hr>
                              </div>
                              @foreach($fam as $info)
                              <div class="col-md-4">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                      <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">HF-Id :</span> {{$info->hfid}}</h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark"> Door No. :</span> {{$info->present_door}}</h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"> <span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark"> HSCC Join Date :</span> {{$info->doj}} </h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"> <span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark"> Annual Income :</span>  <data class="money" value="11000.00">{{$info->income}}</data></h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-5">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Income Source :</span> {{$info->income_source}}   </h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Ration Card No. :</span> {{$info->ration_no}}   <span><small><a href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Ration" class="text-lowercase font-w-700 "> 
                                          {{ifAnd($r = $info->ration_image) ? 'view card' : 'uplaod ration card' }} </a></small></span></h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-12">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Family's Head :</span> {{$info->fname}} {{$info->lname}}</h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-12">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Reason  :</span> {{$info->reason}}</h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Members :</span> {{$depCount}}  (<span class="text-muted">Male : {{$maleCount}}</span> , <span class="text-muted">Female : {{$femaleCount}} </span>)</h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Students :</span> {{$studCount}}</h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Dropouts :</span> {{$dropCount}} </h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Employees :</span> {{$empCount}} </h6>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                           <div class="row p-5">
                              <div class="col-md-12 p-5">
                                 <h4 class="font-14 font-w-700" style="color: #6c757d">PREVIOUS ADDRESS</h4>
                                 <hr>
                              </div>
                              <div class="col-md-2">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Door No. :</span> {{ifAnd($info->door_no) ? $info->door_no : 'N/A' }} </h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-10">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Street/ Area /Village :</span> {{ifAnd($info->street_area) ? $info->street_area : 'N/A' }} </h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Belongs To :</span> {{ifAnd($info->belongs_to) ? $info->belongs_to : 'N/A' }} </h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">City/ Taluk :</span> {{ifAnd($info->city) ? $info->city : 'N/A' }} </h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">District :</span> {{ifAnd($info->district) ? $info->district : 'N/A' }} </h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">State :</span> {{ifAnd($info->state) ? $info->state : 'N/A' }} </h6>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><span class="p-t-30 db font-Trirong font-w-500 text-uppercase font-12 text-dark">Pincode :</span> {{ifAnd($info->pincode) ? $info->pincode : 'N/A' }} </h6>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane" id="servConc" role="tabpanel">
                        <div class="card-body">
                           <?php $c = 0;$s = 0; ?>
                           @if(count($benefit) > 0)
                           @foreach($benefit as $ben)
                           <div class="row familyProfileRow p-5">
                              @if($c == 0)
                              <div class="col-md-12">
                                 <h4 class="font-14 font-w-700" style="color: #6c757d">HELPS NEEDED <small>(FOOD)</small>
                                    <span class="pull-right"><a href="{{route('timeline',[session('id'),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat),encrypt('concern')])}}" target="_blank" class="pull-right"><i class="ti-layout-list-thumb"></i> Timeline</a></span></h4>
                              </div>
                              @endif
                              @if($ben->service_type == 'concern')
                              <div class="col-md-12">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"> <i class="ti-minus"></i> {{$ben->description}}</h6>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>

                           <div class="row familyProfileRow p-5">
                              @if($s == 0)
                              <div class="col-md-12">
                                 <h4 class="font-14 font-w-700" style="color: #6c757d">SERVICES OBTAINED FROM HSCC <small>(FOOD)</small><span class="pull-right"><a href="{{route('timeline',[session('id'),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat),encrypt('service')])}}" target="_blank" class="pull-right"><i class="ti-layout-list-thumb"></i> Timeline</a></span></h4>
                                 <!-- <hr> -->
                              </div>
                              @endif
                              @if($ben->service_type == 'service')
                              <div class="col-md-12">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"><i class="ti-minus"></i>  {{$ben->description}}</h6>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>
                           <?php $c++;$s++; ?>
                           @endforeach
                           @else
                           <div class="row familyProfileRow p-5">
                              <div class="col-md-12">
                                 <h4 class="font-14 font-w-700" style="color: #6c757d">HELPS NEEDED <small>(FOOD)</small>
                                    <span class="pull-right"><a href="{{route('timeline',[session('id'),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat),encrypt('concern')])}}" target="_blank" class="pull-right"><i class="ti-layout-list-thumb"></i> Timeline</a></span></h4>
                              </div>
                              <div class="col-md-12">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"> <i class="ti-minus"></i> No data</h6>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row familyProfileRow p-5">
                              <div class="col-md-12">
                                 <h4 class="font-14 font-w-700" style="color: #6c757d">SERVICES OBTAINED FROM HSCC <small>(FOOD)</small>
                                    <span class="pull-right"><a href="{{route('timeline',[session('id'),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat),encrypt('concern')])}}" target="_blank" class="pull-right"><i class="ti-layout-list-thumb"></i> Timeline</a></span></h4>
                              </div>
                              <div class="col-md-12">
                                 <div class="media p-5 border-bottom">
                                    <div class="media-body">
                                       <h6 style="text-transform: initial;" class="text-lights"> <i class="ti-minus"></i> No data</h6>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endif
                        </div>
                  </div>
               </div>

               <div class="col-md-12">
                  <div class="btn-group pull-right p-5">
                     <p class="text-dark">Related Projects : 
                        <span><a class="btn btn-sm br-25 w-fit border-color3 health-link btn-outline-danger m-auto" data-toggle="modal" data-target="#Health">Health </a> 
                        <a class="btn btn-sm br-25 w-fit btn-outline-success m-auto border-color" style="color: #4caf50 !important" data-toggle="modal" data-target="#Education">Education </a> 
                        <a class="btn btn-sm br-25 w-fit btn-outline-info m-auto" data-toggle="modal" data-target="#Self-Reliance">Self - Reliance </a> 
                        <a class="btn btn-sm br-25 w-fit btn-outline-success m-auto" data-toggle="modal" data-target="#Infrastructure">Infrastructure </a>
                        <!-- <a class="btn btn-sm br-25 w-fit btn-outline-success m-auto" href="" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Infrastructure Details" data-placement="top">Infrastructure </a> -->
                        </span>
                     </p>
                 </div>
               </div>
            </div>
            </div>
         </div>
      </div>

      @foreach($fam as $posts)
      <div class="col-md-12">
         <div class="card  p-5 box-shadow br-5">
            <?php $hid = $posts->id;?>
            @include('admin.Projects.FamiliesInfo.FamiliesDataLink.profileInfo')
         </div>
      </div>
      @endforeach

      @foreach($post as $posts)
      @if(getSubHead($posts->relation,$posts->id,$hid))
      <div class="col-md-12">
         <div class="card  p-5 box-shadow br-5">
            @include('admin.Projects.FamiliesInfo.FamiliesDataLink.profileInfo')
         </div>   
         <!-- end card -->
      </div>
      <!-- end col-md-12 -->
      @endif
      @endforeach

      <?php $oc = 0; ?>
      @foreach($post as $posts)
      @if(onlyFamilySubMainss($posts->relation))
      @if($oc == 0)
      <div class="col-md-12">
        <div class="br-5 p-10">
          <h4 class="font-20 font-w-700" style="color:#6c757d">HEAD'S PARENTS / GUARDIANS</h4>
          <hr class="border-top">
        </div>
      </div>
      @endif
      <div class="col-md-12">
         <div class="card  p-5 box-shadow br-5">
            @include('admin.Projects.FamiliesInfo.FamiliesDataLink.profileInfo')
         </div>   
         <!-- end card -->
      </div>
      <!-- end col-md-12 -->
      <?php $oc++; ?>
      @endif
      @endforeach
    </div>

    <div class="row el-element-overlay">
      <div class="col-md-12">
        <div class="br-5 p-10">
          <h4 class="font-20 font-w-700" style="color:#6c757d">FAMILY'S OTHER MEMBERS</h4>
          <hr class="border-top">
        </div>
      </div>
      @foreach($post as $key)
      @if($key->relation == 'Son' || $key->relation == 'Daughter')
      <div class="col-md-3">
          <div class="card box-shadow br-5 p-0">
          @include('admin.mainpage.pages.profile-loader')
            <?php $mod[] = $key->id; ?>
              <div class="el-card-item p-5 contents" style="display: none;">

                  <div class="el-card-avatar el-overlay-1" style="height: 150px">

                    @if($key->image != '' || $key->image != null)
                    <img class="m-auto" src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$key->image)}}" style="height: 150px;width: auto;">
                    @else
                      @if($key->gender == 'Male')
                      <img class="m-auto" src="{{asset('adminAssets/images/default/default1.png')}}"  style="height: 150px;width: auto;">
                      @else
                      <img class="m-auto" src="{{asset('adminAssets/images/default/girl.jpg')}}"  style="height: 150px;width: auto;">
                      @endif
                    @endif
                      <div class="el-overlay">
                          <ul class="el-info">
                              <li><a class="btn default btn-outline image-popup-vertical-fit" href="#" data-toggle="modal" data-target="#familyProfile{{$key->id}}"><i class=" ti-search"></i></a></li>
                              <li><a class="btn default btn-outline" target="_blank" href="{{route('showStudentsProfile',[encrypt($key->id),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}"><i class="ti-eye"></i></a></li>
                          </ul>
                      </div>

                  </div>
                  <span><div class="btn-group pull-right btnGroup">
                    <a class="btn btn-circle bg-white box-shadow-e" style="border-radius: 50px;" href="{{route('HSCCFamilyEdit',[encrypt($key->id),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="true" title="Edit Profile" data-placement="left">
                      <i class="ti-more-alt text-dark"></i>
                    </a>
                  </div></span>
                  <div class="el-card-content">
                    <h4 class="box-title">{{$key->fname}} {{$key->lname}} </h4> 
                    <small>({{($key->occupation_name == 'Student') ? $key->relation.'/ '.$key->occupation_name : $key->relation}})</small>
                  </div>

              </div>
          </div>
      </div>
      @endif
      @endforeach
    </div>
<!-- *******************************************Start mOdels *********************************************-->

<!-- ******************* Other Projects Service And Concern View Model -->
    @foreach($proj = ['Health','Education','Self-Reliance','Infrastructure'] as $each)
    <div class="modal fade" id="{{$each}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:transparent;border:unset">
          <div>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 100px"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="card">
               <div class="card-body">
                  <?php $c = 0;$s = 0; ?>
                  @if(count($main->sPocServiceConcern(encrypt($hfid),encrypt($type),encrypt($each),encrypt($status))) > 0)
                  @foreach($main->sPocServiceConcern(encrypt($hfid),encrypt($type),encrypt($each),encrypt($status)) as $ben)
                  <div class="row familyProfileRow p-5">
                     @if($c == 0)
                     <div class="col-md-12">
                        <h4 class="font-14 font-w-700" style="color: #6c757d">HELPS NEEDED <small>({{$each}})</small></h4>
                     </div>
                     @endif
                     @if($ben->service_type == 'concern')
                     <div class="col-md-12">
                        <div class="media p-5 border-bottom">
                           <div class="media-body">
                              <h6 style="text-transform: initial;" class="text-lights"> <i class="ti-minus"></i> {{$ben->description}}</h6>
                           </div>
                        </div>
                     </div>
                     @endif
                  </div>

                  <div class="row familyProfileRow p-5">
                     @if($s == 0)
                     <div class="col-md-12">
                        <h4 class="font-14 font-w-700" style="color: #6c757d">SERVICES OBTAINED FROM HSCC <small>({{$each}})</small></h4>
                        <!-- <hr> -->
                     </div>
                     @endif
                     @if($ben->service_type == 'service')
                     <div class="col-md-12">
                        <div class="media p-5 border-bottom">
                           <div class="media-body">
                              <h6 style="text-transform: initial;" class="text-lights"><i class="ti-minus"></i>  {{$ben->description}}</h6>
                           </div>
                        </div>
                     </div>
                     @endif
                  </div>
                  <?php $c++;$s++; ?>
                  @endforeach
                  @else
                  <div class="row familyProfileRow p-5">
                     <h4 class="card-header">Data not available</h4>
                  </div>
                  @endif
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
<!--****************************** end model ***************-->

<!-- ******************* Families Image Viewing Model -->
    @foreach($post as $image)
    <div class="modal fade" id="familyProfile{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:transparent;border:unset">
          <div>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 100px"><span aria-hidden="true">&times;</span></button>
          </div>

          <div class="modal-body">
            @if($image->image != '' && $image->image != null)
            <img class="m-auto" src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$image->image)}}" style="height: auto;width: 100%;">
            @else
              @if($image->gender == 'Male')
              <img class="m-auto" src="{{asset('adminAssets/images/default/default1.png')}}"  style="height: auto;width: 100%;">
              @else
              <img class="m-auto" src="{{asset('adminAssets/images/default/girl.jpg')}}"  style="height: auto;width: 100%;">
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
<!--****************************** end model ***************-->

<!--******************* Adhar Image Model ******************-->
    @foreach($post as $pos)
    @if(getFamiliesMains($pos->relation))
   <div class="modal fade" id="Adhar{{$pos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content" style="background:transparent;border:unset">
            <div style="">
               <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></button>
            </div>
            <div class="modal-body">
               <form method="POST" action="{{route('storeImage')}}" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="pic_type" id="pic_type" value="{{encrypt('Adhar')}}">
                  <input type="hidden" name="id" id="id" value="{{encrypt($pos->id)}}">
                  <input type="hidden" name="str" value="{{encrypt('Doc')}}">
                  <input type="hidden" name="type" value="{{encrypt($type)}}">
                  <input type="hidden" name="hfid" value="{{encrypt($hfid)}}">
                  <div class="card">
                     <div class="card-body">
                       @if(ifAnd($pos->adhar_image))
                       <input type="file" id="input-file-events" class="dropify form-control  @error('adhar_image') is-invalid @enderror" data-width="500" data-height="500" data-max-file-size="250K" data-default-file="{{asset(getImagePath('Doc',$type,$hfid,'Adhar').$pos->adhar_image)}}"  name="adhar_image"required/>
                       @else 
                       <input type="file" name="adhar_image" id="input-file-events" class="dropify form-control @error('adhar_image') is-invalid @enderror" data-max-file-size="250K" required/>
                       @endif
                       <input type="submit" name="submit" value="Upload" class="btn btn-outline-success btn-block">
                     </div>
                  </div>
               </form>
               
            </div>
         </div>
      </div>
   </div>
   @endif
   @endforeach
<!-- ****************************** end model ***************-->

<!-- ******************* Ration Image Model *****************-->
   <div class="modal fade" id="Ration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content" style="background:transparent;border:unset">
            <div style="">
               <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></button>
            </div>
            <div class="modal-body">
               <form method="POST" action="{{route('storeImage')}}" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="pic_type" id="pic_type" value="{{encrypt('Ration')}}">
                  <input type="hidden" name="id" id="id" value="{{encrypt($hid)}}">
                  <input type="hidden" name="str" value="{{encrypt('Doc')}}">
                  <input type="hidden" name="type" value="{{encrypt($type)}}">
                  <input type="hidden" name="hfid" value="{{encrypt($hfid)}}">
                  <div class="card">
                     <div class="card-body">
                       @if(ifAnd($r))
                       <input type="file" name="ration_image" id="input-file-events" class="dropify form-control @error('ration_image') @enderror" data-width="500" data-height="500" data-max-file-size="250K" data-default-file="{{asset(getImagePath('Doc',$type,$hfid,'Ration').$r)}}" required/>
                       @else
                       <input type="file" name="ration_image" id="input-file-events" class="dropify form-control @error('ration_image') is-invalid @enderror" data-max-file-size="250K" required/>
                       @endif
                       <input type="submit" name="submit" value="Upload" class="btn btn-outline-success btn-block">
                     </div>
                  </div>
               </form>
               
            </div>
         </div>
      </div>
   </div>
<!-- ****************************** end model ***************-->

<!-- ******************* Helps adding Model -->
   @foreach($mod as $mods)
   <div class="modal fade" id="{{$mods}}helps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content" style="background:transparent;border:unset;width: 1000px;margin-left: -175px">
            <div style="">
               <a class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></a>
            </div>

            <div class="modal-body">
               <div class="card-body bg-white p-10 br-5">
                  <form action="{{route('feedServiceConcerns')}}" method="POST">
                     @csrf

                     <input type="hidden" name="type" value="{{$type}}">
                     <input type="hidden" name="service_type" value="concern">
                     <input type="hidden" name="hfid" value="{{$hfid}}">
                     <input type="hidden" name="fam_id" value="{{$mods}}">
                     <input type="hidden" name="prType" value="{{$prType}}">
                     <input type="hidden" name="page" value="{{$page}}">
                     <input type="hidden" name="status" value="{{$status}}">
                     <input type="hidden" name="personCat" value="{{$personCat}}">

                     <div class="card-header">
                        <h4 class="card-title">Adding Present Helps needed</h4>
                     </div>
                     <div class="row service-row">
                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="food_concerns"> Food : </label>
                              <textarea name="food" id="food_concerns" rows="6" class="form-control" placeholder="Enter the Services provided in food"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="health_concerns"> Health : </label>
                              <textarea name="health" id="health_concerns" rows="6" class="form-control" placeholder="Enter the Services provided in Health"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="education_concerns"> Education : </label>
                              <textarea name="education" id="education_concerns" rows="6" class="form-control" placeholder="Enter the Services provided in Education"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="reliance"> Self-Reliance : </label>
                              <textarea name="reliance_concerns" id="reliance_concerns" rows="6" class="form-control" placeholder="Enter the Services provided in Self-Reliance"></textarea>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="infrastructure"> Infrastructure : </label>
                              <textarea name="infrastructure_concerns" id="infrastructure_concerns" rows="6" class="form-control" placeholder="Enter the Services provided in Infrastructure"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group">
                              <input type='submit' class='btn btn-block btn-outline-primary' name='submit' value='Submit' />
                           </div>
                        </div>
                     </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach
<!-- ****************************** end model ***************-->

<!-- ******************* Sevice adding Model -->
   @foreach($mod as $mods)
   <div class="modal fade" id="{{$mods}}service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content" style="background:transparent;border:unset;width: 1000px;margin-left: -175px">
            <div style="">
               <a class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></a>
            </div>

            <div class="modal-body">
               <div class="card-body bg-white p-10 br-5">
                  <form action="{{route('feedServiceConcerns')}}" method="POST">
                     @csrf

                     <input type="hidden" name="type" value="{{$type}}">
                     <input type="hidden" name="service_type" value="service">
                     <input type="hidden" name="fam_id" value="{{$mods}}">
                     <input type="hidden" name="hfid" value="{{$hfid}}">
                     <input type="hidden" name="prType" value="{{$prType}}">
                     <input type="hidden" name="page" value="{{$page}}">
                     <input type="hidden" name="status" value="{{$status}}">
                     <input type="hidden" name="personCat" value="{{$personCat}}">

                     <div class="card-header">
                        <h4 class="card-title">Adding Services Provided</h4>
                     </div>
                     <div class="row service-row">
                        
                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="food_servise"> Food : </label>
                              <textarea name="food" id="food_servise" rows="6" class="form-control" placeholder="Enter the Services provided in food"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="health_servise"> Health : </label>
                              <textarea name="health" id="health_servise" rows="6" class="form-control" placeholder="Enter the Services provided in Health"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="education_servise"> Education : </label>
                              <textarea name="education" id="education_servise" rows="6" class="form-control" placeholder="Enter the Services provided in Education"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="reliance_servise"> Self-Reliance : </label>
                              <textarea name="reliance" id="reliance_servise" rows="6" class="form-control" placeholder="Enter the Services provided in Self-Reliance"></textarea>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group controls">
                              <label for="infrastructure_servise"> Infrastructure : </label>
                              <textarea name="infrastructure" id="infrastructure_servise" rows="6" class="form-control" placeholder="Enter the Services provided in Infrastructure"></textarea>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <div class="form-group">
                              <input type='submit' class='btn btn-block btn-outline-primary' name='submit' value='Submit' />
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach
<!-- ******************* Sevice adding Model -->
@endsection
