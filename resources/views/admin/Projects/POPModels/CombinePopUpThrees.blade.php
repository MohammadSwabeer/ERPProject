   <?php use \App\Http\Controllers\MainController; $main = new MainController; $moData = ['Parents','School','Resource'];?>  

   @foreach($moData as $mod)
   <?php $data = $main->modelData($mod);?>

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
                                 <h3 class="font-NexaRustSans-Black animated pulse" style="font-size: 35px;font-weight: 800; margin-top: 20px;color: #23a523;"> {{$data->getData()->title}}.  
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
                                   <div class="animated zoomIn">
                                     <a href="{{(ifAnd($data->getData()->route) == true) ? (ifAnd($data->getData()->id) == true) ? (ifAnd($data->getData()->id21) == true) ? (ifAnd($data->getData()->id31) == true) ? route($data->getData()->route,[$data->getData()->id,$data->getData()->id21,$data->getData()->id31]): route($data->getData()->route,[$data->getData()->id,$data->getData()->id21]) : route($data->getData()->route,[$data->getData()->id]) : route($data->getData()->route) : 'javascript:void(0)'}}" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-success edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#4cc46c;line-height: 2;text-transform: uppercase;">{{$data->getData()->btn}}</h4></a>
                                   </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div class="animated zoomIn">
                                     <a href="{{(ifAnd($data->getData()->route2) == true) ? (ifAnd($data->getData()->id2) == true) ? (ifAnd($data->getData()->id22) == true) ? (ifAnd($data->getData()->id32) == true) ? route($data->getData()->route2,[$data->getData()->id2,$data->getData()->id22,$data->getData()->id32]): route($data->getData()->route2,[$data->getData()->id2,$data->getData()->id22]) : route($data->getData()->route2,[$data->getData()->id2]) : route($data->getData()->route2) : 'javascript:void(0)'}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-success edu-link btn-block box-shadow-e">
                                      <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#4cc46c;line-height: 2;text-transform: uppercase;">{{$data->getData()->btn2}}</h4></a>
                                   </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div class="animated zoomIn">
                                     <a href="{{(ifAnd($data->getData()->route3) == true) ? (ifAnd($data->getData()->id3) == true) ? (ifAnd($data->getData()->id23) == true) ? (ifAnd($data->getData()->id33) == true) ? route($data->getData()->route3,[$data->getData()->id3,$data->getData()->id23,$data->getData()->id33]): route($data->getData()->route3,[$data->getData()->id3,$data->getData()->id33]) : route($data->getData()->route3,[$data->getData()->id3]) : route($data->getData()->route3) : 'javascript:void(0)'}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-success edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#4cc46c;line-height: 2;text-transform: uppercase;">{{$data->getData()->btn3}}</h4></a>
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