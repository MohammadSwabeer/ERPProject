@extends('admin/mainpage/adminmain')

@section('admincontents')
@foreach($post as $posts)
	<div class="row page-titles">
		<div class="col-md-12">
			<div class="d-flex">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{route('viewATTStudents')}}">ATT Student Information</a></li>
					<li class="breadcrumb-item active">Edit ATT Student Information</li>
				</ol>
			</div>

		</div>
	</div> 
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
				@include('admin.mainpage.form-preload')
					<form action="{{route('updateATTStudents')}}" method="POST" id="memberForm" enctype="multipart/form-data" class="contents" style="display: none;"> 
						{{ csrf_field() }}
						<input type="hidden" name="id" value="{{$posts->id}}">
						<div class="wizard-header" style="padding: 10px 0 20px;">
							<h4 class="wizard-title font-NexaRustSans-Black">
								Edit ATT Student details
							</h4>
						</div>
						<div class="wizard-navigation">
							<ul>
								<li><a href="#about" data-toggle="tab">Personal Info.</a></li>
								<li><a href="#Family" data-toggle="tab">Family Info.</a></li>
								<li><a href="#address" data-toggle="tab">Address</a></li>
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
													<input type="text" title="Enter name" required="" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ $posts->full_name}}" placeholder="Enter Full Name">
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
													<input type="text" title="Enter HF-Id" required name="hfId" class="form-control @error('hfId') is-invalid @enderror" value="{{ $posts->hfId}}" placeholder="Enter HF-Id">
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
													<select class="form-control" name="gender" id="gender">
														<option value="{{ $posts->gender}}">{{ $posts->gender}}</option>
														<option value="Male">Male</option>
														<option value="Female">Female</option>
													</select>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group label-floating">
													<label for="stud_email" class="control-label">E-mail Address </label>
													<input name="stud_email" type="email" id="stud_email" class="form-control @error('email') is-invalid @enderror" value="{{ $posts->stud_email}}" required>
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
													<input name="stud_phone" type="number" id="stud_phone" class="form-control @error('stud_phone') is-invalid @enderror" value="{{ $posts->stud_phone}}">
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
													<input name="stud_cell" type="number" id="stud_cell" class="form-control" value="{{ $posts->stud_cell}}">
													@error('stud_cell')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="stud_dob">Date of Birth </label>
													<input name="stud_dob" type="date" class="form-control" id="stud_dob" required onblur="compare('stud_dob','dobError','Birth date should not be greater than current date.')" value="{{ $posts->stud_dob}}">
													<p class="text-danger" id="dobError"> </p>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="birth_place">Place of Birth </label>
													<input name="birth_place" type="text" class="form-control" id="birth_place" value="{{ $posts->birth_place}}">
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="stud_marital">Marital Status </label>
													<select  class="custom-select form-control" id="stud_marital" name="stud_marital">
														<option value="{{ $posts->stud_marital}}">{{ $posts->stud_marital}}</option>
														<option value="Married">Married</option>
														<option value="Single">Single</option>
													</select>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group label-floating">
													<label for="nationality" class="control-label">Nationality </label>
													<input list="Nationality" name="nationality" type="text" class="form-control" id="nationality" value="{{ $posts->nationality}}">
													<datalist id="Nationality">
														<option></option>
													</datalist>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group label-floating">
													<label for="relegion" class="control-label">Relegion </label>
													<input list="Relegion" name="relegion" type="text" class="form-control" id="relegion" value="{{ $posts->relegion}}">
													<datalist id="Relegion">
														<option></option>
													</datalist>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group label-floating">
													<label for="mother_tongue" class="control-label">Mother Tongue </label>
													<input list="Tongue" name="mother_tongue" type="text" class="form-control" id="mother_tongue" value="{{ $posts->mother_tongue}}">
													<datalist id="Tongue">
														<option></option>
													</datalist>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group label-floating">
													<label for="qualification" class="control-label">Qalification </label>
													<input name="qualification" type="text" class="form-control" id="qualification" value="{{ $posts->qualification}}">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group label-floating">
													<label for="college_last_attended" class="control-label">College Last Attended </label>
													<input name="college_last_attended" type="text" class="form-control" id="college_last_attended" value="{{ $posts->college_last_attended}}">
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
													<input type="text" name="father_name" class="form-control" id="father_name" value="{{ $posts->father_name}}">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group label-floating">
													<label for="father_occupation" class="control-label"><b>Father's Occupation :</b></label>
													<input type="text" name="father_occupation" class="form-control" id="father_occupation" value="{{$posts->father_occupation}}">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group label-floating">
													<label for="mother_name" class="control-label"><b>Mother Name :</b></label>
													<input type="text" name="mother_name" class="form-control" id="mother_name" value="{{$posts->mother_name}}">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group label-floating">
													<label for="mother_occupation" class="control-label"><b>Mother Occupation :</b></label>
													<input type="text" name="mother_occupation" class="form-control" id="mother_occupation" value="{{$posts->mother_occupation}}">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group label-floating">
													<label for="husband_name" class="control-label"><b>Husband's Name (if married):</b></label>
													<textarea name="husband_name" id="husband_name" cols="10" rows="4" class="form-control"> {{$posts->husband_name}}</textarea>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group label-floating">
													<label for="husband_occupation" class="control-label"><b>Husband's Occupation :</b></label>
													<input type="text" name="husband_occupation" value="" class="form-control" id="husband_occupation" value="{{$posts->husband_occupation}}">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group label-floating">
													<label for="annual" class="control-label"><b>Annual Income :</b></label>
													<input type="text" name="annual" class="form-control" id="annual" value="{{$posts->annual}}">
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group label-floating">
													<label for="guardian_name" class="control-label"><b>Guardian's Name (if any):</b></label>
													<input type="text" name="guardian_name" class="form-control" id="guardian_name" value="{{$posts->guardian_name}}">
												</div>
											</div>


											<div class="col-md-6">
												<div class="form-group label-floating">
													<label for="g_phone" class="control-label"><b>Phone :</b></label>
													<input type="number" name="g_phone" class="form-control" id="g_phone" value="{{$posts->g_phone}}">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group label-floating">
													<label for="g_cell" class="control-label"><b>Cell :</b></label>
													<input type="number" name="g_cell" class="form-control" id="g_cell" value="{{$posts->g_cell}}">
												</div>
											</div>
										</div>

									</div>
								</section>
							</div>

							<div class="tab-pane" id="address">
								<section>
									<div class="container">
										<div class="row" style="margin-top: 40px;">
											<div class="col-md-12">
												<h4>Address of the Student</h4>
											</div>
											<div class="col-md-10">
												<div class="form-group label-floating">
													<label for="full_address" class="control-label"><b>Full Address :</b></label>
													<input type="text" name="full_address" class="form-control" id="full_address" value="{{$posts->full_address}}" required>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group label-floating">
													<label for="pincode" class="control-label"><b>Pincode :</b></label>
													<input type="number" name="pincode" class="form-control" id="pincode" value="{{$posts->pincode}}" required>
												</div>
											</div>
										</div>

										<div class="row" style="margin-top: 20px;">
											<div class="col-md-12">
												<h4>Guardian's Address</h4>
											</div>
											<div class="col-md-10">
												<div class="form-group label-floating">
													<label for="g_address" class="control-label"><b>Full Address :</b></label>
													<input type="text" name="g_address" class="form-control" id="g_address" value="{{$posts->g_address}}">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group label-floating">
													<label for="g_pincode" class="control-label"><b>Pincode :</b></label>
													<input type="number" name="g_pincode" class="form-control" id="g_pincode" value="{{$posts->g_pincode}}">
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
@endforeach
<script type="text/javascript">
	window.onload = function(){
		document.getElementById('otherOrg').style.display= 'none';
	}
</script>
@endsection