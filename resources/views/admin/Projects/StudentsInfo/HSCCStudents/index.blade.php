   <?php  use \App\Http\Controllers\MainController; $main = new MainController; ?>
   @extends('admin/mainpage/adminmain')

   @section('admincontents')

   {{$main->breadCrumPaths($type,'view')}}
   
     <div class="row page-titles">
       <div class="col-md-12">
         <div class="d-flex">
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
               @if($type == 'ColonyStudents')
               <li class="breadcrumb-item"><a href="{{route('Families.index')}}">HSCC Details</a></li>
               @endif
               <li class="breadcrumb-item active">HSCC Student Details</li>
             </ol>
         </div>
       </div>
     </div>

           <div class="row">
         <div class="col-12">
          <div class="card box-shadow-e br-5">
           @include('admin.mainpage.main-preloader')
           <div class="card-body contents" style="display: none;">
             <h4 class="card-title"> HSCC Students Information
               <!-- <div class="btn-group pull-right btnGroup">
                 <a class="btn btn-circle btn-gradient-color btn-info" style="border-radius: 50px;" href="{{route('HSCCFamilyStudentsAssessing')}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="true" title="Add Student Assessment Details" data-placement="left"><i class="ti-plus"></i>
                 </a>
               </div> -->
               <div class="btn-group pull-right btnGroup">
                     <a class="btn br-25 w-fit btn-outline-success" id="btnFilter" onclick="function f(){ return document.getElementById('filterData').style.display = 'block';};f()" data-toggle="tooltip" data-placement="top" title="Click to filter-search">
                       <i class="ti-filter"></i> Filter
                     </a>
                     <a class="btn br-25 w-fit btn-outline-primary" href="{{route('HSCCFamilyStudentsAssessing')}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add Family Details" data-placement="top">
                       New Evaluation
                       <i class="ti-plus"></i>
                     </a>
                   </div>
             </h4>
             <?php $filterNames = ['Door/House No','HFSCC-ID','Full Name','Age','Qualification'];
               $params = ['presentFamilyDoor','hfId','full_name','dob','qualification'];
               $pos = [1,2,3,7,8,9];?>
               <!-- <div class="row"> -->
                 @include('admin.mainpage._filterData')
               <!-- </div> -->
             <div class="table-responsive m-t-40">
               <table id="HSCCDT" class="table table table m-t-30 table-hover contact-list footable-loaded footable">
                 <thead>
                   <tr>
                     <?php $id=1; ?>
                     <th>Sl.No.</th>
                     <th>Door/House No.</th>
                     <th>HFSCC-ID</th>
                     <th>Full Name</th>
                     <th>Contact No</th>
                     <th>Gender</th>
                     <th>DateOfBirth</th>
                     <th>Age</th>
                     <th>DateOfJoin</th>
                     <th>Education</th>
                     <th>More</th>
                   </tr>
                 </thead>
                 <tbody id="std_tbl_body">
                   @foreach($post as $posts)
                   <tr>
                     <td>{{$id++}}</td>
                     <td>{{$posts->presentFamilyDoor}}</td>
                     <td>{{$posts->hfId}}</td>
                     <td><a href="{{route('showHSCCFamilyStudent',[$posts->id,$posts->hfId])}}">{{$posts->full_name}}</a></td>

                     @if($posts->mobile !=null || $posts->mobile != '')
                     <td>{{$posts->mobile}}</td>
                     @else
                     <td style="color: red">{{"Not Provided"}}</td>
                     @endif
                     <td>{{$posts->gender}}</td>
                     <td>{{$posts->dob}}</td>
                     <td>{{(MainController::age($posts->dob) < 10) ? '0'.MainController::age($posts->dob) : MainController::age($posts->dob)}}</td>
                     @if($posts->mobile !=null || $posts->mobile != 0)
                     <td>{{$posts->dojHSCC}}</td>
                     @else
                     <td style="color: red">{{"Not Provided"}}</td>
                     @endif
                     @if($posts->qualification !=null || $posts->qualification != '')
                     <td>{{$posts->qualification}}</td>
                     @else
                     <td style="color: red">{{"Not Provided"}}</td>
                     @endif
                     <td>
                       <a class="btn btn-circle btn-sm btn-outline-success" href="{{route('showHSCCFamilyStudent',[$posts->id,$posts->hfId])}}"><i class="ti-more"></i></a>
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
