<div class="col-md-2" style="margin-top: -85px">
   <a href="#0" class="text-dark">
      <div id="morrisSurveying"></div>
      <div class="mt-m-100 m-l-15 text-center border-right main-skill">
         <h3 class="m-b-0 font-Trirong font-14">{{$ser = 'Surveying'}}{{'/ Feasibility'}}</h3>
         <h3 class="font-16 text-center"><span>{{$v1 = $posts->servaying_feasibility}}%</span></h3>
      </div>
   </a>
</div>

<div class="col-md-2" style="margin-top: -85px">
   <a href="#0" class="text-dark">
      <div id="morrisNetworking"></div>
      <div class="mt-m-100 m-l-15 text-center border-right main-skill">
         <h3 class="m-b-0 font-Trirong font-14">{{$nw = 'Networking'}}</h3>
         <h3 class="font-16 text-center"><span>{{$v2 = $posts->networking}}%</span></h3>
      </div>
   </a>
</div>

<div class="col-md-2" style="margin-top: -85px">
   <a href="#0" class="text-dark">
      <div id="morrisManaging"></div>
      <div class="mt-m-100 m-l-15 text-center border-right main-skill">
         <h3 class="m-b-0 font-Trirong font-14">{{$mn = 'Managing'}}</h3>
         <h3 class="font-16 text-center"><span>{{$v3 = $posts->managing}}%</span></h3>
      </div>
   </a>
</div>

<div class="col-md-2" style="margin-top: -85px">
   <a href="#0" class="text-dark">
      <div id="morrisLeadership"></div>
      <div class="mt-m-100 m-l-15 text-center border-right main-skill">
            <h3 class="m-b-0 font-Trirong font-14">{{$ls = 'Leadership'}}</h3>
            <h3 class="font-16 text-center"><span>{{$v4 = $posts->leadership}}%</span></h3>
      </div>
   </a>
</div>

<div class="col-md-2" style="margin-top: -85px">
   <a href="#0" class="text-dark">
      <div id="morrisCommunication"></div>
      <div class="mt-m-100 m-l-15 text-center border-right main-skill">
            <h3 class="m-b-0 font-Trirong font-14">{{ $com = 'Communication'}}</h3>
            <h3 class="font-16 text-center"><span>{{$v5 = $posts->communication}}%</span></h3>
      </div>
   </a>
</div>

<div class="col-md-2" style="margin-top: -85px">
   <a href="#0" class="text-dark">
      <div id="morrisOrganising"></div>
      <div class="mt-m-100 m-l-15 text-center border-right main-skill">
         <h3 class="m-b-0 font-Trirong font-14">{{$org = 'Organising'}}</h3>
         <h3 class="font-16 text-center"><span>{{$v6 = $posts->organising }}%</span></h3>
      </div>
   </a>
</div>

<div class="col-md-2" style="margin-top: -85px">
   <a href="#0" class="text-dark">
     <div id="morrisTeam Player"></div>
     <div class="mt-m-100 m-l-15 text-center border-right main-skill">
       <h3 class="m-b-0 font-Trirong font-14">{{$tm = 'Team Player'}}</h3>
       <h3 class="font-16 text-center"><span>{{$v7 = $posts->team_player}}%</span></h3>
     </div>
   </a>
</div>

<script type="text/javascript">
   var skillArr = {'{{$ser}}' : '{{$v1}}' ,'{{$nw}}' : '{{$v2}}','{{$mn}}' : '{{$v3}}','{{$ls}}' : '{{$v4}}','{{$com}}' : '{{$v5}}','{{$org}}' : '{{$v6}}','{{$tm}}' : '{{$v7}}'};
   var cols = ['#1f7a1f','#258e25','#2aa22a','#2fb62f','#34cb34','#49d049','#5dd55d'];
   var x = 0;
   $.each(skillArr, function(i, val){
      Morris.Donut({
        element: 'morris'+i,
        data: [{
          label: i,
          value: Math.round(val),
        }, {
          label: "Need to Progress",
          value: Math.round(100 - val)
        }],
        resize: true,
        colors:[cols[x++], '#2f3d4a'] 
      });
   });
</script>
