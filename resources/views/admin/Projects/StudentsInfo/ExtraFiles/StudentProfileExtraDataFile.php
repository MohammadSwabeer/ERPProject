<!--**********************Student Skills chart******9*************************-->
<div class="row">
   <div class="col-md-12">
      <div class="card p-b-0 p-t-0">
         <div class="row m-b-0 zi-9">
            <div class="col-md-12">
               <div class="card-title">
                  <select class="custom-select w-auto m-r-10 pull-right " id="skillYear">
                  </select>
                  <h4 class="m-l-15">Student Life-Skills</h4>
               </div>
            </div>
         </div>

         <div class="row" id="chartShow1">
            <?php $m = 0; ?>
            <div class="col-md-2" style="margin-top: -85px">
               <a href="#0" class="text-dark">
                  <div id="morrisSurveying"></div>
                  <div class="mt-m-100 m-l-15 text-center border-right main-skill">
                     <h3 class="m-b-0 font-Trirong font-14">{{'Surveying / Feasibility'}}</h3>
                     <h3 class="font-16 text-center"><span>{{$posts->surveying}}%</span></h3>
                  </div>
               </a>
            </div>

            <div class="col-md-2" style="margin-top: -85px">
               <a href="#0" class="text-dark">
                  <div id="morrisNetworking"></div>
                  <div class="mt-m-100 m-l-15 text-center border-right main-skill">
                     <h3 class="m-b-0 font-Trirong font-14">{{'Networking'}}</h3>
                     <h3 class="font-16 text-center"><span>{{$posts->networking}}%</span></h3>
                  </div>
               </a>
            </div>

            <div class="col-md-2" style="margin-top: -85px">
               <a href="#0" class="text-dark">
                  <div id="morrisManaging"></div>
                  <div class="mt-m-100 m-l-15 text-center border-right main-skill">
                     <h3 class="m-b-0 font-Trirong font-14">{{'Managing'}}</h3>
                     <h3 class="font-16 text-center"><span>{{$posts->managing}}%</span></h3>
                  </div>
               </a>
            </div>

         <div class="col-md-2" style="margin-top: -85px">
            <a href="#0" class="text-dark">
               <div id="morrisLeadership"></div>
               <div class="mt-m-100 m-l-15 text-center border-right main-skill">
                     <h3 class="m-b-0 font-Trirong font-14">{{'Leadership'}}</h3>
                     <h3 class="font-16 text-center"><span>{{$posts->leadership}}%</span></h3>
               </div>
               </a>
         </div>

         <div class="col-md-2" style="margin-top: -85px">
            <a href="#0" class="text-dark">
               <div id="morrisCommunication"></div>
               <div class="mt-m-100 m-l-15 text-center border-right main-skill">
                     <h3 class="m-b-0 font-Trirong font-14">{{'Communication'}}</h3>
                     <h3 class="font-16 text-center"><span>{{$posts->communication}}%</span></h3>
               </div>
            </a>
         </div>

         <div class="col-md-2" style="margin-top: -85px">
            <a href="#0" class="text-dark">
               <div id="morrisOrganising"></div>
               <div class="mt-m-100 m-l-15 text-center border-right main-skill">
                  <h3 class="m-b-0 font-Trirong font-14">{{'Organising'}}</h3>
                  <h3 class="font-16 text-center"><span>{{$posts->organising}}%</span></h3>
               </div>
            </a>
         </div>

          <div class="col-md-2" style="margin-top: -85px">
            <a href="#0" class="text-dark">
              <div id="morrisTeamPlayer"></div>
              <div class="mt-m-100 m-l-15 text-center border-right main-skill">
                <h3 class="m-b-0 font-Trirong font-14">{{'Team Player'}}</h3>
                <h3 class="font-16 text-center"><span>{{$posts->team_player}}%</span></h3>
              </div>
            </a>
          </div>
         </div>
      </div>
   </div>
</div>


