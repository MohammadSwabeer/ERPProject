<?php use \App\Http\Controllers\MainController; $main = new MainController;?>  
@extends('admin.mainpage.adminmain')
@section('admincontents')
@include('admin.mainpage.pages._messages')

<div class="row">
  <div class="col-md-12">
    <div>
      <h3 class="text-center font-w-900 p-5 m-t-10">HIDAYAH FOUNDATION ERP SYSTEM</h3>
    </div>
  </div>
  <div class="col-md-6">
    <!-- <div class="card projects-row m-t-60 box-shadow-e br-5">
      <div class="card-body"> -->
        <div class="row projects-row border-right p-l-r-25">
          <div class="col-md-12">
            <h4 class="text-center font-w-900 proj">PROJECTS</h4>
          </div>
          <div class="col-md-12">
             <a href="#0">
               <div class="b-shadow br-5 food-shadow animated zoomIn" onmouseover="mouseOver('food-show')" onmouseout="mouseOut('food-show')">
                 <div class="card food-card br-5 m-t-10 projects1 h-120 m-b-0">
                   <div class="card-body">
                     <div class="text-center food-text">
                       <h4 class="m-auto food-text">FOOD</h4>
                       <p class="food-text">change the life of those, who have no hope.!</p>
                     </div>
                   </div>
                 </div>
                 <div class="card animated flipInX project-overlay1 m-b-0" style="display: none;" id="food-show">
                   <div id="animationSandbox">
                     <div class="card-body p-0">
                       <div class="text-center p-5">
                         <a class="btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-primary food-link border-color2  text-white" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Awarness"><h4 class="m-auto font-12 text-caps font-w-700">Awarness</h4></a>
                         <a class="btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-primary food-link text-white border-color2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Supply"><h4 class="m-auto font-12 text-caps font-w-700">Supply</h4></a>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </a>
           </div>

           <div class="col-md-12">
             <a href="javascript:void(0)">
               <div class="b-shadow br-5 animated zoomIn" onmouseover="mouseOver('health-show')" onmouseout="mouseOut('health-show')">
                 <div class="card health-card br-5 m-t-10 projects1 h-120 m-b-0">
                   <div class="card-body">
                     <div class="health-text text-center">
                       <h4 class="m-auto health-text">HEALTH</h4>
                       <p class="health-text">give your helping hand to those who need it.!</p>
                     </div>
                   </div>
                 </div>

                 <div class="card animated flipInX project-overlay1 m-b-0" style="display: none;" id="health-show">
                   <div id="animationSandbox">
                     <div class="card-body p-0">
                       <div class="text-center p-5">
                         <a href="#0" class="btn btn-sm btn-block border-color3 waves-effect waves-light btn-rounded text-white btn-outline-primary health-link m-b-0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Prevention">
                           <h4 class="m-auto font-12 text-caps font-w-700 border-color">Prevention</h4>
                         </a>
                         <a href="#0" class="btn btn-sm btn-block border-color3 text-white waves-effect m-b-0 waves-light btn-rounded btn-outline-primary health-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Cure">
                           <h4 class="m-auto font-12 text-caps font-w-700">Cure</h4></a>
                         <a href="#0" class="btn btn-sm btn-block border-color3 text-white waves-effect m-b-0 waves-light btn-rounded btn-outline-primary health-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Data">
                           <h4 class="m-auto font-12 text-caps font-w-700">Data</h4></a>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </a>
           </div>

           <div class="col-md-12">
             <a href="#0" >
               <div class="b-shadow br-5 animated zoomIn" onmouseover="mouseOver('edu-show')" onmouseout="mouseOut('edu-show')">
                 <div class="card edu-card br-5 m-t-10 projects1 h-120 m-b-0">
                   <div class="card-body">
                     <div class="text-center">
                        <h4 class="m-auto edu-text">EDUCATION</h4>
                       <p class="edu-text">you can help educate them to secure their future.!</p>
                     </div>
                   </div>
                 </div>
                 <div class="card animated flipInX project-overlay1 m-b-0" style="display: none;" id="edu-show">
                   <div id="animationSandbox">
                     <div class="card-body p-0">
                       <div class="text-center p-5">
                         <a class="btn btn-sm waves-effect waves-light text-white border-color m-b-0 btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Students"><h4 class="m-auto font-12 text-caps font-w-700 border-color">Students</h4></a>
                         <a class="btn btn-sm waves-effect waves-light btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Teachers"><h4 class="m-auto font-12 text-caps font-w-700">Teachers</h4></a>
                         <a class="btn btn-sm waves-effect waves-light font-w-900 border-color m-b-0 text-white btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Parents"><h4 class="m-auto font-12 text-caps font-w-700">Parents</h4></a>
                         <a class="btn btn-sm waves-effect waves-light font-w-900 border-color m-b-0 text-white btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#School"><h4 class="m-auto font-12 text-caps font-w-700">School Management </h4></a>
                         <a class="btn btn-sm waves-effect waves-light font-w-900 border-color m-b-0 text-white btn-rounded btn-outline-primary edu-link btn-block" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Resource"><h4 class="m-auto font-12 text-caps font-w-700">Resource Persons</h4></a>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </a>
           </div>

           <div class="col-md-12">
             <a href="#0">
               <div class="b-shadow br-5 animated zoomIn" onmouseover="mouseOver('reliance-show')" onmouseout="mouseOut('reliance-show')">
                 <div class="card reliance-card br-5 m-t-10 projects1 h-120 m-b-0">
                   <div class="card-body">
                     <div class="text-center">
                       <h4 class="m-auto reliance-text" style="font-size:30px">SELF-RELIANCE</h4>
                       <p class="reliance-text">create an opportunity to disadvantaged people.!</p>
                     </div>
                   </div>
                 </div>

                 <div class="card animated flipInX project-overlay1 m-b-0" style="display: none;" id="reliance-show">
                   <div id="animationSandbox">
                     <div class="card-body p-0">
                       <div class="text-center p-5">
                         <a class="btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-primary reliance-link border-color4 m-b-0 text-white" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Providers"><h4 class="m-auto font-12 text-caps font-w-700" style="border-color:#e9e32b">Providers / Employers</h4></a>
                         <a class="btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-primary reliance-link border-color4 m-b-0 text-white" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Seekers"><h4 class="m-auto font-12 text-caps font-w-700" style="border-color:#e9e32b">Job Seekers</h4></a>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </a>
           </div>

           <div class="col-md-12">
             <a href="#0">
               <div class="b-shadow br-5 animated zoomIn" onmouseover="mouseOver('infra-show')" onmouseout="mouseOut('infra-show')">
                 <div class="card infra-card br-5 m-t-10 projects1 h-120 m-b-0">
                   <div class="card-body">
                     <div class="text-center">
                       <h4 class="m-auto infra-text" style="font-size:30px">INFRASTRUCTURE</h4>
                       <p class="infra-text">Infrastructure is much more important than architecture.!</p>
                     </div>
                   </div>
                 </div>

                 <div class="card animated flipInX project-overlay1 m-b-0" style="display: none;" id="infra-show">
                   <div id="animationSandbox">
                     <div class="card-body p-0">
                       <div class="text-center p-5">
                         <a class="btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-primary infra-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Colony">
                           <h4 class="m-auto font-12 text-caps font-w-700">HSCC Colony</h4>
                         </a>
                         <a href="javascript:void(0)" class="btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-primary infra-link">
                           <h4 class="m-auto font-12 text-caps font-w-700">EPICENTER</h4>
                         </a>
                         <a href="javascript:void(0)" class="btn btn-sm btn-block waves-effect waves-light btn-rounded btn-outline-primary infra-link">
                           <h4 class="m-auto font-12 text-caps font-w-700">Other</h4>
                         </a>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </a>
           </div>

        </div>
      <!-- </div>
    </div> -->

  </div>

  <div class="col-md-6">
    <!-- <div class="card m-t-60 box-shadow-e br-5"> -->
      <div class="row p-l-r-25">
        <div class="col-md-12">
            <h4 class="text-center font-w-900">HUMAN RESOURCE</h4>
            <hr>
        </div>
        <div class="col-md-12">
          <div class="card-body b-shadow animated zoomIn br-5 bg-white m-b-10 p-30 m-t-10">
           <!--  <div class="row">
              <div class="col-md-12">
                <div class="card-body mb-m-20"> -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="light-green">
                        <h3 class="text-uppercase font-32 font-w-900 text-center">headquarters Units</h3>
                      </div>
                      <!-- <hr> -->
                    </div>
                    <div class="col-md-12">
                      <div class="text-center">
                        <h3>
                          <a href="javascript:void(0)" class="btn br-15 btn-sm  font-w-700 btn-outline-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Youth Wing">Youth Wing</a> 
                          <a href="javascript:void(0)" class="btn br-15 btn-sm  font-w-700 btn-outline-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Womens Wing">Womens Wing</a> 
                          <a href="javascript:void(0)" class="btn br-15 btn-sm  font-w-700 btn-outline-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Girls Wing">Girls Wing</a> 
                          <a href="{{route('viewStudentsInfo',[encrypt('ATT'),encrypt('HQ'),encrypt('Dashboard'),encrypt(1),encrypt('Students')])}}" class="btn br-15 btn-sm  font-w-700 btn-outline-green" >ATT Students</a> 
                        </h3>
                      </div>
                    </div>
                  </div>
                <!-- </div>
              </div>
            </div> -->
          </div>
        </div>

        <div class="col-md-12">
            <div class="card-body b-shadow animated zoomIn br-5 bg-white m-b-10 p-30 m-t-10">
              <div class="row">
                <div class="col-md-12">
                  <div class="light-green">
                    <h3 class="text-uppercase font-32 font-w-900 text-center">Overseas Units</h3>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="text-center">
                    <h3><a class="btn br-15 btn-sm btn-outline-green font-w-700" href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Overseas">more info</a></h3>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="col-md-12">
          <div class="card-body b-shadow animated zoomIn br-5 bg-white m-b-10 p-30 m-t-10">
              <div class="row">
                <div class="col-md-12">
                  <div class="light-green">
                    <h3 class="text-uppercase font-32 font-w-900 text-center">Organisation Staffs</h3>
                  </div>
                </div>
                <div class="col-md-12 text-center">
                  <?php $staff = ['ATT','HSCC','HQ Admin','Ground']; ?>
                  <h3>
                    @foreach($staff as $s)
                    <?php $id = $main->getsId('viewMembers',$s,'Staffs'); ?>
                    <a class="btn br-15 btn-sm font-w-700 btn-outline-green" href="{{route('viewMembers',$id)}}">{{$s}} Staff</a>  
                    @endforeach
                  </h3>
                </div>
              </div>
            </div>
        </div>
        
    </div>  
  </div>

