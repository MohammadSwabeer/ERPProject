<?php use \App\Http\Controllers\MainController; $main = new MainController;?> 
@extends('admin/mainpage/adminmain')

@section('admincontents')

<div class="row">
   <div class="col-12">
     <div class="card box-shadow-e br-5">
       @include('admin.mainpage.pages.main-preloader')
         <div class="card-body contents" style="display: none">
            <div class="row">
               <div class="col-md-12"> 
                  <h4 class="card-title"> MONTHLY RATION Information
                     <div class="btn-group pull-right btnGroup">
                        <a class="btn br-25 w-fit btn-outline-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#MRDetails" data-toggle="tooltip" aria-haspopup="true" aria-expanded="false" title="Add Family Details" data-placement="top"> ADD MONTHLY RATION <i class="ti-plus"></i> </a>
                     </div>
                  </h4>
               </div>
            </div>

           <div class="table-responsive m-t-40">
              <table id="HSCCDT" class="table m-t-30 table-hover contact-list ">
                 <thead>
                   <tr>
                       <th>Sl.No.</th>
                       <th>Door/House No.</th>
                       <th>HFSCC-ID</th>
                       <th>Full Name</th>
                       <th>No of Dependent</th>
                    </tr>
                 </thead>
                 <tbody id="HSCCData">

                 </tbody>
              </table>
              <div class="text-center loading-image" style="display: none;">
                <i class="fa fa-spin fa-refresh text-center font-70 text-center m-auto" ></i>
              </div>
           </div>

         </div>
      </div>
   </div>
</div>

<!-- Start Modal -->
    <div class="modal fade" id="MRDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:transparent;border:unset;width: auto;">
           <div style="">
              <a class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></a>
           </div>

          <div class="modal-body">
            <div class="card-body bg-white">
              	<div class="row">
	              	<div class="col-md-12"> 
	                  <h4 class="card-title"> MONTHLY RATION Information </h4>
	               	</div>
	              	<div class="col-md-6">
	                 	<div class="form-group controls">
	                    	<div class="form-group label-floating">
		                       <label class="control-label">Beneficiary Name<small><SUP>(*)</sup></small></label>
		                       <input list="Beneficiary" type="text" name="beneficiary" value="{{ old('p_city') }}" class="form-control" id="beneficiary" required>
								<datalist id="Beneficiary">
			                      <option> Select Beneficiary </option>
			                    </datalist>
	                    	</div>
	                 	</div>
	              	</div>
	              	<div class="col-md-6">
		               	<div class="form-group controls">
		                  	<div class="form-group label-floating">
			                    <label class="control-label">Area of  interest/ Future goal <small><sup>(*)</sup></small></label>
			                    <textarea name="goal" id="goal" rows="6" class="form-control @error('goal') is-invalid @enderror">{{ old('goal') }}</textarea>
			                </div>
		               	</div>
	            	</div>

                </div>
            </div>
          </div>
          <!-- end modal-body -->
        </div>
        <!-- end modal-content -->
      </div>
      <!-- end modal-dialog -->
    </div>

   <!-- Start Modal -->
@endsection
