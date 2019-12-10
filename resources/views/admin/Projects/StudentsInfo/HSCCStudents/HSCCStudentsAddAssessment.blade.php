@extends('admin/mainpage/adminmain')

@section('admincontents')
        <div class="row page-titles">
          <div class="col-md-12">
            <div class="d-flex">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Projects</a></li>
                <li class="breadcrumb-item"><a href="{{route('Families.index')}}">HSCC Details</a></li>
                <li class="breadcrumb-item"><a href="{{route('HSCCFamilyStudents',['ColonyStudents'])}}">HSCC Student Details</a></li>
                <li class="breadcrumb-item active">Add HSCC Student Assessments Details</li>
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
              <div class="card wizard-card" data-color="blue" id="wizardProfile">
                <form action="{{ route('storeHSCCFamilyStudentsAssessment') }}" method="POST">
                  {{ csrf_field() }}
                  <div class="wizard-header p-0">

                    <div class="row">
                      <div class="col-md-4">
                        <div class="card m-r-m-25">
                          <div class="card-body eval-card-body m-b-50 m-l-60">
                            <div class="form-group form-inline">
                              <label for="studId">Student Name/ Id :</label>

                              <input list="name" type="text" name="id" class="custom-select form-control" id="studId" placeholder="Enter name" required="" onchange="ajaxData(this.value,'{{route('findStudentDetails')}}','studentDetails')">
                              <datalist id="name">
                                @foreach($post as $posts)
                                <option value="{{$posts->id}}">
                                  {{$posts->fname}} , DOB: {{$posts->dob}}, Door: {{$posts->presentFamilyDoor}}
                                </option>
                                @endforeach
                              </datalist>

                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="col-md-4">
                        <h3 class="wizard-title p-10 font-NexaRustSans-Black">
                          Student Evaluation
                        </h3>
                      </div>

                      <div class="col-md-4">
                        <div class="card m-r-m-25">
                          <div class="card-body eval-card-body m-b-50 m-l-60">
                            <div class="form-group form-inline">
                              <label for="year">Year of evaluating :</label>
                              <input type="date" name="year" class="form-control" id="year" required="" onblur="compare('year','yearError',' Date should not be greater than current date.')">
                            </div>
                          </div>
                          <small class="text-danger" id="yearError"></small>
                        </div>

                      </div>
                    </div>
                    <div class="row" id="studentDetails"></div>

                  </div>
                  <div class="wizard-navigation">
                    <ul>
                      <li class="font-w-900"><a href="#general" data-toggle="tab" class="font-w-900">General Education Info.</a></li>
                      <li><a href="#religious" data-toggle="tab" class="font-w-900">Religious Education Info.</a></li>
                    </ul>
                  </div>

                  <div class="tab-content p-30">
                    <div class="tab-pane" id="general">
                      <div class="row">
                        <div class="col-md-12">
                            <h4>General Education Info.</h4>
                            <hr>
                          </div>
                      </div>
                      <section class="p-10" style="background-color: #f8f8f8">
                        <div class="row">

                          <div class="col-md-3">
                            <div class="form-group controls">
                              <label for="Category">Category :</label>
                              <input list="category" type="text" name="category" class="custom-select form-control" id="Category" placeholder="Enter School Stage/ Category" required="">
                              <datalist id="category">
                                <option value="">Select Category</option>
                                <option value="Nursery">Nursery</option>
                                <option value="Pre-Primary ">Pre-Primary </option>
                                <option value="Primary">Primary</option>
                                <option value="High_school">High School</option>
                                <option value="PUC">PUC</option>
                                <option value="UG">UG</option>
                                <option value="PG">PG</option>
                              </datalist>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group controls">
                              <label for="emailAddress1">Grade :</label>
                              <input type="text" name="grade" class="form-control" id="emailAddress1" placeholder="Enter grade">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phoneNumber1">School/Colllge :</label>
                              <input type="text" class="form-control input-group" name="school" id="phoneNumber1" placeholder="Enter school/colllge">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group controls">
                              <label for="weak">Weak Subject :</label>
                              <input type="text" name="weak" class="form-control" id="weak" placeholder="Enter weak subject">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="strong">Strong Subject :</label>
                              <input type="text" class="form-control input-group" name="strong" id="strong" placeholder="Enter strong subject">
                            </div>
                          </div>
                        </div>

                        <div class="row">

                          <div class="col-md-12">
                            <div class="form-group">
                              <label>General Education Perfomance : </label>&nbsp;&nbsp;&nbsp;
                              <fieldset class="controls">
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="5" name="perfomance" required="" id="ex" class="custom-control-input" aria-invalid="false" checked="checked">
                                  <label class="custom-control-label" for="ex">Excellent : 95-100</label>
                                </div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="4" name="perfomance" id="vg" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="vg">Very Good : 80-94</label>
                                </div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="3" name="perfomance" id="styled_radio3" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="styled_radio3">Good : 60-79 </label>
                                </div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="2" name="perfomance" id="styled_radio4" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="styled_radio4">Average : 40-59</label>
                                </div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="1" name="perfomance" id="styled_radio5" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="styled_radio5">Need to be improved : below 39</label>
                                </div>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </section>

                    </div>
                    <!-- Religious -->
                    <div class="tab-pane" id="religious">
                      <div class="row">
                        <div class="col-md-12">
                            <h4>Religious Education Info.</h4>
                            <hr>
                          </div>
                      </div>
                      <section class="p-10" style="background-color: #f8f8f8">
                        <div class="row">
                          <div class="col-md-4">
                            <label>Madrasa Education </label>

                            <div class="form-group">
                              <fieldset class="controls">
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="3" name="madrasa" required="" id="Madrasa1" class="custom-control-input" aria-invalid="false" checked="checked">
                                  <label class="custom-control-label" for="Madrasa1">High</label>
                                </div>
                                <div class="help-block" ></div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="2" name="madrasa" id="Madrasa2" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="Madrasa2">Moderate</label>
                                </div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="1" name="madrasa" id="Madrasa3" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="Madrasa3">Low </label>
                                </div>
                              </fieldset>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <label>Huqub-Al-Ibada </label>

                            <div class="form-group">
                              <fieldset class="controls">
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="3" name="ibada" required="" id="ibada1" class="custom-control-input" aria-invalid="false" checked="checked">
                                  <label class="custom-control-label" for="ibada1">High</label>
                                </div>
                                <div class="help-block" ></div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="2" name="ibada" id="ibada2" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="ibada2">Moderate</label>
                                </div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="1" name="ibada" id="ibada3" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="ibada3">Low </label>
                                </div>
                              </fieldset>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label>Practices </label>

                            <div class="form-group">
                              <fieldset class="controls">
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="3" name="practices" required="" id="practices1" class="custom-control-input" aria-invalid="false" checked="checked">
                                  <label class="custom-control-label" for="practices1">High</label>
                                </div>
                                <div class="help-block" ></div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="2" name="practices" id="practices2" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="practices2">Moderate</label>
                                </div>
                              </fieldset>
                              &nbsp;&nbsp;
                              <fieldset>
                                <div class="custom-control custom-radio">
                                  <input type="radio" value="1" name="practices" id="practices3" class="custom-control-input" aria-invalid="false">
                                  <label class="custom-control-label" for="practices3">Low </label>
                                </div>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                  <div class="wizard-footer">
                    <div class="form-group pull-right">
                      <input type='button' class='btn btn-next btn-fill btn-primary btn-wd' name='next' value='Next' />
                      <input type='submit' class='btn btn-finish btn-fill btn-primary btn-wd' name='submit' value='Submit' />
                    </div>

                    <div class="form-group pull-left">
                      <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                    </div>
                    <!-- <div class="clearfix"></div> -->
                  </div>
                </form>
              </div>
            </div> <!-- wizard container -->
          </div>
        </div>

@endsection
