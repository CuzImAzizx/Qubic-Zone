@extends('layouts.simpleapp')

@section('content')
<div class="container mt-4" style="text-align: right;">
    <h1 class="text-center">حسابي</h1>
    <div class="text-center mb-4">
        <h3>{{ auth()->user()->name }} مرحبًا</h3>
    </div>

    @php
        use App\Models\unit_order;
        use App\Models\Branch;
        use App\Models\City;

        $pendingOrders = unit_order::where('user_id', '=', auth()->id())
            ->where('status', '=', 'pending')->get();
    @endphp

    @if(count($pendingOrders) > 0)
        @php
            $branchId = $pendingOrders[0]->branch_id;
            $branch = Branch::find($branchId);
            $branchName = $branch->name;
            $city = City::find($branch->city_id);
            $cityName = $city->name;
        @endphp

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
                                    <strong><span class="text-success">مكتمل</span></strong>
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
@endsection