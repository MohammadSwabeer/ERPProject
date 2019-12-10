   <?php  use \App\Http\Controllers\MainController; $main = new MainController;  ?>
   @extends('admin.mainpage.adminmain')
   @section('admincontents')
   <?php $title = $main->getBCTitle($type,'profile', $personCat, $page,'','edit'); 
     $routes = $main->getBCRoutes($page,$personCat);
     $main->find_field_data('tbl_families_personals','hfid',$id);
     $hfId = $main->find_field_data('tbl_families_personals','hfid',$id)[0]->hfid;
   ?>
   <div class="row page-titles">
      <div class="col-md-12">
         <div class="d-flex">
           <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
             <li class="breadcrumb-item"><a href="{{route($routes->getData()->prevRoute)}}">{{$title->getData()->prevTitle}}</a></li>
             <li class="breadcrumb-item"><a href="{{route('viewFamiliesPage', $main->getsId('viewFamiliesPage', $type, $prType))}}">{{$title->getData()->presTitle}}</a></li>
             <li class="breadcrumb-item"><a href="{{route('showFamiliesProfiles', $main->getsId('showFamiliesProfiles', $type, $prType,'',$hfId))}}">{{$title->getData()->nextTitle}}</a></li>
             <li class="breadcrumb-item active">{{$title->getData()->upNextTitle}}</li>
           </ol>
         </div>
      </div>
   </div>   

   <div class="row">
      <div class="col-md-12">
         <div class="card bg-white box-shadow-e br-5">
            <div class="wizard-container">
               <div class="wizard-card br-5" style="box-shadow:none;" data-color="blue" id="wizardProfile">
               @include('admin.mainpage.pages.form-preload')
                  <form action="{{route('updateHSCCFamilyDetails')}}" method="POST" enctype="multipart/form-data" class="contents" style="display: none;">
                     @csrf
                     @foreach($post as $posts)

                     <input type="hidden" name="type" value="{{$type}}">
                     <input type="hidden" name="fam_id" value="{{$id}}">
                     <input type="hidden" name="prType" value="{{$prType}}">
                     <input type="hidden" name="page" value="{{$page}}">
                     <input type="hidden" name="status" value="{{$status}}">
                     <input type="hidden" name="personCat" value="{{$personCat}}">

                     <div class="wizard-header" style="padding: 10px 0 20px;">
                        <h4 class="wizard-title font-NexaRust Sans-Black">
                           Edit {{$type}} Family Details
                        </h4>
                     </div>
                     <div class="wizard-navigation">
                        <ul>
                           <li><a href="#personal" data-toggle="tab" class="font-w-700">Personal info.</a></li>
                           <li><a href="#otherDetails" data-toggle="tab" class="font-w-700">Other info.</a></li>
                           @if($posts->role == 'Head')
                           <li><a href="#History" data-toggle="tab" class="font-w-700">History/ Status</a></li>
                           @endif
                           <li><a href="#generalEducation" data-toggle="tab" class="font-w-700">General Education Info.</a></li>
                           @if(count($servCon) > 0)
                           <li><a href="#services" data-toggle="tab" class="font-w-700">Helps And Services</a></li>
                           @endif
                        </ul>
                     </div>

                     <div class="tab-content">
                        <div class="tab-pane" id="personal">
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-group picture-container">
                                    <div class="picture">
                                       @if(ifAnd($posts->image) != true)
                                       <img src="{{asset('adminAssets/images/default/user-default.png')}}" class="picture-src" id="wizardPicturePreview" title=""/>  
                                       <input type="file" id="wizard-picture" name="image">
                                       @else
                                       <img src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily'.$posts->image)}}" class="picture-src" id="wizardPicturePreview" title=""/>  
                                       <input type="file" id="wizard-picture" name="image">
                                       @endif
                                    </div>
                                    <h6>Choose Picture</h6>
                                 </div>
                              </div>

                              <div class="col-md-10 m-b-20 pr-25">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group controls">
                                          <div class="form-group">
                                             <label for="fname" class="control-label">First Name <sup>*</sup></label>
                                             <input name="fname" id="fname" type="text" value="{{$posts->fname}}" class="form-control" required placeholder="Enter First Name">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group controls">
                                          <div class="form-group">
                                             <label class="control-label" for="lname">Last Name</label>
                                             <input name="lname" type="text" id="lname" value="{{$posts->lname}}" class="form-control" placeholder="Enter Last Name">
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-2">
                                      <div class="form-group controls">
                                        <div class="form-group">
                                           <label class="control-label" for="dob ">Date of Birth <sup>*</sup></label>
                                           <input name="dob" type="date" class="form-control" id="dob" onblur="compare('dob','dobError',' Date of birth should not be greater than current date.','nxt')" value="{{$posts->dob}}" required>
                                           <p class="text-danger" id="dobError"></p>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-md-2">
                                      <div class="form-group">
                                        <label for="gender">Gender <sup>*</sup> </label>
                                        <select  class="custom-select form-control" id="gender" name="gender" required>
                                          <option value="{{$posts->gender}}">{{$posts->gender}}</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <!-- End row -->
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group controls">
                                          <div class="form-group label-floating">
                                             <label class="control-label" for="birth_palce">Birth Place </label>
                                             <input name="birth_palce" id="birth_palce" type="text" class="form-control" value="{{$posts->birth_place}}">
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
                                             <input list="Mother_toungue" name="mother_tongue" type="text" id="mother_toungue" class="form-control" required value="Beary">
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
                                             <input list="Blood_Group" name="blood_group" type="text" class="form-control" id="blood_group" value="{{$posts->blood_group}}">
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
                                             <input list="occupation" type="text" name="occupation_name" class="custom-select form-control" id="Occupation" value="{{$posts->occupation_name}}" required>
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
                                             <input name="phone" type="text" id="Phone" class="form-control" value="{{$posts->phone}}">
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                       <div class="form-group controls">
                                          <div class="form-group label-floating">
                                             <label class="control-label">Mobile Number <small><sup>*</sup></small></label>
                                             <input type="number" name="mobile" class="form-control" id="Mobile" pattern="[1-9]{1}[0-9]{9}" maxlength="10" value="{{$posts->mobile}}" required>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-6">
                                       <div class="form-group controls">
                                          <div class="form-group label-floating">
                                             <label class="control-label">E-mail <small><sup> (optional)</sup></small></label>
                                             <input type="email" name="email" class="form-control" value="{{$posts->email}}">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- End row -->
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group controls">
                                          <div class="form-group label-floating">
                                             <label class="control-label">Hobbies <small>(followed by comma(,))<sup>(optional)</sup></small></label>
                                             <textarea name="hobbies" id="hobbies" rows="6" class="form-control">{{$posts->hobbies}}</textarea>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-6">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="goal">Area of  interest/ Future goal <small><sup>(optional)</sup></small></label>
                                          <textarea name="goal" id="goal" rows="6" class="form-control">@if($posts->goal != null){{$posts->goal}}@endif</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- End row -->
                              </div>
                           </div>
                           <!-- End Row -->
                        </div>
                        <!-- end personal info -->
                        <!-- Start otherDetails -->
                        <div class="tab-pane" id="otherDetails">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="living_status">HF-Id <small><sup>*</sup></small></label>
                                          <input name="hfid" type="text" class="form-control" id="hfid" required value="{{$posts->hfid}}">
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="living_status">Living Status <small><sup>*</sup></small></label>
                                          <input list="Living_status" name="living" type="text" class="form-control" id="living_status" value="{{$posts->living}}" required>
                                          <datalist id="Living_status">
                                             <option value="Yes"></option>
                                             <option value="No"></option>
                                          </datalist>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="role">Role in Family <small><sup>*</sup></small></label>
                                          <input list="Role" name="role" type="text" class="form-control" id="role" value="{{$posts->role}}" required>
                                          <datalist id="Role">
                                             <option value="Head"></option>
                                             <option value="Member"></option>
                                          </datalist>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="relation">Relation in Family <small><sup>*</sup></small></label>
                                          <input list="Relation" name="relation" type="text" class="form-control" id="relation" value="{{$posts->relation}}" required>
                                          <datalist id="Relation">
                                             <option value="Father/Husband"></option>
                                             <option value="Mother/Wife"></option>
                                             <option value="Son"></option>
                                             <option value="Duaghter"></option>
                                             <option value="Guardian"></option>
                                          </datalist>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="marital_status">Marital Status <small><sup>*</sup></small></label>
                                          <input list="Marital_status" name="marital_status" type="text" class="form-control" id="marital_status" value="{{$posts->marital_status}}" required>
                                          <datalist id="Marital_status">
                                             <option value="Married"></option>
                                             <option value="Single"></option>
                                          </datalist>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- end row -->

                              <div class="row">
                                 <div class="col-md-12">
                                    <hr>
                                    <div class="card-header">
                                       <h4 class="card-title">Document Details</h4>
                                    </div>
                                 </div>

                                 <div class="row">
                                 @if($posts->role == 'Head')
                                    <div class="col-md-6" id="rationDetails">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="Ration">Ration Card Number :</label>
                                                <input type="text" name="ration_no" class="form-control" value="{{ $posts->ration_no}}" id="Ration" placeholder="Enter Ration Card Number">
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
                                                <input type="number" name="adhar_no" class="form-control" value="{{$posts->adhar_no }}" id="Adhar" placeholder="Enter Adhar">
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

                              @if($posts->role == 'Head')
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
                                       <input type="text" name="door_no" class="form-control" id="door_no"  value="{{$posts->door_no}}">
                                    </div>
                                 </div>
                                 <div class="col-md-5">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="street">Area/ Street/ Village</label>
                                       <textarea name="street" id="street" rows="6" class="form-control">{{$posts->street_area}}</textarea>
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label for="belongs_to" class="control-label">Belongs To :</label>
                                       <select name="belongs_to" class="custom-select form-control" id="belongs_to">
                                          <option value="{{$posts->belongs_to}}">{{$posts->belongs_to}}</option>
                                          <option value="Rural">Rural</option>
                                          <option value="Semi-Rural">Semi-Rural</option>
                                          <option value="Urban">Urban</option>
                                       </select>
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                    <div class="form-group label-floating">
                                       <label for="city" class="control-label">Taluk/ City :</label>
                                       <input list="City" type="text" name="city" id="city" class="form-control" value="{{$posts->city}}" onblur="searchDataExists(this.value,'{{route('serachCity')}}','city_apps','city_id','City','city_id','inst')">
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
                                       <input list="district" type="text" name="district" id="District" class="form-control" value="{{$posts->district}}">
                                       <datalist id="district">
                                          <option value="Dakshina Kannada"></option>
                                          <option value="Udupi"></option>
                                       </datalist>
                                    </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group label-floating">
                                       <label for="state" class="control-label">State :</label>
                                       <input list="State" class="form-control" type="text" name="state" id="state" value="{{$posts->state}}">
                                       <datalist id="State">
                                          <option value="Karnataka"></option>
                                          <option value="Kerala"></option>
                                       </datalist>
                                    </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group label-floating">
                                       <label for="pincode" class="control-label">Pin Code :</label>
                                       <input type="number" name="pincode" class="form-control" id="pincode" value="{{$posts->pincode}}">
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>
                        </div>
                        <!-- end otherDetails -->
                        
                        <!-- Start History -->
                        <div class="tab-pane" id="History">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="present_door">Present Door Number <small><sup>*</sup></small> :</label>
                                       <input type="text" name="present_door" class="form-control" id="present_door" value="{{$posts->present_door}}" placeholder="Enter Present Door Number" required>
                                    </div>
                                 </div>   

                                 <div class="col-md-8">
                                    <div class="form-group">
                                       <label for="dojHSCC">Date of Join of HSCC <small><sup>*</sup></small> :</label>
                                       <input type="date" name="doj" class="form-control" value="{{$posts->doj}}" id="dojHSCC" required>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="Reason">Reason/Desperation <small><sup>*</sup></small> :</label>
                                       <textarea name="reason" id="Reason" rows="10" cols="10" class="form-control" placeholder="Enter your Reason/Desperation here..." required>{{$posts->reason}}</textarea>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="Familial">Familial/ Realtionship <small><sup>*</sup></small> :</label>
                                       <input list="familial" type="text" name="familial" class="custom-select form-control" id="Familial" required value="{{$posts->familial_relation}}">
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
                                      <input type="number" name="income" class="form-control" id="income" value="{{$posts->income}}" required>
                                    </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="income_source">Income source <small><sup>*</sup></small> :</label>
                                       <input type="text" name="income_source" class="form-control" id="income_source" value="{{$posts->income_source}}" required>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="HealthStatus">Health Status <small><sup>*</sup></small> :</label>
                                       <input list="healthStatus" type="text" name="HealthStatus" class="custom-select form-control" id="HealthStatus" required value="{{$posts->health_status}}">
                                       <datalist id="healthStatus">
                                          <option value="Good"></option>
                                          <option value="Healthy"></option>
                                       </datalist>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label for="Shelter">Shelter <small><sup>*</sup></small> :</label>
                                       <input list="shelter" type="text" name="shelter" class="custom-select form-control" id="Shelter" placeholder="Enter Shelter" required value="{{$posts->shelter}}">
                                       <datalist id="shelter">
                                          <option value="Owned">Owned</option>
                                          <option value="Rented">Rented</option>
                                          <option value="None">None</option>
                                       </datalist>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label for="SelfReliant">Self Reliant <small><sup>*</sup></small> :</label>
                                       <select class="custom-select form-control" id="SelfReliant" name="SelfReliant" required>
                                          <option value="{{$posts->self_reliant}}">{{$posts->self_reliant}}</option>
                                          <option value="Yes">Yes</option>
                                          <option value="No">No</option>
                                       </select>
                                    </div>
                                 </div>

                              </div>
                           </div>
                        </div>
                        <!-- end History -->

                        <!-- Start generalEducation -->
                        <div class="tab-pane" id="generalEducation">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="Qualification">Qualification <small><sup>*</sup></small></label>
                                       <input type="text" name="qualification" id="Qualification" value="{{$posts->qualification}}" class="form-control">
                                    </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="standard_grade">Grade <small><sup>*</sup></small></label>
                                       <input type="text" name="standard_grade" id="standard_grade" class="form-control" value="{{$posts->standard_grade}}">
                                    </div>
                                 </div>

                                 <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="year">Year <small><sup>*</sup></small></label>
                                       <input type="number" name="year" id="year" class="form-control">
                                       
                                    </div>
                                 </div>

                                 <div class="col-md-8">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="course_name">Course Name <small><sup>*</sup></small></label>
                                       <input type="text" name="course_name" id="course_name" class="form-control" value="{{$posts->course_name}}">
                                    </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group label-floating">
                                       <label for="stage" class="control-label">Stage <small><sup>*</sup></small> :</label>
                                       <input list="Stage" type="text" name="stage" class="custom-select form-control" id="stage" value="{{$posts->stage}}">
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
                                       <input list="Education_status" class="form-control" id="education_status" name="education_status" value="{{$posts->present_status}}">
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
                                       <input type="text" name="performance" class="custom-select form-control" id="Performance" value="{{$posts->performance}}">
                                    </div>
                                 </div>

                                 @if($posts->occupation_name == 'Student')
                                 <div class="col-md-12">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="strength">Strength <small><sup>*</sup></small></label>
                                       <textarea name="strength" id="strength" rows="6" class="form-control">
                                         {{$posts->strength}}
                                       </textarea>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="Weakness">Weakness <small><sup>*</sup></small></label>
                                       <textarea name="weakness" id="Weakness" rows="6" class="form-control">
                                          {{$posts->weakness}}
                                       </textarea>
                                    </div>
                                 </div>
                                 @endif
                                 <div class="col-md-12">
                                    <hr>
                                    <div class="card-header">
                                       <h4 class="card-title"> Institution Information 
                                          @if(ifAnd($posts->institution_name) == false)
                                          <span class="pull-right"> 
                                             <span class="addInst">
                                                Add Institution Info. <a class="btn btn-sm btn-outline-primary m-0 font-10" id="btnAdd" onclick="addInstitution('institution_info','addInst','removeInst','{{$inst}}','inst_choice')"><i class="ti-plus font-w-900"></i></a>
                                             </span>
                                             <span class="removeInst"  style="display: none;">
                                                Remove Institution Info. <a class="btn btn-sm btn-outline-primary m-0 font-10" id="btnDelete" onclick="removeInstitution('institution_info','removeInst','addInst','inst_choice')"><i class="ti-minus font-w-900"></i></a>
                                             </span>
                                          </span>
                                          @endif
                                          <input type="hidden" name="inst_choice" id="inst_choice" value="{{old('inst_choice')}}">
                                       </h4>
                                    </div>
                                 </div>
                                 
                                 @if(ifAnd($posts->institution_name) == true)
                                    <div class="col-md-9">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="Institution"><b>Institution Name </b></label>
                                          <input list="Institutions" type="text" name="institution_name" class="custom-select form-control" value="{{$posts->institution_name}}" id="Institution" onchange="selects(this.value,'Institutions','institution_id')">
                                          <datalist id="Institutions">
                                             @foreach($inst as $list)
                                             <option data-value="{{$list->id}}" value="{{$list->institution_name}}"></option>
                                             @endforeach
                                          </datalist>
                                          <input type="hidden" name="institution_id" id="institution_id" value="{{$posts->inst_id}}">

                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="location"><b>Exact Location </b></label>
                                          <input list="Location" type="text" name="location" class="custom-select form-control" id="location" value="{{$posts->location}}" required="">
                                          <datalist id="Location">
                                             <option value=""></option>
                                          </datalist>
                                       </div>
                                    </div>

                                    <div class="col-md-4">
                                       <div class="form-group label-floating">
                                          <label for="sector" class="control-label">Sector :</label>
                                          <input list="Sector" type="text" name="sector" class="custom-select form-control" id="sector" value="{{$posts->sector}}">
                                          <datalist id="Sector">
                                             <option value="Government"></option>
                                             <option value="Private"></option>
                                          </datalist>
                                       </div>
                                    </div>

                                    <div class="col-md-4">
                                       <div class="form-group label-floating">
                                          <label for="community_type" class="control-label">Community Type :</label>
                                          <input list="Community_type" type="text" name="community_type" class="custom-select form-control" id="community_type" value="{{$posts->community_type}}">
                                          <datalist id="Community_type">
                                             <option value="Community"></option>
                                             <option value="Non Community"></option>
                                          </datalist>
                                       </div>
                                    </div>

                                    <div class="col-md-4">
                                       <div class="form-group label-floating">
                                          <label for="institution_type" class="control-label">School/ College Category :</label>
                                          <input list="Institution_type" type="text" name="institution_type" class="custom-select form-control" id="institution_type" value="{{$posts->institution_category}}">
                                          <datalist id="Institution_type">
                                             <option value="CBSE"></option>
                                             <option value="State"></option>
                                             <option value="Other"></option>
                                          </datalist>
                                       </div>
                                    </div>

                                    <div class="col-md-12">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="inst_street">Area/ Street/ Village</label>
                                          <textarea name="inst_street" id="inst_street" rows="6" class="form-control">{{$posts->inst_street}}</textarea>
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="form-group label-floating">
                                          <label for="inst_city" class="control-label">Taluk/ City :</label>
                                          <input list="inst_City" type="text" name="inst_city" id="inst_city" class="form-control" value="{{$posts->inst_city}}">
                                          <datalist id="inst_City">
                                             <option value="Bantval"></option>
                                             <option value="Mangalore"></option>
                                             <option value="Belthangady"></option>
                                          </datalist>
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="form-group label-floating">
                                          <label for="inst_District" class="control-label">District :</label>
                                          <input list="inst_district" type="text" name="inst_district" id="inst_District" class="form-control" value="{{$posts->inst_district}}">
                                          <datalist id="inst_district">
                                             <option value="Dakshina Kannada"></option>
                                             <option value="Udupi"></option>
                                          </datalist>
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="form-group label-floating">
                                          <label for="inst_state" class="control-label">State :</label>
                                          <input list="inst_State" class="form-control" type="text" name="inst_state" id="inst_state" value="{{$posts->inst_state}}">
                                          <datalist id="inst_State">
                                             <option value="Karnataka"></option>
                                             <option value="Kerala"></option>
                                          </datalist>
                                       </div>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="form-group label-floating">
                                          <label for="inst_pincode" class="control-label">Pin Code :</label>
                                          <input type="number" name="inst_pincode" class="form-control" id="inst_pincode" value="{{$posts->pin_code}}">
                                       </div>
                                    </div>
                                 @else
                                 <div class="col-md-12 animated zoomIn institution_info"></div>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <!-- end generalEducation -->
                        <!-- Start services -->
                        @if(count($servCon) > 0)
                        <div class="tab-pane" id="services">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="card-header">
                                       <h4 class="card-title">Helps Needed</h4>
                                    </div>
                                 </div>
                                 @foreach($main->getServiceConcerns($posts->id,$hfId,$status) as $sh)
                                 @if($sh->service_type == 'concern')
                                 <div class="col-md-12">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="{{$sh->project_type}}_help">{{$main->getServiceTitle($sh->project_type)}} : </label>
                                          <textarea name="concerns[]" id="{{$sh->project_type}}_help" rows="6" class="form-control">{{$sh->description}}</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                              </div>

                              <div class="row">
                                 <div class="col-md-12">
                                    <hr>
                                    <div class="card-header">
                                       <h4 class="card-title">SERVICE OBTAINED FROM HSCC :</h4>
                                    </div>
                                 </div>
                                 @foreach($main->getServiceConcerns($posts->id,$hfId,$status) as $sh)
                                 @if($sh->service_type == 'service')
                                 <div class="col-md-12">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="{{$sh->project_type}}_servise">{{$main->getServiceTitle($sh->project_type)}} : </label>
                                          <textarea name="servises[]" id="{{$sh->project_type}}_servise" rows="6" class="form-control">{{$sh->description}}</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                                 
                              </div>
                           </div>
                        </div>
                        @endif
                        <!-- end services -->
                     </div>
                     <!-- end tab-content -->
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
                     <!-- end wizard-footer -->
                     @endforeach
                  </form>
                  <!-- End form -->
               </div>
               <!-- End card -->
            </div>
            <!-- End wizard-container -->
         </div>
         <!-- end main card -->
      </div>
      <!-- end col-md-12 -->
   </div>
@include('admin.Projects.JavasciptOperations.javascript_inside_laravel')
   <!-- end main rows -->
@stop
