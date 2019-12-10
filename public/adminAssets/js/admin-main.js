$('document').ready(function(){
  $('.filters').hide();
  $('#generalRole').hide();
  $('#trusteeRole').hide();
  $('#edu-show').hide();

});

 window.onload = function(){
  // var val = this.historyDetails();
  // $('#History').html(val);

 } 
 function mouseOver(id){
  $('#'+id).show();
 }

 function mouseOut(id){
  $('#'+id).hide();
 }

function family(){
 console.log("clear");
 document.getElementById('familyForm').reset();
}

function showEval(){
 document.getElementById('evaluationDetailsId').style.display = "none";
 document.getElementById('studentEvaluationRow').style.display = "block";
}

function showEvalDetails(){
 document.getElementById('studentEvaluationRow').style.display = "none";
 document.getElementById('evaluationDetailsId').style.display = "block";
}

function evalHelpsHead(value,help,status){
  
  (value == 'father') ? document.getElementById(help).style.display = 'block' : document.getElementById(help).style.display = 'none';

  var div = (value == 'father' || value == 'mother') ? `<option value="Married">Married</option>` : `<option value="">Select status</option><option value="Married">Married</option>
<option value="Unmarried">Unmarried</option>`;
  $(`#${status}`).html(div);
}

function coinboxSub(){
 $('#coinboxCollected').attr('disabled', false);
 $('#coinboxSubmitted').attr('disabled', false);
}

function coinboxNot(){
 document.getElementById('coinboxSubmitted').value = '';
 document.getElementById('coinboxCollected').value = '';

 $('#coinboxCollected').attr('disabled', true);
 $('#coinboxSubmitted').attr('disabled', true);
}

 // date Validation start 
 function varaibles(){
    var rightNow,resrightNow,passedDate,passedDateRes;
    var val,errors,val2;
 }

 function ids(id,error){
    val = document.getElementById(id).value;
    error = document.getElementById(error).id;
 }

 function compare(id,error,text,nxt)
 {
    if (id !== '') {
      this.varaibles();
      this.ids(id,error);
      rightNow = new Date() ;
      res = rightNow.toISOString().slice(0,10).replace(/-/g,"");
      passedDate = new Date(val);
      passedDateRes = passedDate.toISOString().slice(0,10).replace(/-/g,"");
      if(passedDateRes > res) {
         $(`.${nxt}`).prop('disabled',true);
         return document.getElementById(error).innerHTML = text; 
      }else{
         text = '';
         $(`.${nxt}`).prop('disabled',false);
         return document.getElementById(error).innerHTML = text;
      }
     
   }else{
      console.log(nxt);
      return document.getElementById(error).innerHTML = text = '';
   }
}

function propDisable(id,booleon){
  $(`.${id}`).prop('disabled',booleon);
}

function checkField(id,error,text,v,string,string1)
{
 if(this.compare(id,error,text) == ''){
   if(v !== ''){
     val = document.getElementById(id).value;
     rightNow = new Date(val);
     res = rightNow.toISOString().slice(0,10).replace(/-/g,"");
     passedDate = new Date(v);
     passedDateRes = passedDate.toISOString().slice(0,10).replace(/-/g,"");
     document.getElementById(error).innerHTML = (res < passedDateRes) ? string : string = '';
  }else{
     document.getElementById(error).innerHTML = string1;
  }
}else{
  document.getElementById(error).innerHTML = text;
}

}