<!-- charts -->
<script type="text/javascript">
  var redu=[],gedu=[],basic_skill =[];

  var clr = ['#003300','#004d00','#006600','  #008000','#009900','#00b300','#00cc00','#00e600','#00ff00'];
  var cols = ['#1f7a1f','#258e25','#2aa22a','#2fb62f','#34cb34','#49d049','#5dd55d'];
  var ls = ['Surveying','Networking','Managing','Leadership','Communication','Organising','TeamPlayer'];

  @foreach($post as $posts)
    var convert = new Date('{{$posts->edu_year}}');
    var eduYear = convert.getFullYear();
    var lifeSkil = ['{{$posts->surveying}}','{{$posts->networking}}','{{$posts->managing}}','{{$posts->leadership}}','{{$posts->communication}}','{{$posts->organising}}','{{$posts->team_player}}'];
   
    // general education calculation
    gedu = chartData(parseInt('{{ifAnd($posts->performance) ? $posts->performance : 0}}'),eduYear);
    //religious education calculation
    var reduValue = parseInt('{{round((($posts->m_performance + $posts->tajveed + $posts->fiqh + $posts->arabic) / 400) * 100)}}');
    redu = chartData(reduValue, eduYear);
  @endforeach
  var y =0;
  function chartData(values,year){
    var data=[],dataArray=[];
    data.values= values;
    data.rem = 100 - data.values;
    data.year= year;
    dataArray.push(data);
    return dataArray;
  }

var vals = [52,86,54,96,54,65,84,45,78,36];
  /***************Basic Skills**************/
    for(var x = 0; x < ls.length;x++){
  // console.log((lifeSkil[x] == 0 || lifeSkil[x] == null || lifeSkil[x] == '') ? 0 : lifeSkil[x]);
      var lifeSkill = (lifeSkil[x] == 0 || lifeSkil[x] == null || lifeSkil[x] == '') ? 0 : lifeSkil[x];
      var rems = 100 - lifeSkill;
      Morris.Donut({

        element: 'morris'+ls[x],
        data: [{
          label: ls[x],
          value: Math.round(lifeSkill),
        }, {
          label: "Need to Progress",
          value: Math.round(rems)
        }],
        resize: true,
        colors:[cols[x], '#2f3d4a'] 
      });
    }
    console.log(gedu[0].values);
if(gedu[0].values !== 0 || gedu[0].values !== null || gedu[0].values !== ''){

  Morris.Donut({
    barGap:3,
    barSizeRatio:0.1,
    element: 'morris-donut-chart4',
    data: [{
      label: "General Education",
      value: Math.round(58),
    }, {
      label: "Need to Progress",
      value: Math.round((gedu[0].rem == 0 || gedu[0].rem == null || gedu[0].rem == '') ? 0 : gedu[0].rem)
    }],
    resize: true,
    colors:['#55ce63', '#2f3d4a']
  });
}
  /***************Religious Education**************/
  Morris.Donut({
    element: 'morris-donut-chart5',
    data: [{
      label: "Religious Education",
      value: Math.round((redu[0].values == 0 || redu[0].values == null || redu[0].values == '') ? 0 : redu[0].values),
    }, {
      label: "Need to Progress",
      value: Math.round((redu[0].rem == 0 || redu[0].rem == null || redu[0].rem == '') ? 0 : redu[0].rem)
    }],
    resize: true,
    colors:['#009efb', '#2f3d4a']
  });

</script>


<!--*************************Family Info. Tab **************************-->
            <div class="tab-pane" id="family" role="tabpanel">
               <div class="card-body">
                  <div class="row el-element-overlay">
                     <div class="col-md-12">
                        <h4 class="card-title">Family members</h4>
                        <hr>
                     </div>
                     @if(count($fam)-1 !== 0)
                     @foreach($fam as $obj)
                     @if($obj->id != $pid)
                     <div class="col-md-6">
                        <div class="card box-shadow bg-white br-5">
                           <div class="message-box">
                              <div class="message-widget message-scroll">
                                 <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                       <div class="user-img text-center p-10">
                                          <img src="{{asset('adminAssets/images/default/default1.png')}}" alt="user" class="img-round" style="width: 50px;border-radius: 50%;">
                                       </div>
                                    </div>
                                    <div class="col-md-10">
                                       <div class="mail-contnet w-100">
                                          <span class="btn btn-circle pull-right" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" aria-haspopup="true" aria-expanded="false" style="margin: 5px 17px 0px 0px;background: none;color: black;">
                                             <i class="ti-more-alt pull-right" style="margin-right: 3px;transform: rotate(90deg);margin-top: 2px;"></i>
                                          </span>
                                          <a ref="#" data-toggle="modal" data-target="#familyProfile{{$obj->id}}" class="text-dark">
                                             <h4 class="font-Trirong font-16"><b>{{$obj->fname}} {{$obj->lname}}</b></h4>
                                             <p>({{MainController::findRelation($obj->relation)}})</p>
                                          </a>
                                       </div>

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endif
                     @endforeach
                     @else
                        @include('admin/Error_Pages/error_page2')
                     @endif
                  </div>
               </div>
            </div>
