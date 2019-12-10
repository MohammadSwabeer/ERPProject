<?php use \App\Http\Controllers\MainController; $main = new MainController;?>  
@extends('admin.mainpage.adminmain')

@section('admincontents')

<div class="row page-titles p-10 m-0">
	 <div class="col-md-12">
	   <div class="d-flex">
	       <ol class="breadcrumb">
	         <li class="breadcrumb-item"><a href="">Home</a></li>
	         <li class="breadcrumb-item active">Organisations</li>
	       </ol>
	   </div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h3 class="text-center font-w-700 text-uppercase">Contributing Human Resources</h3>
		<hr>
	</div>
	<div class="col-md-4">
	   <div class="row">
	     <div class="col-md-12">
	       <div class="user-img text-center"> 
	         <img src="{{asset('adminAssets/images/OrganizationsProfile/Mangalore.jpg')}}" alt="user" class="br-t-r-5 box-shadow-e w-100">
	       </div>
	     </div>
	     <div class="col-md-12">
	       <div class="card box-shadow-e br-b-l-5">
	         <div class="card-body">
	           <div class="row">

               @foreach($units as $unit)
               @if($unit->u_category == 'HQ')
               <?php $manglore_id = $unit->id; ?>

	             <div class="col-md-12">
	               <h3>Head Quarters : <a> {{$unit->unit_name}}</a></h3>
	             </div>
	             <div class="col-md-12">
	               <hr>

	               <div class="p-10">

	                 <div class="row">
	                   <div class="media">
	                     <div class="media-left">
	                       <i class="fa fa-phone text-theme-colored font-25 pr-10"></i>
	                     </div>
	                     <div class="media-body">
	                       <h5 class="mt-0 mb-0 font-Trirong">Phone </h5>
	                       <p class="color-1">{{$unit->unit_phone}}</p>
	                     </div>
	                   </div>
	                 </div>

	                 <div class="row">
	                   <div class="media">
	                     <div class="media-left">
	                       <i class="fa fa-map-marker text-theme-colored font-25 pr-10"></i>
	                     </div>
	                     <div class="media-body">
	                       <h5 class="mt-0 mb-0 font-Trirong">Address </h5>
	                       <p class="color-1"> {{$unit->street}}, {{$unit->state}}, {{$unit->nation}}, {{$unit->unit_pin_code}}</p>
	                     </div>
	                   </div>
	                 </div>

	                 <div class="row unitMemeberRow">
	                   <div class="media">
	                     <div class="media-left">
	                       <a class="btn btn-circle btn-sm btn-outline-primary" href="#" data-toggle="modal" data-target="">
	                         <i class="ti-pencil-alt"></i>
	                       </a>
	                     </div>
	                     <div class="media-right">
	                       <a class="btn btn-circle btn-sm btn-outline-success" href="">
	                         <i class="ti-more-alt"></i>
	                       </a>
	                     </div>
	                   </div>
	                 </div>
	                 
	               </div>
	             </div>
	             @endif
	             @endforeach
	           </div>
	         </div>
	       </div>
	     </div>
	   </div>
	</div>

	<div class="col-md-8">
		<div class="card-body box-shadow br-t-l-115 bg-white m-b-10 border-green p-15">
			<div class="row">
				<div class="col-md-2">
					<div class="user-img"> 
			    	    <img src="{{asset('adminAssets/images/HFlogo.jpg')}}" alt="user" class="img-circle box-shadow-color" width="130" height="130">
			      	</div>
				</div>

				<div class="col-md-10">
					<div class="card-body mb-m-20">
						<div class="row">
							<div class="col-md-12">
								<div class="light-green">
									<h3 class="text-uppercase font-32 font-w-900">headquarters Units</h3>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div>
									<h3>
										<a href="javascript:void(0)" class="btn br-15 btn-sm  font-w-700 btn-outline-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Youth Wing">Youth Wing</a> 
										<a href="javascript:void(0)" class="btn br-15 btn-sm  font-w-700 btn-outline-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Womens Wing">Womens Wing</a> 
										<a href="javascript:void(0)" class="btn br-15 btn-sm  font-w-700 btn-outline-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Girls Wing">Girls Wing</a> 
										<a class="btn br-15 btn-sm  font-w-700 btn-outline-green" >ATT Students</a> 
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

			<div class="card-body box-shadow br-t-l-115 bg-white m-b-10 border-green p-15">
				<div class="row">
					<div class="col-md-2">
						<div class="user-img"> 
				         <img src="{{asset('adminAssets/images/HFlogo.jpg')}}" alt="user" class="img-circle box-shadow-color" width="130" height="130">
				      </div>
					</div>

					<div class="col-md-10">
						<div class="card-body mb-m-20">
							<div class="row">
								<div class="col-md-12">
									<div class="light-green">
										<h3 class="text-uppercase font-32 font-w-900">Overseas Units</h3>
									</div>
									<hr>
								</div>
								<div class="col-md-12">
									<div>
										<h3><a class="btn br-15 btn-sm btn-outline-green font-w-700" href="javascript:void(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Overseas">more info</a></h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card-body box-shadow br-t-l-115 bg-white m-b-10 border-green p-15">
				<div class="row">
					<div class="col-md-2">
						<div class="user-img text-center"> 
				         <img src="{{asset('adminAssets/images/HFlogo.jpg')}}" alt="user" class="img-circle box-shadow-color" width="130" height="130">
				      </div>
					</div>

					<div class="col-md-10">
						<div class="card-body mb-m-20">
							<div class="row">
								<div class="col-md-12">
									<div class="light-green">
										<h3 class="text-uppercase font-32 font-w-900">Organisation Staffs</h3>
									</div>
									<hr>
								</div>
								<div class="col-md-12">
									<?php 
										$staff = ['ATT','HSCC','HQ Admin','Ground'];
									 ?>
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
</div>

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

@endsection