function checkNumber(value,app){
  console.log(value);
  // var intRegex = ;
  $('#'+app).html((/^\d+$/.test(value) && value != '') ? "" : 'Enter valid number');
}
 // enddate validation

 function btnSubmit(id){
    $('#'+id).show();
  }

  var div = '';

  var id = 1;
  function addFieilds(name,app){
   div = (name != 'rank') ? `
        <div class="col-md-4" id="col${id}">
          <div class="form-group">
            <label for="other_organisation${id}" class="control-label">Organisation Name :</label>
            <textarea name="other_organisation[]" id="other_organisation${id}" cols="10" rows="4" class="form-control"></textarea>
          </div>
        </div>
        <div class="col-md-4" id="col1${id}">
          <div class="form-group">
            <label for="position_held${id}" class="control-label">Position Held :</label>
            <input type="text" name="position_held[]" value="" class="form-control" id="position_held${id}">
          </div>
        </div>
        <div class="col-md-4" id="col2${id}">
          <div class="form-group">
            <label for="member_since${id}" class="control-label">Member since :</label>
            <input type="date" name="member_since[]" value="" class="form-control" id="member_since${id}">
          </div>
        </div>` : `<div class="col-md-6" id="col${id}">
                      <div class="form-group label-floating">
                         <label class="control-label" for="rank_name${id}"><b>Rank Name :</b></label>
                         <input type="text" class="custom-select form-control" id="rank_name${id}" name="rank_name[]">
                      </div>
                    </div>
                    <div class="col-md-6" id="col2${id}">
                      <div class="form-group label-floating">
                         <label class="control-label" for="rank_list${id}"><b>Rank List :</b></label>
                         <input type="text" class="custom-select form-control" id="rank_list${id}" name="rank_list[]">
                      </div>
                    </div> `;
   id++;
   $('#'+app).append(div);
}

function deleteFieilds(){
     $(`#col${id-1}`).remove();
     $(`#col1${id-1}`).remove();
     $(`#col2${id-1}`).remove();
     id--;
}

  function btnNo(id){
    $('#'+id).hide();
 }


 function filter(){
    $('#btnFilter').hide();
    $(`.filters`).show();
 }

 function filterHide(){
    $('.filters').hide();
    $('#btnFilter').show();
   }

   var i = 1;
   var row = '';
   function addRows(p,p2){
       row = `<div class="form-group" id="col${i}">
               <textarea name="${p}[]" id="${p}${i}" class="form-control" cols="4" rows="50" placeholder="Please fill" required></textarea>
             </div>`;
       i++;
       $(`#${p2}`).append(row);
   }

   function addQRows(p,p2,p3){
       row = `<div class="row" id="col${i}">
               <div class="col-md-8">
                  <div class="form-group" >
                     <textarea name="${p}[]" id="${p}${i}" class="form-control" cols="4" rows="50" placeholder="Please fill" required></textarea>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <input type="text" name="${p2}[]" class="form-control" id="${p2}${i}" placeholder="Please fill...">
                  </div>
               </div>
            </div>
            `;
       i++;
       $(`#${p3}`).append(row);
   }

   function delRows(){
       $(`#col${i-1}`).remove();
       i--;
   }

 var role ='';
 function commiteeRole(p,app){
  console.log(p);
    if (p === 'Core Committee') {
       role = `<option value="">--select role--</option>
                <option value="President">President</option>
                <option value="Secretary">Secretary</option>
                <option value="Finance Controller">Finance Controller</option>
                <option value="Donor Management">Donor Management</option>
                <option value="Event Management">Event Management</option>
                <option value="HR Management">HR Development</option>
                <option value="Team Management">Team Expansion</option>
                <option value="Member">Member</option>`;
       $('#'+app).html(role);

    }else if(p === 'General Committee'){
      role = `<option value="">--select role--</option>
               <option value="Member">Member</option>`;
      $('#'+app).html(role);
   }else{
      role = `<option value="">--select role--</option>
               <option value="Chairman">Chairman</option>
               <option value="Vice Chairman">Vice Chairman</option>
               <option value="Sub-Vice Chairma">Sub-Vice Chairman</option>
               <option value="Finance Controller">Finance Controller</option>
               <option value="General Secretary">General Secretary</option>
               <option value="Member">Member</option>`;
      $('#'+app).html(role);
   }
}

function findMember(val,id,id2){
    if(val == 'Staff'){
      $('#'+id).attr('disabled', true);
      $('#'+id2).attr('disabled', true);
    }else{
      $('#'+id).attr('disabled', false);
      $('#'+id2).attr('disabled', false);
    }
}