<!--*************************End Family Info. Tab **************************-->





   <!--**************************************************************************************-->
                                    <!-- Start Model -->
     <!--**************************************************************************************-->
<?php $j =1; ?>
     @foreach($fam as $posts)
     <div class="modal fade" id="familyProfile{{$posts->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
       <div class="modal-dialog" role="document">
         <div class="modal-content w-1000 m-l-m-100 bg-transparent b-none" style=";;">
           <div>
             <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 40px"><span aria-hidden="true">&times;</span></button>
           </div>

           <div class="modal-body">
             <div class="row m-t-50" style="color:white">

             <div class="col-md-12">

               <div class="card famCard br-t-r-5 mb-m-10" style="background:linear-gradient(rgba(109, 255, 91, 0.3), rgba(0, 0, 0, 0.98)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
                 <div class="card-body">
                   <div class="row">
                     
                     <div class="col-md-10 offset-md-2">
                       <h3 class="card-title m-t-10 text-white">{{$posts->fname}} {{$posts->lname}}  </h3>
                       <div class="modelHead">
                         <h4 class="text-muted">{{ MainController::findRelation($posts->relation)}}<small>({{$posts->role}})</small></h4>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>

             </div>
             <!-- Column -->
             <div class="col-md-12">
               <div class="card br-b-l-5 box-shadow mt-m-15">
                 <!-- Nav tabs -->
                 <div class="row">
                   <div class="col-md-3">
                     <div class="mt-m-90">
                       @if($posts->image != null || $posts->image != '')
                         <img src="{{asset('adminAssets/images/FamiliesProfile/HSCCFamily/profile/'.$posts->image)}}" class="m-l-15" style="width:140px;border: 5px solid white;border-radius: 70px">
                       @else
                         @if($posts->gender == 'Male')
                         <img src="{{asset('adminAssets/images/default/default1.png')}}" class="m-l-15" style="width:140px;border: 5px solid white;border-radius: 70px">
                         @else
                         <img src="{{asset('adminAssets/images/default/girl.jpg')}}" class="m-l-15" style="width:140px;border: 5px solid white;border-radius: 70px">
                         @endif
                       @endif
                     </div>
                  </div>

                  <div class="col-md-12">
                     <ul class="nav nav-tabs profile-tab" role="tablist">
                       <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#headProfile{{$posts->id}}" role="tab" aria-selected="true">Profile</a> </li>
                       @if($posts->role == 'Head')
                       <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#History{{$posts->id}}" role="tab" aria-selected="true">History</a> </li>
                       @endif
                       <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#headAddress{{$posts->id}}" role="tab" aria-selected="false">Address</a> </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content">
                       <!--second tab-->
                       <div class="tab-pane active show" id="headProfile{{$posts->id}}" role="tabpanel">
                         <div class="card-body">
                           <div class="col-md-12">
                             <div class="d-flex m-b-30 no-block">

                               <div class="row memberProfileRow familyProfileRow font-open-sans">
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db font-Trirong"><b> HF Id :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{$posts->hfid}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 @if($posts->email != null && $posts->email != 'null')
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db font-Trirong"><b> E-mail address :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{($posts->email == null) ? 'Not-provided' : $posts->email}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 @endif
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db font-Trirong"><b> Phone number :</b> </small>
                                     </div>
                                     <div class="media-body">
                                       <h6 class="font-open-sans"> {{($posts->mobile == null) ? 'Not provided' : $posts->mobile}}</h6>
                                     </div>
                                   </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b> Gender :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{$posts->gender}}</h6>
                                     </div>
                                   </div>
                                 </div>

                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b> Qualification :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{($posts->qualification == null) ? 'Not-provided' : $posts->qualification}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b> Occupation :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{($posts->occupation_name == null) ? 'Not-provided' : $posts->occupation_name}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b>Age :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{MainController::age($posts->dob)}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b>Marital Status :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{($posts->marital_status == null) ? 'Not-provided' : $posts->marital_status}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b>Annual Income :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{($posts->income == null && $posts->income == 0) ? 'Not-provided' : $posts->income}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 
                                 <div class="col-md-12">
                                   <hr>
                                   <h4>Document Details</h4>
                                 </div>
                                 @if($posts->ration_no != '' && $posts->ration_no != null)
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b>Ration Card number :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{ $posts->ration_no}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 @endif

                                 @if($posts->adhar_no != '' && $posts->adhar_no != null)
                                 <div class="col-md-6">
                                   <div class="media">
                                     <div class="media-left">
                                       <small class="p-t-30 db"><b>Adhar Card number :</b></small>
                                     </div>
                                     <div class="media-body">
                                       <h6> {{ $posts->adhar_no}}</h6>
                                     </div>
                                   </div>
                                 </div>
                                 @endif
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>

                       @if($posts->relation == 'Head')
                       <!-- History Tab Start -->
                       <div class="tab-pane" id="History{{$posts->id}}" role="tabpanel">
                         <div class="card-body">
                           <div class="d-flex m-b-30 no-block">
                             <div class="row memberProfileRow familyProfileRow font-open-sans">
                               <div class="col-md-4">
                                 <div class="media">
                                   <div class="media-left">
                                     <small class="p-t-30 db font-Trirong"><b> Date of Join :</b></small>
                                   </div>
                                   <div class="media-body">
                                     <h6> {{$posts->dojHSCC}}</h6>
                                   </div>
                                 </div>
                               </div>
                               @if($posts->reason != null && $posts->reason != 'null')
                               <div class="col-md-8">
                                 <div class="media">
                                   <div class="media-body">
                                     <small class="p-t-30 db font-Trirong"><b> Reason/Desperation :</b></small>
                                     <h6> {{($posts->reason == null) ? 'Not-provided' : $posts->reason}}</h6>
                                   </div>
                                 </div>
                               </div>
                               @endif

                               <div class="col-md-12">
                                 <hr>
                                 <h4>Previous Status</h4>
                               </div>
                               <div class="col-md-6">
                                 <div class="media">
                                   <div class="media-left">
                                     <small class="p-t-30 db font-Trirong"><b> Familial/ Realtionship :</b> </small>
                                   </div>
                                   <div class="media-body">
                                     <h6 class="font-open-sans"> {{($posts->familial == null) ? 'Not provided' : $posts->familial}}</h6>
                                   </div>
                                 </div>
                               </div>
                               @if($posts->income_source != null && $posts->income_source != '')
                               <div class="col-md-6">
                                  <div class="media">
                                   <div class="media-left">
                                     <small class="p-t-30 db"><b> Income source :</b></small>
                                   </div>
                                   <div class="media-body">
                                     <h6> {{$posts->income_source}}</h6>
                                   </div>
                                 </div>
                               </div>
                               @endif
                               <div class="col-md-6">
                                 <div class="media">
                                   <div class="media-left">
                                     <small class="p-t-30 db"><b> Health Status :</b></small>
                                   </div>
                                   <div class="media-body">
                                     <h6> {{($posts->healthstatus == null) ? 'Not-provided' : $posts->healthstatus}}</h6>
                                   </div>
                                 </div>
                               </div>
                               <div class="col-md-6">
                                 <div class="media">
                                   <div class="media-left">
                                     <small class="p-t-30 db"><b> Shelter :</b></small>
                                   </div>
                                   <div class="media-body">
                                     <h6> {{($posts->shelter == null) ? 'Not-provided' : $posts->shelter}}</h6>
                                   </div>
                                 </div>
                               </div>
                               <div class="col-md-6">
                                 <div class="media">
                                   <div class="media-left">
                                     <small class="p-t-30 db"><b>Self Reliant :</b></small>
                                   </div>
                                   <div class="media-body">
                                     <h6> {{$posts->selfReliant}}</h6>
                                   </div>
                                 </div>
                               </div>
                               <div class="col-md-12">
                                 <div class="media">
                                   <div class="media-body">
                                     <small class="p-t-30 db"><b>Services obtained upto now from HSCC  :</b></small>
                                     @if($posts->services != null)
                                     <?php $service = explode(',',$posts->services); ?>
                                     @foreach($service as $serve)
                                     <h6> <i class="ti-angle-double-right"></i>{{$serve}}</h6>
                                     @endforeach
                                     @else
                                     {{'Not-provided'}}
                                     @endif
                                   </div>
                                 </div>
                               </div>
                               <div class="col-md-12">
                                 <hr>
                                 <h4>Present status</h4>
                               </div>
                               <div class="col-md-12">
                                 <div class="media">
                                   <div class="media-body">
                                     <h6> {{($posts->presentStatus == null && $posts->presentStatus == '') ? 'Not-provided' : $posts->presentStatus}}</h6>
                                   </div>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>
                       <!--  History tab end-->
                       @endif

                       <div class="tab-pane" id="headAddress{{$posts->id}}" role="tabpanel">
                         <div class="card-body">
                             <div class="col-md-12">
                               <div class="d-flex m-b-30 no-block">
                                 <div class="row memberProfileRow familyProfileRow">
                                   <div class="col-md-6">
                                     <div class="row">
                                       <div class="col-md-12">
                                         <h4>Present Address</h4>
                                         <hr>
                                       </div>
                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b> Door Number</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: {{$posts->present_door}}</h6>
                                           </div>
                                         </div>
                                       </div>
                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b>Street</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: Kavalkatte</h6>
                                           </div>
                                         </div>
                                       </div>

                                       <div class="col-md-12">
                                          <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b> State</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: Karnataka</h6>
                                           </div>
                                          </div>
                                       </div>

                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b> Taluk</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: Bantval</h6>
                                           </div>
                                         </div>
                                       </div>
                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b>Posatal Code :</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6> 574265</h6>
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-md-6">
                                     <div class="row">
                                       <div class="col-md-12">
                                         <h4>Previous Address</h4>
                                         <hr>
                                       </div>
                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b> Door Number</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: {{($posts->door_no != '-' && $posts->door_no != '') ? $posts->door_no : 'not provided'}}</h6>
                                           </div>
                                         </div>
                                       </div>
                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b>Street</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: {{$posts->street_area}}</h6>
                                           </div>
                                         </div>
                                       </div>

                                       <div class="col-md-12">
                                          <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b> State</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: {{$posts->state}}</h6>
                                           </div>
                                          </div>
                                       </div>

                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b> Taluk</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6>: Bantval</h6>
                                           </div>
                                         </div>
                                       </div>
                                       <div class="col-md-12">
                                         <div class="media">
                                           <div class="media-left">
                                             <small class="p-t-30 db"><b>Posatal Code :</b></small>
                                           </div>
                                           <div class="media-body">
                                             <h6> {{$posts->pincode}}</h6>
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                     </div>
                   </div>

               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
 <?php $j++; ?>
 @endforeach





 <!-- Performance charts -->
 <?php use \App\Http\Controllers\MainController; $main = new MainController;?>
