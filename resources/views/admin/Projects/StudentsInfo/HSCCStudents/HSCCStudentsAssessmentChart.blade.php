<?php use \App\Http\Controllers\MainController; $main = new MainController;?>
@extends('admin/mainpage/adminmain')

@section('admincontents')
  
<div class="row">

   <div class="col-md-12">
      <hr>
   </div>

   <div class="col-md-12">
      <div class="row">
         <div class="col-md-4">
            <div class="card box-shadow-gradient p-10-0  m-t-m-10">
               <div class="card-body std-card-body m-t-m-10 br-5 p-15 text-dark">
                  <div class="media">
                     <div class="media-left">
                        <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle" width="65">
                     </div>
                     <div class="media-body p-10">
                        <h4 class="card-title m-t-10">Swabbeer</h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-md-4">
            <div class="card box-shadow br-5 m-t-m-10">
               <div class="card-body p-b-0 open-sans">
                  <div class="row">
                     <div class="media">
                        <div class="media-left">
                           <i class="ti-calendar text-theme-colored font-25 pr-10"></i>
                        </div>
                        <div class="media-body">
                           <h5 class="mt-0 mb-0 font-Trirong">Last Evaluated Date:</h5>
                           <p>{{'Evaluating soon..'}}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-md-4">
            <div class="card box-shadow br-5 m-t-m-10">
               <div class="card-body p-b-0 open-sans">
                  <div class="row">
                     <div class="media">
                        <div class="media-left">
                           <i class="ti-calendar text-theme-colored font-25 pr-10"></i>
                        </div>
                        <div class="media-body">
                           <h5 class="mt-0 mb-0 font-Trirong">Last Evaluated Date:</h5>
                           <p>{{'Evaluating soon..'}}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
  
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card box-shadow br-5">
      <div class="card-body">
        <h4 class="card-title">General Education Over all Performance</h4>
        <ul class="list-inline text-right">
            <li> <h5><i class="fa fa-circle m-r-5 text-info"></i>General Education</h5> </li>
        </ul>
        @if(count($getGen))
        <div id="morris-area-chart"></div>
        @else
          @include('admin/Error_Pages/error_page2')
       @endif

      </div>
      <div class="accordion" id="p">
         <div class="row p-0-30-0-30">
            <div class="col-md-12">
               <a data-toggle="collapse" data-target="#d" aria-expanded="false" aria-controls="d" class="animated zoomIn b-none btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-success btn-block box-shadow-e">
                  <h4 class="m-auto text-capitalize"> General Education Information</h4>
               </a>

               <div id="d" class="collapse" data-parent="p">
                   <div class="card-body animated zoomIn br-5">
                     @if(count($getGen))
                     <div class="table-responsive">
                        <table id="StudentEducationTable" class="table table table table-hover contact-list footable-loaded footable">
                           <thead>
                              <tr>
                                 <th>Course</th>
                                 <th>Grade</th>
                                 <th>Performance</th>
                                 <th>Year</th>
                              </tr>
                           </thead>
                           <tbody id="std_tbl_body">
                              @foreach($getGen as $education)
                              <tr class="text-center btn-block-inline">
                                 <td>{{ifAnd($education->course_name) ? $education->course_name : '-'}}</td>
                                 <td>{{$education->standard_grade}}</td>
                                 <td>{{ifAnd($education->performance) ? $education->performance : '-'}}</td>
                                 <td>{{$education->edu_year}}</td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     @else
                        @include('admin/Error_Pages/error_page2')
                     @endif
                   </div>
               </div>
            </div>
         </div>
      </div>
    </div>
  </div>
   <div class="col-md-6">
      <div class="card box-shadow br-5">
         <div class="card-body">
            <h4 class="card-title">Assessments/ Evaluation Chart</h4>
            <ul class="list-inline text-right">
               <li> <h5><i class="fa fa-circle m-r-5 text-inverse"></i>General Education</h5> </li>
               <li> <h5><i class="fa fa-circle m-r-5 text-info"></i>Religious Education</h5> </li>
               <li> <h5><i class="fa fa-circle m-r-5" style="color: #55ce63"></i>Skills </h5> </li>
            </ul>
            <div id="morris-bar-chart"></div>
         </div>
      </div>
  </div>
</div>

<script type="text/javascript" src="{{asset('adminAssets/js/commonfun.js')}}"></script>
<script type="text/javascript">

   // document.addEventListener('touchstart', 'handler', {capture: true});
window.addEventListener("load", function(e){
e.preventDefault();
var check,v,msg,totSubYear,ged=[],ge={},a=[],finalData=[];
@if(count($getGen))
   dob = '{{getProper($getAgeen,"dob")}}';
   @foreach($getGen as $posts)
       ge = []; ge.values = '{{$posts->performance}}'; ge.year = '{{$posts->edu_year}}'; ged.push(ge);
   @endforeach

   $.each(ged, function(vals) { return a.push(getEvaluatingData(ged[vals])); });
   $.each(a, function(g) { return finalData.push({period: a[g][0].period,gEdu:a[g][0].gEdu}); });

   function getEvaluatingData(p) {
      ge = [];check = g.getAge(dob) - (g.getAge(p.year));
      msg = g.ifZero(Math.round(p1.values)) ? ' Performance not updated' : '';
      (check < 30) ? ge.push({ period: g.getPeriod(p.year,check,msg), gEdu: Math.round(p.values) }) : null;
      return ge; }

   Morris.Area({  
        element: 'morris-area-chart',
        data: finalData,
        xkey: 'period',
        ykeys: ['gEdu'],
        labels: ['General Education'],
        pointSize: 3,
        fillOpacity: 0.4,
        pointStrokeColors:['#009efb'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 3,
        hideHover: 'auto',
        lineColors: ['#009efb'],
        resize: true });
@endif

  Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '20016',
            a: 100,
            b: 90,
        }, {
            y: '20017',
            a: 75,
            b: 85,
        }, {
            y: '20018',
            a: 50,
            b: 40,
        }, {
            y: '20019',
            a: 75,
            b: 65,
        }],
        showInLegend: true,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Spiritual Development', 'Life Skills'],
        barColors:['#55ce63', '#2f3d4a'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });
},{capture: true});
   
</script>
@endsection
