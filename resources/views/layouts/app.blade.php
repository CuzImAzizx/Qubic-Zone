<!doctype html>
<html class="no-js" lang="en">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
        

        <!-- title of site -->
        <title>Store it</title>

        <!-- For favicon png -->
		<link rel="shortcut icon" type="image/icon" href="{{asset('assets/logo/favicon.png')}}"/>
       
        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">

        <!--linear icon css-->
		<link rel="stylesheet" href="{{asset('assets/css/linearicons.css')}}">

        <!--flaticon.css-->
		<link rel="stylesheet" href="{{asset('assets/css/flaticon.css')}}">

		<!--animate.css-->
        <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">

        <!--owl.carousel.css-->
        <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
		
        <!--bootstrap.min.css-->
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

		
		<!-- bootsnav -->
		<link rel="stylesheet" href="{{asset('assets/css/bootsnav.css')}}" >	
        
        <!--style.css-->
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        
        <!--responsive.css-->
        <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">


        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		
        <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
	
	<body>
		<!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
	
		<!--welcome-hero start -->
		<section id="home" class="welcome-hero">

			<!-- top-area Start -->
			<div class="top-area">
				<div class="header-area">
					<!-- Start Navigation -->
				    <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

				        <div class="container">

				            <!-- Start Header Navigation -->
				            <div class="navbar-header">
				                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
				                    <i class="fa fa-bars"></i>
				                </button>
				                <a class="navbar-brand" href="/">Qubic Zone<span></span></a>

				            </div><!--/.navbar-header-->
				            <!-- End Header Navigation -->

				            <!-- Collect the nav links, forms, and other content for toggling -->
				            <div class="collapse navbar-collapse menu-ui-design">
				                <ul class="nav navbar-nav navbar-right">
                                <li><a href="/contact">التواصل</a></li>
								<li><a href="/services">الخدمات</a></li>
				                    <li><a href="/branches">الفروع</a></li>
									<li><a href="/plans">الاشتراكات</a></li>

									@if (!auth()->check())
									<li><a href="/login">تسجيل الدخول</a></li>
									@else
									<li><a href="/myProfile">حسابي</a></li>
									@endif
				                </ul><!--/.nav -->
				            </div><!-- /.navbar-collapse -->
				        </div><!--/.container-->
				    </nav><!--/nav-->
				    <!-- End Navigation -->
				</div><!--/.header-area-->
			    <div class="clearfix"></div>

			</div><!-- /.top-area-->
			<!-- top-area End -->
            <div class="container">
				<div class="welcome-hero-txt">
                    
                @yield('content')

				</div>
			</div>

		</section><!--/.welcome-hero-->
		<!--welcome-hero end -->

        
        
        <!-- Include all js compiled plugins (below), or include individual files as needed -->

		<script src="{{asset('assets/js/jquery.js')}}"></script>
        
        <!--modernizr.min.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
		
		<!--bootstrap.min.js-->
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

		
		<!-- bootsnav js -->
		<script src="{{asset('assets/js/bootsnav.js')}}"></script>

		<!--owl.carousel.js-->
        <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

        <!--Custom JS-->
        <script src="{{asset('assets/js/custom.js')}}"></script>
		<style>

        footer {
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: black;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>

		<footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Qubic Zone. جميع الحقوق محفوظة.</p>
            <p>
                <a href="/privacy-policy">سياسة الخصوصية</a> | 
                <a href="/terms-of-service">شروط الخدمة</a>
            </p>
        </div>
    </footer>

    </body>
	
</html>