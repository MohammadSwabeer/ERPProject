<?php  use \App\Http\Controllers\MainController; $main = new MainController;  ?>
@extends('admin.mainpage.adminmain')
@section('admincontents')
<!-- Bread crum -->
<div class="row page-titles">
    <div class="col-md-12">
      {{$main->breadCrumbsData($type,$prType,'view',$personCat,$page,$status)}}
    </div>
</div>

<!-- end Bread crum -->
<div class="row">
   <div class="col-12">
     <div class="card box-shadow-e br-5">
       @include('admin.mainpage.pages.main-preloader')
         <div class="card-body contents" style="display: none">
            <div class="row">
               <div class="col-md-12"> 
                  <h4 class="card-title"> {{$type}} Family Information
                     <div class="btn-group pull-right btnGroup">
                        <a class="btn br-25 w-fit btn-outline-success" id="btnFilter" onclick="function f(){ return document.getElementById('filterData').style.display = 'block';};f()" data-toggle="tooltip" data-placement="top" title="Click to filter-search">
                        <i class="ti-filter"></i> Filter </a>
                        <a class="btn br-25 w-fit btn-outline-primary" href="{{route('HSCCFamiliesAdd',[encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat),encrypt('Head')])}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add Family Details" data-placement="top"> Add Head of Family <i class="ti-plus"></i> </a>
                        <a class="btn br-25 w-fit btn-outline-primary" href="{{route('HSCCFamiliesAdd',[encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat),encrypt('Member')])}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add Family Details" data-placement="top"> Add Members of Family <i class="ti-plus"></i> </a>
                     </div>
                  </h4>
               </div>
               @include('admin.mainpage.pages._filterData')
            </div>

            <div>
               <div class="table-responsive">
                  <table id="HSCCDT" class="table table-hover contact-list ">
                     <thead>
                       <tr>
                           <?php $id=1; ?>
                           <th>Sl.No.</th>
                           <th>Door/House No.</th>
                           <th>HFSCC-ID</th>
                           <th>Full Name</th>
                           <th>No of Dependent</th>
                           <th>Contact No</th>
                           <th>Gender</th>
                           <th>Age</th>
                           <th>DateOfJoin</th>
                           <th>Education</th>
                           <th>Occupation</th>
                           <th>More</th>
                           <th>Delete</th>
                        </tr>
                     </thead>
                     <tbody id="HSCCData">
                       @foreach($post as $posts)
                       <tr>
                           <td>{{$id++}}</td>
                           <td>{{$posts->present_door}}</td>
                           <td>{{$posts->hfid}}</td>
                           <td><a href="{{route('showFamiliesProfiles',[encrypt($posts->id),encrypt($posts->hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}">{{$posts->fname}} {{$posts->lname}}</a></td>
                           <td>{{$main->countDependents($posts->hfid,$type)-1}}</td>

                           @if($posts->mobile !=null || $posts->mobile != '')
                           <td>{{$posts->mobile}}</td>
                           @else
                           <td style="color: red">{{"Not-Provided"}}</td>
                           @endif
                           <td>{{$posts->gender}}</td>
                           <td>{{$main->age($posts->dob)}}</td>
                           <td>{{$posts->doj}}</td>

                           @if($posts->qualification !=null || $posts->qualification != '')
                           <td>{{$posts->qualification}}</td>
                           @else
                           <td style="color: red">{{"Not-Provided"}}</td>
                           @endif

                           <td>{{$posts->occupation_name}}</td>
                           <td> <a class="btn btn-circle btn-sm btn-outline-info m-0" href="{{route('showFamiliesProfiles',[encrypt($posts->id),encrypt($posts->hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}"><i class="ti-more-alt"></i></a>
                           </td>
                           <td> <a class="btn btn-circle btn-sm btn-outline-danger m-0" onclick="SWALDATA('{{$posts->hfid}}','{{route('HSCCFamilyRemove')}}','{{$type}}')"><i class="ti-trash"></i> </a>
                           </td>
                           <!-- {{--route('appendHSCCData')--}} //this is for retrieving route for add if needed -->
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="text-center loading-image" style="display: none;">
                    <i class="fa fa-spin fa-refresh text-center font-70 text-center m-auto" ></i>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>
@endsection
