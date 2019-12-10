<?php use \App\Http\Controllers\Admin\Projects\FamiliesController;$fam = new FamiliesController;?>
@if($next == 'HeadId')
	@if($count == 1)
	    <option value="Member">Member</option>
	@else
		<option value="">Select Role</option>
	    <option value="Head">Head</option>
	    <option value="Member">Member</option>
	@endif
@endif

@if($next == 'FoundMobile')
  {{($count > 0) ? "The mobile number has already been taken." : ""}}
@endif

@if($next == 'FoundPhone')
  {{($count > 0) ? "The mobile has already been taken." : ""}}
@endif

@if($next == 'FoundEmail')
  {{($count > 0) ? "The email has already been taken." : ""}}
@endif

@if($next == 'inst_find')
	@if($count > 0)

    @foreach($post as $posts)
    <div class="col-md-4">
      <div class="form-group">
         <label for="sector">Sector :</label>
         <input type="text" name="sector" class="custom-select form-control" id="sector" value="{{$posts->sector}}">
      </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
        <label for="community_type">Community Type :</label>
        <input type="text" name="community_type" class="custom-select form-control" id="community_type" value="{{$posts->institution_category}}">
     </div>
  </div>

   <div class="col-md-4">
      <div class="form-group">
         <label for="institution_type">School/ College Category :</label>
         <input list="Institution_type" type="text" name="institution_type" class="custom-select form-control" id="institution_type" value="{{$posts->community_type}}">
      </div>
   </div>

   <div class="col-md-12">
      <div class="form-group">
         <label for="inst_street">Area/ Street/ Village</label>
         <textarea name="inst_street" id="inst_street" rows="6" class="form-control">{{$posts->street}}</textarea>
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group">
         <label for="inst_city">Taluk/ City :</label>
         <input type="text" name="inst_city" id="inst_city" class="form-control" value="{{$posts->city}}">
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group">
         <label for="inst_District">District :</label>
         <input type="text" name="inst_district" id="inst_District" class="form-control" value="{{$posts->district}}">
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group ">
         <label for="inst_state">State :</label>
         <input class="form-control" type="text" name="inst_state" id="inst_state" value="{{$posts->state}}">
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group">
         <label for="inst_pincode">Pin Code :</label>
         <input type="number" name="inst_pincode" class="form-control" id="inst_pincode" value="{{$posts->pin_code}}">
      </div>
   </div>
   @endforeach
  @else
    <div class="col-md-4">
      <div class="form-group">
         <label for="sector">Sector :</label>
         <input list="Sector" type="text" name="sector" class="custom-select form-control" id="sector" value="{{old('sector')}}">
         <datalist id="Sector">
            <option value="Government"></option>
            <option value="Private"></option>
         </datalist>
      </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
        <label for="community_type">Community Type :</label>
        <input list="Community_type" type="text" name="community_type" class="custom-select form-control" id="community_type" value="{{old('community_type')}}">
        <datalist id="Community_type">
           <option value="Community"></option>
           <option value="Non Community"></option>
        </datalist>
     </div>
  </div>

   <div class="col-md-4">
      <div class="form-group">
         <label for="institution_type">School/ College Category :</label>
         <input list="Institution_type" type="text" name="institution_type" class="custom-select form-control" id="institution_type" value="{{old('institution_type')}}">
         <datalist id="Institution_type">
            <option value="CBSE"></option>
            <option value="State"></option>
            <option value="Other"></option>
         </datalist>
      </div>
   </div>

   <div class="col-md-12">
      <div class="form-group">
         <label for="inst_street">Area/ Street/ Village</label>
         <textarea name="inst_street" id="inst_street" rows="6" class="form-control">{{old('inst_street')}}</textarea>
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group">
         <label for="inst_city">Taluk/ City :</label>
         <input list="inst_City" type="text" name="inst_city" id="inst_city" class="form-control" value="{{old('inst_city')}}">
         <datalist id="inst_City">
            <option value="Bantval"></option>
            <option value="Mangalore"></option>
            <option value="Belthangady"></option>
         </datalist>
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group">
         <label for="inst_District">District :</label>
         <input list="inst_district" type="text" name="inst_district" id="inst_District" class="form-control" value="{{old('inst_district')}}">
         <datalist id="inst_district">
            <option value="Dakshina Kannada"></option>
            <option value="Udupi"></option>
         </datalist>
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group ">
         <label for="inst_state">State :</label>
         <input list="inst_State" class="form-control" type="text" name="inst_state" id="inst_state" value="{{ old('inst_state')}}">
         <datalist id="inst_State">
            <option value="Karnataka"></option>
            <option value="Kerala"></option>
         </datalist>
      </div>
   </div>

   <div class="col-md-3">
      <div class="form-group">
         <label for="inst_pincode">Pin Code :</label>
         <input type="number" name="inst_pincode" class="form-control" id="inst_pincode" value="{{old('inst_pincode')}}">
      </div>
   </div>
  @endif