@extends('admin/mainpage/adminmain')

@section('admincontents')
<?php $c =0; ?>
@foreach($post as $posts)
<?php $c++;
$stdid = $posts->student_id;
$evalId = $posts->stdid;
$hfid = $posts->hfId;
 ?>
@if($c == 1)
<?php $year =  $posts->eval_year; ?>
@endif
@endforeach
  
<div class="row">

  <div class="col-md-12">
    <hr>
  </div>
  <div class="col-md-12">
    <div>
    <?php $count = 0;?>
    @foreach($post as $posts)

    @if($posts->full_name !== null)
    <?php $pid = $posts->student_id;
      $count++; ?>
    @endif
    @if($count == 1)
    <div class="row">
      <div class="col-md-4">
        <div class="card box-shadow-gradient p-10-0  m-t-m-10">
          <div class="card-body std-card-body m-t-m-10 br-5 p-15" style="background:linear-gradient(rgba(255, 255, 255, 0), rgba(5, 40, 19, 0.7)),url(http://localhost:8000/adminAssets/images/ex/1769682-JPPJVCXZ-33.jpg) no-repeat;">
              <div class="media">
                <div class="media-left">
                  <img src="{{asset('adminAssets/images/default/default1.png')}}" class="img-circle" width="65">
                </div>
                <div class="media-body p-10">
                  <h4 class="card-title m-t-10 text-white">{{$posts->full_name}}</h4>
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
                  <h5 class="mt-0 mb-0 font-Trirong">Last Evaluated Date:</h5>
                  <p>{{ ($evalId != null) ? date("D F j Y",strtotime($year)) : 'Evaluating soon..'}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    @endforeach
    </div>
  </div>
  @if($evalId != null)
  <div class="col-md-12">
    <div class="card box-shadow">
      <div class="card-body">
        <h4 class="card-title">Student Evaluation Chart</h4>
        <ul class="list-inline text-right">
            <li>
                <h5><i class="fa fa-circle m-r-5 text-inverse"></i>General Education</h5>
            </li>
            <li>
                <h5><i class="fa fa-circle m-r-5 text-info"></i>Religious Education</h5>
            </li>

            <li>
                <h5><i class="fa fa-circle m-r-5" style="color: #55ce63"></i>Skills </h5>
            </li>
        </ul>
        <div id="morris-area-chart"></div>
      </div>
    </div>
</div>
@else
  @include('admin/Error_Pages/error_page2')
@endif
</div>
<script type="text/javascript">
  var date = new Date();//to find current date
  var Year =date.getFullYear();//to find only currunt year
  var val=[],gedu=[],redu=[];
  var val1 ={},gedu1={},redu1={};
  @if($stdid != null)

   @foreach($post as $posts)

      dob='{{$posts->dob}}';

      gedu1=[];
      gedu1.values='{{$posts->performance}}';
      gedu1.year= '{{$posts->eval_year}}';
      gedu.push(gedu1);

      redu1 = [];
      redu1.values='{{round(($posts->madrasa + $posts->practices + $posts->ibada)/3)}}';
      redu1.year = '{{$posts->eval_year}}';
      redu.push(redu1);
    @endforeach
    // console.log(val);
    var dobDate = new Date(dob);//getting db date of dob
    var dobYear = dobDate.getFullYear();//db year

    var totSubYear = Year - dobYear;//age
    var all = [], religiousEvaluatedDataAll=[],generalEvaluatedDataAll=[];
    // console.log(redu[0]);
    var finalData=[];

    var skill = [50,85,65,70];
    for(var i=0; i < gedu.length; i++){
        all.push(getEvaluatingData(skill[i],redu[i],gedu[i]));
      }
    
    console.log(all);
    var finalData2=[];
      for (var s in all) {
        if (all.hasOwnProperty(s)){
    // console.log();
          finalData2.push({period: all[s][0].period,Skills : all[s][0].Skills,ReligiousEducation:all[s][0].ReligiousEducation,GeneralEducation:all[s][0].GeneralEducation});
        }
      }
      console.log(finalData2);
      function getEvaluatingData(p1,p2,p3){
        var evaluationData=[];
        var check;
        var evaluationArray = [];
        for(var i=0; i < 1; i++){
            var convert = new Date(p3.year);
            var eduYear = convert.getFullYear();
            evaluationData=[];
            if (eduYear <= Year) {
              check =(totSubYear)-(Year - eduYear);
            }
            var v = eduYear.toString()+'(Age :'+check+')';
            // console.log(v);
          if(check < 30){
            evaluationData ={period: v,Skills:Math.round(p1),ReligiousEducation:Math.round(p2.values),GeneralEducation:Math.round(p3.values)};
          }
          evaluationArray.push(evaluationData);
        }
      return evaluationArray;
    }

        Morris.Area({
          element: 'morris-area-chart',
          data: finalData2,
          xkey: 'period',
          ymin: 0,
          ymax: 100,
          // numLines: ,
          ykeys: ['Skills','ReligiousEducation','GeneralEducation'],
          labels: ['Skills','ReligiousEducation','General Education'],
          pointSize: 3,
          fillOpacity: 0,
          pointStrokeColors:[ '#55ce63','#009efb','#2f3d4a'],
          behaveLikeLine: true,
          gridLineColor: '#e0e0e0',
          lineWidth: 3,
          hideHover: 'auto',
          lineColors: [ '#55ce63','#009efb','#2f3d4a'],
          resize: true

        });
  @endif
</script>
@endsection

