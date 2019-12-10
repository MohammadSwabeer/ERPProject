<?php use \App\Http\Controllers\MainController;$main = new MainController;?>
@extends('admin/mainpage/adminmain')

@section('admincontents')
@foreach($post as $posts)
<div class="row">
      <div class="col-md-4">
        <div class="card box-shadow-gradient p-10-0  m-t-m-10">
          <div class="card-body std-card-body m-t-m-10 br-5 p-15" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
              <div class="media">
                <div class="media-left">
                  <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle" width="65">
                </div>
                <div class="media-body p-10">
                  <h4 class="card-title m-t-10 text-white">{{$posts->member_fname}} {{$posts->member_mname}} {{$posts->member_lname}} </h4>
                </div>
              </div>
          	</div>
          <div>
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
                  <h5 class="mt-0 mb-0 font-Trirong">Last Assessed Date:</h5>
                  <p>25 Feb 2019</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


          <div class="card-body bg-white box-shadow br-5">

            <div class="row el-element-overlay">
              <div class="col-md-12">
                <h3 class="card-title text-center">{{$type}} Performance Indicator <span> <div style="margin-top: -37px">
			        <a class="btn btn-danger pull-right bt-small" href="{{route('memberReport',[encrypt($id),encrypt($type),encrypt($unit),encrypt($page)])}}">Report</a>
			        <a class="btn btn-outline-secondary pull-right bt-small" href="{{route('yearlyPlanner',[encrypt($id),encrypt($type),encrypt($unit),encrypt($page)])}}">Yearly Planner</a>
			        <!-- <button id="Print" class="btn btn-default btn-outline pull-right" type="button"> <span><i class="fa fa-print"></i> Print</span> </button> -->
			      </div></span>
			  </h3>
              </div>

              <div class="col-md-8">
                <div class="row">
                  <canvas id="polar-chart"></canvas>
                </div>
              </div>

              	<div class="col-md-4">
		          	<div class="card-body" style="border-right: 1px solid #15141429">

                           <div class="d-flex no -block p-15 align-items-center">
                             <div class="rounds bg-light text-dark" style="background: #ffcd56 !important;"><i class="fa fa-institution font-16 text-white"></i></div>
                             <div class="m-l-10 ">
                               	<h4 class="m-b-0 font-Trirong font-w-900"><a href="{{route('memberPhysicalCredit',[encrypt($posts->id),encrypt($type),encrypt($unit),encrypt($page),encrypt('Physical')])}}" target="_blank">Physical Credis</a></h4>
                               	<h5 class="font-light m-b-0 font-14">Earned Credits: 1450</h5>
                                <h5 class="font-light m-b-0 font-14">Total Credits : 1700 </h5>
                               </div>
                             </div>
                             <hr>
                             <div class="d-flex no-block p-15 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: #36a2eb !important;"><i class="fa fa-graduation-cap font-16 text-white"></i></div>
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong font-w-900"><a href="{{route('memberPhysicalCredit',[encrypt($posts->id),encrypt($type),encrypt($unit),encrypt($page),encrypt('Intellectual')])}}" target="_blank">Intellectual Credits</a></h4>
                                 <h5 class="font-light m-b-0 font-14">Earned Credits: 350 </h5>
                                 <h5 class="font-light m-b-0 font-14">Total Credits : 500 </h5>
                               </div>
                             </div>
                             <hr>
                             <div class="d-flex no-block p-15 m-b-15 align-items-center">
                               <div class="rounds bg-light text-dark" style="background: #07b107 !important;"><i class="fa fa-book font-16 text-white"></i></div>
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong font-w-900"><a href="{{route('memberPhysicalCredit',[encrypt($posts->id),encrypt($type),encrypt($unit),encrypt($page),encrypt('Financial')])}}" target="_blank">Financial Credits</a></h4>
                                 <h5 class="font-light m-b-0 font-14">Earned Credits : 550 </h5>
                                 <h5 class="font-light m-b-0 font-14">Total Credits : 600</h5>
                               </div>
                         	</div>

                         	<hr>
                             <div class="d-flex no-block p-15 m-b-15 align-items-center">
                               <div class="m-l-10">
                                 <h4 class="m-b-0 font-Trirong font-w-900">TOTAL : <span class="font-light m-b-0 font-18 font-w-900">2400 / 2800 </span> </h4>

                               </div>
                         	</div>
		        	</div>
              	</div>
            </div>

          </div>
        @endforeach
    <script type="text/javascript">


    var myChart = new Chart(document.getElementById("polar-chart"), {
      type: 'polarArea',
      fullWidth : true,

      data: {
	        a : ["Physical Credis","Intellectual Credits","Financial Credits"],
	        labels: ["Physical Credis","Intellectual Credits","Financial Credits"],
	        datasets: [
	        {
	          label: "{{$type}} Performance Indicator",
	          backgroundColor: ["#ffcd56","#36a2eb","#07b107"],
	          data: [1450,550,550]
	        }
        ]
      },
      options: {
     //  	onClick: function(e){
     //  		 // var series= element[0]._model.datasetLabel;
     //  		var activePoints = myChart.getElementsAtEvent(e);
     //  		 var label = activePoints[0]._model.label;
     //  		 var data = this.data.datasets[0].data[selectedIndex];
    	// 	var selectedIndex = activePoints[0]._index;
    	// 	console.log(label);
    	// },
        title: {
          display: true,
          // text: 'Womens-wing monthly report'
        },
        legend: {
          display: true,
            labels: {
              mirror : true,
              padding : 2,
                // boxWidth : 15
            }
        },
        tooltips:{
          callbacks: {
            title: function(tooltipItem, data) {
              return data['a'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']];
            },

          }
        }
      }
    });
</script>
@endsection
