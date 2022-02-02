<!DOCTYPE html>
<html>
    
    <head>
        <title> {{ str_replace('-', ' ', config('app.name')) }}</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="{{ asset('layout/img/logo.png')}}">
        <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('layout/css/bootstrap-responsive.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('layout/css/matrix-login.css') }}" />
        <link rel="stylesheet" href="{{ asset('layout/css/font-awesome.css') }}" />
        <link rel="stylesheet" href="{{ asset('layout/css/main.css') }}" />
    </head>
    <body>
        
        <div id="loginbox">            
            <h3 class="text-center">
                <div class="imgBox">
                    <div class="imgBoxContainer">
                    
                    </div>
                </div>
                
            </h3>

            @if ($errors->any())
            <div class="the-errors text-center" >
                <div class='msg error'>Login ou mot de passe invalide</div>
            </div>
            @endif

            <form id="loginform" method="POST" class="form-vertical" action="{{ route('login') }}">
				 <div class="control-group normal_text"> 
                    <h1>{{ str_replace('-', ' ', config('app.name')) }}
                    </h1>
                </div>

             @csrf
                
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" name="username" placeholder="Login" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Mot de passe" />
                        </div>
                    </div>
                </div>
                <div class="form-actions text-center">
                    <input class="btn btn-success" type="submit" value="Se connecter" >
                </div>
            </form>
        </div>
        <div class="row-fluid">
            <div id="footer" class="span12"> {{ date('Y') }} &copy; MC PHARMA.</div>
        </div>
        <div class="main-wrapper">
        
        <!-- ============================================================== -->
        <!-- All Required js -->
        <!-- ============================================================== -->
        <script src="{{ asset('layout/js/jquery.min.js') }}"></script>  
        <script src="{{ asset('layout/js/matrix.login.js') }}"></script> 
        <!-- ============================================================== -->
        <!-- This page plugin js -->
        <!-- ============================================================== -->
    
      
    
    </body>

</html>