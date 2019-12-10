<?php use \App\Http\Controllers\MainController; $main = new MainController; $popsData=['Teachers','Resource','School','Parents','Colony','Seekers','Providers','Data','Cure','Prevention','Awarness','Supply'];?>  

@foreach($popsData as $mods)
<?php $p = $main->popsUpData($mods);
$a = ($p->getData()->t !== null) ? $p->getData()->t->original : null;
$btn = ($a->btn !== null) ? $a->btn : null;
$route = ($p->getData()->r !== null) ? $p->getData()->r : null;
$ids = ($p->getData()->i !== null) ? $p->getData()->i : null;
// dd($ids);
$pCat = ($p->getData()->pCat !== null) ? $p->getData()->pCat : null; ?>
<!--*************************************** Start Modal ********************************************-->
<div class="modal fade" id="{{$mods}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
   <!-- Start modal-dialog -->
   <div class="modal-dialog" role="document">
      <?php $bg = 'background:transparent'; ?>
      <!-- start modal-content -->
      <div class="modal-content" style="{{$bg}};border:unset;width: 800px">
         <div style="">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="font-size: 50px;margin-bottom: -20px;margin-right: -15px;transform: rotate(45deg);color: white;opacity: 1;"><i class="fa fa-plus-circle"></i></button>
         </div>
         <!-- start modal-body -->
         <div class="modal-body">
            <div class="card box-shadow-e br-5">
               <div class="row">
                  <div class="col-md-12">
                     <div class="media p-10 m-auto">
                        <div class="media-right p-5">
                           <img class="box-shadow" src="{{asset('images/HFLogo.jpg')}}" style="width: 100px;border-radius: 100%">
                        </div>
                        <div class="media-body text-center m-auto">
                           <h3 class="font-NexaRustSans-Black animated pulse" style="font-size: 35px;font-weight: 800; margin-top: 20px;color: {{$p->getData()->clr}};">  {{$p->getData()->t->original->title}} Info.  
                           </h3>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="card bg-white">
                  <div class="accordion" id="{{$mods}}Col">
                     <div class="row p-0-30-0-30">
                        <!-- Buttons And thier sub Buttons with and without accordian -->
                        @if(ifAnd($btn) == true)
                        <?php $i = 0; ?>
                        @foreach($btn as $b)
                        <div class="col-md-12">
                           @if(is_object($b) === true)
                           <a data-toggle="collapse" data-target="#{{$b->original->title}}" aria-expanded="false" aria-controls="{{$b->original->title}}" class="animated zoomIn btn btn-block waves-effect waves-light btn-rounded btn-outline-primary {{$main->getPClass($pCat)}} btn-block box-shadow-e">
                              <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#2187c2;line-height: 2;text-transform: uppercase;"> {{$b->original->title}}
                              </h4>
                           </a>

                           <div id="{{$b->original->title}}" class="collapse" data-parent="{{$mods}}Col">
                              <?php $j = 0; ?>
                              @foreach($b->original->btn as $sub)
                              <?php $id = $main->getsId($route[$i][$j],$ids[$i][$j],$pCat); ?>
                               <div class="card-header animated zoomIn box-shadow-e br-5">
                                 <a href="{{ ifAnd($route[$i][$j]) ? ifAnd($id) ? route($route[$i][$j],$id) : route($route[$i][$j]) : 'javascript:void(0)' }}">
                                    <h4 class="text-center m-auto font-16 text-caps font-NexaRustSans-Black">{{$sub}}</h4>
                                 </a>
                               </div>
                               <?php $j++; ?>
                              @endforeach
                           </div>
                           @else
                           <?php $id = $main->getsId(ifAnd($route) ? ifAnd($route[$i]) ? $route[$i] : null : null,ifAnd($ids) ? ifAnd($ids[$i]) ? $ids[$i] : null : null,$pCat); ?>
                           <a href="{{ifAnd($route) ? ifAnd($route[$i]) ? ifAnd($id) ? route($route[$i],$id) : route($route[$i]) : 'javascript:void(0)' : 'javascript:void(0)' }}" class="animated zoomIn btn btn-block waves-effect waves-light btn-rounded btn-outline-primary {{$main->getPClass($pCat)}} btn-block box-shadow-e">
                              <h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#2187c2;line-height: 2;text-transform: uppercase;"> {{$b}}
                              </h4>
                           </a>
                           @endif
                        </div>
                        <?php $i++; ?>
                        @endforeach
                        @endif
                     </div>
                  </div>
               </div>
            </div>
            <!-- end card -->
         </div>
         <!-- end Model Body -->
      </div>
      <!-- end modal-content -->
   </div>
   <!-- end modal-dialog -->
</div>
<!--*************************************** End Modal ********************************************-->
@endforeach