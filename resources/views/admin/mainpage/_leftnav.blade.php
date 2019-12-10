<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="d-flex no-block nav-text-box align-items-center">
                <!-- <span><img src="{{--asset('adminAssets/images/logo-icon.png')--}}" alt="elegant admin template"></span> -->
                <a class="nav-lock waves-effect waves-dark ml-auto hidden-md-down" href="javascript:void(0)"><i class="mdi mdi-toggle-switch"></i></a>
                <a class="nav-toggler waves-effect waves-dark ml-auto hidden-sm-up" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            </div>
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> 
                    <a class="waves-effect waves-dark" href="{{route('admin-home')}}" aria-expanded="false">
                    <i class="ti-timer"></i><span class="hide-menu">Dashboard </span></a>
                </li>
                <li class="nav-small-cap"></li>
                <li> 
                    <a class="waves-effect waves-dark" href="{{route('projectPage')}}" aria-expanded="false">
                    <i class="  fa  fa-folder-open-o"></i><span class="hide-menu">Projects <span class="badge badge-pill badge-cyan">5</span></span></a>
                </li>
                <li class="nav-small-cap"></li>
                 <li> 
                    <a class="waves-effect waves-dark" href="{{route('OrganizationPage')}}" aria-expanded="false"><i class="fa fa-asterisk"></i><span class="hide-menu">Human Resource <span class="badge badge-pill badge-cyan">3</span></span></a>
                </li>
                <li class="nav-small-cap"></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
<!-- End Sidebar scroll-->
</aside>