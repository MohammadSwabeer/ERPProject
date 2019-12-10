@extends('admin/mainpage/adminmain')
@section('admincontents')
<div class="row page-titles">
  <div class="col-md-12">
     <div class="d-flex">
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Home</a></li>
         <li class="breadcrumb-item"><a href="{{route('projectPage')}}">Project</a></li>
         <li class="breadcrumb-item"><a href="{{route('viewFamiliesPage',[encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}">{{$type}} Families Information</a></li>
         <li class="breadcrumb-item"><a href="{{route('showFamiliesProfiles',[session('id'),encrypt($hfid),encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat)])}}">{{$type}} Families Profile Information</a></li>
         <li class="breadcrumb-item active">Timeline</li>
       </ol>
     </div>
  </div>
</div>   

<div class="row">
    <div class="col-md-12">
        @if(count($serve))
        <div class="card box-shadow br-5">
            <div class="card-body">
                <ul class="timeline">
                    <?php $count = 0; ?>
                    @foreach($serve as $b)
                    @if($count == 0)
                    <li>
                        <div class="timeline-badge success">
                            <img class="img-responsive" alt="user" src="{{asset('adminAssets/images/default/girl.jpg')}}" alt="img"> 
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Beneficiary Name : {{$b->fname}} {{$b->lname}}</h4>
                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{date('l, F d y h:i:s', strtotime($b->created_at))}}</small> </p>
                            </div>
                            <div class="timeline-body">
                                <p><small class="text-capitalize">Project Type : {{$b->project_type}}</small></p>
                                <p>{{$b->description}}</p>
                            </div>
                        </div>
                    </li>
                    <?php $count++; ?>
                    @else
                    <li class="timeline-inverted">
                        <div class="timeline-badge warning"><img class="img-responsive" alt="user" src="{{asset('adminAssets/images/default/girl.jpg')}}" alt="img"> </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Beneficiary Name : {{$b->fname}} {{$b->lname}}</h4>
                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{date('l, F d y h:i:s', strtotime($b->created_at))}} </small> </p>
                            </div>
                            <div class="timeline-body">
                                <p><small class="text-capitalize">Project Type : {{$b->project_type}}</small></p>
                                <p>{{$b->description}}</p>
                            </div>
                        </div>
                    </li>
                    <?php $count = 0; ?>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @else
        <div class="card-body m-auto text-center" style="min-height:400px; ">
            <h1 style="padding-top:177px; ">Data not found</h1>
        </div>
        @endif
    </div>
</div>
@stop