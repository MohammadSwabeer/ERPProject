<div class="row">
   <div class="col-12">
    @if(Session::has('success'))
    <script type="text/javascript">
      // $('#wizardProfile').find('form')[0].reset();
      // document.getElementById("addForm").reset();
      // document.forms["frm_id"].reset();
      // $('#client.frm').trigger("reset");
    </script>
      <div class="alert alert-success">{{Session::get('success')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
    @endif
    @if(Session::has('error'))
      <div class="alert alert-danger">{{Session::get('error')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
    @endif
   </div>
</div>