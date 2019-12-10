   <div class="col-md-12">
    <?php  $filter = json_decode($main->filterData($type)); ?>
     <div class="card-body animated zoomIn br-5 m-b-0 p-5" id="filterData" style="display: none;">
       <span class="pull-right"><button type="button" class="btn btm-small btn-outline-danger btn-circle m-0" onclick="function f(){ return document.getElementById('filterData').style.display = 'none';};f()" data-toggle="tooltip" data-placement="top" title="Click to Remove filter-search" style="border-radius: 100%;width: 30px;height: 30px;padding: 5px;"><i class=" ti-close"></i> </button></span>
       <div class="table-responsive">
       <table class="table table-hover contact-list footable footable-loaded m-b-0 m-t-m-5 w-auto">
         <tbody id="myForm">
             <tr>
              <?php $j= 6; ?>
                @for($i = 1;$i <= count($filter->name);$i++)
                 @if($i <= $j)
                  @include('admin.mainpage.pages._filters')
                 @endif
                @endfor
             </tr>
             <tr>
               @for($i = 1;$i <= count($filter->name);$i++)
               @if($i > $j)
                  @include('admin.mainpage.pages._filters')
                 @endif
               @endfor
             </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>