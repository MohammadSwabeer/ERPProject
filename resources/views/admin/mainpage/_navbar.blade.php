<header class="topbar" style="background: linear-gradient(to right, #8ebc5c 0%, #9edf58 100%)">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" style="margin-left: -15px;" href="javascript:void(0)">
                <!-- Logo icon -->
                <b><img src="{{URL::asset('adminAssets/images/images.jpg')}}" alt="homepage" class="light-logo" style="width: 66px;margin-top: -7px;margin-bottom: -4px;" /></b>
                <!--End Logo icon -->
                <!-- Logo text -->    
                <span><img src="{{URL::asset('adminAssets/images/Hidayah-logo-web-Text.png')}}" class="light-logo" alt="homepage" style="width: 152px;margin-top: -8px;margin-bottom: -14px;" /></span>
                 <!-- End Light Logo text -->    
            </a>
        </div>
        <!-- End Logo -->
        <div class="navbar-collapse">
            <!-- toggle and nav items -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <!-- onclick="addClass('show-sidebar')" -->
                <!-- onclick="addClass('lock-nav')" -->
                <li class="nav-item hidden-sm-up"> <a class="nav-link nav-toggler waves-effect waves-light"><i class="ti-menu"></i></a></li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link nav-lock waves-effect waves-light"><i class="ti-menu"></i></a></li>   
            </ul>   
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="javascript:void(0)" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-settings"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                        <span class="with-arrow"><span class="bg-danger"></span></span>
                        <div class="drop-title text-white bg-danger"><hr></div>
                        <a class="dropdown-item" href="{{route('register_user')}}"><i class="ti-user m-r-5 m-l-5"></i> Add Sub Admin</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('role_page')}}"><i class="ti-user m-r-5 m-l-5"></i> Add Role</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('adminAssets/images/default/default1.png')}}" alt="user" class="img-circle" width="30"></a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <span class="with-arrow"><span class="bg-primary"></span></span>
                        <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                            <div class=""><img src="{{asset('adminAssets/images/default/default1.png')}}" alt="user" class="img-circle" width="60"></div>
                            <div class="m-l-10">
                                <h4 class="m-b-0">Mr.Khasim</h4>
                                <p class=" m-b-0">mrkhsimhf@gmail.com</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('admin-logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('admin-logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</header>