
@if($addresses != "")

	<div class="col-md-12 m-b-0">
		<span class="text-warning font-12">Address your trying is already exist, can you continue to this...</span>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="colony">Street/ Colony :</label>
			<input type="text" name="colony" id="colony" class="form-control" required="must enter the field" required="">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="street">Street/Village :</label>
			<textarea name="street" id="street" rows="2" class="form-control" readonly="">
				{{$addresses->street}}
			</textarea>
		</div>
	</div>
<!-- 	<div class="col-md-2">
		<div class="form-group">
			<label for="belongs">Belongs To :</label>
			<input type="text" value="Urban" name="belongs" class="form-control" id="belongs" readonly=""> 
		</div>
	</div> -->
	<div class="col-md-4">
		<div class="form-group">
			<label for="state">State :</label>
			<input type="text" value="{{$addresses->state}}" name="state" class="form-control" id="state" readonly="">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="city">City :</label>
			<input type="text" value="{{$addresses->taluk}}" name="city" class="form-control" id="city" readonly="">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="post">Post Code :</label>
			<input type="text" value="{{$addresses->postcode}}" name="post" class="form-control" id="post" readonly=""> 
		</div>
	</div>
	@else
	<div class="col-md-6">
		<div class="form-group">
			<label for="colony">Street/ Colony :</label>
			<input type="text" name="colony" id="colony" class="form-control" placeholder="Enter your street or street or colony details..." required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="street">Street/Village :</label>
			<textarea name="street" id="street" rows="2" class="form-control" placeholder="Enter your street or village details..."></textarea>
		</div>
	</div>
<!-- 	<div class="col-md-2">
		<div class="form-group">
			<label>Belongs To : </label>
			<fieldset class="controls">
                     <div class="custom-control custom-radio">
                        <input type="radio" value="Urban" name="belongs" required="" id="Urban1" class="custom-control-input" aria-invalid="false" checked="checked">
                        <label class="custom-control-label" for="Urban1">Urban</label>
                     </div>
                     <div class="help-block" ></div>
                  </fieldset>
                 <fieldset>
                    <div class="custom-control custom-radio">
                       <input type="radio" value="Rural" name="belongs" id="rural1" class="custom-control-input">
                       <label class="custom-control-label" for="rural1">Rural</label>
                    </div>
                 </fieldset>
                 <fieldset>
                    <div class="custom-control custom-radio">
                       <input type="radio" value="Semi-Rural" name="belongs" id="Semi1" class="custom-control-input">
                       <label class="custom-control-label" for="Semi1">Semi-Rural</label>
                    </div>
                 </fieldset>
		</div>
	</div> -->
	<div class="col-md-4">
		<div class="form-group">
			<label for="state">State :</label>
			<select class="custom-select form-control" id="state" name="state">
				<option value="">Select state</option>
				<option value="Karnataka">Karnataka</option>
				<option value="Kerala">Kerala</option>
				<option value="UP">UP</option>
			</select>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label for="city">City :</label>
			<select class="custom-select form-control" id="city" name="city">
				<option value="">Select city</option>
				<option value="Mangalore">Mangalore</option>
				<option value="Bantval">Bantval</option>
				<option value="Udupi">Udupi</option>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="post">Post Code :</label>
			<input type="text" name="post" value="" class="form-control" id="post" placeholder="Enter pin/postal code"> 
		</div>
	</div>

@endif