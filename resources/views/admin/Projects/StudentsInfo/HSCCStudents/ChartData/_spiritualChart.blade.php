<div class="col-md-6">
   <div id="morris-donut-chart5" class="h-260"></div>
   <ul class="list-inline text-right">
     <li>
       <p><i class="fa fa-circle m-r-5"></i>Huqooq-Allah</p>
     </li>
     <li>
       <p><i class="fa fa-circle m-r-5" style="color: #96b69f"></i>Huqooq-Ul-Ibada</p>
     </li>
     <li>
       <p><i class="fa fa-circle m-r-5 text-info"></i>Madrasa Education</p>
     </li>
   </ul>
</div>

<div class="col-md-6">
   <div class="card m-b-0 p-b-0 p-t-0" style="border-left: 1px solid #15141429">
     <div class="d-flex no-block p-15 align-items-center">
       <div class="round bg-info"><i class="fa fa-book font-18"></i></div>
       <div class="m-l-10">
         <h3 class="m-b-0 font-Trirong">Madrasa Education : {{$posts->madrasa}}  %</h3>
       </div>
     </div>
     <hr>
     <div class="d-flex no-block p-15 align-items-center">
       <div class="round" style="background: #96b69f"><i class="fa fa-book font-18"></i></div>
       <div class="m-l-10">
         <h3 class="m-b-0 font-Trirong">Huqooq-Ul-Ibada : {{$posts->huqooq_ibaadh}} %</h3>
       </div>
     </div>
     <hr>
     <div class="d-flex no-block p-15 m-b-15 align-items-center">
       <div class="round bg-dark"><i class="fa fa-book font-16"></i></div>
       <div class="m-l-10">
         <h3 class="m-b-0 font-Trirong">Huqooq-Allah : {{$posts->huqooq_allah}} %</h3>
       </div>
     </div>
   </div>
</div>
<script type="text/javascript">
   /***************Religious Education**************/
   Morris.Donut({
      element: 'morris-donut-chart5',
      data: [{
         label: "Madrasa Education",
         value: Math.round('{{$posts->madrasa}}'),
      }, {
         label: "Huqooq-Allah",
         value: Math.round('{{$posts->huqooq_allah}}')
      }, {
         label: "Huqooq-Ul-Ibadh",
         value: Math.round('{{$posts->huqooq_ibaadh}}')
      }],
      resize: true,
      colors:['#009efb', '#2f3d4a','#96b69f']
   });
</script>