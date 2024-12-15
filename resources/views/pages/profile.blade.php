@extends('layouts.simpleapp')

@section('content')



<div class="container mt-4" style="text-align: right;">
    <div class="header-text card-header">
        <h1 class="text-center">حسابي</h1>
    </div>
    <br>
    <style>
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
        }

        .main-body {
            padding: 15px;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }
    </style>
    @php
        use App\Models\Subscription;
        use App\Models\Plan;
        $sub = Subscription::where('user_id', auth()->id())->first();
        $plan = Plan::find($sub->plan_id);
    @endphp
    @php
        use App\Models\unit_order;
        use App\Models\Branch;
        use App\Models\City;

        $pendingOrders = unit_order::where('user_id', '=', auth()->id())
            ->where('status', '=', 'pending')->get();
        $countAllOrders = unit_order::where('user_id', '=', auth()->id())->count()
    @endphp


    <div class="container">
        <div class="main-body">


            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUW0u5Eiiy3oM6wcpeEE6sXCzlh8G-tX1_Iw&s"
                                    alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4>{{auth()->user()->name}}</h4>
                                    <p class="text-secondary mb-1">نوع الاشتراك: {{$plan->name}}</p>
                                    <p class="text-muted font-size-sm">عدد نقاط الولاء: {{$sub->loyalty_points}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-9 text-secondary">
                                    {{auth()->user()->name}}
                                </div>
                                <div class="col-sm-3">
                                    <h6 class="mb-0">اسم المستخدم</h6>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9 text-secondary">
                                    {{auth()->user()->email}}
                                </div>
                                <div class="col-sm-3">
                                    <h6 class="mb-0">البريد الالكتروني</h6>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9 text-secondary">
                                    {{auth()->user()->created_at->format('Y-m-d')}}
                                </div>
                                <div class="col-sm-3">
                                    <h6 class="mb-0">تاريخ انشاء الحساب</h6>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9 text-secondary">
                                    {{$countAllOrders}}
                                </div>
                                <div class="col-sm-3">
                                    <h6 class="mb-0">عدد الطلبات</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @if(count($pendingOrders) > 0)

                            <div class="alert alert-warning" role="alert">
                                <strong>تحذير:</strong> لديك طلبات غير مكتملة
                            </div>

                            <h2 class="mt-4">طلبات غير مكتملة</h2>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>عرض التفاصيل</th>
                                            <th>الحالة</th>
                                            <th>تاريخ الطلب</th>
                                            <th>المبلغ</th>
                                            <th>الفرع, المدينة</th>
                                            <th>عدد الوحدات المحجوزة</th>
                                            <th>رقم الطلب</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingOrders as $order)
                                            @php
                                                $branchId = $order->branch_id;
                                                $branch = Branch::find($branchId);
                                                $branchName = $branch->name;
                                                $city = City::find($branch->city_id);
                                                $cityName = $city->name;
                                            @endphp
                                            <tr>
                                                <td><a href="/orderDetails/{{$order->id}}" class="btn btn-info">عرض التفاصيل</a></td>
                                                <td><strong><span class="text-warning">غير مكتمل</span></strong></td>
                                                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                                <td>{{ number_format($order->total_price, 2) }} ر.س</td>
                                                <td>{{ $branchName }}, {{ $cityName }}</td>
                                                <td>{{ count(json_decode($order->units)) }}</td>
                                                <td>{{ $order->id }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                @endif

                @php
                    $orders = unit_order::where('user_id', '=', auth()->id())
                        ->where('status', '!=', 'pending')->get();
                @endphp

                @if(count($orders) > 0)
                            <h2 class="mt-4">الطلبات السابقة</h2>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>عرض التفاصيل</th>
                                            <th>الحالة</th>
                                            <th>تاريخ الطلب</th>
                                            <th>المبلغ</th>
                                            <th>الفرع, المدينة</th>
                                            <th>عدد الوحدات المحجوزة</th>
                                            <th>رقم الطلب</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            @php
                                                $branchId = $order->branch_id;
                                                $branch = Branch::find($branchId);
                                                $branchName = $branch->name;
                                                $city = City::find($branch->city_id);
                                                $cityName = $city->name;
                                            @endphp
                                            <tr>
                                                <td><a href="/orderDetails/{{$order->id}}" class="btn btn-info">عرض التفاصيل</a></td>
                                                <td>
                                                    @if($order->status == 'confirmed')
                                                        <strong><span class="text-success">فعّال</span></strong>
                                                    @elseif($order->status == 'canceled')
                                                        <strong><span class="text-danger">ملغي</span></strong>
                                                    @else
                                                        <span class="text-secondary">{{ $order->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                                <td>{{ number_format($order->total_price, 2) }} ر.س</td>
                                                <td>{{ $branchName }}, {{ $cityName }}</td>
                                                <td>{{ count(json_decode($order->units)) }}</td>
                                                <td>{{ $order->id }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection