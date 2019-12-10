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
      <section id="wrapper" class="error-page">
        <div class="error-box">
          <div class="error-body text-center">
            <h1><i class="fa fa-code"></i></h1>
            <h1 style="font-size: 60px;">{{$msg}}</h1>
            <h4 class="text-uppercase">YOU SEEM TO BE TRYING TO FIND HIS WAY BACK</h4>
            <!-- <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY BACK</p> -->
            <a href="{{route('student.show',$sid)}}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to...</a> 
          </div>
        </div>
      </section>
    </div>
    <!-- End Page wrapper  -->
  </div>
</body>
</html>
@endsection
