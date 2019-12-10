	@extends('admin.mainpage.adminmain')

	@section('admincontents')

					<!-- <div class="row page-titles">
				        <div class="col-md-12">
				          <div class="d-flex">
				            <ol class="breadcrumb">
				              <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
				              <li class="breadcrumb-item"><a href="{{route('ATTStaffsView')}}">ATT Staffs Information</a></li>
				              <li class="breadcrumb-item active">Add ATT Staffs Information</li>
				            </ol>
				          </div>

				        </div>
				      </div> -->
					<div class="row">
						<div class="col-12">
							@if(Session::has('success'))
							<div class="alert alert-success">{{Session::get('success')}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button></div>
							@endif

							@if(Session::has('error'))
							<div class="alert alert-danger">{{Session::get('error')}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button></div>
							@endif
						</div>
						<div class="col-md-12">
							<div class="wizard-container">
								<div class="card wizard-card" data-color="green" id="wizardProfile">
	       						 @include('admin.mainpage.pages.form-preload')
									<form action="{{route('storeATTStaffDetails')}}" method="POST" id="memberForm" enctype="multipart/form-data" class="contents" style="display: none;">
										{{ csrf_field() }}
										<input type="hidden" class="custom-select form-control" name="unit" value="HQ Mangalore">
										<div class="wizard-header" style="padding: 10px 0 20px;">
											<h4 class="wizard-title font-NexaRustSans-Black">
												Add att staff details
											</h4>
										</div>
										<div class="wizard-navigation">
											<ul>
												<li><a href="#about" data-toggle="tab">Personal Info.</a></li>
												<li><a href="#address" data-toggle="tab">Address</a></li>
												<li><a href="#company" data-toggle="tab">Company Details</a></li>
											</ul>
										</div>

										<div class="tab-content">
											<div class="tab-pane" id="about">

												<input type="hidden" name="hfname" value="HFATT">
												<input type="hidden" name="type" value="ATT">

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
													<div class="col-md-10">

														<div class="row">
															<div class="col-md-4">
																<div class="form-group label-floating">
																	<label class="control-label">First Name <small>(*)</small></label>
																	<input class="form-control @error('member_fname') is-invalid @enderror" type="text" title="Enter name" required="" name="member_fname" value="{{ old('member_fname') }}">
																</div>
																@error('member_fname')
			                                          <span class="invalid-feedback" role="alert">
			                                              <strong>{{ $message }}</strong>
			                                          </span>
			                                       @enderror 
															</div>
															<div class="col-md-4">
																<div class="form-group label-floating">
																	<label class="control-label">Middle Name <small>(*)</small></label>
																	<input class="form-control" type="text" name="member_mname" value="{{ old('member_mname') }}">
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group label-floating">
																	<label class="control-label">Last Name</label>
																	<input type="text" name="member_lname" class="form-control" value="{{ old('member_lname') }}">
																</div>
															</div>
														</div>

														<div class="row">
															<div class="col-md-2">
																<div class="form-group">
																	<label for="hfId">HF-Id </label>
																	<input name="hfId" type="text" id="hfId" value="{{ old('hfId') }}" class="form-control @error('hfId') is-invalid @enderror" placeholder="Enter HF-Id" required>
																</div>
																@error('hfId')
			                                          <span class="invalid-feedback" role="alert">
			                                              <strong>{{ $message }}</strong>
			                                          </span>
			                                       @enderror 
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="email">E-mail Address </label>
																	<input name="email" type="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter E-mail" required>
																	@error('email')
			                                          	<span class="invalid-feedback" role="alert">
			                                              	<strong>{{ $message }}</strong>
			                                          	</span>
			                                       	@enderror
																</div>
															</div>

															<div class="col-md-4">
																<div class="form-group">
																	<label for="dob">Date of Birth </label>
																	<input name="dob" type="date" class="form-control" id="dob" required="" onblur="compare('dob','dobError','Birth date should not be greater than current date.')" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
																	<p class="text-danger" id="dobError"> </p>
																	@error('dob')
						                                    <span class="invalid-feedback" role="alert">
						                                        <strong>{{ $message }}</strong>
						                                    </span>
						                                 @enderror
																</div>
															</div>
															<div class="col-md-2">
						                              <div class="form-group">
						                                  <label>Gender : </label>
						                                  <fieldset class="controls">
						                                    <div class="custom-control custom-radio">
						                                        <input type="radio" value="Male" name="gender" id="styled_radio1" class="custom-control-input" aria-invalid="false" checked="checked">
						                                        <label class="custom-control-label" for="styled_radio1">Male</label>
						                                    </div>
						                                    <!-- <div class="help-block" ></div> -->
						                                	</fieldset>
						                                	<fieldset>
						                                    	<div class="custom-control custom-radio">
						                                        <input type="radio" value="Female" name="gender" id="styled_radio2" class="custom-control-input" aria-invalid="false">
						                                        <label class="custom-control-label" for="styled_radio2">Female</label>
						                                    	</div>
						                                	</fieldset>
						                            	</div>
						                        	</div>
														</div>

														<div class="row">

															<div class="col-md-4">
																<div class="form-group">
																	<label for="doj">Date of Joining HF </label>
																	<input name="doj" type="date" class="form-control" aria-required="true" required="" id="doj" onblur="compare('doj','dojError','Join date should not be greater than current date.')" class="form-control @error('doj') is-invalid @enderror" value="{{ old('doj') }}">
																	@error('doj')
						                                    <span class="invalid-feedback" role="alert">
						                                        <strong>{{ $message }}</strong>
						                                    </span>
						                                 @enderror
																	<p class="text-danger" id="dojError"> </p>
																</div>
															</div>

															<div class="col-md-8">
																<div class="form-group">
																	<label for="qualification">Educational Qualification </label>
																	<input name="qualification" id="qualification" type="text" class="form-control" required="" spellcheck="true" value="{{ old('qualification') }}" placeholder="Enter Qualification">
																</div>
															</div>
														</div>

													</div>
												</div>

											</div>
											<div class="tab-pane" id="address">
												<section>
													<div class="container">
														<div class="row" style="margin-top: 40px;">
															<h4>Permanent Address</h4>
															<div class="col-md-12">
																<div class="form-group label-floating">
																	<label for="paddress" class="control-label">Full Address :</label>
																	<textarea name="p_address" id="Address" cols="10" rows="4" class="form-control"spellcheck="true" required="">{{ old('p_address') }}</textarea>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group label-floating">
																	<label for="Phone" class="control-label">Phone No. :</label>
																	<input type="number" name="phone" value="{{ old('phone') }}" class="form-control input-group" id="Phone"  required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group label-floating">
																	<label for="Residence" class="control-label">Residence :</label>
																	<input type="text" name="p_residence" value="{{ old('p_residence') }}" class="form-control" id="Residence" required="">
																</div>
															</div>
														</div>

														<div class="row" style="margin-top: 20px;">
															<h4>Residence Address</h4>
															<div class="col-md-12">
																<div class="form-group label-floating">
																	<label for="raddress" class="control-label">Full Address :</label>
																	<textarea name="r_address" id="street" cols="10" rows="4" class="form-control" spellcheck="true">{{ old('r_address') }}</textarea>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group label-floating">
																	<label for="Mobile" class="control-label">Mobile No. :</label>
																	<input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control input-group" id="Mobile">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group label-floating">
																	<label for="rResidence" class="control-label">Residence :</label>
																	<input type="text" name="rresidence" value="{{ old('rresidence') }}" class="form-control" id="rResidence">
																</div>
															</div>
														</div>
													</div>

												</section>
											</div>

											<div class="tab-pane" id="company">
												<section>
													<div class="container">
														<div class="row">
															<div class="col-md-8">
																<div class="form-group label-floating">
																	<label for="employment" class="control-label"><b>Designation :</b></label>
																	<input type="text" name="employment" value="{{ old('employment') }}" class="form-control" id="employment" required="">
																</div>
															</div>

															<input type="hidden" name="company_name" value="Arabic Teachers Training">
															<div class="col-md-4">
																<div class="form-group label-floating">
																	<label for="position" class="control-label"><b>Position Held :</b></label>
																	<input type="text" name="position" value="{{ old('position') }}" class="form-control" id="position" spellcheck="true">
																</div>
															</div>

														</div>

														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="since"><b>Working since :</b></label>
																	<input type="date" name="since" value="{{ old('since') }}" class="form-control" id="since">
																</div>
															</div>

															<div class="col-md-6">
																<div class="form-group">
																	<label for="expertise"><b>Area of Expertise :</b></label>
																	<textarea name="expertise" id="expertise" rows="5" class="form-control"spellcheck="true" placeholder="Enter Area of Expertise">{{ old('expertise') }}</textarea>
																</div>
															</div>

															<div class="col-md-12">
																<div class="form-group label-floating">
																	<label for="skills" class="control-label"><b>Contributable Skills :</b></label>
																	<textarea name="skills" id="skills" rows="5" class="form-control" spellcheck="true">{{ old('skills') }}</textarea>
																</div>
															</div>
														</div>

														<div class="row">
															<div class="col-md-4">
													         <div class="form-group">
														         <label for="other_organisation"><b>Organisation Name :</b></label>
														         <textarea name="other_organisation" id="other_organisation" cols="10" rows="4" class="form-control" placeholder="Enter Organisation name">
														         	{{ old('other_organisation') }}
														         </textarea>
													         </div>
													      </div>
													      <div class="col-md-4">
													         <div class="form-group">
														         <label for="member_since"><b>Worked For :</b></label>
														         <input type="date" name="member_since" value="{{ old('member_since') }}" class="form-control" id="member_since">
													         </div>
												         </div>
												         <div class="col-md-4">
													         <div class="form-group">
														         <label for="position_held"><b>Position Held :</b></label>
														         <input type="text" name="position_held" value="{{ old('position_held') }}" class="form-control" id="position_held" placeholder="Enter Postion held">
													         </div>
												         </div>
														</div>

													</div>
												</section>
											</div>
										</div>

										<div class="wizard-footer">
											<div class="form-group pull-right">
												<input type='button' class='btn btn-next btn-fill btn-primary btn-wd' name='next' value='Next' style="background:  #4caf50" />
												<input type='submit' class='btn btn-finish btn-fill btn-primary btn-wd' name='submit' value='Submit' style="background: #4caf50"/>
											</div>
											<div class="form-group pull-left">
												<input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous'/>
											</div>
											<!-- <div class="clearfix"></div> -->
										</div>

									</form>
								</div>
							</div> <!-- wizard container -->
						</div>
					</div>
				</div>
				<!-- End PAge Content -->
		<script type="text/javascript">
			window.onload = function(){
				document.getElementById('otherOrg').style.display= 'none';
				// document.getElementById('btnDelete').style.display= 'none';
			}
		</script>
		
	@endsection
