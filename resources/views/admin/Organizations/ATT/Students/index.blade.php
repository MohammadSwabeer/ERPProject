<?php  use \App\Http\Controllers\MainController; $main = new MainController;  ?>
@extends('admin/mainpage/adminmain')

@section('admincontents')
        <div class="row page-titles">
          <div class="col-md-12">
            <div class="d-flex">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
                  <li class="breadcrumb-item active">ATT Students Information</li>
                </ol>
            </div>
          </div>
        </div>
        @include('admin.mainpage.pages._messages')

        <div class="row">
          <div class="col-12">
           <div class="card box-shadow-e br-5">
            @include('admin.mainpage.pages.main-preloader')
            <div class="card-body contents" style="display: none;">

              <h4 class="card-title"> ATT Students Information
                <div class="btn-group pull-right btnGroup">
                  <a class="btn br-25 w-fit btn-outline-success" id="btnFilter" onclick="function f(){ return document.getElementById('filterData').style.display = 'block';};f()" data-toggle="tooltip" data-placement="top" title="Click to filter-search">
                    <i class="ti-filter"></i> Filter
                  </a>
                  <a class="btn br-25 w-fit btn-outline-primary" href="{{route('ATTStudentsAddPage')}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add Student Details" data-placement="top">
                    New Students
                    <i class="ti-plus"></i>
                  </a>
                </div>
              </h4>

              <?php $filterNames = ['HF-ID','Full Name','Contact No.','Age','Qualification'];
              $params = ['hfId','full_name','stud_cell','stud_dob','qualification'];
              $pos = [1,2,3,5,6];?>
              <div class="table-responsive m-t-40">
                <table id="HSCCDT" class="table table table m-t-30 table-hover contact-list footable-loaded footable">
                  <thead>
                    <tr>
                      <?php $id=1; ?>
                      <th>Sl.No.</th>
                      <th>HF Id</th>
                      <th>Full Name</th>
                      <th>Contact No</th>
                      <th>E-mail</th>
                      <th>Age</th>
                      <th>Qualification</th>
                      <th>School/ College last attended</th>
                      <th>Edit</th>
                      <!-- <th>Delete</th> -->
                      <th>More</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($post as $posts)
                    <tr>
                      <td>{{$id++}}</td>
                      <td>{{$posts->hfId}}</td>
                      <td>{{$posts->full_name}}</td>

                      @if($posts->stud_cell !=null || $posts->stud_cell != '')
                      <td>{{$posts->stud_cell}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      @if($posts->stud_email !=null || $posts->stud_email != '')
                      <td>{{$posts->stud_email}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      <td>{{MainController::age($posts->stud_dob)}}</td>

                      @if($posts->qualification !=null || $posts->qualification != '')
                      <td>{{$posts->qualification}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      <td>{{$posts->college_last_attended}}</td>
                      <td>
                        <a class="btn btn-circle btn-sm btn-outline-primary" href="{{route('editATTStudents',[$posts->id])}}"><i class="ti-pencil-alt"></i></a>
                      </td>
         <!--              <td>
                        <a class="btn btn-circle btn-sm btn-outline-danger" href="#"><i class="ti-trash"></i>
                        </a>
                      </td> -->
                      <td>
                        <a class="btn btn-circle btn-sm btn-outline-success" href="{{route('ATTStudentsProfile',[$posts->id])}}"><i class="ti-more"></i></a>
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