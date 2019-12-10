<?php  use \App\Http\Controllers\MainController; $main = new MainController;?>
@extends('admin/mainpage/adminmain')

@section('admincontents')

<div class="row page-titles">
    <div class="col-md-12">
  		{{ $main->breadCrumbsData($type,$prType,'add',$personCat,$page,$status) }}
  	</div>
</div>

 @include('admin.mainpage.pages._messages')
 
<div class="row">
	<div class="col-md-12">
		<div class="wizard-container">
			<div class="card wizard-card" data-color="green" id="wizardProfile">
				@include('admin.mainpage.pages.form-preload')
				<form action="{{route('storeATTStudents')}}" method="POST" id="memberForm" enctype="multipart/form-data" class="contents" style="display: none;" id="addForm">
					{{ csrf_field() }}
					<input type="hidden" name="category" value="{{$type}}">
					<input type="hidden" name="hfname" value="HFATT">
					<div class="wizard-header" style="padding: 10px 0 20px;">
						<h4 class="wizard-title font-NexaRustSans-Black">
							Add {{$type}} Student Details
						</h4>
					</div>
					<div class="wizard-navigation">
						<ul>
							<li><a href="#about" data-toggle="tab">Personal Info.</a></li>
							<li><a href="#Family" data-toggle="tab">Family Info.</a></li>
							<li><a href="#education" data-toggle="tab">Education Info.</a></li>
						</ul>
					</div>

					<div class="tab-content">
						<div class="tab-pane" id="about">

							<div class="row">
								<div class="col-md-2">
									<div class="form-group picture-container">
										<div class="picture">
											<img src="{{asset('adminAssets/images/default/user-default.png')}}" class="picture-src" id="wizardPicturePreview" title="Student Image"/>
											<input type="file" id="wizard-picture" name="stud_image" id="stud_image">
										</div>
										<h6>Choose Picture</h6>
									</div>
								</div>
								<div class="col-md-10">

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label">Full Name <small>(*)</small></label>
												<input type="text" title="Enter name" required="" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" placeholder="Enter Full Name">
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
												<input type="text" title="Enter HF-Id" required name="hfId" class="form-control @error('hfId') is-invalid @enderror" value="{{ old('hfId') }}" placeholder="Enter HF-Id">
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
														<input type="radio" value="Male" name="gender" id="styled_radio1" class="custom-control-input" aria-invalid="false" checked="checked">
														<label class="custom-control-label" for="styled_radio1">Male</label>
													</div>
												</fieldset>
												<fieldset>
													<div class="custom-control custom-radio">
														<input type="radio" value="Female" name="gender" id="styled_radio2" class="custom-control-input" aria-invalid="false">
														<label class="custom-control-label" for="styled_radio2">Female</label>
													</div>
												</fieldset>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="stud_email" class="control-label">E-mail Address </label>
												<input name="email" type="email" id="stud_email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
												@error('email')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror 
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="phone" class="control-label">Student Phone </label>
												<input name="phone" type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
												@error('phone')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="mobile" class="control-label">Student Cell </label>
												<input name="mobile" type="number" id="mobile" class="form-control @error('mobile') is-invalid @enderror"" value="{{ old('mobile') }}" required>
												@error('mobile')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="dob">Date of Birth </label>
												<input name="dob" type="date" class="form-control" id="dob" required onblur="compare('dob','dobError','Birth date should not be greater than current date.')" value="{{ old('dob') }}">
												<p class="text-danger" id="dobError"> </p>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="birth_place">Place of Birth </label>
												<input name="birth_place" type="text" class="form-control" id="birth_place" value="{{ old('birth_place') }}" required>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="stud_marital">Marital Status </label>
												<select  class="custom-select form-control" id="stud_marital" name="stud_marital" onchange="ifExists(this.value,'husbandDiv','Single')" required>
													<option>Select</option>
													<option value="Married">Married</option>
													<option value="Single">Single</option>
												</select>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="nationality" class="control-label">Nationality </label>
												<input list="Nationality" name="nationality" type="text" class="form-control" id="nationality" value="{{ old('nationality') }}" required>
												<datalist id="Nationality">
													<option></option>
												</datalist>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="relegion" class="control-label">Relegion </label>
												<input list="Relegion" name="relegion" type="text" class="form-control" id="relegion" value="{{ old('relegion') }}" required>
												<datalist id="Relegion">
													<option></option>
												</datalist>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="mother_tongue" class="control-label">Mother Tongue </label>
												<input list="Tongue" name="mother_tongue" type="text" class="form-control" id="mother_tongue" value="{{ old('mother_tongue') }}" required>
												<datalist id="Tongue">
													<option></option>
												</datalist>
											</div>
										</div>

											<div class="col-md-12">
												<h4>Address of the Student</h4>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="full_address" class="control-label"><b>Full Address :</b></label>
													<input type="text" name="full_address" class="form-control" id="full_address" placeholder="Enter Streat,area,village..." value="{{ old('full_address') }}" required>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="form-group label-floating">
													<label for="PCity" class="control-label">City/ Taluq :</label>
													<input list="pCity" type="text" name="presentCity" value="{{ old('presentCity') }}" class="form-control" id="PCity" required>
													<datalist id="rCity">
								                      <option> Select City </option>
								                      <option value="Mangalore">Mangalore</option>
								                      <option value="Bantval">Bantval</option>
								                      <option value="Putture">Putture</option>
								                      <option value="Sullia">Sullia</option>
								                    </datalist>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group label-floating">
													<label for="district" class="control-label">District :</label>
													<input list="District" type="text" name="district" value="{{ old('district') }}" class="form-control" id="district" required>
													<datalist id="District">
								                      <option> Select District </option>
								                      <option value="Dakshin Kannada">Dakshin Kannada</option>
								                      <option value="Udupi">Udupi</option>
								                    </datalist>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group label-floating">
													<label for="PState" class="control-label">State :</label>
													<input list="pState" type="text" name="presentState" value="{{ old('presentState') }}" class="form-control" id="PState" required>
													<datalist id="pState">
								                      <option> Select State </option>
								                      <option value="Karnataka">Karnataka</option>
								                      <option value="Kerala">Kerala</option>
								                    </datalist>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="form-group label-floating">
													<label for="pincode" class="control-label"><b>Pincode :</b></label>
													<input type="number" name="pincode" class="form-control" id="pincode" value="{{ old('pincode') }}">
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
												<input type="text" name="father_name" class="form-control" id="father_name" value="{{ old('father_name') }}" required>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="father_occupation" class="control-label"><b>Father's Occupation :</b></label>
												<input type="text" name="father_occupation" class="form-control" id="father_occupation" value="{{ old('father_occupation') }}" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-5">
											<div class="form-group label-floating">
												<label for="mother_name" class="control-label"><b>Mother Name :</b></label>
												<input type="text" name="mother_name" class="form-control" id="mother_name" value="{{ old('mother_name') }}">
											</div>
										</div>

										<div class="col-md-5">
											<div class="form-group label-floating">
												<label for="mother_occupation" class="control-label"><b>Mother Occupation :</b></label>
												<input type="text" name="mother_occupation" class="form-control" id="mother_occupation" value="{{ old('mother_occupation') }}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group label-floating">
												<label for="annual" class="control-label"><b>Annual Income :</b></label>
												<input type="number" name="annual" class="form-control" id="annual" value="{{ old('annual') }}" required>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="contact" class="control-label"><b>Parent's Contatct 1 :</b></label>
												<input name="contact" type="number" id="contact" class="form-control" value="{{ old('contact') }}" required>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="contact2" class="control-label"><b>Parent's Contatct 2 :</b></label>
												<input name="contact2" type="number" id="contact2" class="form-control" value="{{ old('contact2') }}">
											</div>
										</div>
									</div>

									<div class="row" id="husbandDiv">
										<div class="col-md-5">
											<div class="form-group label-floating">
												<label for="husband_name" class="control-label"><b>Husband's Name :</b></label>
												<input name="husband_name" id="husband_name" class="form-control" value="{{ old('husband_name') }}" required> 
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label for="husband_occupation" class="control-label"><b>Husband's Occupation :</b></label>
												<input type="text" name="husband_occupation" value="" class="form-control" id="husband_occupation" value="{{ old('husband_occupation') }}">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="husMobile" class="control-label"><b>Contact Number :</b></label>
												<input name="husMobile" type="number" id="husMobile" class="form-control" value="{{ old('husMobile') }}" required>
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
									<div class="row" id="GuardianDiv" style="display: none;    transition: all 0.1s ease-out;">
										<div class="col-md-12">
											<div class="form-group label-floating">
												<label for="guardian_name" class="control-label"><b>Guardian's Name :</b></label>
												<input type="text" name="guardian_name" class="form-control" id="guardian_name" value="{{ old('guardian_name') }}" required>
											</div>
										</div>


										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="g_phone" class="control-label"><b>Phone :</b></label>
												<input type="number" name="g_phone" class="form-control" id="g_phone" value="{{ old('g_phone') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="g_cell" class="control-label"><b>Cell :</b></label>
												<input type="number" name="g_cell" class="form-control" id="g_cell" value="{{ old('g_cell') }}" required>
											</div>
										</div>

										
										<div class="col-md-10">
											<div class="form-group label-floating">
												<label for="g_address" class="control-label"><b>Full Address :</b></label>
												<input type="text" name="g_address" class="form-control" id="g_address" value="{{ old('g_address') }}" required>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group label-floating">
												<label for="g_pincode" class="control-label"><b>Pincode :</b></label>
												<input type="number" name="g_pincode" class="form-control" id="g_pincode" value="{{ old('g_pincode') }}" required>
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
												<input name="qualification" type="text" class="form-control" id="qualification" value="{{ old('qualification') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="school_college_name" class="control-label">Last Attended College Name</label>
												<input name="school_college_name" type="text" class="form-control" id="school_college_name" value="{{ old('school_college_name') }}">
											</div>
										</div>	

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="Grade" class="control-label">Grade : </label>
												<input name="grade" type="text" class="form-control" id="Grade" value="{{ old('grade') }}">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label for="Course" class="control-label">Course : </label>
												<input name="course" type="text" class="form-control" id="Course" value="{{ old('course') }}">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="Performance" class="control-label">Performance : </label>
												<input name="performance" type="text" class="form-control" id="Performance" value="{{ old('performance') }}">
											</div>
										</div>									
									</div>
							</div>
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