@endif

@if($next == 'city')
  @if($count > 0)
    @foreach($city as $cit)
      <div class="col-md-4">
        <div class="form-group label-floating">
           <label for="District" class="control-label">District :</label>
           <input list="district" type="text" name="district" id="District" class="form-control" value="{{$cit->dist_name}}">
           <datalist id="district">
              <option value="Dakshina Kannada"></option>
              <option value="Udupi"></option>
           </datalist>
        </div>
     </div>

     <div class="col-md-4">
        <div class="form-group label-floating">
           <label for="state" class="control-label">State :</label>
           <input list="State" class="form-control" type="text" name="state" id="state" value="{{$cit->state_name}}">
           <datalist id="State">
              <option value="Karnataka"></option>
              <option value="Kerala"></option>
           </datalist>
        </div>
     </div>

     <div class="col-md-4">
        <div class="form-group label-floating">
           <label for="pincode" class="control-label">Pin Code :</label>
           <input type="number" name="pincode" class="form-control" id="pincode" value="{{$cit->pincode}}">
        </div>
     </div>
    @endforeach
  @else
    <div class="col-md-4">
      <div class="form-group label-floating">
         <label for="District" class="control-label">District :</label>
         <input list="district" type="text" name="district" id="District" class="form-control" value="{{ old('district') }}">
         <datalist id="district">
            <option value="Dakshina Kannada"></option>
            <option value="Udupi"></option>
         </datalist>
      </div>
   </div>

   <div class="col-md-4">
      <div class="form-group label-floating">
         <label for="state" class="control-label">State :</label>
         <input list="State" class="form-control" type="text" name="state" id="state" value="{{ old('state') }}">
         <datalist id="State">
            <option value="Karnataka"></option>
            <option value="Kerala"></option>
         </datalist>
      </div>
   </div>

   <div class="col-md-4">
      <div class="form-group label-floating">
         <label for="pincode" class="control-label">Pin Code :</label>
         <input type="number" name="pincode" class="form-control" id="pincode" value="{{ old('pincode') }}">
      </div>
   </div>
  @endif
@endif

@if($next == 'HSCCFamDestroy')
		<?php $id=1; ?>
        @foreach($post as $posts)
        <tr>	
          <td>{{$id++}}</td>
          <td>{{$posts->presentFamilyDoor}}</td>
          <td>{{$posts->hfId}}</td>
          <td><a href="{{route('showHSCCFamilyDetails',[$posts->hfId])}}">{{$posts->fname}}</a></td>
          <td>{{$fam->countDependents($posts->hfId)-1}}</td>

          @if($posts->mobile !=null || $posts->mobile != '')
          <td>{{$posts->mobile}}</td>
          @else
          <td style="color: red">{{"Not-Provided"}}</td>
          @endif
          <td>{{$posts->gender}}</td>
          <td>{{$fam->age($posts->dob)}}</td>
          <td>{{$posts->dojHSCC}}</td>

          @if($posts->qualification !=null || $posts->qualification != '')
          <td>{{$posts->qualification}}</td>
          @else
          <td style="color: red">{{"Not-Provided"}}</td>
          @endif

          <td>{{$posts->occupation}}</td>
          <td>
            <a class="btn btn-circle btn-sm btn-outline-info m-0" href="{{route('showHSCCFamilyDetails',[$posts->hfId])}}"><i class="ti-more-alt"></i></a>
          </td>
       <!--    <td>
            <a class="btn btn-circle btn-sm btn-outline-primary m-0" href="{{route('HSCCFamilyEdit',[$posts->id,'Head'])}}"><i class="ti-pencil-alt"></i></a>
          </td> -->
          <td>
            <a class="btn btn-circle btn-sm btn-outline-danger" onclick="SWALDATA('{{$posts->hfId}}','{{route('HSCCFamilyRemove')}}','HSCCData','HSCC Family','{{route('appendHSCCData')}}')"><i class="ti-trash"></i>
            </a>
          </td>

        </tr>
        @endforeach
@endif

@if($next == 'generalEdu')
  @foreach($post as $posts)
    @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._generalEduChartJs')
  @endforeach
@endif   

@if($next == 'spiritualDev')
  @if(count($post))
  @foreach($post as $posts)
    @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._spiritualChart')
  @endforeach
  @else
    @include('admin.Error_Pages.boxerrorpage')
 @endif
@endif

@if($next == 'lifeSkillsEval')
  @if(count($post))
  @foreach($post as $posts)
    @include('admin.Projects.StudentsInfo.HSCCStudents.ChartData._lifeSkillsChart')
  @endforeach
  @else
    @include('admin.Error_Pages.boxerrorpage')
 @endif
@endif