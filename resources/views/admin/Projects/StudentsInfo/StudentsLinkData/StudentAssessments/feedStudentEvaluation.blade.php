<?php use \App\Http\Controllers\MainController; $main = new MainController;?>

@extends('admin/mainpage/adminmain')

@section('admincontents')
  <div class="row page-titles">
    <div class="col-md-12">
      {{$main->breadCrumbsData($type,$prType,'assessments',$personCat,$page,$status)}}
    </div>
</div>
        
<div class="row">
  <div class="col-md-12">

      <div class="wizard-container">
         <div class="card wizard-card br-5" data-color="blue" id="wizardProfile">
            @include('admin.mainpage.pages.form-preload')
            <form action="{{route('feedAssessments')}}" method="POST" class="contents" style="display: none;">
               {{ csrf_field() }}

               <input type="hidden" name="category" value="{{$type}}">
               <input type="hidden" name="id" value="{{$id}}">
               <input type="hidden" name="hfid" value="{{$hfid}}">
               <input type="hidden" name="prType" value="{{$prType}}">
               <input type="hidden" name="page" value="{{$page}}">
               <input type="hidden" name="status" value="{{$status}}">
               <input type="hidden" name="personCat" value="{{$personCat}}">

               <div class="wizard-header" style="padding: 10px 0 20px;">
                  <h4 class="wizard-title font-NexaRust Sans-Black">
                     Add {{$type}} Family Details
                  </h4>
               </div>
               <div class="wizard-navigation">
                  <ul>
                     <li><a href="#about" data-toggle="tab" style="font-weight:700 ">Spiritual development</a></li>
                     <li><a href="#addresses" data-toggle="tab" style="font-weight:700 ">lifeskills</a></li>
                  </ul>
               </div>

               <div class="tab-content">
                  <div class="tab-pane" id="about">
                     <div class="row p-10">
                        <div class="col-md-3 offset-md-1 p-10">
                           <div class="card-header">
                              <h4>Huqooq-Allah</h4>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Salah </label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="salah" required id="salah" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="salah">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="20" name="salah" id="salah1" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="salah1">20</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="40" name="salah" id="salah2" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="salah2">40</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="60" name="salah" id="salah3" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="salah3">60</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="80" name="salah" id="salah4" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="salah4">80</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="100" name="salah" id="salah5" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="salah5">100</label>
                                     </div>
                                  </fieldset>
                                    <!-- <input name="salah" type="text" class="form-control" value="{{ old('salah') }}"> -->
                                 </div>
                              </div>
                              
                              <div class="col-md-6">
                                 <div class="form-group">
                                   <label>Saum </label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="saum" required id="saum" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="saum">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="20" name="saum" id="saum1" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="saum1">20</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="40" name="saum" id="saum3" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="saum3">40</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="60" name="saum" id="saum4" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="saum4">60</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="80" name="saum" id="saum5" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="saum5">80</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="100" name="saum" id="saum6" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="saum6">100</label>
                                     </div>
                                  </fieldset>
                                   <!-- <input name="saum" type="number" class="form-control" value="{{ old('saum') }}" id="saum"> -->
                                 </div>
                              </div>
                           </div>      
                        </div>

                        <div class="col-md-5 offset-md-1 p-10">     

                           <div class="card-header">
                              <h4>Huqooq-ul-Ibaadh</h4>
                           </div>

                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group label-floating">
                                    <label>Physical </label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="physical" required id="physical1" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="physical1">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="20" name="physical" id="physical2" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="physical2">20</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="40" name="physical" id="physical3" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="physical3">40</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="60" name="physical" id="physical4" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="physical4">60</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="80" name="physical" id="physical5" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="physical5">80</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="100" name="physical" id="physical6" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="physical6">100</label>
                                     </div>
                                  </fieldset>
                                    <!-- <input type="number" name="physical" class="form-control" value="{{ old('physical') }}"> -->
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Finance</label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="finance" required id="finance1" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="finance1">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                           <input type="radio" value="20" name="finance" id="finance2" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="finance2">20</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="40" name="finance" id="finance3" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="finance3">40</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="60" name="finance" id="finance4" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="finance4">60</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="80" name="finance" id="finance5" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="finance5">80</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="100" name="finance" id="finance6" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="finance6">100</label>
                                       </div>
                                    </fieldset>
                                    <!-- <input type="number" name="finance" class="form-control" value="{{ old('finance') }}" id="finance"> -->
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group label-floating">
                                    <label>Intellectual</label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="intellectual" required id="intellectual1" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="intellectual1">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="20" name="intellectual" id="intellectual2" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="intellectual2">20</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="40" name="intellectual" id="intellectual3" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="intellectual3">40</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="60" name="intellectual" id="intellectual4" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="intellectual4">60</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="80" name="intellectual" id="intellectual5" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="intellectual5">80</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="100" name="intellectual" id="intellectual6" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="intellectual6">100</label>
                                       </div>
                                    </fieldset>
                                     <!-- <input type="number" name="intellectual" class="form-control" value="{{ old('intellectual') }}" id="Intellectual"> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <div class="col-md-12">
                           <div class="card-header">
                              <h4>Madrasa Education</h4>
                           </div>
                        </div>

                        <div class="col-md-3 offset-md-1 p-10">
                           <div class="card-header">
                              <h4>Academics</h4>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group label-floating">
                                    <label class="control-label">Class/ Grade </label>
                                    <input type="text" name="madrasa_grade" class="form-control" value="{{ old('madrasa_grade') }}">
                                 </div>
                              </div>
                              
                              <div class="col-md-6">
                                 <div class="form-group">
                                   <label>Performance </label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="performance" required id="performance" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="performance">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="20" name="performance" id="performance1" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="performance1">20</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="40" name="performance" id="performance2" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="performance2">40</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="60" name="performance" id="performance4" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="performance4">60</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="80" name="performance" id="performance5" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="performance5">80</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="100" name="performance" id="performance6" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="performance6">100</label>
                                     </div>
                                  </fieldset>
                                   <!-- <input type="number" name="performance" class="form-control" value="{{ old('performance') }}" id="Performance"> -->
                                 </div>
                              </div>
                           </div>      
                        </div>

                        <div class="col-md-5 offset-md-1 p-10">     

                           <div class="card-header">
                              <h4>Tarbiyyah</h4>
                           </div>

                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group label-floating">
                                    <label>Tajveed </label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="tajveed" required id="tajveed" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="tajveed">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="20" name="tajveed" id="tajveed1" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="tajveed1">20</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="40" name="tajveed" id="tajveed2" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="tajveed2">40</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="60" name="tajveed" id="tajveed3" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="tajveed3">60</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="80" name="tajveed" id="tajveed4" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="tajveed4">80</label>
                                     </div>
                                  </fieldset>
                                  <fieldset>
                                     <div class="custom-control custom-radio">
                                        <input type="radio" value="100" name="tajveed" id="tajveed5" class="custom-control-input" aria-invalid="false">
                                        <label class="custom-control-label" for="tajveed5">100</label>
                                     </div>
                                  </fieldset>
                                    <!-- <input type="number" name="physical" class="form-control" value="{{ old('physical') }}"> -->
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Fiqh</label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="fiqh" required id="fiqh" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="fiqh">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                           <input type="radio" value="20" name="fiqh" id="fiqh1" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="fiqh1">20</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="40" name="fiqh" id="fiqh3" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="fiqh3">40</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="60" name="fiqh" id="fiqh4" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="fiqh4">60</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="80" name="fiqh" id="fiqh5" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="fiqh5">80</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="100" name="fiqh" id="fiqh6" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="fiqh6">100</label>
                                       </div>
                                    </fieldset>
                                    <!-- <input type="number" name="finance" class="form-control" value="{{ old('finance') }}" id="finance"> -->
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group label-floating">
                                    <label>Arabic</label>
                                    <fieldset class="controls">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="0" name="arabic" required id="arabic" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="arabic">0</label>
                                       </div>
                                       <div class="help-block" ></div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="20" name="arabic" id="arabic1" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="arabic1">20</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="40" name="arabic" id="arabic2" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="arabic2">40</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="60" name="arabic" id="arabic3" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="arabic3">60</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="80" name="arabic" id="arabic4" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="arabic4">80</label>
                                       </div>
                                    </fieldset>
                                    <fieldset>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" value="100" name="arabic" id="arabic6" class="custom-control-input" aria-invalid="false">
                                          <label class="custom-control-label" for="arabic6">100</label>
                                       </div>
                                    </fieldset>
                                     <!-- <input type="number" name="intellectual" class="form-control" value="{{ old('intellectual') }}" id="Intellectual"> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="tab-pane p-10" id="addresses" style="background-color: #f8f8f8">
                     <section class="p-10">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="card-header">
                                       <h4 class="text-center">Life Skills Evaluation </h4>
                                    </div>
                                 </div>
                                 
                              </div>
                              
                              <div class="row">
                                 <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label>Survey/ Feasibility </label>
                                       <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="0" name="feasibility" required id="feasibility" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="feasibility">0</label>
                                          </div>
                                          <div class="help-block" ></div>
                                       </fieldset>
                                       <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="20" name="feasibility" id="feasibility1" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="feasibility1">20</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="40" name="feasibility" id="feasibility2" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="feasibility2">40</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="60" name="feasibility" id="feasibility3" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="feasibility3">60</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="80" name="feasibility" id="feasibility4" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="feasibility4">80</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="100" name="feasibility" id="feasibility6" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="feasibility6">100</label>
                                        </div>
                                     </fieldset>
                                       <!-- <input type="number" name="physical" class="form-control" value="{{ old('physical') }}"> -->
                                    </div>
                                 </div>

                                 <div class="col-md-1">
                                    <div class="form-group">
                                       <label>Networking</label>
                                       <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="0" name="networking" required id="networking" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="networking">0</label>
                                          </div>
                                          <div class="help-block" ></div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                              <input type="radio" value="20" name="networking" id="networking2" class="custom-control-input" aria-invalid="false">
                                              <label class="custom-control-label" for="networking2">20</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="40" name="networking" id="networking3" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="networking3">40</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="60" name="networking" id="networking4" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="networking4">60</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="80" name="networking" id="networking5" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="networking5">80</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="100" name="networking" id="networking6" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="networking6">100</label>
                                          </div>
                                       </fieldset>
                                       <!-- <input type="number" name="finance" class="form-control" value="{{ old('finance') }}" id="finance"> -->
                                    </div>
                                 </div>

                                 <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label>Managing</label>
                                       <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="0" name="managing" required id="managing" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="managing">0</label>
                                          </div>
                                          <div class="help-block" ></div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="20" name="managing" id="managing1" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="managing1">20</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="40" name="managing" id="managing2" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="managing2">40</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="60" name="managing" id="managing3" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="managing3">60</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="80" name="managing" id="managing4" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="managing4">80</label>
                                          </div>
                                       </fieldset>
                                       <fieldset>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="100" name="managing" id="managing6" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="managing6">100</label>
                                          </div>
                                       </fieldset>
                                        <!-- <input type="number" name="intellectual" class="form-control" value="{{ old('intellectual') }}" id="Intellectual"> -->
                                    </div>
                                 </div>

                                 <div class="col-md-1">
                                    <div class="form-group label-floating">
                                       <label>Leadership </label>
                                       <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="0" name="leadership" required id="leadership" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="leadership">0</label>
                                          </div>
                                          <div class="help-block" ></div>
                                       </fieldset>
                                       <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="20" name="leadership" id="leadership2" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="leadership2">20</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="40" name="leadership" id="leadership3" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="leadership3">40</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="60" name="leadership" id="leadership4" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="leadership4">60</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="80" name="leadership" id="leadership5" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="leadership5">80</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="100" name="leadership" id="leadership6" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="leadership6">100</label>
                                        </div>
                                     </fieldset>
                                       <!-- <input type="number" name="physical" class="form-control" value="{{ old('physical') }}"> -->
                                    </div>
                                 </div>

                                 <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label>Communication </label>
                                       <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="0" name="communication" required id="communication" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="communication">0</label>
                                          </div>
                                          <div class="help-block" ></div>
                                       </fieldset>
                                       <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="20" name="communication" id="communication2" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="communication2">20</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="40" name="communication" id="communication3" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="communication3">40</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="60" name="communication" id="communication4" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="communication4">60</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="80" name="communication" id="communication5" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="communication5">80</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="100" name="communication" id="communication6" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="communication6">100</label>
                                        </div>
                                     </fieldset>
                                       <!-- <input type="number" name="physical" class="form-control" value="{{ old('physical') }}"> -->
                                    </div>
                                 </div>

                                 <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label>Organising </label>
                                       <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="0" name="organising" required id="organising" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="organising">0</label>
                                          </div>
                                          <div class="help-block" ></div>
                                       </fieldset>
                                       <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="20" name="organising" id="organising1" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="organising1">20</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="40" name="organising" id="organising2" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="organising2">40</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="60" name="organising" id="organising3" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="organising3">60</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="80" name="organising" id="organising4" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="organising4">80</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="100" name="organising" id="organising5" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="organising5">100</label>
                                        </div>
                                     </fieldset>
                                       <!-- <input type="number" name="physical" class="form-control" value="{{ old('physical') }}"> -->
                                    </div>
                                 </div>

                                 <div class="col-md-2">
                                    <div class="form-group label-floating">
                                       <label>Team Player </label>
                                       <fieldset class="controls">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" value="0" name="team_player" required id="team_player" class="custom-control-input" aria-invalid="false">
                                             <label class="custom-control-label" for="team_player">0</label>
                                          </div>
                                          <div class="help-block" ></div>
                                       </fieldset>
                                       <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="20" name="team_player" id="team_player1" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="team_player1">20</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="40" name="team_player" id="team_player2" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="team_player2">40</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="60" name="team_player" id="team_player3" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="team_player3">60</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="80" name="team_player" id="team_player4" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="team_player4">80</label>
                                        </div>
                                     </fieldset>
                                     <fieldset>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" value="100" name="team_player" id="team_player5" class="custom-control-input" aria-invalid="false">
                                           <label class="custom-control-label" for="team_player5">100</label>
                                        </div>
                                     </fieldset>
                                       <!-- <input type="number" name="physical" class="form-control" value="{{ old('physical') }}"> -->
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
