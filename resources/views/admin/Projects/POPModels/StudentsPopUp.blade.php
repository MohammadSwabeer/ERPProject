   
   <div class="modal fade" id="Students" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
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
                                 <h3 class="font-NexaRustSans-Black animated pulse" style="font-size: 35px;font-weight: 800; margin-top: 20px;color: #23a523;">Students Info.  
                                </h3>
                             </div>
                          </div>
                        </div>
                      </div>

                     

                      <div class="row">

                        <div class="col-md-6 border-right">
                           <div class="card">
                              <div class="card-header">
                                 <h3 class="font-NexaRustSans-Black animated pulse text-center" style="font-weight: 800;color: #23a523;">Hidayah Foundation  
                                </h3>
                              </div>
                              <div class="row p-0-30-0-30">
                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{route('viewStudentsInfo',[encrypt('HSCC'),encrypt('Education'),encrypt('Projects'),encrypt(1),encrypt('Students')])}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">HSCC Students Info.</h4></a>
                                   </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{route('viewStudentsInfo',[encrypt('MR'),encrypt('Education'),encrypt('Projects'),encrypt(1),encrypt('Students')])}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">MR Students Info.</h4></a>
                                   </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="javascript:void(0)" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">SNC Students Info.</h4></a>
                                   </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{route('viewStudentsInfo',[encrypt('ATT'),encrypt('Education'),encrypt('Projects'),encrypt(1),encrypt('Students')])}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">ATT Students Info.</h4></a>
                                   </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="javascript:void(0)" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">Other Students Info.</h4></a>
                                   </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="card">
                              <div class="card-header">
                                 <h3 class="font-NexaRustSans-Black animated pulse text-center" style="font-weight: 800;color: #23a523;">Other Institution  
                                </h3>
                              </div>
                              <div class="row p-0-30-0-30">
                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{route('viewStudentsInfo',[encrypt('Database'),encrypt('Education'),encrypt('Projects'),encrypt(1),encrypt('Students')])}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black; font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">Database Students Info.</h4></a>
                                   </div>
                                 </div>

                                 <div class="col-md-12">
                                   <div style="" class="animated zoomIn">
                                     <a href="{{route('viewStudentsInfo',[encrypt('Workshop'),encrypt('Education'),encrypt('Projects'),encrypt(1),encrypt('Students')])}}" style="color:#fff;border-color:#4cc46c" class="btn btn-block waves-effect waves-light btn-rounded btn-outline-primary edu-link btn-block box-shadow-e"><h4 class="m-auto font-16 text-caps font-NexaRustSans-Black" style="color: black;font-weight: 900;border-color:#e9e32b;line-height: 2;text-transform: uppercase;">WorkShop Students Info.</h4></a>
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