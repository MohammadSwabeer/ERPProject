  @extends('admin.mainpage.adminmain')

  @section('admincontents')

          @include('admin.mainpage.pages._messages')
          
          <div class="row">

            <div class="col-md-12">

              <div class="wizard-container">
                <div class="card wizard-card br-5" data-color="blue" id="wizardProfile">
                  <form action="{{route('storeOtherStudents')}}" method="POST" enctype="multipart/form-data">
                       {{ csrf_field() }}
                    <input type="hidden" name="familyCategory" value="HSCC Family">
                    <div class="wizard-header" style="padding: 10px 0 20px;">
                      <h4 class="wizard-title font-NexaRustSans-Black">
                         Add Other Students Details
                      </h4>
                    </div>
                    <div class="wizard-navigation">
                      <ul>
                         <li><a href="#Personal" data-toggle="tab" style="font-weight:700 ">Personal Details</a></li>
                         <li><a href="#addresses" data-toggle="tab" style="font-weight:700 ">Address</a></li>
                      </ul>
                    </div>

                    <div class="tab-content">
                      <div class="tab-pane" id="Personal">
                        <div class="row p-10">
                            <div class="col-md-12 m-t-20">

                              <div class="row">
                                <div class="col-md-7">
                                   <div class="form-group controls">
                                      <div class="form-group">
                                         <label for="full_name"><b>Full Name <sup>(*)</sup></b></label>
                                         <input name="full_name" type="text" class="form-control" required id="full_name" placeholder="Enter Student's Full Name">
                                         <p class="animated zoomIn" style="color:red" id="fname"></p>
                                      </div>
                                   </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group controls">
                                    <div class="form-group">
                                       <label for="dob"><b>Date of Birth</b></label>
                                       <input name="dob" type="date" class="form-control" id="dob" onblur="compare('dob','dobError',' Date of birth should not be greater than current date.','nxt')">
                                       <p class="text-danger" id="dobError"></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label><b>Gender : </b></label>
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

                              <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="Mobile"><b>Contact Number</b></label>
                                       <input type="text" name="mobile" class="form-control" id="Mobile">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="college_name"><b>School/ College Name :</b></label>
                                     <input list="College_name" type="text" class="custom-select form-control" id="College_name" name="college_name">
                                     <datalist id='college_name'>
                                        <option value=""></option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="UP">UP</option>
                                     </datalist>
                                  </div>
                                </div>

                                <!-- <div class="col-md-3">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="Grade"><b>Grade/ Standard :</b></label>
                                     <input list="grade" type="text" class="custom-select form-control" name="grade" id="Grade" required>
                                     <datalist id='grade'>
                                        <option value=""></option>
                                     </datalist>
                                  </div>
                                </div> -->
                                <div class="col-md-4">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="Course"><b>Stream</b></label>
                                     <input list="course" type="text" class="custom-select form-control" id="Course" name="course" required>
                                     <datalist id='course'>
                                       <option value=""></option>
                                        <option value="Science"></option>
                                        <option value="Commerce"></option>
                                        <option value="Arts"></option>
                                     </datalist>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="perfomance"><b>Perfomance</sup> :</b></label>
                                     <input type="text" class="custom-select form-control" id="perfomance" name="perfomance">
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="rank_name"><b>Rank Name</sup> :</b></label>
                                     <input type="text" class="custom-select form-control" id="rank_name" name="rank_name" value="CET,NEET">
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="rank_list"><b>Rank List</sup> :</b></label>
                                     <input type="text" class="custom-select form-control" id="rank_list" name="rank_list">
                                  </div>
                                </div>
                                <!-- <div class="col-md-5">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="caddress"><b>School/ College Place/ Address</b></label>
                                         <textarea name="caddress" id="caddress" rows="6" class="form-control"></textarea>
                                      </div>
                                </div> -->
                                <div class="col-md-12">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="goal"><b>Future Goal/ Area of Interest</b></label>
                                         <textarea name="goal" id="goal" rows="6" class="form-control"></textarea>
                                      </div>
                                </div>
                                <!-- <div class="col-md-3">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="remark"><b>Remark</b></label>
                                         <select class="form-control" name="remark" id="remark" onchange="findRemark(this.value,'Remarks')">
                                           <option value="">Select Remark</option>
                                           <option value="Drop Out">Drop Out</option>
                                           <option value="Admission">Admission</option>
                                         </select>
                                      </div>
                                </div> -->
                                <!-- <div class="col-md-4">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="remarkReason"><b>Reason</b></label>
                                         <input list="Remarks" type="text" class="form-control" name="remarkReason" id="remarkReason">
                                         <datalist id="Remarks">
                                            <option>Select</option>
                                         </datalist>
                                      </div>
                                </div> -->
                              </div>

                              <div class="row">
                                <div class="col-md-4">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="father_name"><b>Father's Name</b></label>
                                         <input type="text" class="custom-select form-control" id="father_name" name="father_name">
                                      </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="f_occupation"><b>Father's Occupation</b></label>
                                       <input type="text" class="custom-select form-control" id="f_occupation" name="f_occupation">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="mother_name"><b>Mother's Name</b></label>
                                         <input type="text" class="custom-select form-control" id="mother_name" name="mother_name">
                                      </div>
                                </div>
                                <div class="col-md-6">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="m_occupation"><b>Mother's Occupation</b></label>
                                         <input type="text" class="custom-select form-control" id="m_occupation" name="m_occupation">
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="p_mobile"><b>Parents Contact Number</b></label>
                                       <input type="text" name="p_mobile" class="form-control" id="p_mobile">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="annual"><b>Annual Income</b></label>
                                       <input type="number" name="annual" class="form-control" id="annual">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="feedback"><b>Feedback</b></label>
                                       <textarea name="feedback" id="feedback" rows="6" class="form-control"></textarea>
                                    </div>
                                </div>
                             </div>
                            </div>
                          </div>
                        </div>

                        <!--Address Tab  -->
                        <div class="tab-pane p-10" id="addresses" style="background-color: #f8f8f8">
                           <section class="p-10">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="row">
                                      <h4 class="text-center"> <span><i class="fa  fa-map-marker"></i></span> Present Address</h4>
                                      <hr>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-8">
                                      <div class="form-group">
                                         <label for="presentStreet">Area, Colony, Street, Sector, Village:  :</label>
                                         <input type="text" name="presentStreet" class="form-control" id="presentStreet" placeholder="Enter Area, Colony, Street, Sector, Village">
                                      </div>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                         <label for="Belongs">Belongs To</label>
                                         <input list="belongs" type="text" class="custom-select form-control" id="Belongs" name="belongs" placeholder="Enter Belongs to">
                                         <datalist id='belongs'>
                                            <option value="Urban"></option>
                                            <option value="Rural"></option>
                                         </datalist>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="presentCity">City :</label>
                                           <input type="text" list="PresentCity" name="presentCity" id="presentCity" class="form-control" placeholder="Enter City">
                                           <datalist id='PresentCity'>
                                            <option value="">Select District</option>
                                            <option value="Mangalore">Mangalore</option>
                                            <option value="Bantval">Bantval</option>
                                            <option value="Bantval">Putture</option>
                                          </datalist>
                                        </div>
                                     </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                         <label for="District">District :</label>
                                         <input list="district" type="text" class="custom-select form-control" id="District" name="district" placeholder="Enter District" required>
                                         <datalist id='district'>
                                            <option value="">Select District</option>
                                            <option value="Dakshin Kannada">Dakshin Kannada</option>
                                            <option value="Udupi">Udupi</option>
                                         </datalist>
                                      </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="presentState">State :</label>
                                           <input type="text" list="PresentState" name="presentState" class="form-control"  id="presentState" placeholder="Enter State">
                                            <datalist id='PresentState'>
                                              <option value="">Select state</option>
                                              <option value="Karnataka">Karnataka</option>
                                              <option value="Kerala">Kerala</option>
                                            </datalist>
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="presentPin">Pin Code :</label>
                                           <input type="number" name="presentPin" class="form-control" id="presentPin" placeholder="Enter pin/postal code">
                                        </div>
                                     </div>
                                  </div>
                                </div>
                              </div>
                            </section>
                          </div>
                    </div>

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
                  </form>
                </div>
              </div> <!-- wizard container -->
            </div>
          </div>
  @endsection
