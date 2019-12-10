   <?php use \App\Http\Controllers\MainController; $main = new MainController;?>  

   @extends('admin.mainpage.adminmain')
   @section('admincontents')
   @include('admin.mainpage.pages.main-preloader')
     <div class="row projects-row m-t-60 contents" style="display: none">
       <!-- <div class="col-md-12 m-b-20 border-top">
         <div class="card bg-light box-shadow br-5 w-fit p-10 m-m40-0-0-440">
           <h4 class="card-title text-center font-20 font-w-900">Projects by Hidayah Foundation</h4>
         </div>
       </div> -->
       <hr>
       <div class="col-md-6">
         <a href="#0">
           <div class="box-s br-5 animated food-shadow zoomIn" onmouseover="mouseOver('food-show')" onmouseout="mouseOut('food-show')">
             <div class="card food-card br-5 m-t-10 projects h-150">
               <div class="card-body">
                 <div class="text-center food-text">
                   <h4 class="m-auto food-text">FOOD</h4>
                   <p class="food-text">change the life of those, who have no hope.!</p>
                 </div>
               </div>
             </div>
             <div class="card animated flipInX project-overlay" style="display: none;" id="food-show">
               <div id="animationSandbox">
                 <div class="card-body p-0">
                   <div class="text-center p-5">
                     <a class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary food-link border-color2  text-white" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Awarness"><h4 class="m-auto font-14 text-caps font-w-900">Awarness</h4></a>
                     <a class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary food-link text-white border-color2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Supply"><h4 class="m-auto font-14 text-caps font-w-900">Supply</h4></a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </a>
       </div>

       <div class="col-md-6">
         <a href="javascript:void(0)">
           <div class="box-s br-5 animated zoomIn" onmouseover="mouseOver('health-show')" onmouseout="mouseOut('health-show')">
             <div class="card health-card br-5 m-t-10 projects h-auto">
               <div class="card-body">
                 <div class="health-text text-center">
                   <h4 class="m-auto health-text">HEALTH</h4>
                   <p class="health-text">give your helping hand to those who need it.!</p>
                 </div>
               </div>
             </div>

             <div class="card animated flipInX project-overlay" style="display: none;" id="health-show">
               <div id="animationSandbox">
                 <div class="card-body p-0">
                   <div class="text-center p-5">
                     <a href="javascript:void(0)" class="btn btn-block border-color3 waves-effect waves-light btn-rounded text-white btn-outline-primary health-link m-b-0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Prevention">
                       <h4 class="m-auto font-14 text-caps font-w-900 border-color">Prevention</h4>
                     </a>
                     <a href="javascript:void(0)" class="btn btn-block border-color3 text-white font-w-900 waves-effect m-b-0 waves-light btn-rounded btn-outline-primary health-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Cure">
                       <h4 class="m-auto font-14 text-caps font-w-900">Cure</h4></a>
                     <a href="javascript:void(0)" class="btn btn-block border-color3 text-white font-w-900 waves-effect m-b-0 waves-light btn-rounded btn-outline-primary health-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Data">
                       <h4 class="m-auto font-14 text-caps font-w-900">Data</h4></a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </a>
       </div>

       <div class="col-md-12">
         <a href="#0" >
           <div class="box-s br-5 animated zoomIn" onmouseover="mouseOver('edu-show')" onmouseout="mouseOut('edu-show')">
             <div class="card edu-card br-5 m-t-10 projects h-150">
               <div class="card-body">
                 <div class="text-center">
                    <h4 class="m-auto edu-text">EDUCATION</h4>
                   <p class="edu-text">you can help educate them to secure their future.!</p>
                 </div>
               </div>
             </div>
             <div class="card animated flipInX project-overlay" style="display: none;" id="edu-show">
               <div id="animationSandbox">
                 <div class="card-body p-0">
                   <div class="text-center p-5">
                     <a class="btn waves-effect waves-light text-white border-color m-b-0 btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Students"><h4 class="m-auto font-14 text-caps font-w-900 border-color">Students</h4></a>
                     <a class="btn waves-effect waves-light btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Teachers"><h4 class="m-auto font-14 text-caps font-w-900">Teachers</h4></a>
                     <a class="btn waves-effect waves-light font-w-900 border-color m-b-0 text-white btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Parents"><h4 class="m-auto font-14 text-caps font-w-900">Parents</h4></a>
                     <a class="btn waves-effect waves-light font-w-900 border-color m-b-0 text-white btn-rounded btn-outline-primary edu-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#School"><h4 class="m-auto font-14 text-caps font-w-900">School Management </h4></a>
                     <a class="btn waves-effect waves-light font-w-900 border-color m-b-0 text-white btn-rounded btn-outline-primary edu-link btn-block" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Resource"><h4 class="m-auto font-14 text-caps font-w-900">Resource Persons</h4></a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </a>
       </div>

       <div class="col-md-6">
         <a href="#0">
           <div class="box-s br-5 animated zoomIn" onmouseover="mouseOver('reliance-show')" onmouseout="mouseOut('reliance-show')">
             <div class="card reliance-card br-5 m-t-10 projects h-150">
               <div class="card-body">
                 <div class="text-center">
                   <h4 class="m-auto reliance-text" style="font-size:30px">SELF-RELIANCE</h4>
                   <p class="reliance-text">create an opportunity to disadvantaged people.!</p>
                 </div>
               </div>
             </div>

             <div class="card animated flipInX project-overlay" style="display: none;" id="reliance-show">
               <div id="animationSandbox">
                 <div class="card-body p-0">
                   <div class="text-center p-5">
                     <a style="color:#fff;margin-bottom: 0px;" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary reliance-link border-color4" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Providers"><h4 class="m-auto font-14 text-caps" style="font-weight: 900;border-color:#e9e32b">Providers / Employers</h4></a>
                     <a style="color:#fff;margin-bottom: 0px;" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary reliance-link border-color4" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Seekers"><h4 class="m-auto font-14 text-caps" style="font-weight: 900;border-color:#e9e32b">Job Seekers</h4></a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </a>
       </div>
       <div class="col-md-6">
         <a href="#0">
           <div class="box-s br-5 animated zoomIn" onmouseover="mouseOver('infra-show')" onmouseout="mouseOut('infra-show')">
             <div class="card infra-card br-5 m-t-10 projects h-150">
               <div class="card-body">
                 <div class="text-center">
                   <h4 class="m-auto infra-text" style="font-size:30px">INFRASTRUCTURE</h4>
                   <p class="infra-text">Infrastructure is much more important than architecture.!</p>
                 </div>
               </div>
             </div>

             <div class="card animated flipInX project-overlay" style="display: none;" id="infra-show">
               <div id="animationSandbox">
                 <div class="card-body p-0">
                   <div class="text-center p-5">
                     <a class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary infra-link" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Colony">
                       <h4 class="m-auto font-14 text-caps font-w-900">HSCC Colony</h4>
                     </a>
                     <a href="javascript:void(0)" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary infra-link">
                       <h4 class="m-auto font-14 text-caps font-w-900">EPICENTER</h4>
                     </a>
                     <a href="javascript:void(0)" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary infra-link">
                       <h4 class="m-auto font-14 text-caps font-w-900">Other</h4>
                     </a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </a>
       </div>
     </div>
     
     <!-- ********************* Start Model ********************** -->
      @include('admin.Projects.POPModels.StudentsPopUp')
     <!-- ********************* End Model ********************** -->

     <!-- ********************* Start Model ********************** -->
      @include('admin.Projects.POPModels.DDPopUp')
     <!-- ********************* End Model ********************** -->
   @endsection
