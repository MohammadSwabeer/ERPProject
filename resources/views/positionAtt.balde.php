<div class="tab-content">
						<div class="tab-pane" id="about">

							<div class="row">
								<div class="col-md-2">
									<div class="form-group picture-container">
										<div class="picture">
											<img src="{{asset('adminAssets/images/default/user-default.png')}}" class="picture-src" id="wizardPicturePreview" title="Student Image"/>
											<input type="file" id="wizard-picture" name="stud_image3" id="stud_image">
										</div>
										<h6>Choose Picture</h6>
									</div>
								</div>
								<div class="col-md-10">

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label">Full Name <small>(*)</small></label>
												<input type="text" title="Enter name" required="" name="full_name2" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" placeholder="Enter Full Name">
												@error('full_name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror 
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group">
												<label class="control-label">HF-Id <small>(*)</small></label>
												<input type="text" title="Enter HF-Id" required name="hfId1" class="form-control @error('hfId') is-invalid @enderror" value="{{ old('hfId') }}" placeholder="Enter HF-Id">
												@error('hfId')
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
														<input type="radio" value="Male" name="gender5" id="styled_radio1" class="custom-control-input" aria-invalid="false" checked="checked">
														<label class="custom-control-label" for="styled_radio1">Male</label>
													</div>
													<!-- <div class="help-block" ></div> -->
												</fieldset>
												<fieldset>
													<div class="custom-control custom-radio">
														<input type="radio" value="Female" name="gender5" id="styled_radio2" class="custom-control-input" aria-invalid="false">
														<label class="custom-control-label" for="styled_radio2">Female</label>
													</div>
												</fieldset>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="stud_email" class="control-label">E-mail Address </label>
												<input name="stud_email8" type="email" id="stud_email" class="form-control @error('email') is-invalid @enderror" value="{{ old('stud_email') }}" required>
												@error('stud_email')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror 
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="stud_phone" class="control-label">Student Phone </label>
												<input name="stud_phone7" type="number" id="stud_phone" class="form-control @error('stud_cell') is-invalid @enderror" value="{{ old('stud_cell') }}">
												@error('stud_cell')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="stud_cell" class="control-label">Student Cell </label>
												<input name="stud_cell6" type="number" id="stud_cell" class="form-control" value="{{ old('stud_cell') }}">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="stud_dob">Date of Birth </label>
												<input name="stud_dob4" type="date" class="form-control" id="stud_dob" required onblur="compare('stud_dob','dobError','Birth date should not be greater than current date.')" value="{{ old('stud_dob') }}">
												<p class="text-danger" id="dobError"> </p>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="birth_place">Place of Birth </label>
												<input name="birth_place12" type="text" class="form-control" id="birth_place" value="{{ old('birth_place12') }}">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="stud_marital">Marital Status </label>
												<select  class="custom-select form-control" id="stud_marital" name="stud_marital19" onchange="ifExists(this.value,'husbandDiv','Single')" required>
													<option value="Select">Select</option>
													<option value="Married">Married</option>
													<option value="Single">Single</option>
												</select>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="nationality" class="control-label">Nationality </label>
												<input list="Nationality" name="nationality13" type="text" class="form-control" id="nationality" value="{{ old('nationality') }}">
												<datalist id="Nationality">
													<option></option>
												</datalist>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="relegion" class="control-label">Relegion </label>
												<input list="Relegion" name="relegion14" type="text" class="form-control" id="relegion" value="{{ old('relegion') }}">
												<datalist id="Relegion">
													<option></option>
												</datalist>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="mother_tongue" class="control-label">Mother Tongue </label>
												<input list="Tongue" name="mother_tongue15" type="text" class="form-control" id="mother_tongue" value="{{ old('mother_tongue') }}">
												<datalist id="Tongue">
													<option></option>
												</datalist>
											</div>
										</div>

											<div class="col-md-12">
												<h4>Address of the Student</h4>
											</div>
											<div class="col-md-10">
												<div class="form-group label-floating">
													<label for="full_address" class="control-label"><b>Full Address :</b></label>
													<input type="text" name="full_address38" class="form-control" id="full_address" value="{{ old('full_address38') }}" required>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group label-floating">
													<label for="pincode" class="control-label"><b>Pincode :</b></label>
													<input type="number" name="pincode41" class="form-control" id="pincode" value="{{ old('pincode41') }}" required>
												</div>
											</div>
										</div>
								</div>
							</div>

						</div>

						<div class="tab-pane" id="Family">
							<section>
								<div class="container">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="father_name" class="control-label"><b>Father's Name :</b></label>
												<input type="text" name="father_name2" class="form-control" id="father_name" value="{{ old('father_name2') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="father_occupation" class="control-label"><b>Father's Occupation :</b></label>
												<input type="text" name="father_occupation21" class="form-control" id="father_occupation" value="{{ old('father_occupation21') }}">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-5">
											<div class="form-group label-floating">
												<label for="mother_name" class="control-label"><b>Mother Name :</b></label>
												<input type="text" name="mother_name2" class="form-control" id="mother_name" value="{{ old('mother_name2') }}">
											</div>
										</div>

										<div class="col-md-5">
											<div class="form-group label-floating">
												<label for="mother_occupation" class="control-label"><b>Mother Occupation :</b></label>
												<input type="text" name="mother_occupation21" class="form-control" id="mother_occupation" value="{{ old('mother_occupation21') }}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group label-floating">
												<label for="annual" class="control-label"><b>Annual Income :</b></label>
												<input type="text" name="annual29" class="form-control" id="annual" value="{{ old('annual29') }}">
											</div>
										</div>
									</div>

									<div class="row" id="husbandDiv">
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="husband_name" class="control-label"><b>Husband's Name (if married):</b></label>
												<input name="husband_name2" id="husband_name" class="form-control" value="{{ old('husband_name2') }}"> 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="husband_occupation" class="control-label"><b>Husband's Occupation :</b></label>
												<input type="text" name="husband_occupation21" value="" class="form-control" id="husband_occupation" value="{{ old('husband_occupation21') }}">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
										<hr>
											<h4>Guardian's Info : <span> <small class="text-muted">(if any)</small>
												<div class="form-group form-check form-check-inline">
												  <input type="radio" class="form-check-input" id="materialInline1" name="inlineMaterialRadiosExample" onclick="function h(){ $('#GuardianDiv').show(); } h();">
												  <label class="form-check-label" for="materialInline1">Yes</label>
												</div>

												<!-- Material inline 2 -->
												<div class="form-group form-check form-check-inline">
												  <input type="radio" class="form-check-input" id="materialInline2" name="inlineMaterialRadiosExample" onclick="function h(){ $('#GuardianDiv').hide(); } h();">
												  <label class="form-check-label" for="materialInline2">No</label>
												</div></span>
											</h4>
										</div>
									</div>
									<div class="row" id="GuardianDiv" style="display: none;transition: all 0.1s ease-out;">
										<div class="col-md-12">
											<div class="form-group label-floating">
												<label for="guardian_name" class="control-label"><b>Guardian's Name :</b></label>
												<input type="text" name="guardian_name2" class="form-control" id="guardian_name" value="{{ old('guardian_name2') }}">
											</div>
										</div>


										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="g_phone" class="control-label"><b>Phone :</b></label>
												<input type="number" name="g_phone7" class="form-control" id="g_phone" value="{{ old('g_phone7') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="g_cell" class="control-label"><b>Cell :</b></label>
												<input type="number" name="g_cell6" class="form-control" id="g_cell" value="{{ old('g_cell6') }}">
											</div>
										</div>

										
										<div class="col-md-10">
											<div class="form-group label-floating">
												<label for="g_address" class="control-label"><b>Full Address :</b></label>
												<input type="text" name="g_address38" class="form-control" id="g_address" value="{{ old('g_address38') }}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group label-floating">
												<label for="g_pincode" class="control-label"><b>Pincode :</b></label>
												<input type="number" name="g_pincode41" class="form-control" id="g_pincode" value="{{ old('g_pincode41') }}">
											</div>
										</div>
									</div>

								</div>
							</section>
						</div>

						<div class="tab-pane" id="education">
							<div class="container">
								<div class="row">
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="qualification" class="control-label">Qalification </label>
												<input name="qualification32" type="text" class="form-control" id="qualification" value="{{ old('qualification32') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="school_college_name" class="control-label">Last Attended College Name</label>
												<input name="school_college_name7" type="text" class="form-control" id="school_college_name" value="{{ old('school_college_name7') }}">
											</div>
										</div>	

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="Grade" class="control-label">Grade : </label>
												<input name="grade4" type="text" class="form-control" id="Grade" value="{{ old('grade4') }}">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="Course" class="control-label">Course : </label>
												<input name="course6" type="text" class="form-control" id="Course" value="{{ old('course6') }}">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="Performance" class="control-label">Performance : </label>
												<input name="performance10" type="text" class="form-control" id="Performance" value="{{ old('performance10') }}">
											</div>
										</div>									
									</div>
							</div>
						</div>

					</div>