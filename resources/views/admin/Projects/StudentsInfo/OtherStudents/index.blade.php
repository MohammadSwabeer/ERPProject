@extends('admin/mainpage/adminmain')

@section('admin/mainpage/admincontents')
<html lang="en">
<body class="skin-blue fixed-layout lock-nav">
  <!-- Main wrapper - style you can find in pages.scss -->
  <div id="main-wrapper">
     @include('admin/mainpage/_leftnav')
    <div class="page-wrapper">
        <!-- Container fluid  -->
      <div class="container-fluid">

        <div class="row page-titles">
          <div class="col-md-12">
            <div class="d-flex">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#0">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
                  <li class="breadcrumb-item active">Other Students Details</li>
                </ol>
            </div>
          </div>
        </div>
          @include('admin/mainpage/_messages')

        <div class="row">
          <div class="col-12">
           <div class="card box-shadow-e br-5">
            <div class="card-body">

              <h4 class="card-title"> Other Students Information
                <div class="btn-group pull-right btnGroup">
                  <a class="btn btn-circle btn-gradient-color btn-info" style="border-radius: 50px;" href="{{route('addOtherStudentsPage')}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="true" title="Add Student Details" data-placement="left"><i class="ti-plus"></i>
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
                      <th>Contact No</th>
                      <th>Grade/ Standard</th>
                      <th>Present Course</th>
                      <th>Future Goal</th>
                      <th>Remark</th>
                      <th>Edit</th>
                      <!-- <th>Delete</th> -->
                      <th>More</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($post as $posts)
                    <tr>
                      <td>{{$id++}}</td>
                      <td><a href="{{route('OtherStudentsProfile',[$posts->id])}}">{{$posts->student_name}}</a></td>

                      @if($posts->s_contact !=null || $posts->s_contact != '')
                      <td>{{$posts->s_contact}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      @if($posts->student_grade !=null || $posts->student_grade != '')
                      <td>{{$posts->student_grade}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      @if($posts->present_course !=null || $posts->present_course != '')
                      <td>{{$posts->present_course}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      @if($posts->future_goal !=null || $posts->future_goal != '')
                      <td>{{$posts->future_goal}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif

                      @if($posts->remark !=null || $posts->remark != '')
                      <td>{{$posts->remark}}</td>
                      @else
                      <td style="color: red">{{"Not-Provided"}}</td>
                      @endif
                      <td>
                        <a class="btn btn-circle btn-sm btn-outline-primary" style="border: none;" href="{{route('editOtherStudents',[$posts->id])}}"><i class="ti-pencil-alt"></i></a>
                      </td>
                      <!-- <td>
                        <a class="btn btn-circle btn-sm btn-outline-danger" href="#"><i class="ti-trash"></i>
                        </a>
                      </td> -->
                      <td>
                        <a class="btn btn-circle btn-sm btn-outline-success" style="border: none;" href="{{route('OtherStudentsProfile',[$posts->id])}}"><i class="ti-more-alt"></i></a>
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
    </div>
<!-- End Page wrapper  -->
  </div>
</body>
</html>
@endsection
