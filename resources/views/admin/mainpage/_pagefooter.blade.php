<footer class="footer text-left">
    © Hidayah Foundation
</footer>
<!-- Bootstrap popper Core JavaScript -->
<script src="{{URL::asset('adminAssets/js/popper/popper.min.js')}}"></script>
<script src="{{URL::asset('adminAssets/js/bootstrap.min.js')}}"></script>
<!-- paper boostrap -->
<script src="{{URL::asset('adminAssets/js/paper-step/jquery.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('adminAssets/js/paper-step/material-bootstrap-wizard.js')}}" type="text/javascript"></script>
<!-- validation JavaScript -->
<script src="{{asset('adminAssets/js/jquery.validate.min.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{URL::asset('adminAssets/js/perfect-scrollbar.jquery.min.js')}}"></script>
<!--Wave Effects -->
<script src="{{URL::asset('adminAssets/js/waves.js')}}"></script>
<script src="{{URL::asset('adminAssets/js/sidebarmenu.js')}}"></script>
<!--stickey kit -->
<script src="{{URL::asset('adminAssets/js/sticky-kit-master/sticky-kit.min.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('adminAssets/js/custom.min.js')}}"></script>
<script src="{{URL::asset('adminAssets/js/sweet-alert/sweetalert.min.js')}}"></script>


<!-- This is data table -->
<script src="{{asset('adminAssets/js/datatables/jquery.dataTables.min.js')}}"></script>
<!-- start - This is for export functionality only -->
<script src="{{asset('adminAssets/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('adminAssets/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('adminAssets/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')}}"></script>
<script src="{{asset('adminAssets/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')}}"></script>
<script src="{{asset('adminAssets/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')}}"></script>
<script src="{{asset('adminAssets/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('adminAssets/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')}}"></script>
<!-- datepicker JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<!-- Timeline JavaScript -->
<script src="{{asset('adminAssets/js/horizontal-timeline/horizontal-timeline.js')}}"></script>
<!-- Added by Author -->
<script type="text/javascript" src="{{URL::asset('adminAssets/js/admin-main.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('adminAssets/js/DataTable-data.js')}}"></script>
<script type="text/javascript" src="{{asset('adminAssets/js/main.charts.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('adminAssets/js/preloader.js')}}"></script>
<!-- <script type="text/javascript" src="{{--URL::asset('adminAssets/js/swal-data.js')--}}"></script> -->
<script type="text/javascript" src="{{URL::asset('adminAssets/js/ajax-main.js')}}"></script>
<script type="text/javascript" src="{{asset('adminAssets/js/dropify.min.js')}}"></script>
<!-- <script type="text/javascript" src="{{--asset('adminAssets/js/dropzone.js')--}}"></script> -->
<script>
    $(document).ready(function() {
        $('.myModels').modal({
            show: false,
            backdrop: 'static',
            keyboard: false
        });

        // Basic
        $('.dropify').dropify({
            messages : {
                default : 'Drag and drop Marks card file here'
            }
        });

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pourdropzone remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }

            // Dropzone class:
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });

    $('a[data-toggle="tab"]').on('hide.bs.tab', function (e) {
         var $old_tab = $($(e.target).attr("href"));
         var $new_tab = $($(e.relatedTarget).attr("href"));

         if($new_tab.index() < $old_tab.index()){
            $old_tab.css('position', 'relative').css("right", "0").show();
            $old_tab.animate({"right":"-100%"}, 500, function () {
               $old_tab.css("right", 0).removeAttr("style");
            });
         }
         else {
            $old_tab.css('position', 'relative').css("left", "0").show();
            $old_tab.animate({"left":"-100%"}, 500, function () {
               $old_tab.css("left", 0).removeAttr("style");
            });
         }
      });

      $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
         var $new_tab = $($(e.target).attr("href"));
         var $old_tab = $($(e.relatedTarget).attr("href"));

         if($new_tab.index() > $old_tab.index()){
            $new_tab.css('position', 'relative').css("right", "-2500px");
            $new_tab.animate({"right":"0"}, 500);
         }
         else {
            $new_tab.css('position', 'relative').css("left", "-2500px");
            $new_tab.animate({"left":"0"}, 500);
         }
      });

      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
         // your code on active tab shown
      });
    </script>
<script type="text/javascript">
// document.oncontextmenu = document.body.oncontextmenu = function() {return false;}
     $("#adhar-picture").change(function(){
        readURL2(this);
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log(reader);
            reader.onload = function (e) {
                $('#adharPreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#ration-picture").change(function(){
        readURL3(this);
    });

    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log(reader);
            reader.onload = function (e) {
                $('#RationPreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $.ajaxSetup({
    data: {
        _token: $('meta[name="csrf-token"]').attr('content')
    }
    });



    function SWALDATA(id,route,types){
        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this Record...!",   
            type: "warning",   
            customClass: 'swal-wide',
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Delete",   
            cancelButtonText: "Cancel",   
            closeOnConfirm: false,   
            closeOnCancel: false, 
        }, function(isConfirm){   
            if (isConfirm) { 
                retrieveAjax(id,route,types);
            } else {     
                swal("Cancelled", "Your file is safe", "error");   
            } 
        });
    }

    function retrieveAjax(val,url,type){
        $.ajax({
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url:url,
            dataType:'json',
            data:{val:val,type:type,_token:'{{csrf_token()}}'},
            cache: false,
            beforeSend: function() {
                swal({   
                    title: "processing..!",
                    imageUrl: "../adminAssets/images/LoaderSpin.gif",
                    showConfirmButton: false
                });
            }, 
            success: function(response){
                swal({   
                    title: response.act,
                    text: response.message,
                    type: response.status,
                    timer:2000,   
                    showConfirmButton: false
                });
                
            },
            error:function(e){
                console.log(e);
            },
            complete : pageLoad
        });
    }

    function pageLoad(){
        setTimeout("location.reload(true);",500);
    }

    function projectsAjaxData(value,url,dest,type,field,next){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'POST',
            url : url,
            dataType: 'text',
            data:{hfid:value,type:type,field:field,next:next,_token:'{{csrf_token()}}'},
            success:function(data){
                $('#'+dest).html(data);
                console.log(data);
            },
            error:function(e){
                console.log(e);
            }
        });
    }

    function ajaxData(val,url,appId,str,str2,str3 = ''){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method:'POST',
            url : url,
            dataType: 'text',
            data:{val:val,str:str,str2:str2,str3:str3,_token:'{{csrf_token()}}'},
            success:function(data){
                $('#'+appId).html(data)
                console.log(data);
            },  
            error:function(e){
                console.log(e);
            }
        });
    } 

    function ajaxGetData(value,url,chartid){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'POST',
            url : url,
            dataType: 'text',
            data:{value:value,_token:'{{csrf_token()}}'},
            success:function(data){
                $('#'+chartid).html(data)
                console.log(data);
            },  
            error:function(e){
                console.log(e);
            }
        });
    }  


    function searchDataExists(value,url,app,id,listId,app2,str){
        var value1 = (str == 'inst') ? selects(value,listId,app2) : document.getElementById(app2).value;
        id = document.getElementById(id).value;
        if(id != ''){
            var val = (str == 'inst') ? id : value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'POST',
                url : url,
                dataType: 'text',
                data:{value : value1,id : val,val2 : value,_token:'{{csrf_token()}}'},
                success:function(data){
                    $('#'+app).html(data)
                    console.log(data);
                },  
                error:function(e){
                    console.log(e);
                }
            });
        }
    }   
    
    </script>

