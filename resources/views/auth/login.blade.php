<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ strtoupper(Route::getCurrentRoute()->getName()) }} - {{ Config::get('constant.lang.title_Login') }}</title>

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('assets/favicon.ico')}}">
    <style>
        .loginrow{
        }

        .bglogin{background:linear-gradient(180deg, #00acff, transparent),url("{{asset('assets/img/bag.png')}}")  no-repeat left bottom;; background-size:cover; min-height:500px; padding:0; border-radius: 0px 15px 15px 0px; }
        
        .banner-sec{background:linear-gradient(180deg, #00acff, transparent),url("{{asset('assets/logo/wharehouse.png')}}")  no-repeat left bottom;; background-size:cover; min-height:500px; padding:0; }
        .container{background:#fff; border-radius: 10px;}
        
        .login-sec{padding: 40px 30px; position:relative;}
        .login-sec .copy-text{position:absolute; width:90%; bottom:10px; font-size:13px; text-align:center;}
        .login-sec .copy-text i{color:#FEB58A;}
        .login-sec .copy-text a{color:#E36262;}
        
        .login-sec h2{margin-bottom:30px; font-weight:800; font-size:28px; color: #00acff;}
        .login-sec h2:after{content:" "; width:100px; height:5px; background:#00acff; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}

        .btn-login{background: #00acff; color:#fff; font-weight:600;}
        .btn-login:focus{background: #106188; color:#fff; font-weight:600;}
        .btn-login:hover{background: #169bdc; color:#fff; font-weight:600;}
        .btn-login:active{background: #169bdc; color:#fff; font-weight:600;}
        
        .banner-text{width:97%; position:absolute; top:20px; padding-left:20px; text-align: justify;}
        .banner-text h2{color:#fff; font-weight:600;font-size:28px;}
        .banner-text h2:after{content:" "; width:100px; height:5px; background:#fff; display:block; margin-top:20px; border-radius:3px;}
        .banner-text p{color:#fff;}
        @media only screen and (max-width:750px) {
            .banner-sec{display:none;}
        }

    </style>    

</head>

<body class="bglogin gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row loginrow">
        <div class="col-md-4 login-sec " style="padding:unset;">
                <div class="ibox-content" style="height:100%">
                <img src="{{asset('assets/logo/LOGO_BIZPLAN-06.png')}}" alt="logo" style="width: 100%;padding: 0 20px">
                <h2 class="text-center"></h2>

                <form class="m-t" role="form" action="" method="post">
                    @csrf
                        <div class="form-group">
                        <label for="username" class="text-uppercase">Username</label>
                            <input type="email" name="email" class="form-control" placeholder="Username" required="">
                        </div>
                        <div class="form-group">
                        <label for="username" class="text-uppercase">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required="">
                        </div>
                        <button type="submit" class="btn-login btn block full-width m-b">Login</button>

                        
                        <a href="#">
                            <small>Forgot password?</small>
                        </a>
                    </form>
                    
                    <div class="copy-text">Demuria Erp &copy; 2021</div>
                    
                </div>
            </div>
            <div id="image-login" class="col-md-8 banner-sec" style="padding:unset;">
                    <div class="banner-text">
                        <h2>Portal Bizplan.id</h2>
                        <p>
                            Silahkan Login Dengan User Anda.
                        </p>
                </div>
            </div>
           
        </div>

    </div>

</body>

</html>