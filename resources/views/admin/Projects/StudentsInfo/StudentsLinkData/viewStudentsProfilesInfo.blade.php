<?php use \App\Http\Controllers\MainController; $pid='';$eval='';?>
@extends('admin/mainpage/adminmain')
@section('admincontents')
<div class="row page-titles p-b-0 m-auto">
   <div class="col-md-9">
      <div class="d-flex">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
            <li class="breadcrumb-item"><a href="{{route('viewStudentsInfo',[encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}">{{$type}} Students Details</a></li>
            <li class="breadcrumb-item active">{{$type}} Student Profile</li>
         </ol>
      </div>
   </div>

   <div class="col-md-3">
     <ol class="breadcrumb pull-right">
       <li class="breadcrumb-item active m-t-0">
         <a class="btn btn-sm border-black text-dark  font-12 br-25 w-fit btn-outline-info pull-right m-t-0" href="{{route('addAssessments',[encrypt($stdid),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add {{$type}} Student Assessments" data-placement="top">
          New Assessments
          <i class="ti-plus"></i>
         </a>
       </li>
     </ol>
   </div>
</div>

@include('admin.mainpage.pages._messages')
<div class="row">
   <div class="col-md-3">
      @foreach($post as $posts)

      <div class="card box-shadow-gradient br-5 p-10-0" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
         <center class="m-t-30">
            @if(ifAnd($posts->image))
            <img src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$posts->image)}}" class="img-circle mt-m-25" width="150">
            @else
               @if($posts->gender == 'Male')
                  <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle mt-m-25" width="150">
               @else
                  <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="img-circle mt-m-25" width="150">
               @endif
            @endif
            <h4 class="card-title m-t-10 text-white">{{$posts->fname}} {{$posts->lname}}</h4>
         </center>
         
         <div class="card br-b-l-5 m-b-0 p-5 box-shadow-e" style="background: #00000061;color: white;">
            <div class="row text-center ">
               <div class="col-md-6 border-right">
                  <div>
                     <h5 class="font-Trirong font-14 font-w-900">HF-ID <br><small style="font-size: 100%">{{($posts->hfid != null) ? $posts->hfid : 'Not provided'}}</small></h5>
                     
                  </div>
               </div>
               <div class="col-md-6">
                  <div>
                     <h5 class="font-Trirong font-14 font-w-900">Adhar No <span><a href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Adhar{{$pid = $posts->id}}"><strong><small>{{ifAnd($posts->adhar_image) ? 'view' : 'upload' }} card</small></strong></a></span> <br><small style="font-size: 100%">{{($posts->adhar_no != null) ? $posts->adhar_no : 'Not provided'}}</small></h5>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="card box-shadow br-5 m-t-m-10">
         <div class="card-body p-b-0 open-sans">
            <div class="row">
               <div class="media">
                  <div class="media-left">
                     <i class="fa fa-user-circle-o text-theme-colored font-25 pr-10"></i>
                  </div>
                  <div class="media-body">
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Age : <span class="font-open-sans font-w-100">{{MainController::age($posts->dob)}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Gender : <span class="font-open-sans font-w-100">{{$posts->gender}}</span></h5>

                     <h5 class="mt-0 mb-0 font-Trirong p-5">Contact Number : <span class="font-open-sans font-w-100">{{($posts->mobile != null) ? $posts->mobile : 'Not provided'}}</span></h5>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="card box-shadow br-5 m-t-m-10">
         <div class="card-body p-b-0 open-sans">
            <div class="row">
               <div class="media">
                  <div class="media-left">
                     <i class="fa fa-lightbulb-o text-theme-colored font-25 pr-10"></i>
                  </div>
                  <div class="media-body">
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Hobbies : <span class="font-open-sans font-w-100">{{($posts->hobbies != null) ? $posts->hobbies : 'Not provided'}}</span></h5>
                     <h5 class="mt-0 mb-0 font-Trirong p-5">Area of Interest/ Goal  <p class="font-open-sans p-5 font-w-100">{{($posts->goal != null) ? $posts->goal : 'Not provided'}}</p></h5>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endforeach  

      @foreach($add as $addr)
      <div class="card box-shadow br-5 m-t-m-10">
         <div class="card-body p-b-0 open-sans">
            <div class="row">
               <div class="media">
                  <div class="media-left">
                     <i class="fa fa-map-marker text-theme-colored font-25 pr-10"></i>
                  </div>
                  <div class="media-body">
                     <h5 class="mt-0 mb-0 font-Trirong">Present Address:</h5>
                     <p>{{$addr->present_door}}, Kavalkatte, Bantval, Karnataka 574231</p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      @if(ifAnd($addr->aid))
      <div class="card box-shadow br-5 m-t-m-10">
         <div class="card-body p-b-0 open-sans">
            <div class="row">
               <div class="media">
                  <div class="media-left">
                     <i class="fa fa-map-marker text-theme-colored font-25 pr-10"></i>
                  </div>
                  <div class="media-body">
                     <h5 class="mt-0 mb-0 font-Trirong">Previous Address:</h5>
                     <p>{{$addr->door_no.', '.$addr->street_area.', '.$addr->belongs_to.', '.$addr->city.', '.$addr->district.', '.$addr->state.', '.$addr->nation.', '.$addr->pincode}} </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif
      @endforeach  
   </div>

   <div class="col-md-9">
      <div class="card box-shadow br-5">
         <ul class="nav nav-tabs bg-white m-l-0 " role="tablist" style="border-bottom: 0.5px solid #0001;">
            <li class="nav-item"> <a class="nav-link nav-a active show bg-white text-dark" data-toggle="tab" href="#Profiles" role="tab" aria-selected="true">Profile</a> </li>
            <li class="nav-item"><a class="nav-link nav-a bg-white text-dark" data-toggle="tab" href="#Education" role="tab"  aria-selected="false">Educational Info.</a></li>
            <li class="nav-item ">
              <a class="nav-link nav-a bg-white text-dark" href="{{route('showPerformanceChart',[encrypt($stdid),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}" target="_blank"  aria-selected="false">Perfomance/ Evaluation</a>
            </li>
            <li class="nav-item"> <a class="nav-link nav-a bg-white text-dark" href="{{route('showFamiliesProfiles',[session('id'),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}" target="_blank">Family Details</a> </li>
         </ul>

         <div class="tab-content">
            <div class="tab-pane active show" id="Profiles" role="tabpanel">
               @foreach($post as $posts)
<!--********************General education chart data***************************-->
               @if(ifAnd($posts->stdid))
               <div class="card m-b-0 p-b-0 animated zoomIn">
                  <div class="card-body p-b-0 p-t-0 mb-m-10">
                     <div class="row">
                        <div class="col-md-4">
                           <h4 class="card-title m-b-0 align-self-center">Genaral Education</h4>
                        </div>
                        <div class="col-md-8">
                           <div class="pull-right ml-auto">
                              <a class="btn btn-sm border-black text-dark br-25 w-fit btn-outline-info pull-right m-t-0" href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#eduModel">
                                 New <i class="ti-plus"></i>
                              </a>
                           </div>

                           <div class="pull-right ml-auto">
                              <label class="m-t-10">Educational Year</label>
                              <select class="custom-select w-auto b-none" id="general" onchange="ajaxData(this.value,'{{route('generalEdu')}}','generalChart','{{$posts->id}}','{{$hfid}}','{{$status}}')">
                                 <option value="{{$posts->edu_year}}">{{$posts->edu_year}}</option>
                                 @foreach($years as $y)
                                 @if($posts->edu_year != $y->year)
                                 <option value="{{$y->year}}">{{$y->year}}</option>
                                 @endif
                                 @endforeach
                              </select>
                           </div>
                           
                        </div>
                     </div>

                     <div class="row" id="generalChart">
                        @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._generalEduChartJs')
                     </div>
                     
                  </div>   
               </div>
               @else
                  <div class="card p-10 p-b-0 m-b-0 animated zoomIn">
                     <h4 class="card-title m-b-0">Genaral Education</h4>
                     @include('admin.Error_Pages.boxerrorpage')
                  </div>
               @endif
               <hr>
<!--************************Religious Education chart*************************-->
               @if(ifAnd($posts->rid) && ifAnd($posts->hid))
               <div class="card m-b-0 p-b-0 p-t-0 animated zoomIn">
                  <div class="card-body p-b-0 p-t-0 mb-m-10">

                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="card-title m-b-0 align-self-center">Religious/ Spiritual Development Information</h4>
                        </div>
                        <div class="col-md-6">
                           <div class="pull-right ml-auto">
                              <a class="btn btn-sm border-black text-dark br-25 w-fit btn-outline-info pull-right m-t-0" href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#spiritualModel">
                                 New <i class="ti-plus"></i>
                              </a>
                           </div>

                           <div class="pull-right ml-auto">
                              <label class="m-t-10">Year</label>
                              <select class="custom-select w-auto b-none" id="religiousYear" onchange="ajaxData(this.value,'{{route('spiritualDev')}}','religiousChart','{{$stdid}}','{{$hfid}}','{{$status}}')">
                                 @foreach($sdYear as $y)
                                 <option value="{{$y->monthYear}}">{{date("Y - F",strtotime($y->monthYear))}}</option>
                                 @endforeach
                              </select>
                           </div>
                           
                        </div>
                     </div>

                     <div class="row" id="religiousChart">
                        @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._spiritualChart')
                     </div>
                  </div>
               </div>
               @else
                  <div class="card p-10 p-b-0 m-b-0 animated zoomIn">
                     <h4 class="card-title m-b-0">Religious/ Spiritual Development Information</h4>
                     @include('admin.Error_Pages.boxerrorpage')
                  </div>
               @endif
               <hr>
<!--************************Student Skills chart*************************-->
               @if(ifAnd($posts->lifeskill_id))
               <div class="card m-b-0 p-b-0 p-t-0 animated zoomIn">
                  <div class="card-body p-b-0 p-t-0 mb-m-10">

                     <div class="row" style="z-index: 5;position: relative;">
                        <div class="col-md-6">
                           <h4 class="card-title m-b-0 align-self-center">Life Skills/ Evaluation Information</h4>
                        </div>
                        <div class="col-md-6">
                           <div class="pull-right ml-auto">
                              <a class="btn btn-sm border-black text-dark br-25 w-fit btn-outline-info pull-right m-t-0" href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#lifeSkillModal">
                                 New <i class="ti-plus"></i>
                              </a>
                           </div>

                           <div class="pull-right ml-auto">
                              <label class="m-t-10">Year</label>
                              <select class="custom-select w-auto b-none" id="religiousYear" onchange="ajaxData(this.value,'{{route('lifeSkillsEval')}}','skillsChart','{{$stdid}}','{{$hfid}}','{{$status}}')">
                                 @foreach($lsYear as $y)
                                 <option value="{{$y->monthYear}}">{{date("Y - F",strtotime($y->monthYear))}}</option>
                                 @endforeach
                              </select>
                           </div>
                           
                        </div>
                     </div>

                     <div class="row" id="skillsChart">
                        <!-- Life Skills Chart -->
                        @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._lifeSkillsChart')
                     </div>

                     
                  </div>
               </div>
               @else
                  <div class="card p-10 p-b-0 m-b-0 animated zoomIn">
                     <h4 class="card-title m-b-0">Life Skills/ Evaluation Information</h4>
                     @include('admin.Error_Pages.boxerrorpage')
                  </div>
               @endif
               @endforeach
            </div>
<!--************************* End Profile Tab **************************-->

<!--************************* Education Tab **************************-->
            <div class="tab-pane" id="Education" role="tabpanel">
               <div class="card p-10">
                  <div class="card-body">
                     <h4>Educational Information</h4>
                 
                     @if(count($educations))
                     <div class="table-responsive">
                        <table id="StudentEducationTable" class="table table table m-t-30 table-hover contact-list footable-loaded footable">
                           <thead>
                              <tr>
                                 <?php $i=1; ?>
                                 <th>#</th>
                                 <th>Course Name</th>
                                 <th>Grade /Standard</th>
                                 <th>School/ College-Name</th>
                                 <th>Weakness</th>
                                 <th>Strength</th>
                                 <th>Performance</th>
                                 <th>Year</th>
                              </tr>
                           </thead>
                           <tbody id="std_tbl_body">
                              @foreach($educations as $education)
                              <tr class="text-center btn-block-inline">
                                 <td>{{$i++}}</td>
                                 <td>{{ifAnd($education->course_name) ? $education->course_name : '-'}}</td>
                                 <td>{{$education->standard_grade}}</td>
                                 <td>{{ifAnd($education->institution_name) ? $education->institution_name.' '.$education->street : '-'}}</td>
                                 <td>{{ifAnd($education->weakness) ? $education->weakness : '-' }}</td>
                                 <td>{{ifAnd($education->strength) ? $education->strength : '-' }}</td>
                                 <td>{{$education->performance}}</td>
                                 <td>{{$education->year}}</td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     @else
                        @include('admin/Error_Pages/error_page2')
                     @endif
                  </div>
               </div>
            </div>
<!--*************************End Education Info. Tab **************************-->

         </div>
      </div>
   </div>
</div>
<!-- End of row contents -->

<!--******************* Adhar Image Model ******************-->
@foreach($post as $pos)
   @foreach($d = ['Adhar','Marks'] as $docs)
   <div class="modal fade" id="{{$docs.$pos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content" style="background:transparent;border:unset">
            <div style="">
               <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></button>
            </div>
            <div class="modal-body">
               <form method="POST" action="{{route('storeImage')}}" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="pic_type" id="pic_type" value="{{encrypt(($docs.$pos->id == 'Adhar'.$pos->id) ? 'Adhar' : 'Marks')}}">
                  <input type="hidden" name="id" id="id" value="{{encrypt($pos->id)}}">
                  <input type="hidden" name="str" value="{{encrypt('Doc')}}">
                  <input type="hidden" name="type" value="{{encrypt($type)}}">
                  <input type="hidden" name="hfid" value="{{encrypt($hfid)}}">
                  <div class="card m-b-0 p-t-0 br-5 box-shadow-e">
                     <div class="card-body p-5">
                        <div class="form-group m-b-0 m-t-10 p-b-0">                        
                        @if($docs.$pos->id == 'Adhar'.$pos->id)
                           @if(ifAnd($pos->adhar_image))
                           <input type="file" id="input-file-events" class="dropify form-control  @error('adhar_image') is-invalid @enderror" data-width="500" data-height="500" data-max-file-size="250K" data-default-file="{{asset(getImagePath('Doc',$type,$hfid,'Adhar').$pos->adhar_image)}}"  name="adhar_image"required/>
                           @else 
                           <input type="file" name="adhar_image" id="input-file-events" class="dropify form-control @error('adhar_image') is-invalid @enderror" data-max-file-size="250K" required/>
                           @endif
                        @else
                           @if(ifAnd($pos->marks_img))
                           <input type="file" id="input-file-events" class="dropify form-control" data-width="500" data-height="500" data-max-file-size="250K" data-default-file="{{asset(getImagePath('Doc',$type,$hfid,'Marks').$pos->marks_img)}}" name="marks_img" required/>
                           @else 
                           <input type="file" name="marks_img" id="input-file-events" class="dropify form-control @error('marks_img') is-invalid @enderror" data-max-file-size="250K" required/>
                           @endif
                        @endif
                        </div>
                       <input type="submit" name="submit" value="Upload" class="btn btn-sm btn-outline-success btn-block p-b-0 m-b-0">
                     </div>
                  </div>
               </form>
               
            </div>
         </div>
      </div>
   </div>
   @endforeach
@endforeach
<!-- ****************************** end model ***************-->

<!-- ******************* General Education Model *****************-->
   <div class="modal fade" id="eduModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content w-1000" style="background:transparent;border:unset">
            <div style="">
               <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></button>
            </div>
            <div class="modal-body">
               <form method="POST" action="{{route('storeGeneralEducation')}}" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="type" value="{{encrypt($type)}}">
                  <input type="hidden" name="hfid" value="{{encrypt($hfid)}}">
                  <input type="hidden" name="id" value="{{encrypt($stdid)}}">
                  <div class="card br-5 box-shadow-e p-b-0 m-b-0">
                     <div class="card-body p-b-0 m-b-0">
                        <div class="row">
                           <div class="col-md-12">
                              <h4 class="card-title">Add General Education Information</h4>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="Qualification">Qualification :</label>
                                 <input list="qualification" type="text" name="qualification" class="form-control" value="{{ old('qualification') }}" id="Qualification" required>
                                 <datalist id="qualification">
                                    <option value="Select">Select</option>
                                 </datalist>
                              </div>
                           </div>

                           <div class="col-md-2">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="edu_year">Year <small><sup>*</sup></small></label>
                                 <input list="eduYear" class="form-control" type="number" name="year" value="{{ old('year') }}" id="edu_year"/>
                                 <datalist id="eduYear">
                                    @foreach(array_combine(range(date("Y"), 1980), range(date("Y"), 1980)) as $y)
                                    <option value="{{$y}}"></option>
                                    @endforeach
                                 </datalist>
                              </div>
                           </div>

                           <div class="col-md-3">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="standard_grade">Grade <small><sup>*</sup></small></label>
                                 <input type="text" name="standard_grade" id="standard_grade" class="form-control" value="{{ old('standard_grade') }}">
                              </div>
                           </div>

                           <div class="col-md-3">
                              <div class="form-group label-floating">
                                 <label for="stage" class="control-label">Stage <small><sup>*</sup></small> :</label>
                                 <input list="Stage" type="text" name="stage" class="custom-select form-control" id="stage" value="{{ old('stage') }}">
                                 <datalist id="Stage">
                                    <option value="Pre-Primary"></option>
                                    <option value="Primary"></option>
                                    <option value="High School"></option>
                                 </datalist>
                              </div>
                           </div>

                           <div class="col-md-5">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="course_name">Course Name <small><sup>*</sup></small></label>
                                 <input type="text" name="course_name" id="course_name" class="form-control" value="{{ old('course_name') }}">
                              </div>
                           </div>

                           <div class="col-md-3">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="education_status">Present Education Status <sup>*</sup> </label>
                                 <input list="Education_status" class="form-control" id="education_status" name="education_status" value="{{ old('education_status') }}">
                                 <datalist id="Education_status">
                                    <option value="Completed"></option>
                                    <option value="Pursuing"></option>
                                    <option value="Dropout"></option>
                                 </datalist>
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="Performance">Performance <sup>*</sup> </label>
                                 <input type="text" name="performance" class="custom-select form-control" id="Performance" value="{{ old('performance') }}">
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="strength">Strength <small><sup>*</sup></small></label>
                                       <textarea name="strength" id="strength" rows="6" class="form-control">{{ old('strength') }}</textarea>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="Weakness">Weakness <small><sup>*</sup></small></label>
                                       <textarea name="weakness" id="Weakness" rows="6" class="form-control">{{ old('weakness') }}</textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <input type="file" name="marks_img" id="input-file-events" class="dropify form-control" data-max-file-size="500K" required/>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <hr>
                              <input type="hidden" name="inst_choice" id="inst_choice" value="{{old('inst_choice')}}">
                              <!-- <div class="card-header"> -->
                                 <h4 class="card-title"> Institution Information  
                                    <span class="pull-right"> 
                                       <span class="addInst">
                                          Add Institution Info. 
                                          <a class="btn btn-sm btn-outline-primary m-0 font-10" id="btnAdd" onclick="addInstitution('institution_info','addInst','removeInst','{{$inst}}','inst_choice')">
                                             <i class="ti-plus font-w-900"></i>
                                          </a>
                                       </span>
                                       <span class="removeInst"  style="display: none;">
                                          Remove Institution Info. 
                                          <a class="btn btn-sm btn-outline-primary m-0 font-10" id="btnDelete" onclick="removeInstitution('institution_info','removeInst','addInst','inst_choice')">
                                             <i class="ti-minus font-w-900"></i>
                                          </a>
                                       </span>
                                    </span>
                                 </h4>
                              <!-- </div> -->
                           </div>

                           <div class="col-md-12 animated zoomIn institution_info"></div>
                           <div class="col-md-12">
                              <input type='submit' class='btn btn-sm btn-outline-success btn-block' name='submit' value='Submit' />
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
               
            </div>
         </div>
      </div>
   </div>
<!-- ****************************** end model ***************-->

<!-- ******************* Spiritual Development Model *****************-->
@foreach($d = ['spiritualModel','lifeSkillModal'] as $si)
   <div class="modal fade spiritual-model" id="{{$si}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content w-1000" style="background:transparent;border:unset">
            <div style="">
               <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></button>
            </div>
            <div class="modal-body">
               <form method="POST" action="{{route('storeSpiritual')}}">
                  @csrf
                  <input type="hidden" name="type" value="{{encrypt($type)}}">
                  <input type="hidden" name="hfid" value="{{encrypt($hfid)}}">
                  <input type="hidden" name="status" value="{{encrypt($status)}}">
                  <input type="hidden" name="id" value="{{encrypt($stdid)}}">
                  <input type="hidden" name="formid" value="{{encrypt($si)}}">
                  @if($si == 'spiritualModel')
                  <input type="hidden" name="huqooq_id" value="{{encrypt(getByNum($sids,'spd_id',0))}}">
                  <input type="hidden" name="ibadh_id" value="{{encrypt(getByNum($sids,'spd_id',1))}}">
                  <input type="hidden" name="madrasa_id" value="{{encrypt(getByNum($sids,'spd_id',2))}}">
                  <input type="hidden" name="academi_id" value="{{encrypt(getByNum($mids,'mid',0))}}">
                  <input type="hidden" name="tarbiyyah_id" value="{{encrypt(getByNum($mids,'mid',1))}}">
                  @endif
                  <div class="card br-5 box-shadow-e p-b-0 m-b-0">
                     <div class="card-body p-b-0 m-b-0">
                        <div class="row">
                           <div class="col-md-12">
                              <h4 class="card-title">Add {{($si == 'spiritualModel') ? 'Spiritual Development' : 'Life Skills Evaluation' }}  Information</h4>
                              <hr>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="sp_year">Assessment Year :</label>
                                 <input class="form-control" type="date" name="sp_year" value="{{ old('sp_year') }}" id="sp_year"/>
                              </div>
                           </div>

                           <div class="col-md-12">
                              @if($si == 'spiritualModel')
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="card-header p-b-5 br-5">
                                       <h4 class="card-title font-14">Madrasa Education Information</h4>
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="row p-5">
                                       <div class="col-md-6">
                                          <div class="row border-right">
                                             <div class="col-md-12">
                                                <h4 class="card-title font-14">Academic Information</h4>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <input list="M_Grade" type="text" name="m_grade" class="form-control" value="{{ old('m_grade') }}" id="m_grade" placeholder="Madrasa Class/ Grade" required>
                                                   <datalist id="M_Grade">
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                      <option value="5">5</option>
                                                      <option value="6">6</option>
                                                      <option value="7">7</option>
                                                      <option value="8">8</option>
                                                   </datalist>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <input list="M_performnace" type="text" name="m_performance" class="custom-select form-control" id="m_performance" value="{{ old('m_performance') }}" placeholder="Academic Performance">
                                                   <datalist id="M_performnace">
                                                      <option value="0">0</option>
                                                      <option value="20">20</option>
                                                      <option value="40">40</option>
                                                      <option value="60">60</option>
                                                      <option value="80">80</option>
                                                      <option value="100">100</option>
                                                   </datalist>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- end of academic -->
                                       <div class="col-md-6">
                                          <div class="row">
                                             <div class="col-md-12">
                                                <h4 class="card-title font-14">Tarbiyyah/ Practice Information</h4>
                                             </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                   <input list="Tajveed" type="text" name="tajveed" class="form-control" value="{{ old('tajveed') }}" id="tajveed" placeholder="Tajveed" required>
                                                   <datalist id="Tajveed">
                                                      <option value="0">0</option>
                                                      <option value="20">20</option>
                                                      <option value="40">40</option>
                                                      <option value="60">60</option>
                                                      <option value="80">80</option>
                                                      <option value="100">100</option>
                                                   </datalist>
                                                </div>
                                             </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                   <input list="Fiqh" type="text" name="fiqh" class="custom-select form-control" id="fiqh" value="{{ old('fiqh') }}" required placeholder="Fiqh">
                                                   <datalist id="Fiqh">
                                                      <option value="0">0</option>
                                                      <option value="20">20</option>
                                                      <option value="40">40</option>
                                                      <option value="60">60</option>
                                                      <option value="80">80</option>
                                                      <option value="100">100</option>
                                                   </datalist>
                                                </div>
                                             </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                   <input list="Arabic" type="text" name="arabic" class="form-control" value="{{ old('arabic') }}" id="arabic" placeholder="Arabic" required>
                                                   <datalist id="Arabic">
                                                      <option value="0">0</option>
                                                      <option value="20">20</option>
                                                      <option value="40">40</option>
                                                      <option value="60">60</option>
                                                      <option value="80">80</option>
                                                      <option value="100">100</option>
                                                   </datalist>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="card-header p-b-5 br-5">
                                       <h4 class="card-title font-14">Huqooq-Allah Information</h4>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <input list="Salah" type="text" name="salah" class="form-control" value="{{ old('salah') }}" id="salah" placeholder="Salah" required>
                                       <datalist id="Salah">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <input list="Saum" type="text" name="saum" class="form-control" value="{{ old('saum') }}" id="saum" placeholder="Saum" required>
                                       <datalist id="Saum">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="card-header p-b-5 br-5">
                                       <h4 class="card-title font-14">Huqooq-Ul-Ibaadh Information</h4>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input list="Physical" type="text" name="physical" class="form-control" value="{{ old('physical') }}" id="physical" placeholder="Physical" required>
                                       <datalist id="Physical">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input list="Finance" type="text" name="finance" class="form-control" value="{{ old('finance') }}" id="finance" placeholder="Finance" required>
                                       <datalist id="Finance">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input list="Intellectual" type="text" name="intellectual" class="form-control" value="{{ old('intellectual') }}" id="intellectual" placeholder="Intellectual" required>
                                       <datalist id="Intellectual">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <!-- end row -->
                              </div>
                              @else
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="card-header p-b-5 br-5">
                                       <h4 class="card-title font-14">Life Skills </h4>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <input list="Servaying" type="text" name="servaying" class="form-control" value="{{ old('servaying') }}" id="servaying" placeholder="Servaying/ Feasibility" required>
                                       <datalist id="Servaying">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <input list="Networking" type="text" name="networking" class="form-control" value="{{ old('networking') }}" id="networking" placeholder="Networking" required>
                                       <datalist id="Networking">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <input list="Managing" type="text" name="managing" class="form-control" value="{{ old('managing') }}" id="managing" placeholder="Managing" required>
                                       <datalist id="Managing">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <input list="Leadership" type="text" name="leadership" class="form-control" value="{{ old('leadership') }}" id="leadership" placeholder="Leadership" required>
                                       <datalist id="Leadership">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <input list="Communication" type="text" name="communication" class="form-control" value="{{ old('communication') }}" id="communication" placeholder="Communication" required>
                                       <datalist id="Communication">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <input list="Organising" type="text" name="organising" class="form-control" value="{{ old('organising') }}" id="organising" placeholder="Organising" required>
                                       <datalist id="Organising">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <input list="Team_player" type="text" name="team_player" class="form-control" value="{{ old('team_player') }}" id="team_player" placeholder="Team_player" required>
                                       <datalist id="Team_player">
                                          <option value="0">0</option>
                                          <option value="20">20</option>
                                          <option value="40">40</option>
                                          <option value="60">60</option>
                                          <option value="80">80</option>
                                          <option value="100">100</option>
                                       </datalist>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>

                           <div class="col-md-12">
                              <input type='submit' class='btn btn-sm btn-outline-success btn-block' name='submit' value='Submit' />
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
               
            </div>
         </div>
      </div>
   </div>
@endforeach
<!-- ****************************** end model ***************-->

@include('admin.Projects.JavasciptOperations.javascript_inside_laravel')

@endsection
