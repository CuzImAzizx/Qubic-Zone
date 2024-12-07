@extends('layouts.simpleapp')
@section('content')
<div class="container mt-4" style="text-align: right;">
<pdo><h1 style="text-align: center;">{{auth()->user()->name}} لوحة التحكم الخاصة لـ </h1></pdo>
<br>
<!-- display all pending orders -->
@php
use App\Models\unit_order;
use App\Models\Branch;
use App\Models\City;
use App\Models\User;

$pendingOrders = unit_order::where('status', '=', 'pending')->get();
@endphp
    @if(count($pendingOrders) > 0)
        @php
            $branchId = $pendingOrders[0]->branch_id;
            $branch = Branch::find($branchId);
            $branchName = $branch->name;
            $city = City::find($branch->city_id);
            $cityName = $city->name;
            $userId = $pendingOrders[0]->user_id;
            $user = User::find($userId);
            $userName = $user->name
        @endphp

        <div class="alert alert-warning" role="alert">
            <strong>تحذير:</strong> توجد طلبات تحتاج المراجعة
        </div>

        <h2 class="mt-4">طلبات غير مكتملة</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>عرض التفاصيل</th>
                        <th>تاريخ الطلب</th>
                        <th>المبلغ</th>
                        <th>الفرع, المدينة</th>
                        <th>عدد الوحدات المحجوزة</th>
                        <th>صاحب الطلب</th>
                        <th>رقم الطلب</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingOrders as $order)
                        <tr>
                            <td><a href="/reviewOrder/{{$order->id}}" class="btn btn-info">عرض التفاصيل</a></td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ number_format($order->total_price, 2) }} ر.س</td>
                            <td>{{ $branchName }}, {{ $cityName }}</td>
                            <td>{{ count(json_decode($order->units)) }}</td>
                            <td>{{$userName}}</td>
                            <td>{{ $order->id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @php
    $orders = unit_order::where('status', '!=', 'pending')->get();

    @endphp
    @if (count($orders) > 0)
    @php
            $branchId = $orders[0]->branch_id;
            $branch = Branch::find($branchId);
            $branchName = $branch->name;
            $city = City::find($branch->city_id);
            $cityName = $city->name;
            $userId = $orders[0]->user_id;
            $user = User::find($userId);
            $userName = $user->name
        @endphp


        <h2 class="mt-4">جميع الطلبات السابقة</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>عرض التفاصيل</th>
                        <th>تاريخ الطلب</th>
                        <th>المبلغ</th>
                        <th>الفرع, المدينة</th>
                        <th>عدد الوحدات المحجوزة</th>
                        <th>صاحب الطلب</th>
                        <th>رقم الطلب</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td><a href="/reviewOrder/{{$order->id}}" class="btn btn-info">عرض التفاصيل</a></td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ number_format($order->total_price, 2) }} ر.س</td>
                            <td>{{ $branchName }}, {{ $cityName }}</td>
                            <td>{{ count(json_decode($order->units)) }}</td>
                            <td>{{$userName}}</td>
                            <td>{{ $order->id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif
</div>
@endsection()