@extends('admin/mainpage/adminmain')

@section('admincontents')

        <div class="row page-titles">
          <div class="col-md-12">
            <div class="d-flex">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="0">Home</a></li>
                  <li class="breadcrumb-item active">ATT  Information</li>
                </ol>
            </div>
          </div>
        </div>

        <div class="card box-shadow-e br-5 " style="height: 500px">
          <div class="row">
            <div class="col-md-12">
              <div class="media p-30 m-auto">
                 <div class="media-right">
                    <img class="box-shadow-e" src="{{asset('images/HFLogo.jpg')}}" style="width: 175px;border-radius: 100%">
                 </div>
                 <div class="media-body text-center m-auto">
                     <h3 class="font-NexaRustSlab animated pulse" style="font-size: 18px;margin-top: 50px">Welcome to <br>
                      <span style="font-size: 40px">Arabic teachers training</span>
                       <!-- <sup>&reg;</sup> -->
                    </h3>
                 </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="padding:50px;margin-top:70px;" class="animated zoomIn">
                <a href="{{route('ATTStaffsView')}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary food-link btn-block box-shadow-e"><h4 class="m-auto font-20 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">ATT Staffs Info.</h4></a>
              </div>
            </div>

            <div class="col-md-6">
              <div style="padding:50px;margin-top:70px;" class="animated zoomIn">
                <a href="{{route('viewATTStudents')}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary food-link btn-block box-shadow-e"><h4 class="m-auto font-20 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">ATT Students Info.</h4></a>
              </div>
            </div>
          </div>
        </div>
@endsection
