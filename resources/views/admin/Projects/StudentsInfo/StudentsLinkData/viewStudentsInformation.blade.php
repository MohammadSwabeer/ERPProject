   <?php  use \App\Http\Controllers\MainController; $main = new MainController;?> 
   @extends('admin/mainpage/adminmain')

   @section('admincontents')
   
    <div class="row page-titles">
      <div class="col-md-12">
      {{ $main->breadCrumbsData($type,$prType,'view',$personCat,$page,$status) }}
      </div>
    </div>

        <div class="row">
         <div class="col-12">
          <div class="card box-shadow-e br-5">
           @include('admin.mainpage.pages.main-preloader')
           <div class="card-body contents" style="display: none;">
             <h4 class="card-title"> {{$type}} Students Information
               <div class="btn-group pull-right btnGroup">
                     <!-- <a class="btn br-25 w-fit btn-outline-success" id="btnFilter" onclick="function f(){ return document.getElementById('filterData').style.display = 'block';};f()" data-toggle="tooltip" data-placement="top" title="Click to filter-search">
                       <i class="ti-filter"></i> Filter
                     </a> -->
                     <a class="btn br-25 w-fit btn-outline-primary" href="{{route('studentsAssessingPage',[encrypt($type)])}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add Aseessment Details" data-placement="top">
                       New Evaluation
                       <i class="ti-plus"></i>
                     </a>
                     @if($type == 'Database' || $type == 'Workshop' || $type == 'ATT')
                      <a class="btn br-25 w-fit btn-outline-info" href="{{route(($type != 'ATT') ? 'addOtherStudentsPage' : 'ATTStudentsAddPage',[encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add {{$type}} Student Details" data-placement="top">
                       New Student
                       <i class="ti-plus"></i>
                     </a>
                     @endif
                </div>
             </h4>

             <div class="table-responsive">
               <table id="HSCCDT" class="table table m-t-30 table-hover contact-list footable-loaded footable">
                 <thead>
                   <tr>
                     <?php $id=1; ?>
                     <th>Sl.No.</th>
                     <th>HF-ID</th>
                     <th>Full Name</th>
                     <th>Gender</th>
                     <th>DateOfBirth</th>
                     <th>Age</th>
                     <th>Education</th>
                     <th>Future Goal</th>
                     <th>More</th>
                   </tr>
                 </thead>
                 <tbody>
                   @foreach($post as $posts)
                   <tr>
                     <td>{{$id++}}</td>
                     <td>{{$posts->hfid}}</td>
                     <td><a href="{{route('showStudentsProfile',[encrypt($posts->id),encrypt($posts->hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}">{{$posts->fname}} {{$posts->lname}}</a></td>
                     <td>{{$posts->gender}}</td>
                     <td>{{$posts->dob}}</td>
                     <td>{{(MainController::age($posts->dob) < 10) ? '0'.MainController::age($posts->dob) : MainController::age($posts->dob)}}</td>
                     @if(ifAnd($posts->qualification))
                     <td>{{$posts->qualification}}</td>
                     @else
                     <td style="color: red">{{"Not Provided"}}</td>
                     @endif

                     @if(ifAnd($posts->goal))
                     <td>{{$posts->goal}}</td>
                     @else
                     <td style="color: red">{{"Not Provided"}}</td>
                     @endif
                     <td>
                       <a class="btn btn-circle btn-sm btn-outline-success" href="{{route('showStudentsProfile',[encrypt($posts->id),encrypt($posts->hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}"><i class="ti-more"></i></a>
                     </td>
                   </tr>
                   @endforeach
                 </tbody>
                 </table>
               </div>
             </div>
           </div>
         </div>
       </div>
   @endsection
