<script>
function addInstitution(app,btn,btn2,lists,choice){
  var list = JSON.parse(lists);
  document.getElementById(choice).value = 1;
  var div = `<div class="row instrow animated zoomIn">
            <div class="col-md-9">
              <div class="form-group">
                 <input list="Institutions" type="text" name="institution_name" class="custom-select form-control" id="Institution" placeholder="Enter School/ College name" value="{{ old('institution_name') }}" onblur="searchDataExists(this.value,'{{route('serachDataExists')}}','inst_info','location','Institutions','institution_id','inst')" required>
                  <datalist id="Institutions">
                  ${Object.keys(list).map(function (key) {
                    return "<option data-value='" + list[key].id + "' value='" + list[key].institution_name + "'></option>"
                  }).join("")}  
                  </datalist>
              	<input type="hidden" name="institution_id" id="institution_id">
              </div>
           </div>

           <div class="col-md-3">
            <div class="form-group">
              <input list="Location" type="text" name="location" class="custom-select form-control" id="location" placeholder="Enter Exact Location" onblur="searchDataExists(this.value,'{{route('serachDataExists')}}','inst_info','Institution','Institutions','institution_id','loc')" value="{{ old('location') }}" placeholder="Eneter Exact Location"  required>
              <datalist id="Location">
              ${Object.keys(list).map(function(key){return "<option value='" + list[key].location + "'></option>"}).join("")}
              </datalist>            
            </div>
          </div>
        </div>
        <div class="row instrow animated zoomIn" id="inst_info">
         <div class="col-md-4">
	      	<div class="form-group">
	         <input list="Sector" type="text" name="sector" class="custom-select form-control" id="sector" value="{{old('sector')}}" placeholder="Enter sector name">
	         <datalist id="Sector">
	            <option value="Government"></option>
	            <option value="Private"></option>
	         </datalist>
	      </div>
	   </div>

	   <div class="col-md-4">
	     <div class="form-group">
	        <input list="Community_type" type="text" name="community_type" class="custom-select form-control" id="community_type" value="{{old('community_type')}}" placeholder="Community Type">
	        <datalist id="Community_type">
	           <option value="Community"></option>
	           <option value="Non Community"></option>
	        </datalist>
	     </div>
	  </div>

	   <div class="col-md-4">
	      <div class="form-group">
	         <input list="Institution_type" type="text" name="institution_type" class="custom-select form-control" id="institution_type" value="{{old('institution_type')}}" placeholder="Institution Type">
	         <datalist id="Institution_type">
	            <option value="CBSE"></option>
	            <option value="State"></option>
	            <option value="Other"></option>
	         </datalist>
	      </div>
	   </div>

	   <div class="col-md-12">
	      <div class="form-group">
	         <textarea name="inst_street" id="inst_street" rows="6" class="form-control" placeholder="Area/ Street/ Village">{{old('inst_street')}}</textarea>
	      </div>
	   </div>

	   <div class="col-md-3">
	      <div class="form-group">
	         <input list="inst_City" type="text" name="inst_city" id="inst_city" class="form-control" value="{{old('inst_city')}}" placeholder="Taluk/ City">
	         <datalist id="inst_City">
	            <option value="Bantval"></option>
	            <option value="Mangalore"></option>
	            <option value="Belthangady"></option>
	         </datalist>
	      </div>
	   </div>

	   <div class="col-md-3">
	      <div class="form-group">
	         <input list="inst_district" type="text" name="inst_district" id="inst_District" class="form-control" value="{{old('inst_district')}}" placeholder="District">
	         <datalist id="inst_district">
	            <option value="Dakshina Kannada"></option>
	            <option value="Udupi"></option>
	         </datalist>
	      </div>
	   </div>

	   <div class="col-md-3">
	      <div class="form-group ">
	         <input list="inst_State" class="form-control" type="text" name="inst_state" id="inst_state" value="{{ old('inst_state')}}" placeholder="State">
	         <datalist id="inst_State">
	            <option value="Karnataka"></option>
	            <option value="Kerala"></option>
	         </datalist>
	      </div>
	   </div>

	   <div class="col-md-3">
	      <div class="form-group">
	         <input type="number" name="inst_pincode" class="form-control" id="inst_pincode" value="{{old('inst_pincode')}}" placeholder="Pin-Code">
	      </div>
	   </div>
      <div>`;
      $('.'+btn).hide();
      $('.'+btn2).show();
   $('.'+app).html(div);
}

function removeInstitution(app,btn,btn2,choice){
  document.getElementById(choice).value = 0;
    $(`.instrow`).hide("slow", function(){ $(this).remove(); });
    $('.'+btn).hide();
    $('.'+btn2).show();
}
</script>