<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Mohammad Swabeer">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{URL::asset('adminAssets/css/style.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('adminAssets/css/pages/login-register-lock.css')}}" rel="stylesheet">
    <style type="text/css">
       .font-NexaRustSlab{ font-family: 'NexaRustSlab', sans-serif !important; }
       .font-Orbitron{ font-family: 'Orbitron', sans-serif !important; }
       .box-shadow-e{ box-shadow: 0 1px 3px 0 rgba(60,64,67,0.3), 0 4px 8px 3px rgba(60,64,67,0.15); }
       .font-open-sans{ font-family: 'Open Sans', sans-serif !important; }
       .font-NexaRustSans-Black{ font-family: 'NexaRustSans-Black', sans-serif !important; }    
    </style>
</head>
<body class="skin-blue card-no-border">
   <section id="wrapper">
        <div class="login-register"  style="background:#EEEEEE;">
            <div class="row justify-content-center">
                <div class="col-md-12">
                   <div class="login-box card box-shadow-e" style="border-radius: 5px;">
                        <div class="media p-10">
                            <div class="media-right">
                                <img src="{{asset('images/HFLogo.jpg')}}" style="width: 85px">
                            </div>
                            <div class="media-body text-center m-auto">
                                 <span class="font-NexaRustSlab" style="color: #2ed82ef0;font-size: 18px;">Welcome to <br> Hidayah Foundation
                             </div>
                        </div>
                      
                       <div class="card-body">
                         <hr>
                         <div class="text-center m-auto" style="/*background: #d2fab8*/;padding: 5px;border-radius: 5px;">
                            <h4 class="font-NexaRustSans-Black">ERP System <sup class="font-open-sans">(Alpha)</sup></h4>
                         </div>
                         <form class="form-horizontal form-material m-t-20" id="loginform" action="{{ route('login') }}" method="POST">
                            @csrf
                            <h3 class="box-title m-b-20">Sign In</h3>
                            <div class="form-group ">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Username">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <!-- <div class="form-check"> -->
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        <!-- </div> -->
                                  <!--       <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Remember me</label> -->
                                        @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot Password?</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12 p-b-20">
                                    <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Log In</button>
                                </div>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
            </div>
        </div>
   </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/node_modules/popper/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
    $(function() {
        // $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // Login and Recover Password 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    </script>
</body>
</html>
