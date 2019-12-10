<?php use \App\Http\Controllers\MainController; $main = new MainController;?>
@extends('admin/mainpage/adminmain')

@section('admincontents')
<div class="row page-titles">
   <div class="col-md-12">
      {{$main->breadCrumbsData($type,$prType,'add',$personCat,$page,$status)}}
   </div>
</div>
@include('admin.mainpage.pages._messages')  
<div class="wizard-container">
   <div class="card wizard-card br-5" data-color="blue" id="wizardProfile">
      @include('admin.mainpage.pages.form-preload')
      <form action="{{route('storeHSCCFamilyDetails')}}" method="POST" enctype="multipart/form-data" class="contents" style="display: none;">
         {{ csrf_field() }}
         <input type="hidden" name="type" value="{{$type}}">
         <input type="hidden" name="prType" value="{{$prType}}">
         <input type="hidden" name="page" value="{{$page}}">
         <input type="hidden" name="status" value="{{$status}}">
         <input type="hidden" name="personCat" value="{{$personCat}}">
         <input type="hidden" name="role" value="{{$role}}">
         <div class="wizard-header" style="padding: 10px 0 20px;">
            <h4 class="wizard-title font-NexaRust Sans-Black">
               {{$type}} Family {{($role == 'Head') ? "Head's" : "Members"}} Information
            </h4>
         </div>

         <div class="wizard-navigation">
            <ul id="list">
               <li><a href="#personal" data-toggle="tab" class="font-w-700">Personal info.</a></li>
               <li><a href="#otherDetails" data-toggle="tab" class="font-w-700">Other info.</a></li>
               @if($role == 'Head')
               <li><a href="#History" data-toggle="tab" class="font-w-700">History/ Status</a></li>
               @endif
               <li><a href="#generalEducation" data-toggle="tab" class="font-w-700">General Education Info.</a></li>
               <li><a href="#services" data-toggle="tab" class="font-w-700">Helps And Services</a></li>
            </ul>
         </div>

         <div class="tab-content">
            <div class="tab-pane" id="personal">
               <div class="row p-10">
                  <div class="col-md-2">
                     <div class="form-group picture-container">
                        <div class="picture">
                           <img src="{{asset('adminAssets/images/default/user-default.png')}}" class="picture-src" id="wizardPicturePreview" title=""/>
                           <input type="file" id="wizard-picture" name="image">
                        </div>
                        <h6>Choose Picture</h6>
                     </div>
                  </div>

                  <div class="col-md-10 m-t-20">
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">First Name <small>(*)</small></label>
                              <input name="fname" type="text" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname') }}" placeholder="Enter First Name" required>
                              @error('fname')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                               @enderror 
                           </div>
                        </div>

                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="control-label" for="lname">Last Name</label>
                              <input name="lname" type="text" id="lname" value="{{ old('lname') }}" class="form-control" placeholder="Enter Last Name">
                           </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group controls">
                              <div class="form-group">
                                 <label class="control-label">Date of Birth <small>(*)</small></label>
                                 <input name="dob" type="date" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" id="dob" onblur="compare('dob','dobError',' Date of birth should not be greater than current date.','nxt')" required>
                                  <small class="text-danger" id="dobError"></small>
                                @error('dob')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                           </div>
                        </div>

                        <div class="col-md-2">
                           <div class="form-group">
                              <label>Gender : </label>
                              <fieldset class="controls">
                                 <div class="custom-control custom-radio">
                                    <input type="radio" value="Male" name="gender" required id="Male" class="custom-control-input" aria-invalid="false" checked="checked">
                                    <label class="custom-control-label" for="Male">Male</label>
                                 </div>
                                 <div class="help-block" ></div>
                              </fieldset>
                              <fieldset>
                                 <div class="custom-control custom-radio">
                                    <input type="radio" value="Female" name="gender" id="Female" class="custom-control-input" aria-invalid="false">
                                    <label class="custom-control-label" for="Female">Female</label>
                                 </div>
                              </fieldset>
                           </div>
                        </div>
                     </div>
                     <!-- End row -->
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="birth_palce">Birth Place </label>
                                 <input name="birth_palce" id="birth_palce" type="text" class="form-control" value="{{ old('birth_palce') }}">
                              </div>
                           </div>
                        </div>

                        <div class="col-md-2">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="relegion">Relegion<sup>*</sup> </label>
                                 <input list="Relegion" name="relegion" type="text" class="form-control" required id="relegion" value="Islam">
                                 <datalist id="Relegion">
                                    <option value="Islam"></option>
                                    <option value="Hindu"></option>
                                    <option value="Christian"></option>
                                 </datalist>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-2">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="mother_toungue">Mother Tongue <sup>*</sup></label>
                                 <input list="Mother_toungue" type="text" name="mother_tongue" value="{{ old('mother_tongue') }}" id="mother_toungue" class="form-control" required value="Beary">
                                 <datalist id="Mother_toungue">
                                    <option value="Beary"></option>
                                    <option value="Tulu"></option>
                                    <option value="Malayalam"></option>
                                    <option value="English"></option>
                                    <option value="Urdu"></option>
                                    <option value="Hindi"></option>
                                 </datalist>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-2">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="nationality">Nationality <sup>*</sup> </label>
                                 <input list="Nationality" name="nationality" type="text" class="form-control" id="nationality" required value="Indian">
                                 <datalist id="Nationality">
                                    <option value="Indian"></option>
                                 </datalist>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="blood_group">Blood Group</label>
                                 <input list="Blood_Group" name="blood_group" type="text" class="form-control" id="blood_group" value="{{ old('blood_group') }}">
                                 <datalist id="Blood_Group">
                                    <option value="A -ve"></option>
                                    <option value="A +ve"></option>
                                    <option value="B +ve"></option>
                                    <option value="B -ve"></option>
                                    <option value="O -ve"></option>
                                    <option value="O +ve"></option>
                                 </datalist>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="Occupation">Occupation <sup>*</sup></label>
                                 <input list="occupation" type="text" name="occupation_name" class="custom-select form-control" id="Occupation" value="{{ old('occupation_name') }}" required>
                                 <datalist id="occupation">
                                    <option value="Student"></option>
                                    <option value="Employee"></option>
                                    <option value="Coolie Worker"></option>
                                 </datalist>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label" for="Phone">Phone </label>
                                 <input type="text" name="phone" id="Phone" class="form-control" value="{{ old('phone') }}" minlength="6" maxlength="10" onblur="projectsAjaxData(this.value,'{{route('isMobileExist')}}','phones','{{$type}}','phone','FoundPhone')" oninput="checkNumber(this.value,'phones')">
                                 <small class="text-danger"><strong  id="phones"></strong></small>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group label-floating">
                              <label class="control-label">Mobile Number</label>
                              <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" id="Mobile" pattern="[1-9]{1}[0-9]{9}" maxlength="10" oninput="checkNumber(this.value,'number')" onblur="projectsAjaxData(this.value,'{{route('isMobileExist')}}','number','{{$type}}','mobile','FoundMobile')">
                              <small class="text-danger"><strong id="number"></strong></small>
                              @error('mobile')
                               <span class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                             @enderror
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group label-floating">
                              <label class="control-label">E-mail <small><sup> (optional)</sup></small></label>
                              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" onchange="projectsAjaxData(this.value,'{{route('isMobileExist')}}','emails','{{$type}}','email','FoundEmail')">
                              <small class="text-danger"><strong id="emails"></strong></small> 
                              @error('email')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                              @enderror
                           </div>
                        </div>
                     </div>
                     <!-- End row -->
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group controls">
                               <div class="form-group label-floating">
                                  <label class="control-label">Hobbies <small>(followed by comma(,))<sup>(optional)</sup></small></label>
                                  <textarea name="hobbies" id="hobbies" rows="6" class="form-control @error('hobbies') is-invalid @enderror">{{ old('hobbies') }}</textarea>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group controls">
                              <div class="form-group label-floating">
                                 <label class="control-label">Area of  interest/ Future goal <small><sup>(optional)</sup></small></label>
                                 <textarea name="goal" id="goal" rows="6" class="form-control @error('goal') is-invalid @enderror">{{ old('goal') }}</textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end col-md-10 -->
               </div>
               <!-- end row -->
            </div>
            <!-- End tab about content -->

            <div class="tab-pane" id="otherDetails">
               <section class="p-10" >
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="hfId">HF Id :</label>
                           <input type="number" name="hfid" value="" class="form-control @error('hfid') is-invalid @enderror" value="{{ old('hfid') }}" id="hfId" placeholder="Enter HF Id" required>
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group controls">
                           <div class="form-group">
                              <label for="Living">Living Status</label>
                              <select class="custom-select form-control" id="Living" name="living" required>
                                 <option value="{{old('living')}}">{{(old('Living') == null) ? 'Select Living Status' : old('Living')}}</option>
                                 <option value="Alive">Alive</option>
                                 <option value="Late">Late</option>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="Relation">Relation in Family:</label>
                           <select class="custom-select form-control" id="Relation" name="relation" required onchange="MaritalChange(this.value,'Marital')">
                              <option value="{{old('relation')}}">{{(old('Relation') == null) ? 'Select Relation' : old('Relation')}}</option>
                              <option value="Father">Father</option>
                              <option value="Mother">Mother</option>
                              <option value="Wife">Wife</option>
                              <option value="Husband">Husband</option>
                              <option value="Son">Son</option>
                              <option value="Daughter">Daughter</option>
                              <option value="Sister">Sister</option>
                              <option value="Brother">Brother</option>
                              <option value="Guardian">Guardian</option>
                           </select>
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group controls">
                           <div class="form-group">
                              <label for="Marital">Marital Status</label>
                              <select class="custom-select form-control" id="Marital" name="marital_status" required>
                                 <option value="{{old('marital_status')}}"> {{(old('marital_status') == null) ? 'Select Marital' : old('marital_status')}}</option>
                                 <option value="Married">Married</option>
                                 <option value="Single">Single</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>

               <section class="p-10">
                  <div class="row">
                     <div class="col-md-12">
                        <hr>
                        <div class="card-header">
                           <h4 class="card-title">Document Details</h4>
                        </div>
                     </div>

                     <div class="row">
                     @if($role == 'Head')
                        <div class="col-md-6" id="rationDetails">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="Ration">Ration Card Number :</label>
                                    <input type="text" name="ration_no" class="form-control" value="{{ old('ration_no') }}" id="Ration" placeholder="Enter Ration Card Number">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group text-center">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <div class="docs-image br-5">
                                             <img src="{{asset('adminAssets/images/default/docs.png')}}" class="picture-src" id="RationPreview" title="" height="60" />
                                             <input type="file" id="ration-picture" name="ration_image">
                                          </div>
                                       </div>
                                       <div class="col-md-8">
                                          <p><span><i class="fa fa-spin fa-spinner"></i></span> Click image to upload Ration Card copy</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     @endif
                        <div class="col-md-6">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="Adhar">Adhar Card Number :</label>
                                    <input type="number" name="adhar_no" class="form-control" value="{{ old('adhar_no') }}" id="Adhar" placeholder="Enter Adhar">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group text-center picture-container">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <div class="docs-image br-5">
                                             <img src="{{asset('adminAssets/images/default/docs.png')}}" class="picture-src" id="adharPreview" title="" />
                                             <input type="file" id="adhar-picture" name="adhar_image">
                                          </div>
                                       </div>
                                       <div class="col-md-8">
                                          <p><span><i class="fa fa-spin fa-spinner"></i></span> Click image to upload Adhar Card copy</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                    </div>
                  </div>
                  <!-- end Document Details -->
                  @if($role == 'Head')
                  <div class="row">
                     <div class="col-md-12">
                        <hr>
                        <div class="card-header">
                           <h4 class="card-title">Previous Address</h4>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group label-floating">
                           <label for="door_no" class="control-label">Door Number :</label>
                           <input type="text" name="door_no" class="form-control" id="door_no"  value="{{ old('door_no') }}">
                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class="form-group label-floating">
                           <label class="control-label" for="street">Area/ Street/ Village</label>
                           <textarea name="street" id="street" rows="6" class="form-control">{{ old('street') }}</textarea>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group label-floating">
                           <label for="belongs_to" class="control-label">Belongs To :</label>
                           <select name="belongs_to" class="custom-select form-control" id="belongs_to">
                              <option value="{{ old('belongs_to') }}">{{old('belongs_to')}}</option>
                              <option value="Rural">Rural</option>
                              <option value="Semi-Rural">Semi-Rural</option>
                              <option value="Urban">Urban</option>
                           </select>
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group label-floating">
                           <label for="city" class="control-label">Taluk/ City :</label>
                           <input list="City" type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" onblur="searchDataExists(this.value,'{{route('serachCity')}}','city_apps','city_id','City','city_id','inst')">
                           <datalist id="City">
                              @foreach($cities as $city)
                              <option data-value="{{$city->id}}" value="{{$city->city_name}}"></option>
                              @endforeach
                           </datalist>
                           <input type="hidden" name="city_id" id="city_id">
                        </div>
                     </div>
                  </div>
                  <div class="row" id="city_apps">
                     <div class="col-md-4">
                        <div class="form-group label-floating">
                           <label for="District" class="control-label">District :</label>
                           <input list="district" type="text" name="district" id="District" class="form-control" value="{{ old('district') }}">
                           <datalist id="district">
                              <option value="Dakshina Kannada"></option>
                              <option value="Udupi"></option>
                           </datalist>
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group label-floating">
                           <label for="state" class="control-label">State :</label>
                           <input list="State" class="form-control" type="text" name="state" id="state" value="{{ old('state') }}">
                           <datalist id="State">
                              <option value="Karnataka"></option>
                              <option value="Kerala"></option>
                           </datalist>
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group label-floating">
                           <label for="pincode" class="control-label">Pin Code :</label>
                           <input type="number" name="pincode" class="form-control" id="pincode" value="{{ old('pincode') }}">
                        </div>
                     </div>
                  </div>
                  <!-- End Previuos Address Details -->
                  @endif
               </section>
            </div>
            <!-- End Other Details content -->
            @if($role == 'Head')
            <div class="tab-pane" id="History">
               <section class="p-10">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="present_door">Present Door Number <small><sup>*</sup></small> :</label>
                           <input type="text" name="present_door" class="form-control" id="present_door" value="{{old('present_door')}}" placeholder="Enter Present Door Number" required>
                        </div>
                     </div>

                     <div class="col-md-8">
                        <div class="form-group">
                           <label for="dojHSCC">Date of Join :</label>
                           <input type="date" name="dojHSCC" class="form-control" value="{{ old('dojHSCC') }}" id="dojHSCC" placeholder="Enter Date of Join">
                        </div>
                     </div>

                     <div class="col-md-12">
                        <div class="form-group label-floating">
                           <label class="control-label" for="Reason">Reason/Desperation :</label>
                           <textarea name="reason" id="Reason" rows="10" cols="10" class="form-control" required>{{ old('reason') }}</textarea>
                        </div>
                     </div>
                   
                     <div class="col-md-6">
                        <div class="form-group label-floating">
                           <label class="control-label" for="Familial">Familial/ Realtionship :</label>
                           <input list="familial" type="text" name="familial" class="custom-select form-control" value="{{ old('familial') }}" id="Familial" required>
                           <datalist id="familial">
                              <option value="Abandoned">Abandoned</option>
                              <option value="Domestic Violence">Domestic Violence</option>
                              <option value="Divorcee">Divorcee</option>
                              <option value="Widowed">Widowed</option>
                           </datalist>
                        </div>
                     </div>

                     <div class="col-md-2" id="AnnualIncome">
                        <div class="form-group label-floating">
                          <label class="control-label" for="income">Annual Income <small><sup>*</sup></small> : </label>
                          <input type="number" name="income" class="form-control" id="income" value="{{old('income')}}" required>
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group label-floating">
                           <label class="control-label" for="income_source">Income source :</label>
                           <input type="text" name="income_source" class="form-control" value="{{ old('income_source') }}" id="income_source" required>
                        </div>
                     </div>

                     <div class="col-md-12">
                        <div class="form-group label-floating">
                           <label class="control-label" for="HealthStatus">Health Status :</label>
                           <input list="healthStatus" type="text" name="HealthStatus" class="custom-select form-control" value="{{ old('HealthStatus') }}" id="HealthStatus" required>
                           <datalist id="healthStatus">
                              <option value="Select">Select</option>
                           </datalist>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="Shelter">Shelter :</label>
                           <input list="shelter" type="text" name="shelter" class="custom-select form-control" id="Shelter" required placeholder="select shelter">
                           <datalist id="shelter">
                              <option value="{{ old('shelter') }}">{{ ifAnd(old('shelter')) ? old('shelter') : 'Select Shelter' }}</option>
                              <option value="Rented">Rented</option>
                              <option value="None">None</option>
                           </datalist>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="SelfReliant">Self Reliant :</label>
                           <select class="custom-select form-control" id="SelfReliant" name="SelfReliant" required>
                             <option value="{{ old('SelfReliant') }}">{{ ifAnd(old('SelfReliant')) ? old('SelfReliant') : 'Select Self Reliant' }}</option>
                             <option value="Yes">Yes</option>
                             <option value="No">No</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <!-- end row -->
               </section>
               <!-- End section -->
            </div>
            <!-- end of FamilyDetails -->
            @endif
            <div class="tab-pane" id="generalEducation">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group label-floating">
                           <label class="control-label" for="Qualification">Qualification :</label>
                           <input list="qualification" type="text" name="Qualification" class="form-control" value="{{ old('Qualification') }}" id="Qualification" required>
                           <datalist id="qualification">
                              <option value="Select">Select</option>
                           </datalist>
                        </div>
                     </div>

                     <div class="col-md-2">
                        <div class="form-group label-floating">
                           <label class="control-label" for="edu_year">Year <small><sup>*</sup></small></label>
                           <input class="form-control" type="number" name="edu_year" value="{{ old('edu_year') }}" id="edu_year"/>
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group label-floating">
                           <label class="control-label" for="standard_grade">Grade <small><sup>*</sup></small></label>
                           <input type="text" name="standard_grade" id="standard_grade" class="form-control" value="{{ old('standard_grade') }}">
                        </div>
                     </div>

                     <div class="col-md-8">
                        <div class="form-group label-floating">
                           <label class="control-label" for="course_name">Course Name <small><sup>*</sup></small></label>
                           <input type="text" name="course_name" id="course_name" class="form-control" value="{{ old('course_name') }}">
                        </div>
                     </div>

                     <div class="col-md-4">
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

                     <div class="col-md-6">
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
                     
                     <div class="col-md-6">
                        <div class="form-group label-floating">
                           <label class="control-label" for="Performance">Performance <sup>*</sup> </label>
                           <input type="text" name="performance" class="custom-select form-control" id="Performance" value="{{ old('performance') }}">
                        </div>
                     </div>

                     <div class="col-md-12">
                        <div class="form-group label-floating">
                           <label class="control-label" for="strength">Strength <small><sup>*</sup></small></label>
                           <textarea name="strength" id="strength" rows="6" class="form-control">{{ old('strength') }}</textarea>
                        </div>
                     </div>

                     <div class="col-md-12">
                        <div class="form-group label-floating">
                           <label class="control-label" for="Weakness">Weakness <small><sup>*</sup></small></label>
                           <textarea name="weakness" id="Weakness" rows="6" class="form-control">{{ old('weakness') }}</textarea>
                        </div>
                     </div>

                     <div class="col-md-12">
                        <hr>
                        <input type="hidden" name="inst_choice" id="inst_choice" value="{{old('inst_choice')}}">
                        <div class="card-header">
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
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-12 animated zoomIn institution_info"></div>
                  <!-- end row -->
               </div>
               <!-- end card-body -->
            </div>
            <!-- end generalEducation contents-->

            <div class="tab-pane" id="services">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card-header">
                           <h4 class="card-title">HELPS NEEDED </h4>
                        </div>
                     </div>
                     <?php $projects = ['Food','Health','Education','Self-Reliance','Infrastructure']; ?>
                     @foreach($projects as $helps)
                     <div class="col-md-12">
                        <div class="form-group controls">
                           <div class="form-group label-floating">
                              <label class="control-label" for="{{$helps}}_help">{{$helps}} : </label>
                              <textarea name="concerns[]" id="{{$helps}}_help" rows="6" class="form-control">{{old('concerns[]')}}</textarea>
                              <input type="hidden" name="helps_project[{{$helps}}]" value="{{$helps}}">
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <hr>
                        <div class="card-header">
                           <h4 class="card-title">SERVICE OBTAINED FROM HSCC :</h4>
                        </div>
                     </div>
                     @foreach($projects as $service)
                     <div class="col-md-12">
                        <div class="form-group controls">
                           <div class="form-group label-floating">
                              <label class="control-label" for="{{$service}}_service">{{$service}} : </label>
                              <textarea name="services[]" id="{{$service}}_service" rows="6" class="form-control">{{old('services[]')}}</textarea>
                              <input type="hidden" name="services_project[{{$service}}]" value="{{$service}}">
                           </div>
                        </div>
                     </div>
                     @endforeach
                     
                  </div>
               </div>
            </div>
         </div>
         <!-- end of tab content -->

         <div class="wizard-footer">
            <div class="form-group pull-right">
               <input type='button' class='btn btn-next btn-fill btn-success btn-wd nxt' name='next' value='Next' />
               <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='submit' value='Submit' />
            </div>

            <div class="form-group pull-left">
               <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
            </div>
            <div class="clearfix"></div>
         </div>
         <!-- end of wizard-footer -->
      </form>
      <!-- end of form -->
   </div>
   <!-- end wizard-card -->
</div> 
<!-- wizard container -->

@include('admin.Projects.JavasciptOperations.javascript_inside_laravel')
@endsection
