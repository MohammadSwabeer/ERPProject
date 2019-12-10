   <?php  use \App\Http\Controllers\MainController; $main = new MainController;  ?>
   @extends('admin.mainpage.adminmain')

   @section('admincontents')
   <?php $title = $main->getBCTitle($type,'profile', $personCat, $page,'','edit'); 
     $routes = $main->getBCRoutes($page,$personCat);
     $hfId = $main->find_field_data('families_models','hfId',$id)[0]->hfId
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
         <div class="accordion" id="accordionOther">
            <form action="{{route('updateHSCCFamilyDetails')}}" method="POST" enctype="multipart/form-data" class="contents">
            <div class="card bg-white box-shadow-e br-5">
               <a data-toggle="collapse" data-target="#collapseMain" aria-expanded="true" aria-controls="collapseMain">
                  <div class="card-header bg-white" id="headingMain">
                     <h4 class="mb-0 font-18 font-w-700"> MODIFY PERSONAL INFORMATION </h4>
                  </div>
              </a>
              
              <div id="collapseMain" class="collapse show" aria-labelledby="headingMain" data-parent="#accordionOther">
                  <div class="wizard-container">
                    <div class="wizard-card br-5" style="box-shadow : none;" data-color="blue" id="wizardProfile">
                     
                        <div class="row">
                           <div class="col-md-2">
                              <div class="form-group picture-container">
                                 <div class="picture">
                                    <img src="{{asset('adminAssets/images/default/user-default.png')}}" class="picture-src" id="wizardPicturePreview" title=""/>  
                                    <input type="file" id="wizard-picture" name="image">
                                 </div>
                                 <h6>Choose Picture</h6>
                              </div>
                           </div>

                           <div class="col-md-10 m-b-20 m-t-20 pr-25">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group controls">
                                       <div class="form-group">
                                          <label for="fname" class="control-label">First Name <sup>*</sup></label>
                                          <input name="fname" id="fname" type="text" class="form-control" required placeholder="Enter First Name">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group controls">
                                       <div class="form-group">
                                          <label class="control-label" for="lname">Last Name</label>
                                          <input name="fname" type="text" id="lname" class="form-control" placeholder="Enter Last Name">
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-2">
                                   <div class="form-group controls">
                                     <div class="form-group">
                                        <label class="control-label" for="dob ">Date of Birth <sup>*</sup></label>
                                        <input name="dob" type="date" class="form-control" id="dob" onblur="compare('dob','dobError',' Date of birth should not be greater than current date.','nxt')" required>
                                        <p class="text-danger" id="dobError"></p>
                                     </div>
                                   </div>
                                 </div>

                                 <div class="col-md-2">
                                   <div class="form-group">
                                     <label for="gender">Gender <sup>*</sup> </label>
                                     <select  class="custom-select form-control" id="gender" name="gender" required>
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
                                          <input name="birth_palce" id="birth_palce" type="text" class="form-control">
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-2">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label" for="relegion">Relegion<sup>*</sup> </label>
                                          <input list="Relegion" name="fname" type="text" class="form-control" required id="relegion">
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
                                          <input list="Mother_toungue" name="mother_toungue" type="text" id="mother_toungue" class="form-control" required>
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
                                          <input list="Nationality" name="fname" type="text" class="form-control" required id="nationality">
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
                                          <input list="Blood_Group" name="blood_group" type="text" class="form-control" id="blood_group">
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
                                          <label class="control-label">Occupation <sup>*</sup></label>
                                          <input name="fname" type="text" class="form-control" required>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label">Phone </label>
                                          <input name="fname" type="text" class="form-control" required>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-md-6">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label">Mobile Number <small><sup>*</sup></small></label>
                                          <input type="number" name="mobile" class="form-control" id="Mobile" pattern="[1-9]{1}[0-9]{9}" maxlength="10">
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label">E-mail <small><sup> (optional)</sup></small></label>
                                          <input type="email" name="email" class="form-control">
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
                                          <textarea name="hobbies" id="hobbies" rows="6" class="form-control"></textarea>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group controls">
                                       <div class="form-group label-floating">
                                          <label class="control-label">Area of  interest/ Future goal <small><sup>(optional)</sup></small></label>
                                          <textarea name="goal" id="goal" rows="6" class="form-control"></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- End row -->
                           </div>

                        </div>
                        
                    </div>
                  </div>
               </div>
                  
            </div>
            <!-- End card -->

            <div class="card bg-white box-shadow-e br-5">
               <a data-toggle="collapse" data-target="#collapseMain1" aria-expanded="true" aria-controls="collapseMain1">
                  <div class="card-header bg-white" id="headingMain1">
                     <h4 class="mb-0 font-18 font-w-700"> MODIFY PERSONAL INFORMATION </h4>
                  </div>
              </a>
              
              <div id="collapseMain1" class="collapse" aria-labelledby="headingMain1" data-parent="#accordionOther">
                  <div class="wizard-container">
                    <div class="wizard-card br-5" style="box-shadow : none;" data-color="blue" id="wizardProfie">
                     
                        <div class="row">
                           <div class="col-md-10 m-b-20 m-t-20 pr-25">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group controls">
                                       <div class="form-group">
                                          <label for="dd" class="control-label">First Name <sup>*</sup></label>
                                          <input name="fname" id="dd" type="text" class="form-control" required placeholder="Enter First Name">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                        </div>
                        
                    </div>
                  </div>
               </div>
                  
            </div>
         </div>
            <div class="row">
                     <input type="submit" name="submit" class="btn btn-block btn-primary" value="Submit">
                  </div>
            </form>
         </div> 
      </div>
   </div>
   @endsection
