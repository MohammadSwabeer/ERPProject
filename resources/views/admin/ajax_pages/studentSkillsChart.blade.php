<?php use \App\Http\Controllers\MainController; ?>
@if($report == 0)

<div class="offset-md-1 col-md-2">
  <div id="morris-donut-chart0"></div>
  <div class="card mt-m-60 border-right">
    <div class="d-flex no-block p-15 m-b-15 m-auto align-items-center">
      <i class="fa fa fa-eercast font-16" style="color:#2a7e34"></i>
      <div class="m-l-10">
        <h3 class="m-b-0 font-Trirong font-14">Networking</h3>
        <h4 class="m-b-0 font-Trirong font-16">{{$networkingCalc}} %</h4>
      </div>
    </div>
  </div>
</div>

<div class="col-md-2">
  <div id="morris-donut-chart1"></div>
  <div class="card mt-m-60 border-right">
    <div class="d-flex no-block p-15 m-b-15 m-auto align-items-center">
      <i class="fa fa fa-eercast font-16" style="color:#24af34"></i>
      <div class="m-l-10">
        <h3 class="m-b-0 font-Trirong font-14">Presentation</h3>
        <h4 class="m-b-0 font-Trirong font-16">{{$presentationCalc}} %</h4>
      </div>
    </div>
  </div>
</div>

<div class="col-md-2">
  <div id="morris-donut-chart2"></div>
  <div class="card mt-m-60 border-right">
    <div class="d-flex no-block p-15 m-b-15 m-auto align-items-center">
      <i class="fa fa fa-eercast font-16" style="color:#55ce63"></i>
      <div class="m-l-10">
        <h3 class="m-b-0 font-Trirong font-14">Leadership</h3>
        <h4 class="m-b-0 font-Trirong font-16">{{$leadershipCalc}} %</h4>
      </div>
    </div>
  </div>
</div>

<div class="col-md-2">
  <div id="morris-donut-chart3"></div>
  <div class="card mt-m-60">
    <div class="d-flex no-block p-15 m-b-15 m-auto align-items-center">
      <i class="fa fa fa-eercast font-16" style="color:#77f986"></i>
      <div class="m-l-10">
        <h3 class="m-b-0 font-Trirong font-14">Strategic Planning</h3>
        <h4 class="m-b-0 font-Trirong font-16">{{$planCalc}} %</h4>
      </div>
    </div>
  </div>
</div>

<div class="col-md-2">
  <div id="morris-donut-chart33"></div>
  <div class="card mt-m-60">
    <div class="d-flex no-block p-15 m-b-15 m-auto align-items-center">
      <i class="fa fa fa-eercast font-16" style="color:#93f19e"></i>
      <div class="m-l-5">
        <h3 class="m-b-0 font-Trirong font-14">Counclling</h3>
        <h4 class="m-b-0 font-Trirong font-16">{{$councCalc}} %</h4>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	Morris.Donut({
    element: "morris-donut-chart0",
    data: [{
      label: "Networking",
      value: Math.round('{{$networkingCalc}}')
      }, {
        label: "Need to Progress",
        value: Math.round('{{$networkingRem}}')
        }],
        resize: true,
        colors:['#2a7e34', '#2f3d4a']
      });
  // 009efb

	Morris.Donut({
    element: "morris-donut-chart1",
    data: [{
      label: "Presentation",
      value: Math.round('{{$presentationCalc}}')
      }, {
        label: "Need to Progress",
        value: Math.round('{{$presentationRem}}')
        }],
        resize: true,
        colors:['#29a137', '#2f3d4a']
      });

	Morris.Donut({
    element: "morris-donut-chart2",
    data: [{
      label: "Leadership",
      value: Math.round('{{$leadershipCalc}}')
      }, {
        label: "Need to Progress",
        value: Math.round('{{$leadershipRem}}')
        }],
        resize: true,
        colors:['#55ce63', '#2f3d4a']
      });
  // #d17905

	Morris.Donut({
    element: "morris-donut-chart3",
    data: [{
      label: "Sports",
      value: Math.round('{{$planCalc}}')
      }, {
        label: "Need to Progress",
        value: Math.round('{{$sportsRem}}')
        }],
        resize: true,
        colors:['#77f986', '#2f3d4a']
      });

  Morris.Donut({
        element: 'morris-donut-chart33',
        data: [{
          label: "Councling",
          value: Math.round('{{$councCalc}}'),

        }, {
          label: "Need to Progress",
          value: Math.round('{{$councRem}}')
        }],
        resize: true,
        colors:['#93f19e', '#2f3d4a']
      });