</div>

<!-- Start Model -->
<?php $moData=['Overseas','Girls Wing','Womens Wing','Youth Wing']; ?>
<!-- Start Model -->
   @foreach($moData as $mod)

   <div class="modal fade" id="{{$mod}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
         <div class="modal-dialog" role="document">
           <?php $bg = 'background:transparent'; ?>
            <div class="modal-content" style="{{$bg}};border:unset;width: 800px">
               <div style="">
                  <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></button>
               </div>

               <div class="modal-body">

                  <div class="card box-shadow-e br-5">
                     <div class="row">
                        <div class="col-md-12">
                          <div class="media p-20 m-auto">
                             <div class="media-right">
                                <img class="box-shadow" src="{{asset('images/HFLogo.jpg')}}" style="width: 110px;border-radius: 100%">
                             </div>
                             <div class="media-body text-center m-auto">
                                 <h3 class="font-NexaRustSans-Black animated pulse" style="font-size: 25px;font-weight: 800; margin-top: 20px;color: #23a523;"> {{$mod}} units.  
                                </h3>
                             </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                           <div class="card">
                              <div class="row p-0-30-0-30">
                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                    @foreach($units as $unit)
                                      @if($mod !== 'Overseas' || $unit->unit_name !== 'Mangalore')
                                      <?php $id = $main->getsId('viewMembers',$mod, ($mod == 'Overseas') ? 'Overseas' : 'HQ Unit',$unit->id); ?>
                                       <a href="{{route('viewMembers',$id)}}" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-success edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#4cc46c;line-height: 2;text-transform: uppercase;">{{$unit->unit_name}}</h4></a>
                                      @endif
                                    @endforeach
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
    @endforeach
<!-- End Model -->

<!-- ********************* Start Model ********************** -->
  @include('admin.Projects.POPModels.StudentsPopUp')
<!-- ********************* End Model ********************** -->

<!-- ********************* Start Model ********************** -->
  @include('admin.Projects.POPModels.DDPopUp')
<!-- ********************* End Model ********************** -->
    
@endsection