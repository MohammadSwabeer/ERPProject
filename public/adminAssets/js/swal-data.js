
$( document ).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function SWALDATA(id,route,chartid,method,route2,str){
    swal({   
        title: "Are you sure?",   
        text: "You will not be able to recover this imaginary file!",   
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
            retrieveAjaxGet(route,method,id,str);
            retrieveData(route2,chartid); 
        } else {     
            swal("Cancelled", "Your file is safe", "error");   
        } 
    });
}

function SWALDATAPOST(url,destId,method,route,id){
        var data = $(`#${id}`).serialize();
        retrieveAjax(url,method,data);
        retrieveData(route,destId);
}


// function retrieveAjax(url,method,val,string){
//     $.ajax({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         method:'POST',
//         url:url,
//         dataType:'json',
//         data:{val:val,_token:'{{csrf_token()}}'},
//         beforeSend:function() {
//             swal({   
//                 title: "processing..!",
//                 imageUrl: "../adminAssets/images/LoaderSpin.gif",
//                 timer:3000,   
//                 showConfirmButton: false
//             });
//         }, 
//         success: function(response){
//             console.log(response);
//             swal({   
//                 title: response.act,
//                 text: response.message,
//                 type: response.status,
//                 timer:3000,   
//                 showConfirmButton: false
//             });
//         },
//         error:function(e){
//             console.log(e);
//         }
//     });
// }

// function retrieveAjax(url,val,type){
//     console.log(val);
//     $.ajax({
//         headers : {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         method: 'POST',
//         url:url,
//         dataType:'json',
//         data:{val:val,type:type,_token:'{{csrf_token()}}'},
//         cache: false,
//         beforeSend:function() {
//             swal({   
//                 title: "processing..!",
//                 imageUrl: "../adminAssets/images/LoaderSpin.gif",
//                 showConfirmButton: false
//             });
//         }, 
//         success: function(response){
//             swal({   
//                 title: response.act,
//                 text: response.message,
//                 type: response.status,
//                 timer:3000,   
//                 showConfirmButton: false
//             });
//         },
//         error:function(e){
//             console.log(e);
//         }
//     });
// }

// function retrieveData(url,destId){                   
//     $.ajax({
//         method :'GET',  
//         url : url,
//         beforeSend:function() {
//             swal({   
//                 title: "processing..!",
//                 imageUrl: "../adminAssets/images/LoaderSpin.gif",
//                 showConfirmButton: false
//             });
//         }, 
//         success:function(data){
//             $(`#${destId}`).html(data);
//         },
//         error:function(e){
//             console.log(e);
//         }
//     });
// }
