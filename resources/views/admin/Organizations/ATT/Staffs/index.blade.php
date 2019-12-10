<?php
  use \App\Http\Controllers\MainController;?>
@extends('admin.mainpage.adminmain')

@section('admincontents')
        <div class="row page-titles">
          <div class="col-md-12">
            <div class="d-flex">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
                  <li class="breadcrumb-item active">ATT Staffs Information</li>
                </ol>
            </div>
          </div>
        </div>
        @include('admin/mainpage/pages/_messages')

        <div class="row">
          <div class="col-12">
           <div class="card box-shadow-e br-5">
            @include('admin.mainpage.pages.main-preloader')

            <div class="card-body contents" style="display: none;">

              <h4 class="card-title"> ATT Staffs Information
                <div class="btn-group pull-right btnGroup">
                  <a class="btn btn-circle btn-gradient-color btn-info" style="border-radius: 50px;" href="{{route('ATTStaffsAddPage')}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="true" title="Add Staff Details" data-placement="left"><i class="ti-plus"></i>
                  </a>
                </div>
              </h4>
              <div class="table-responsive m-t-40">
                <table id="myTable" class="table table table m-t-30 table-hover contact-list footable-loaded footable">
                  <thead>
                    <tr>
                      <?php $id=1; ?>
                      <th>Sl.No.</th>
                      <th>Full Name</th>
                      <th>Unit</th>
                      <th>Contact No</th>
                      <th>E-mail</th>
                      <th>Age</th>
                      <th>Qualification</th>
                      <th>Designation</th>
                      <th>Edit</th>
                      <!-- <th>Delete</th> -->
                      <th>More</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($post as $posts)
                    <tr>
                      <td>{{$id++}}</td>
                      <td>{{$posts->member_fname}}  {{$posts->member_mname}} {{$posts->member_lname}}</td>
                      <td>{{$posts->unit_id}}</td>

                      @if($posts->mobile !=null || $posts->mobile != '')
                      <td>{{$posts->mobile}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      @if($posts->email !=null || $posts->email != '')
                      <td>{{$posts->email}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      <td>{{MainController::age($posts->dob)}}</td>

                      @if($posts->qualification !=null || $posts->qualification != '')
                      <td>{{$posts->qualification}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      <td>{{$posts->designation}}</td>
                      <td>
                        <a class="btn btn-circle btn-sm btn-outline-primary" href="{{route('editATTStaffDetails',[$posts->id])}}"><i class="ti-pencil-alt"></i></a>
                      </td>
         <!--              <td>
                        <a class="btn btn-circle btn-sm btn-outline-danger" href="#"><i class="ti-trash"></i>
                        </a>
                      </td> -->
                      <td>
                        <a class="btn btn-circle btn-sm btn-outline-success" href="{{route('ATTStaffProfile',[$posts->id])}}"><i class="ti-more"></i></a>
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
@endsection
