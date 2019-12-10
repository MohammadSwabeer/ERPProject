<!-- General Chart -->
    <div class="col-md-6 border-right">
       <div class="card m-b-0 p-b-0 p-t-0">
          <div class="d-flex no-block p-5 align-items-center">
             <div class="round bg-light text-dark"><i class="fa fa-institution font-16"></i></div>
             <div class="m-l-10">
                <h4 class="m-b-0 font-Trirong">School/ College:</h4>
                @if(ifAnd($posts->institution_name))
                   <h5 class="font-light m-b-0 font-14 text-lights"> Name : 
                      <span><a href="javascript:void(0)">{{$posts->institution_name}}</a></span>
                   </h5>
                   <h5 class="font-light m-b-0 font-14 text-lights">Address : <span>{{$posts->inst_street.', '.$posts->inst_city.', '.$posts->inst_district.', '.$posts->inst_state.', '.$posts->pin_code}}</span></h5>
                @else
                 <h4>N/A</h4>
                @endif  
             </div>
          </div>
          <hr>
          <div class="d-flex no-block p-5 align-items-center">
             <div class="round bg-light text-dark"><i class="fa fa-graduation-cap font-16"></i></div>
             <div class="m-l-10">
                <h4 class="m-b-0 font-Trirong">Grade/ Standard and Perfomance:</h4>
                <h5 class="font-light m-b-0 font-14">Grade : <span class="text-lights">{{$posts->standard_grade}}</span></h5>
                <h5 class="font-light m-b-0 font-14">Qualification Year : <span class="text-lights">{{$posts->edu_year}}</span></h5>
                <h5 class="font-light m-b-0 font-14">Present Status : <span class="text-lights">{{$posts->present_status}}</span></h5>
                <h5 class="font-light m-b-0 font-14">Perfomance : 
                  <span class="text-lights">{{ifAnd($posts->performance) ? $posts->performance : 'N/A'}}</span> 
                  <span class="pull-right"><a href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Marks{{$posts->id}}">{{ifAnd($posts->marks_img) ? 'view' : 'upload'}} marks card</a></span> 
                </h5>
             </div>
          </div>
          <hr>
          <div class="d-flex no-block p-5 m-b-15 align-items-center">
             <div class="round bg-light text-dark"><i class="fa fa-book font-16"></i></div>
             <div class="m-l-10">
                <h4 class="m-b-0 font-Trirong">Strength and Weakness:</h4>
                <h5 class="font-light m-b-0 font-14">Weakness : <span class="text-lights">{{ifAnd($posts->weakness) ? $posts->weakness : 'N/A'}}</span></h5>
                <h5 class="font-light m-b-0 font-14">Strength : <span class="text-lights">{{ifAnd($posts->strength) ? $posts->strength : 'N/A'}}</span></h5>
             </div>
          </div>
       </div>
    </div>

    <div class="col-md-6 text-center">
       <div id="morris-donut-chart4" class="h-260">
          @if(!ifAnd($posts->performance))
          <div class="card m-auto" style="width: 240px;margin-top: -258px !important;background: #c2ddd4f2;border-radius: 120px;">
             <div class="crad-header" style="padding: 90px 0px 90px 0px;">
                @if($posts->present_status == 'Completed')
                   <h3>{{$posts->present_status}} <span class="font-12">But Performance N/A</span></h3>
                @else
                <h2>{{$posts->present_status}}</h2>
                @endif
             </div>
          </div>
          @endif
       </div>
       <ul class="list-inline text-right">
          <li><p><i class="fa fa-circle m-r-5 color-high"></i>General Education</p></li>
          <li><p><i class="fa fa-circle m-r-5"></i>Need to improve</p></li>
       </ul>
    </div>
                     <!-- end General Chart -->
<script type="text/javascript" src="{{asset('adminAssets/js/commonfun.js')}}"></script>
<script type="text/javascript">
   var gedu = c.chartData(parseInt('{{ifAnd($posts->performance) ? $posts->performance : 0}}'));
   Morris.Donut({
      barGap:3,
      barSizeRatio:0.1,
      element: 'morris-donut-chart4',
      data: [{
         label: "General Education",
         value: Math.round(g.ifCheck(gedu[0].values) ? gedu[0].values : 0),
      }, {
         label: "Need to Progress",
         value: Math.round(g.ifCheck(gedu[0].rem) ? gedu[0].rem : 0)
      }],
      resize: true,
      colors:['#55ce63', '#2f3d4a']
  });
</script>
