<?php use \App\Http\Controllers\MainController;$main = new MainController;
$mem = $main->find_tested_data('organisation_details','member_type','category','unit_id',$type,$unit);$mem = ifAnd($mem == true) ? $mem->member_type : 'Member'; ?>
@extends('admin.mainpage.adminmain')

@section('admincontents')
<div class="row page-titles">
    <div class="col-md-12">
      {{$main->breadCrumbsData($type,$prType,'add',$personCat,$page,$status, ($personCat == 'Members') ? $unit : '')}}
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
				@include('admin.mainpage.pages.form-preload')
				<form action="{{route('storeOrganizationinfo')}}" method="POST" id="memberForm" enctype="multipart/form-data" class="contents" style="display: none;">
					{{ csrf_field() }}

					<input type="hidden" name="unit" value="{{$unit}}">
					<input type="hidden" name="type" value="{{$type}}">
					<input type="hidden" name="page" value="{{$page}}">

					<div class="wizard-header" style="padding: 10px 0 20px;">
						<h4 class="wizard-title font-NexaRustSans-Black">
							Information 
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

							<div class="row">
								<div class="col-md-2">
									<div class="form-group picture-container">
										<div class="picture">
											<img src="{{asset('adminAssets/images/default/user-default.png')}}" class="picture-src" id="wizardPicturePreview" title=""/>
											<input type="file" id="wizard-picture" name="image">
										</div>
										<h6> Choose Picture</h6>
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
												<label class="control-label">Middle Name</label>
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
										<div class="col-md-3">
											<div class="form-group">
												<label for="hfId">HF-Id <small>(*)</small></label>
												<input name="hfId" type="number" id="hfId" value="{{ old('hfId') }}" class="form-control @error('hfId') is-invalid @enderror" placeholder="Enter HF-Id" required>
											</div>
											@error('hfId')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror 
										</div>
										<div class="col-md-7">
											<div class="form-group">
												<label for="email">E-mail Address <small>(*)</small></label>
												<input name="email" type="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter E-mail" required>
												@error('email')
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

										<div class="col-md-3">
											<div class="form-group">
												<label for="dob">Date of Birth <small>(*)</small></label>
												<input name="dob" type="date" class="form-control" id="dob" required="" onblur="compare('dob','dobError','Birth date should not be greater than current date.')" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
												<p class="text-danger" id="dobError"> </p>
												@error('dob')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label for="doj">Date of Joining HF <small>(*)</small></label>
												<input name="doj" type="date" class="form-control" aria-required="true" required="" id="doj" onblur="compare('doj','dojError','Join date should not be greater than current date.')" class="form-control @error('doj') is-invalid @enderror" value="{{ old('doj') }}">
												@error('doj')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
												<p class="text-danger" id="dojError"> </p>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="qualification">Educational Qualification <small>(*)</small></label>
												<input name="qualification" id="qualification" type="text" class="form-control" required="" spellcheck="true" value="{{ old('qualification') }}" placeholder="Enter Qualification">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group controls">
							                  <div class="form-group">
							                    <label for="member_type">Member Type <small>(*)</small></label>
							                    <select class="custom-select form-control" id="member_type" name="member_type" required onchange="findMember(this.value,'committee','Role')">
							                       <option>Select type</option>
							                       <option value="Staff">Staff</option>
							                       <option value="Member">Member</option>
							                    </select>
							                  </div>
							                </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="committee" class="control-label">Committee</label>
												<select name="committee" class="custom-select form-control" id="committee" required onchange="commiteeRole(this.value,'Role')">
					                                <option value="">Select Role</option>
					                                <option value="">Select Committee</option>
					                                <option value="Trustee Committee">Trustee Committee </option>
					                                <option value="Core Committee">Core Committee</option>
					                                <option value="General Committee">General Committee </option>
					                            </select>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="Role" class="control-label">Role</label>
					                            <select name="role" class="custom-select form-control" required id="Role">
					                                <option value="">Select Role</option>
					                            </select>
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
										<div class="col-md-12">	
										<h4>Permanent Address <sup>	comma (,) separated</sup></h4>
										</div>
										<div class="col-md-9">
											<div class="form-group label-floating">
												<label for="paddress" class="control-label">Full Address <small>(*)</small> :</label>
												<textarea name="p_address" id="Address" cols="10" rows="4" class="form-control"spellcheck="true" required>{{ old('p_address') }}</textarea>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="mobile" class="control-label">Phone No. :</label>
												<input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control input-group" id="mobile"  required>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="Residence" class="control-label">Residence :</label>
												<input type="text" name="p_residence" value="{{ old('p_residence') }}" class="form-control" id="Residence" required="">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="PCity" class="control-label">City/ Taluq :</label>
												<input list="pCity" type="text" name="p_city" value="{{ old('p_city') }}" class="form-control" id="PCity" required>
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
												<label for="PState" class="control-label">State :</label>
												<input list="pState" type="text" name="p_state" value="{{ old('p_state') }}" class="form-control" id="PState" required>
												<datalist id="pState">
							                      <option> Select City </option>
							                      <option value="Karnataka">Karnataka</option>
							                      <option value="Kerala">Kerala</option>
							                    </datalist>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="PNation" class="control-label">Nation :</label>
												<input list="p_nation" type="text" name="p_nation" value="{{ old('p_nation') }}" class="form-control" id="PNation" required>
												<datalist id="p_nation">
							                      <option> Select Nation </option>
							                      <option value="India"></option>
							                      <option value="UAE"></option>
							                    </datalist>
											</div>
										</div>
									</div>

									<div class="row" style="margin-top: 20px;">
										<h4>Residence Address <sup>	comma (,) separated</sup> </h4>
										<div class="col-md-9">
											<div class="form-group label-floating">
												<label for="raddress" class="control-label">Full Address :</label>
												<textarea name="r_address" id="street" cols="10" rows="4" class="form-control" spellcheck="true">{{ old('r_address') }}</textarea>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="phone" class="control-label">Mobile No. :</label>
												<input type="number" name="phone" value="{{ old('phone') }}" class="form-control input-group" id="phone">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="rResidence" class="control-label">Residence :</label>
												<input type="text" name="rresidence" value="{{ old('rresidence') }}" class="form-control" id="rResidence">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating"">
												<label for="RCity" class="control-label">City/ Taluq :</label>
												<input list="rCity" type="text" name="r_city" value="{{ old('r_city') }}" class="form-control" id="RCity">
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
											<div class="form-group label-floating"">
												<label for="RState" class="control-label">State :</label>
												<input list="rState" type="text" name="r_state" value="{{ old('r_state') }}" class="form-control" id="RState">
												<datalist id="rState">
							                      <option> Select City </option>
							                      <option value="Karnataka">Karnataka</option>
							                      <option value="Kerala">Kerala</option>
							                    </datalist>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating"">
												<label for="RNation" class="control-label">Nation :</label>
												<input list="p_nation" type="text" name="r_nation" value="{{ old('r_nation') }}" class="form-control" id="RNation">
												<datalist id="p_nation">
							                      <option> Select Nation </option>
							                      <option value="India"></option>
							                      <option value="UAE"></option>
							                    </datalist>
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

										<div class="col-md-12">
											<div class="form-group label-floating">
												<label for="employment" class="control-label"><b>{{($mem == 'Member') ? 'Employment/ Business Information' : 'Designation'}} :</b></label>
												<input type="text" name="employment" value="{{ old('employment') }}" class="form-control" id="employment">
											</div>
										</div>

										<div class="col-md-8">
											<div class="form-group label-floating">
												<label for="company_name" class="control-label"><b>Company Name:</b></label>
												<input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control" id="company_name">
											</div>
										</div>

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
												<textarea name="expertise" id="expertise" rows="5" class="form-control"spellcheck="true" placeholder="Enter Area of Expertise" required>{{ old('expertise') }}</textarea>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group label-floating">
												<label for="skills" class="control-label"><b>Contributable Skills :</b></label>
												<textarea name="skills" id="skills" rows="5" class="form-control" spellcheck="true" required>{{ old('skills') }}</textarea>
											</div>
										</div>

									</div>

									<div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group form-inline">
                                        <label>Other Organization Info.? : &nbsp;&nbsp;&nbsp;</label>
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
                                        <a class="btn btn-sm btn-outline-primary m-0 font-8" id="btnAdd" onclick="addFieilds('org','show')"><i class="ti-plus font-w-900"></i></a>
                                        <a class="btn btn-sm btn-outline-primary m-0 font-8" id="btnDelete" onclick="deleteFieilds()"><i class="ti-minus font-w-900"></i></a>
                                      </div>
                                    </div>
                                  </div>
									<div class="row" id="show">

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
	}
</script>

@endsection