</script>
@else
<!-- $report = 1 -->
<!-- Students Annual Report -->
@foreach($post as $posts)
<div class="col-md-12">
  <div class="card card-body printableArea">
    <h3><b>Student-Evaluation Yearly Report</b><span class="pull-right">Hidayah-Foundation</span></h3>
    <hr>
    <div class="row">
      <div class="col-md-12">
        <div class="pull-left">
          <address>
            <h3> &nbsp;<b class="text-danger">{{$posts->fname}} {{$posts->lname}}</b></h3>
            <p class="text-muted m-l-5"> {{$posts->door}} - {{$posts->street}},
              <br/>{{$posts->taluk}},
              <br/>{{$posts->state}}, 
              <br/>{{$posts->postcode}} 
            </p>
          </address>
        </div>
        <div class="pull-right text-right">
          <address>
            <!-- <h3>To,</h3> -->
            <h4 class="font-bold">School/ College : {{$posts->school}},</h4>
            <p class="text-muted m-l-30">Grade : {{$posts->grade}}</p>
            @if($posts->strong !== null)
            <p class="text-muted m-l-30">Strong Subject : {{$posts->strong}}</p>
            @endif
            @if($posts->strong !== null)
            <p class="text-muted m-l-30">Weak Subject : {{$posts->weak}}</p>
            @endif
            <p class="m-t-30"><b>Evaluation Date : </b> <i class="fa fa-calendar"></i> {{MainController::DATE_FORMAT_DASH($posts->year)}}</p>
            <!-- <p><b>Due Date :</b> <i class="fa fa-calendar"></i> 25th Jan 2017</p> -->
          </address>
        </div>
      </div>
      <div class="col-md-12">
        <div class="table-responsive m-t-40" style="clear: both;">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Description</th>
                <th>Perfomance</th>
                <!-- <th class="text-right">Perfomance(%)</th> -->
                <th class="text-right">Remarks (%)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="2"><b>General Education</b></td>
                <!-- calling function in Control -->

                @if((MainController::remark($posts->perfomance)) == 'Need to be improved')
                <td class="text-danger">{{MainController::remark($posts->perfomance)}}</td>
                @else
                <td>{{MainController::remark($posts->perfomance)}}</td>
                @endif

                @if((MainController::remark($posts->perfomance)) == 'Need to be improved')
                <td class="text-danger text-right ">{{($posts->perfomance / 5) * 100}}</td>
                @else
                <td class="text-right">{{ $posts->perfomance }}</td>
                @endif
              </tr>
              <tr>
                <td colspan="4"><b>Student Relegious Education :</b></td>
              </tr>
              <tr>
                <td class="text-center">1</td>
                <td>Madrasa</td>
                @if((MainController::remarkRelegious($posts->madrasa)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->madrasa)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->madrasa)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->madrasa)) == 'Low')
                <td class="text-danger text-right ">{{$posts->madrasa}}</td>
                @else
                <td class="text-right">{{$posts->madrasa}}</td>
                @endif
              </tr>
              <tr>
                <td class="text-center">2</td>
                <td>Huqub-Al-Ibada</td>
                @if((MainController::remarkRelegious($posts->ibada)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->ibada)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->ibada)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->ibada)) == 'Low')
                <td class="text-danger text-right ">{{$posts->ibada}}</td>
                @else
                <td class="text-right">{{ $posts->ibada }}</td>
                @endif
              </tr>

              <tr>
                <td class="text-center">3</td>
                <td>Practices</td>
                @if((MainController::remarkRelegious($posts->practices)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->practices)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->practices)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->practices)) == 'Low')
                <td class="text-danger text-right ">{{$posts->practices}}</td>
                @else
                <td class="text-right">{{$posts->practices}}</td>
                @endif
              </tr>

              <tr>
                <td colspan="4"><b> Student Skills :</b></td>
              </tr>
              
              <tr>
                <td class="text-center">1</td>
                <td>Networking</td>
                @if((MainController::remarkRelegious($posts->networking)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->networking)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->networking)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->networking)) == 'Low')
                <td class="text-danger text-right ">{{$posts->networking}}</td>
                @else
                <td class="text-right">{{$posts->networking}}</td>
                @endif
              </tr>

              <tr>
                <td class="text-center">2</td>
                <td>Presentation</td>
                @if((MainController::remarkRelegious($posts->presentation)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->presentation)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->presentation)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->presentation)) == 'Low')
                <td class="text-danger text-right ">{{$posts->presentation}}</td>
                @else
                <td class="text-right">{{$posts->presentation}}</td>
                @endif
              </tr>

              <tr>
                <td class="text-center">3</td>
                <td>Leadership</td>
                @if((MainController::remarkRelegious($posts->leadership)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->leadership)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->leadership)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->leadership)) == 'Low')
                <td class="text-danger text-right">{{$posts->leadership}}</td>
                @else
                <td class="text-right">{{$posts->leadership}}</td>
                @endif
              </tr>

              <tr>
                <td class="text-center">4</td>
                <td>Strategic Planning</td>
                @if((MainController::remarkRelegious($posts->planning)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->planning)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->planning)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->planning)) == 'Low')
                <td class="text-danger text-right ">{{$posts->planning}}</td>
                @else
                <td class="text-right">{{$posts->planning}}</td>
                @endif
              </tr>

              <tr>
                <td class="text-center">5</td>
                <td>Counclling</td>
                @if((MainController::remarkRelegious($posts->counclling)) == 'Low')
                <td class="text-danger">{{MainController::remarkRelegious($posts->counclling)}}</td>
                @else
                <td>{{MainController::remarkRelegious($posts->counclling)}}</td>
                @endif

                @if((MainController::remarkRelegious($posts->counclling)) == 'Low')
                <td class="text-danger text-right ">{{$posts->counclling}}</td>
                @else
                <td class="text-right">{{$posts->counclling}}</td>
                @endif
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-12">
        <div class="pull-right m-t-30 text-right">
          <hr>
          <h3><b>Overall Remarks : </b> <span class="text-muted">{{floor($posts->remark)}} (%)</span> </h3>
        </div>
      </div>
    </div>
    
  </div>
</div>
@endforeach
@endif