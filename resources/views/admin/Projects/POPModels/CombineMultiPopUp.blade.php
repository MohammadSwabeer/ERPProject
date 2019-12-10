 <?php use \App\Http\Controllers\MainController; $main = new MainController; 
 $modeledData=['FPrevention','FCure','HPrevention','HCure','Data','Colony'];?>  

   @foreach($modeledData as $mod)
   <?php $data = $main->modelData($mod); ?>  
   <div class="modal fade" id="{{$mod}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
         <div class="modal-dialog" role="document">
           <?php $bg = 'background:transparent'; ?>
            <div class="modal-content" style="{{$bg}};border:unset;width: 800px">
               <div style="">
                  <a class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></a>
               </div>

               <div class="modal-body">

                  <div class="card box-shadow-e br-5">
                     <div class="row">  
                        <div class="col-md-12">
                          <div class="media p-10 m-auto">
                             <div class="media-right p-5">
                                <img class="box-shadow" src="{{asset('images/HFLogo.jpg')}}" style="width: 100px;border-radius: 100%">
                             </div>
                             <div class="media-body text-center m-auto">
                                 <h3 class="font-NexaRustSans-Black animated pulse" style="font-size: 35px;font-weight: 800; margin-top: 20px;color: {{($mod == 'FPrevention' || $mod == 'FCure') ? '#f3c113' : '#eb2f22'}} {{($mod == 'Colony') ? '#4bc882':'' }};"> {{$data->getData()->title}} Info.  
                                </h3>
                             </div>
                          </div>
                        </div>
                      </div>

                      
                      <div class="row">

                        <div class="col-md-12 border-right">
                           <div class="card">
                              <div class="row p-0-30-0-30">
                                @if(ifAnd($data->getData()->btn) == true)
                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{(ifAnd($data->getData()->route) == true) ? (ifAnd($data->getData()->id) == true) ? (ifAnd($data->getData()->id21) == true) ? route($data->getData()->route,[$data->getData()->id,$data->getData()->id21]) : route($data->getData()->route,[$data->getData()->id]) : route($data->getData()->route) : 'javascript:void(0)'}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary {{($mod == 'FPrevention' || $mod == 'FCure') ? 'food-link border-color2' : 'health-link border-color3'}} {{($mod == 'Colony') ? 'infra-link border-color5' : ''}} btn-block box-shadow-e">
                                      <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">
                                        {{$data->getData()->btn}}
                                      </h4>
                                    </a>
                                   </div>
                                 </div>
                                @endif

                                @if(ifAnd($data->getData()->btn2) == true)
                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{(ifAnd($data->getData()->route2) == true) ? (ifAnd($data->getData()->id2) == true) ? (ifAnd($data->getData()->id22) == true) ? route($data->getData()->route2,[$data->getData()->id2,$data->getData()->id22]) : route($data->getData()->route2,[$data->getData()->id2]) : route($data->getData()->route2) : 'javascript:void(0)'}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary {{($mod == 'FPrevention' || $mod == 'FCure') ? 'food-link border-color2' : 'health-link border-color3'}} {{($mod == 'Colony') ? 'infra-link border-color5' : ''}} btn-block box-shadow-e">
                                      <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">
                                        {{$data->getData()->btn2}}
                                      </h4>
                                    </a>
                                   </div>
                                 </div>
                                @endif

                                @if(ifAnd($data->getData()->btn3) == true)
                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{(ifAnd($data->getData()->route3) == true) ? (ifAnd($data->getData()->id3) == true) ? (ifAnd($data->getData()->id23) == true) ? route($data->getData()->route3,[$data->getData()->id3,$data->getData()->id23]) : route($data->getData()->route3,[$data->getData()->id3]) : route($data->getData()->route3) : 'javascript:void(0)'}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary {{($mod == 'FPrevention' || $mod == 'FCure') ? 'food-link border-color2' : 'health-link border-color3'}} {{($mod == 'Colony') ? 'infra-link border-color5' : ''}} btn-block box-shadow-e">
                                      <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">
                                        {{$data->getData()->btn3}}
                                      </h4>
                                    </a>
                                   </div>
                                 </div>
                                @endif
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