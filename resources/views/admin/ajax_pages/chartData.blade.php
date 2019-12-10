<?php 
//*************************studentsProfile page General education chart details*********************
if ($religiousCalc == '') {
  foreach($post as $posts){ ?>
    <div class="col-md-6">
      <div class="card" style="border-right: 1px solid #15141429">
        <div class="d-flex no-block p-15 align-items-center">
          <div class="round bg-light text-dark"><i class="fa fa-institution font-18"></i></div>
          <div class="m-l-10 ">
            <h3 class="m-b-0 font-Trirong">School/ College:</h3>
            <h5 class="font-light m-b-0 font-14">{{$posts->school}}</h5> </div>
          </div>
          <hr>
          <div class="d-flex no-block p-15 align-items-center">
            <div class="round bg-light text-dark"><i class="fa fa-graduation-cap font-18"></i></div>
            <div class="m-l-10">
              <h3 class="m-b-0 font-Trirong">Grade/ Standard and Perfomance</h3>
              <h5 class="font-light m-b-0 font-14">Grade : {{$posts->grade}}</h5>
              <h5 class="font-light m-b-0 font-14">Perfomance : {{$posts->perfomance}}</h5>
            </div>
          </div>
          <hr>
          <div class="d-flex no-block p-15 m-b-15 align-items-center">
            <div class="round bg-light text-dark"><i class="fa fa-book font-16"></i></div>
            <div class="m-l-10">
              <h3 class="m-b-0 font-Trirong">Weak and Strong Subjects</h3>
              <?php if($posts->weak != null){ ?>
                <h5 class="font-light m-b-0 font-14">Weak : {{$posts->weak}}</h5>
              <?php }else{ ?>
                <h5 class="font-light m-b-0 font-14">Weak : Not-mentioned </h5>
              <?php } ?>

              <?php if($posts->strong != null){ ?>
                <h5 class="font-light m-b-0 font-14">Strong : {{$posts->strong}}</h5>
              <?php }else{ ?>
                <h5 class="font-light m-b-0 font-14">Strong : Not-mentioned</h5>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 text-center">
        <div id="morris-donut-chart4" class="h-260"></div>
        <ul class="list-inline text-right">
          <li>
            <p><i class="fa fa-circle m-r-5"></i>Need to improve</p>
          </li>
          <li>
            <p><i class="fa fa-circle m-r-5 color-high"></i>General Education</p>
          </li>
        </ul> 
      </div>
    <?php
    }
  echo '<script type="text/javascript">
    Morris.Donut({
      element: "morris-donut-chart4",
      data: [{
        label: "General Education",
        value: Math.round('.$calc.')
        }, {
          label: "Need to Progress",
          value: Math.round('.$generalRem.')
          }],
          resize: true,
          colors:["#55ce63", "#2f3d4a"]
        });</script>';
}

//******************studentsProfile page Religeous education chart details*********************************
if ($calc == '') {
  foreach($post as $posts){
?>
<div class="col-md-6">
  <div id="morris-donut-chart5" class="h-260"></div>
  <ul class="list-inline text-right">
    <li>
      <p><i class="fa fa-circle m-r-5"></i>Need to progress</p>
    </li>
    <li>
      <p><i class="fa fa-circle m-r-5 text-info"></i>Religious Education</p>
    </li>
  </ul>
</div>

<div class="col-md-6">
  <div class="card" style="border-left: 1px solid #15141429">
    <div class="d-flex no-block p-15 align-items-center">
      <div class="round bg-dark"><i class="fa fa-book font-18"></i></div>
      <div class="m-l-10 ">
        <h3 class="m-b-0 font-Trirong">Madrasa : {{$posts->madrasa}} %</h3>
      </div>
    </div>
    <hr>
    <div class="d-flex no-block p-15 align-items-center">
      <div class="round bg-dark"><i class="fa fa-book font-18"></i></div>
      <div class="m-l-10">
        <h4 class="m-b-0 font-Trirong"><b>Huqub-Al-Ibada : {{$posts->ibada}} %</b></h4>
      </div>
    </div>
    <hr>
    <div class="d-flex no-block p-15 m-b-15 align-items-center">
      <div class="round bg-dark"><i class="fa fa-book font-16"></i></div>
      <div class="m-l-10">
        <h3 class="m-b-0 font-Trirong">Practices : {{$posts->practices}} %</h3>
      </div>
    </div>
  </div>
</div>
 <?php }
 echo '<script type="text/javascript">
  Morris.Donut({
    element: "morris-donut-chart5",
    data: [{
      label: "Religious Education",
      value: Math.round('.$religiousCalc.')
      }, {
        label: "Need to Progress",
        value: Math.round('.$religiousRem.')
        }],
        resize: true,
        colors:["#009efb", "#2f3d4a"]
      });</script>';
 }
//******************index page skills chart details***************************************************

if ($skillCheck == '') { ?>
  <div class="col-md-8">
    <div class="col-md-12">
      <div class="card mt-m-25">
        <div class="row">
          <div class="card-body">
            <div id="morris-bar-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4" style="    border-left: 1px solid #00000014;">
    <div class="card skill-card border-right m-b-0 mt-m-40">
      <?php $lables = ['Analytical Planning','Presentation/ Marketing','Networking/ Follow-up','Counclling','Sharing','Leadership']; 
      $l = 0;?>
      @foreach($lables as $label)
      <div class="d-flex no-block align-items-center">
        <div class="round bg-white text-dark"><i class="ti-stats-up"></i>
        </div>
        <div class="m-l-10 ">
          <h3 class="m-b-0 font-14">{{$label}} </h3>
          <h5 class="font-light m-b-0 font-12 skill-h5"><span><i class="fa fa-circle  color-high"></i>High : {{$hscount[$l]}} students</span>&nbsp;<span><i class="fa fa-circle text-info"></i>Moderate : {{$mscount[$l]}} students </span>&nbsp;<span><i class="fa fa-circle"></i>Low : {{$lscount[$l]}} students</span></h5> 
        </div>
      </div>
      <hr>
      <?php $l++; ?>
      @endforeach
    </div>
  </div>
  <script type="text/javascript">
    @include('admin\dashboard-charts\ajax-charts')//this include file contains chart and data 
  </script>
  
<?php 
}
//******************index page religious counts chart details*********************************

if ($ajaxData == '' && $chartId != '') {

 ?>
  <div class="col-md-4">
    <div class="card skill-card" style="padding: 15px;border-right: 1px solid #15141429">
      <div class="d-flex no-block align-items-center m-b-15">
        <div class="round bg-white text-dark"><i class=" ti-pie-chart"></i>
        </div>
        
        <div class="m-l-10 ">
          <h3 class="m-b-0 font-16">Madrasa </h3>
          <h5 class="font-light m-b-0 font-12 skill-h5"><span><i class="fa fa-circle  color-high"></i>High : {{$hcount[0]}} students</span>&nbsp;<span><i class="fa fa-circle text-info"></i>Moderate : {{$mcount[0]}} students </span>&nbsp;<span><i class="fa fa-circle"></i>Low : {{$lcount[0]}} students</span></h5> 
        </div>
      </div>
      <hr>
      <div class="d-flex no-block align-items-center m-b-15">
        <div class="round bg-white text-dark"><i class="ti-pie-chart"></i>
        </div>
        <div class="m-l-10 ">
          <h3 class="m-b-0 font-16">Huqub-Al-Ibada </h3>
          <h5 class="font-light m-b-0 font-12 skill-h5"><span><i class="fa fa-circle  color-high"></i>High : {{$hcount[1]}} students</span>&nbsp;<span><i class="fa fa-circle text-info"></i>Moderate : {{$mcount[1]}} students </span>&nbsp;<span><i class="fa fa-circle"></i>Low : {{$lcount[1]}} students</span></h5> 
        </div>
      </div>
      <hr>
      <div class="d-flex no-block align-items-center m-b-15">
        <div class="round bg-white text-dark"><i class="ti-pie-chart"></i>
        </div>
        <div class="m-l-10 ">
          <h3 class="m-b-0 font-16">Leadership </h3>
          <h5 class="font-light m-b-0 font-12 skill-h5"><span><i class="fa fa-circle color-high"></i>High : {{$hcount[2]}} students</span>&nbsp;<span><i class="fa fa-circle text-info"></i>Moderate : {{$mcount[2]}} students </span>&nbsp;<span><i class="fa fa-circle"></i>Low : {{$lcount[2]}} students</span></h5> 
        </div>
      </div>

    </div>
  </div>
  <div class="col-md-8">
    <div class="row mt-m-10 m-b-10">
      <div class="col-md-4">
        <div id="morris-donut-chartReligiousMadrasa"></div>
        <div class=" mt-m-35 text-center">
          <h3 class="m-b-0 font-Trirong font-18"><i class="fa fa fa-eercast font-16"></i> Madrasa</h3>
        </div>
      </div>

      <div class="col-md-4">
        <div id="morris-donut-chartReligiousibada"></div>
        <div class=" mt-m-35 text-center">
          <h3 class="m-b-0 font-Trirong font-18"><i class="fa fa fa-eercast font-16"></i> Huqub-Al-Ibada</h3>
        </div>
      </div>

      <div class="col-md-4">
        <div id="morris-donut-chartReligiousPractices"></div>
        <div class=" mt-m-35 text-center">
          <h3 class="m-b-0 font-Trirong font-18"><i class="fa fa fa-eercast font-16"></i>Practices </h3>
        </div>
      </div>
    </div>
  </div>
 <script type="text/javascript">
  <?php $i = 0; ?>
  @foreach($cids as $ids)
  Morris.Donut({
    element: '{{$ids}}',
    data: [{
      label: "High",
      value: Math.round('{{$hcount[$i]}}'),

    }, {
      label: "Moderate",
      value: Math.round('{{$mcount[$i]}}')
    }, {
      label: "Low",
      value: Math.round('{{$lcount[$i]}}')
    }],
    resize: true,
    colors:['#24af34','#55ce63','#77f986']
  });
  <?php $i++; ?>
  @endforeach
</script>
<?php }

//******************to find student details while adding evaluation details(by id)*********************************

if ($stud == '') { ?>
  <div class="col-md-12">
    <div class="alert alert-rounded" style="border-radius: 1em;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"> 

      <table id="demo-foo-addrow" class="table  table-hover no-wrap contact-list">
        <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn pull-right" class="close" data-dismiss="alert" aria-label="Close"><i class="ti-close" aria-hidden="true"></i></button>
        <thead>
          <tr>
            <th class="footable-sortable">Name<span class="footable-sort-indicator"></span></th>
            <th class="footable-sortable">Gender<span class="footable-sort-indicator"></span></th>
            <th class="footable-sortable">DOB<span class="footable-sort-indicator"></span></th>
            <th class="footable-sortable">Age<span class="footable-sort-indicator"></span></th>
            <th class="footable-sortable">Colony<span class="footable-sort-indicator"></span></th>
            <th class="footable-sortable">Door Number<span class="footable-sort-indicator"></span></th>

          </tr>
        </thead>
        <tbody>
          <tr class="footable-even" style="">
            <td>
              <img src="{{asset('images/default.jpg')}}" alt="user" class="img-circle" width="50px"> {{$posts->fname}} {{$posts->lname}}
            </td>
            <td>{{$posts->gender}}</td>
            <td>{{$posts->dob}}</td>
            <td>{{$posts->age}} </td>
            <td>{{$posts->colony}}</td>
            <td>{{$posts->std_door}}</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
<?php } ?>