function makeRole(val,app){
  val = (val == 'Alive' && document.getElementById(app).value == '') ? `<option value="">Select Role</option>
                <option value="Head">Head</option>
                <option value="Member">Member</option>` : `<option value="Member">Member</option>`;
  
  $('#'+app).html(val);
}


function makeVisibleField(val,app,id,id2,id3,preAdd,infoHead){
  if(val == 'Head') {
    $('#'+id).show();
    $('#'+id2).show();
    $('#'+id3).show();
    $('#'+preAdd).show();
    $('#'+infoHead).hide();
    val =  this.historyDetails();
  }else{
    $('#'+id).hide();
    $('#'+id2).hide();
    $('#'+id3).hide();
    $('#'+preAdd).hide();
    $('#'+infoHead).show();
    val= `<div class="row">
          
              <div class="col-md-12">
                <div class="form-group">
                   <label for="HealthStatus">Health Status :</label>
                   <input list="healthStatus" type="text" name="HealthStatus" class="custom-select form-control" id="HealthStatus" placeholder="Enter Health Condition" required>
                    <datalist id="healthStatus">
                      <option value="Select">Select</option>
                    </datalist>
                </div>
             </div>
             <div class="col-md-12">
                <div class="form-group">
                   <label for="Qualification">Qualification :</label>
                   <input list="qualification" type="text" name="Qualification" class="custom-select form-control" id="Qualification" placeholder="Enter Qualification" required>
                    <datalist id="qualification">
                      <option value="Select">Select</option>
                    </datalist>
                </div>
             </div>
          </div>`;
  }
  $('#'+app).html(val);
}

function MaritalChange(val,app){
  console.log(val);
  val = (val === 'Father' || val === 'Mother'|| val === 'Wife'|| val === 'Husband') ? `<option value="Married">Married</option>` : 
          `<option value="">Select Marital Status</option>
          <option value="Married">Married</option>
          <option value="UnMarried">Single</option>`;
  $('#'+app).html(val);
}

function historyDetails(){
  return `<div class="row">
             <div class="col-md-3">
                <div class="form-group">
                   <label for="dojHSCC">Date of Join :</label>
                   <input type="date" name="dojHSCC" class="form-control" id="dojHSCC" placeholder="Enter Date of Join" required> 
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                   <label for="Reason">Reason/Desperation :</label>
                   <textarea name="reason" id="Reason" rows="10" cols="10" class="form-control" placeholder="Enter your Reason/Desperation here..." required></textarea>
                </div>
             </div>
             <div class="col-md-12">
              <hr>
               <h4>Previous status </h4>
             </div>
             <div class="col-md-4">
                <div class="form-group">
                   <label for="Familial">Familial/ Realtionship :</label>
                   <input list="familial" type="text" name="familial" class="custom-select form-control" id="Familial" placeholder="Enter Familial/ Realtionship" required>
                    <datalist id="familial">
                      <option value="Abandoned">Abandoned</option>
                      <option value="Domestic Violence">Domestic Violence</option>
                      <option value="Divorcee">Divorcee</option>
                      <option value="Widowed">Widowed</option>
                    </datalist>
                </div>
             </div>
             <div class="col-md-4">
                <div class="form-group">
                   <label for="income_source">Income source :</label>
                   <input type="text" name="income_source" class="form-control" id="income_source" placeholder="Enter Income source" required> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                   <label for="HealthStatus">Health Status :</label>
                   <input list="healthStatus" type="text" name="HealthStatus" class="custom-select form-control" id="HealthStatus" placeholder="Enter Health Condition" required>
                      <datalist id="healthStatus">
                        <option value="Select">Select</option>
                      </datalist>
                </div>
             </div>
             <div class="col-md-4">
                <div class="form-group">
                   <label for="Qualification">Qualification :</label>
                   <input list="qualification" type="text" name="Qualification" class="custom-select form-control" id="Qualification" placeholder="Enter Qualification" required>
                      <datalist id="qualification">
                        <option value="Select">Select</option>
                      </datalist>
                </div>
             </div>

             <div class="col-md-4">
                <div class="form-group">
                   <label for="Shelter">Shelter :</label>
                   <input list="shelter" type="text" name="Shelter" class="custom-select form-control" id="Shelter" placeholder="Enter Shelter" required>
                      <datalist id="shelter">
                        <option value="Owned">Owned</option>
                        <option value="Rented">Rented</option>
                        <option value="None">None</option>
                      </datalist>
                </div>
             </div>

             <div class="col-md-4">
                <div class="form-group">
                   <label for="SelfReliant">Self Reliant :</label>
                   <select class="custom-select form-control" id="SelfReliant" name="SelfReliant" required>
                       <option value="">Select Self Reliant</option>
                       <option value="Yes">Yes</option>
                       <option value="No">No</option>
                    </select>
                </div>
             </div>

             <div class="col-md-12">
                <div class="form-group">
                   <label for="Services">Services obtained upto now from HSCC :</label>
                   <textarea name="Services" id="Services" rows="10" cols="10" class="form-control" placeholder="Enter Services obtained upto now from HSCC..." required></textarea>
                </div>
             </div>
             <div class="col-md-12">
              <hr>
               <h4>Present status </h4>
             </div>
             <div class="col-md-12">
                <div class="form-group">
                   <textarea name="presentStatus" id="presentStatus" rows="10" cols="50" class="form-control" placeholder="Briefly explain the contentment or dissatisfaction..." required></textarea>
                </div>
             </div>
          </div>`;
}

