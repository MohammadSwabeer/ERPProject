<!-- /* To find basicSkills for main skill while adding questionnaires*/ -->
@if($var == 'findBasicSkill')
	@foreach($post as $posts)
		<option value="">Select Basic Skill</option>
		@foreach($ex as $exp)
	  	<option value="{{$exp}}">{{$exp}}</option>
		@endforeach
	@endforeach
@endif

@if($var === 'stud')
	<?php $id=1; ?>
	@foreach($post as $posts)
    <tr class="text-center btn-block-inline">
      <td>{{$id}}</td>
      <td>{{$posts->fname}}</td>
      @if($posts->lname != null)
      <td>{{$posts->lname}}</td>
      @else
      <td>{{"---"}}</td>
      @endif
      <td>{{$posts->gender}}</td>
      <td>{{$posts->dob}}</td>yyyzz			
      <td>{{$posts->age}}</td> 
      @if($posts->belongs_to != null)
      <td>{{$posts->belongs_to}}</td>
      @else
      <td class="text-danger">not provided</td>
      @endif
      <td>{{$posts->colony}}</td>
      <td>{{$posts->std_door}}</td>
      <td>
        <a class="btn btn-circle btn-sm btn-outline-primary" href="#" data-toggle="modal" data-target="#studentModal{{$posts->student_id}}"><i class="ti-pencil-alt"></i></a>
      </td>
      <td>
        <a class="btn btn-circle btn-sm btn-outline-danger" href="#" onclick="SWALDATA('{{$posts->student_id}}','{{route('dataStud')}}','std_tbl_body','GET','{{route('destroyStud')}}','{{$posts->std_door}}')"><i class="ti-trash"></i></a>
      </td>
      <td>
        <a class="btn btn-circle btn-sm btn-outline-success" href="{{route('student.show',[$posts->student_id])}}"><i class="ti-more"></i></a>
      </td>
      </tr>
      <?php $id++; ?>
      @endforeach
@endif

@if($var == 'allSkillsData')
	@include('admin/others/Skills_Details/allSkillsData')
@endif

@if($var == 'basicSkillsData')
	@include('admin/others/Skills_Details/basicSkillsAjaxData')
@endif

@if($var == 'QuestionnaireData')
	<div class="accordion" id="accordionBasic">
  <?php $basics = explode(',',$posts->sub_name);$b=1; ?>
		
	  <?php $i=1; ?>
	  @foreach($basics as $base)
	  @foreach($question as $q)
	  @if($q->basic_name == $base)
	  <div class="card bg-white m-b-0 border-bottom">
	    <a data-toggle="collapse" data-target="#{{$q->basic_name}}{{$posts->main_name}}{{$i}}" aria-expanded="false" aria-controls="{{$q->basic_name}}{{$posts->main_name}}{{$i}}">
	      <div class="card-header bg-white p-5" id="{{$q->basic_name}}{{$posts->main_name}}{{$i}}head">
	        <h4 class="mb-0 font-14 font-w-700 font-Roboto">
	          {{$i}}. {{$q->question_name}} 
	          <span class="p-10">
	            <a class="pull-right m-l-5 text-dark" style="border-radius: 5px;padding: 0px 5px 0px 5px;border: 1px solid;" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Click here" data-placement="left">
	              <i class="ti-more"></i>
	            </a>
	            <div class="dropdown-menu">
	              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubModal">
	                <i class="fa fa-pencil text-success"></i>
	              </a>
	              <a class="dropdown-item" href="#" onclick="SWALDATA('{{$q->id}}','{{route('questionnairsDelete')}}','retrieveQuestionnaire','{{route('retrieveQuestionnaire')}}')">
	                <i class="fa fa-trash-o text-danger"></i>
	              </a>
	              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addQuetionModal">
	                <i class="fa fa-share"></i>
	              </a>
	            </div>
	            
	            <span class="badge badge-pill badge-cyan pull-right" style="background: linear-gradient(to right, #000000 11%, #000000 100%)">
	              {{count(explode(',',$q->options))+1}} Options
	            </span>
	          </span>
	        </h4>
	      </div>
	    </a>
	    <div id="{{$q->basic_name}}{{$posts->main_name}}{{$i}}" class="collapse" aria-labelledby="{{$q->basic_name}}{{$posts->main_name}}{{$i++}}head" data-parent="#accordionBasic">
	      <div class="card-body">
	        <h4 class="font-12 text-success"><i class="fa fa-eercast"></i> {{$q->answer}}</h4>
	        @foreach((explode(',',$q->options)) as $opt)
	          <h4 class="font-12"><i class="fa fa-eercast"></i> {{$opt}}</h4>
	        @endforeach
	      </div>
	    </div>
	  </div>
	  @endif
	  @endforeach
	  @endforeach
	</div>
@endif
