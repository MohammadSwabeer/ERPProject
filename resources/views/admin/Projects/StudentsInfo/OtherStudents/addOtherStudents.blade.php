  @extends('admin.mainpage.adminmain')

  @section('admincontents')

          @include('admin.mainpage.pages._messages')
          
          <div class="row">

            <div class="col-md-12">

              <div class="wizard-container">
                <div class="card wizard-card br-5" data-color="blue" id="wizardProfile">
                  <form action="{{route('storeATTStudents')}}" method="POST" enctype="multipart/form-data">
                       {{ csrf_field() }}
                    <input type="hidden" name="category" value="{{$type}}">
                    <input type="hidden" name="hfname" value="{{($type == 'Database') ? 'HFDBS' : 'HFWAS'}}">
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
                                         <input name="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required id="full_name" placeholder="Enter Student's Full Name">
                                         @error('full_name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                         @enderror
                                         <p class="animated zoomIn" style="color:red" id="full_name"></p>
                                      </div>
                                   </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group controls">
                                    <div class="form-group">
                                       <label for="dob"><b>Date of Birth</b></label>
                                       <input name="dob" type="date" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" id="dob" onblur="compare('dob','dobError',' Date of birth should not be greater than current date.','nxt')">
                                       <p class="text-danger" id="dobError"></p>
                                       <span>
                                         @error('dob')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                         @enderror
                                       </span>
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
                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="hfId"><b>HF Id :</b></label>
                                       <input type="text" name="hfId" class="form-control @error('hfId') is-invalid @enderror" value="{{ old('hfId') }}" id="hfId" required>
                                        @error('hfId')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="Mobile"><b>Contact Number</b></label>
                                       <input type="number" name="mobile" maxlength="10" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" id="Mobile" required>
                                        @error('mobile')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="email"><b>E-mail</b></label>
                                       <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email">
                                        @error('email')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="colleges_name"><b>School/ College Name :</b></label>
                                     <input list="College_name" type="text" class="custom-select form-control" id="colleges_name" onchange="findDDValue(this.value,'college_name','College_name')" name="colleges_name" value="{{ old('colleges_name') }}">
                                     <input type="hidden" name="school_college_name" id="college_name" value="{{ old('school_college_name') }}">
                                     <datalist id='College_name'>
                                        <option value=""></option>
                                        <option data-value="1" value="Karnataka"></option>
                                        <option data-value="2" value="Kerala"></option>
                                        <option data-value="3" value="UP"></option>
                                     </datalist>
                                  </div>
                                </div>

                                <div class="col-md-2">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="Grade"><b>Grade/ Standard :</b></label>
                                     <input list="grade" type="text" class="custom-select form-control" name="qualification" id="Grade" value="{{ old('qualification') }}">
                                     <datalist id='grade'>
                                        <option value=""></option>
                                     </datalist>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-group label-floating">
                                     <label class="control-label" for="Course"><b>Course/ Stream</b></label>
                                     <input list="course" type="text" class="custom-select form-control" id="Course" name="course" value="{{ old('course') }}">
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
                                     <label class="control-label" for="perfomance"><b>Perfomance :</b></label>
                                     <input type="text" class="custom-select form-control" id="perfomance" name="performance" value="{{ old('performance') }}">
                                  </div>
                                </div>
                                
                                <div class="col-md-12">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group form-inline">
                                        <label>Any Rank Info ? : &nbsp;&nbsp;&nbsp;</label>
                                        <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                            <input type="radio" value="Yes" name="confirm" id="yes" class="custom-control-input">
                                            <label class="custom-control-label" for="yes" onclick="btnSubmit('ranks')">Yes</label>
                                          </div>
                                          <div class="help-block" ></div>
                                        </fieldset>&nbsp;&nbsp;
                                        <fieldset>
                                          <div class="custom-control custom-radio">
                                            <input type="radio" value="No" name="confirm" id="no" class="custom-control-input">
                                            <label class="custom-control-label" for="no" onclick="btnNo('ranks')">No</label>
                                          </div>
                                        </fieldset>
                                        <!-- <h4>If Yes then add the details...</h4> -->
                                      </div>
                                    </div>
                                    <div class="col-md-8">
                                      <div class="form-group pull-right" id="ranks" style="display: none">
                                        <label>if <b>Yes</b> add here : </label>
                                        <a class="btn btn-sm btn-outline-primary m-0 font-8" id="btnAdd" onclick="addFieilds('rank','show')"><i class="ti-plus font-w-900"></i></a>
                                        <a class="btn btn-sm btn-outline-primary m-0 font-8" id="btnDelete" onclick="deleteFieilds()"><i class="ti-minus font-w-900"></i></a>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row" id="show"></div>

                                </div>

                                <div class="col-md-12">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="goal"><b>Future Goal/ Area of Interest</b></label>
                                         <textarea name="goal" id="goal" rows="6" class="form-control">{{ old('goal') }}</textarea>
                                      </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="father_name"><b>Father's Name</b></label>
                                         <input type="text" class="custom-select form-control" id="father_name" name="father_name" value="{{ old('father_name') }}">
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="father_occupation"><b>Father's Occupation</b></label>
                                       <input type="text" class="custom-select form-control" id="father_occupation" name="father_occupation" value="{{ old('father_occupation') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="mother_name"><b>Mother's Name</b></label>
                                         <input type="text" class="custom-select form-control" id="mother_name" name="mother_name" value="{{ old('mother_name') }}">
                                      </div>
                                </div>
                                <div class="col-md-6">
                                      <div class="form-group label-floating">
                                         <label class="control-label" for="mother_occupation"><b>Mother's Occupation</b></label>
                                         <input type="text" class="custom-select form-control" id="mother_occupation" name="mother_occupation" value="{{ old('mother_occupation') }}">
                                      </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="p_mobile"><b>Parents Contact Number 1</b></label>
                                       <input type="number" name="contact" class="form-control" id="p_mobile" value="{{ old('contact') }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="contact2"><b>Parents Contact Number 2</b></label>
                                       <input type="number" name="contact2" class="form-control" id="contact2" value="{{ old('contact2') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="annual"><b>Annual Income</b></label>
                                       <input type="number" name="annual" class="form-control" id="annual" value="{{ old('annual') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                       <label class="control-label" for="feedback"><b>Feedback</b></label>
                                       <textarea name="feedback" id="feedback" rows="6" class="form-control">{{ old('feedback') }}</textarea>
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
                                    <div class="col-md-12">
                                      <div class="form-group">
                                         <label for="full_address">Area, Colony, Street, Sector, Village:  :</label>
                                         <input type="text" name="full_address" class="form-control" id="full_address" placeholder="Enter Area, Colony, Street, Sector, Village" value="{{ old('full_address') }}">
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="presentCity">City :</label>
                                           <input type="text" list="PresentCity" name="presentCity" id="presentCity" class="form-control" placeholder="Enter City" value="{{ old('presentCity') }}">
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
                                         <input list="district" type="text" class="custom-select form-control" id="District" name="district" placeholder="Enter District" value="{{ old('district') }}">
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
                                           <input type="text" list="PresentState" name="presentState" class="form-control"  id="presentState" placeholder="Enter State" value="{{ old('presentState') }}">
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
                                           <input type="number" name="pincode" class="form-control" id="presentPin" placeholder="Enter pin/postal code" value="{{ old('pincode') }}">
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
