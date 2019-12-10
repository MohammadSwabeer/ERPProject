    <?php use \App\Http\Controllers\MainController; $main = new MainController; // $popData=['Seekers']; ?>  
      @foreach($popData as $mod)
      <?php $pop = $main->popUpData($mod);
      $param = ($pop->getData()->param !== null) ? $pop->getData()->param->original->type : null; 
      $param2 = ($pop->getData()->param2 !== null) ? $pop->getData()->param2->original->type : null; 
      $route1 = ($pop->getData()->route !== null) ? $pop->getData()->route->original->type : null; 
      $route2 = ($pop->getData()->route2 !== null) ? $pop->getData()->route2->original->type : null; 
      $val = ($pop->getData()->id !== null) ? $pop->getData()->id->original->type : null; 
      $val2 = ($pop->getData()->id2 !== null) ? $pop->getData()->id2->original->type : null; ?> 
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
                             <div class="media p-10 m-auto">
                                <div class="media-right p-5">
                                   <img class="box-shadow" src="{{asset('images/HFLogo.jpg')}}" style="width: 100px;border-radius: 100%">
                                </div>
                                <div class="media-body text-center m-auto">
                                    <h3 class="font-NexaRustSans-Black animated pulse" style="font-size: 35px;font-weight: 800; margin-top: 20px;color: #2187c2;"> {{$pop->getData()->title}} Info.  
                                   </h3>
                                </div>
                             </div>
                           </div>
                         </div>

                        <div class="card bg-white">
                           <div class="accordion" id="{{$mod}}{{$pop->getData()->btn2}}">

                              <div class="row p-0-30-0-30">
                                @if(ifAnd($param) == true)
                                 <div class="col-md-12">
                                    <a data-toggle="collapse" data-target="#{{$pop->getData()->btn}}" aria-expanded="false" aria-controls="{{$pop->getData()->btn}}" class="animated zoomIn btn btn-block waves-effect waves-light btn-rounded btn-outline-primary reliance-link border-color4 btn-block box-shadow-e">
                                        <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#2187c2;line-height: 2;text-transform: uppercase;">
                                          {{$pop->getData()->btn}} 
                                        </h4>
                                    </a>

                                    <div id="{{$pop->getData()->btn}}" class="collapse" data-parent="#{{$mod}}{{$pop->getData()->btn2}}">
                                      <?php $i = 0; ?>
                                          @foreach($param as $sub)
                                             @if(ifAnd($sub) == true)
                                              <div class="card-header animated zoomIn box-shadow-e br-5">
                                                <a href="{{(ifAnd($route1[$i]) == true) ? (ifAnd($val[$i]) == true) ? route($route1[$i],$val[$i]) : route($route1[$i]) : 'javascript:void(0)'}}"><h4 class="text-center m-auto font-16 text-caps font-NexaRustSans-Black">{{$sub}}</h4></a>
                                              </div>
                                             @endif
                                             <?php $i++; ?>
                                        @endforeach
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-md-12">
                                   <a  class="animated zoomIn btn btn-block waves-effect waves-light btn-rounded btn-outline-primary reliance-link border-color4 btn-block box-shadow-e">
                                     <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#2187c2;line-height: 2;text-transform: uppercase;"> {{$pop->getData()->btn}}
                                     </h4>
                                  </a>
                                </div>
                                @endif

                                 <div class="col-md-12">
                                    <a data-toggle="collapse" data-target="#{{$pop->getData()->btn2}}" aria-expanded="false" aria-controls="{{$pop->getData()->btn2}}" class="animated zoomIn btn btn-block waves-effect waves-light btn-rounded btn-outline-primary reliance-link border-color4 btn-block box-shadow-e">
                                        <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#2187c2;line-height: 2;text-transform: uppercase;">
                                          {{$pop->getData()->btn2}} 
                                        </h4>
                                    </a>

                                    <div id="{{$pop->getData()->btn2}}" class="collapse" data-parent="#{{$mod}}{{$pop->getData()->btn2}}">
                                      @if(ifAnd($param2) == true)
                                      <?php $j = 0; ?>
                                        @foreach($param2 as $sub)
                                          @if(ifAnd($sub) == true)
                                           <div class="card-header animated zoomIn box-shadow-e br-5">
                                             <a href="{{(ifAnd($route2[$j]) == true) ? (ifAnd($val2[$j]) == true) ? route($route2[$j],$val2[$j]) : route($route2[$j]) : 'javascript:void(0)'}}"><h4 class="text-center m-auto font-16 text-caps font-NexaRustSans-Black">{{$sub}}</h4></a>
                                           </div>
                                          @endif
                                          <?php $j++; ?>
                                        @endforeach
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
         </div>
       @endforeach