function selects(value,listId,app){
    return document.getElementById(app).value = $('#'+listId+' [value="' + value + '"]').data('value'); 
  }

function checkField(val,app,type,next){

  if(type == 'number'){
    val = (parseInt("0"+val, 10) == 0) ? this.disables('','Please enter valid information',next) : this.disables('',' ',next);
  }else if(type == 'string' || val != ''){
    val = (/[^a-zA-Z\- \/]/.test(val) == true) ? this.disables('Please enter valid information','',next) : this.disables(' ','',next);
  }

  $(`#${app}`).html(val);
}

function disables(string,num,dis){
  if(num != ''){
    (string == '' ) ? $('.'+dis).prop('disabled',true) : $('.'+dis).prop('disabled',false);
    (string == '' && num == ' ') ? $('.'+dis).prop('disabled',false) : $('.'+dis).prop('disabled',true);
    return num;
  }else{
    (num == '' ) ? $('.'+dis).prop('disabled',true) : $('.'+dis).prop('disabled',false);
    (num == '' && string == ' ') ? $('.'+dis).prop('disabled',true) : $('.'+dis).prop('disabled',false);
    return string;
  }
} 

function findRemark(val,dest){
  val = (val == 'Drop Out') ? `<option value="">Select</option>
                              <option value="Not Planned">Not Planned</option>
                        <option value="Financial Problem">Financial Problem</option>
                        <option value="Failure">Failure</option>` : `<option value="Admitted">Admitted</option>`;
  $(`#${dest}`).html(val);
}

function findDDValue(val,app,id){
    var vals = document.querySelector("#"+id+" option[value='"+val+"']").dataset.value;
    return document.getElementById(app).value = vals;
}

function ifExists(val,app,str){
    return (val == str ) ? $('#'+app).hide() : $('#'+app).show();
}

function findDocCards(v,app){
    return document.getElementById(app).value = v;
}

function headRigths(val,app){
  // if($("#list").has('#histories').length){
  //   console.log($("#list").has('#hisetories').length);
  // }else{
  //   console.log($("#list").has('#histories').length);
  // }
    // if(val != 'Head'){
    //   $('.'+app).hide();
    //   $('#histories').remove();
    // }else{
      // console.log($("#list").has('#histories').length);
      // if($("#list").has('#histories').length == 0){
      //   $('<li id="histories"><a href="#History" data-toggle="tab" class="font-w-700">History/ Status</a></li>').insertAfter('#list li:eq(0)')
      // }
      // $('.'+app).show();
      // if($("#list").has('#histories').length == 0){
      //   $('#list li:eq(0)').after('<li id="histories"><a href="#History" data-toggle="tab" class="font-w-700">History/ Status</a></li>');
      // }
}


