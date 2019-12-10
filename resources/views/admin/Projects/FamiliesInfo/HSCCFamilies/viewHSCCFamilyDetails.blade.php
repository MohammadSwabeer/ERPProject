<?php  use \App\Http\Controllers\MainController; $main = new MainController;  ?>
@extends('admin.mainpage.adminmain')

@section('admincontents')
        <div class="row page-titles">
          <div class="col-md-12">
            <div class="d-flex">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
                  @if($type == 'ColonyFamily')
                  <li class="breadcrumb-item"><a href="{{route('Families.index')}}">HSCC Details</a></li>
                  @endif
                  <li class="breadcrumb-item active">HSCC Families Details</li>
                </ol>
            </div>
          </div>
        </div>

        <div class="row">
      <div class="col-12">
       <div class="card box-shadow-e br-5">
        @include('admin.mainpage.main-preloader')
        <div class="card-body contents" style="display: none;">
          <div class="row">
            <div class="col-md-12">
              <h4 class="card-title"> HSCC Family Information
                <div class="btn-group pull-right btnGroup">
                  <a class="btn br-25 w-fit btn-outline-success" id="btnFilter" onclick="function f(){ return document.getElementById('filterData').style.display = 'block';};f()" data-toggle="tooltip" data-placement="top" title="Click to filter-search">
                    <i class="ti-filter"></i> Filter
                  </a>
                  <a class="btn br-25 w-fit btn-outline-primary" href="{{route('HSCCFamiliesAdd')}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add Family Details" data-placement="top">
                    Create Family
                    <i class="ti-plus"></i>
                  </a>
                </div>
              </h4>
            </div>
            <?php $filterNames = ['Door/House No','HFSCC-ID','Full Name','Age','Date of Join','Qualification','Occupation'];
            $params = ['presentFamilyDoor','hfId','full_name','dob','dojHSCC','qualification','occupation'];
            $pos = [1,2,3,7,8,9,10];?>
            @include('admin.mainpage._filterData')
          </div>

          <div>
            <div class="table-responsive m-t-40">
            <table id="HSCCDT" class="table m-t-30 table-hover contact-list ">
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
                  <td>{{$posts->presentFamilyDoor}}</td>
                  <td>{{$posts->hfId}}</td>
                  <td><a href="{{route('showHSCCFamilyDetails',[$posts->hfId])}}">{{$posts->full_name}}</a></td>
                  <td>{{$main->countDependents($posts->hfId,'HSCC Family')-1}}</td>

                  @if($posts->mobile !=null || $posts->mobile != '')
                  <td>{{$posts->mobile}}</td>
                  @else
                  <td style="color: red">{{"Not-Provided"}}</td>
                  @endif
                  <td>{{$posts->gender}}</td>
                  <td>{{$main->age($posts->dob)}}</td>
                  <td>{{$posts->dojHSCC}}</td>

                  @if($posts->qualification !=null || $posts->qualification != '')
                  <td>{{$posts->qualification}}</td>
                  @else
                  <td style="color: red">{{"Not-Provided"}}</td>
                  @endif

                  <td>{{$posts->occupation}}</td>
                  <td>
                    <a class="btn btn-circle btn-sm btn-outline-info m-0" href="{{route('showHSCCFamilyDetails',[$posts->hfId])}}"><i class="ti-more-alt"></i></a>
                  </td>
                  <td>
                    <a class="btn btn-circle btn-sm btn-outline-danger m-0" onclick="SWALDATA('{{$posts->hfId}}','{{route('HSCCFamilyRemove')}}','HSCCData','HSCC Family','{{route('appendHSCCData')}}','')"><i class="ti-trash"></i>
                    </a>
                  </td>

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
  