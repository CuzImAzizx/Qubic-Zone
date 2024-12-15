<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <title>Qubic Zone</title>
    <style>
        body {
            background-color: #f9f9f9;
        }

        .card {
            background-color: #fafafa;
        }

        footer {
            background-color: #f9f9f9;
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
</head>
@php
use App\Models\Subscription;
@endphp
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="font-size:x-large">
        <div class="container-fluid">
            <a class="navbar-brand" style="font-size:30px" href="/">Qubic Zone</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                        <a class="nav-link" href="/contact">التواصل</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/services">الخدمات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/branches">الفروع</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/plans">الاشتراكات</a>
                    </li>
                    @if (!auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="/login">تسجيل الدخول</a>
                    </li>
                    @else
                    <li>
                        @php
                        $loyaltyPoints = Subscription::where('user_id', auth()->id())->first()->loyalty_points
                        @endphp
                    <div class="nav-link">نقاط الولاء: {{$loyaltyPoints}}</div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/myProfile">حسابي</a>
                        
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
    
    <br><br><br><br><br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                @yield('content')
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Qubic Zone. جميع الحقوق محفوظة.</p>
            <p>
                <a href="/privacy-policy">سياسة الخصوصية</a> | 
                <a href="/terms-of-service">شروط الخدمة</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
</body>

</html>