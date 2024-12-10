@extends('layouts.simpleapp')
@section('content')


<style>
    .cart-item {
        display: flex;
        align-items: center;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
        margin: 10px 0;
        background-color: #f9f9f9;
        transition: box-shadow 0.3s;
    }

    .cart-item:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .cart-item img {
        height: 100px;
        width: auto;
        border-radius: 8px;
        margin-right: 15px;
    }

    .cart-item-details {
        flex-grow: 1;
        text-align: left;
    }

    .cart-item-details h6 {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .cart-item-details p {
        margin: 0;
    }

    .confirmation-message {
        margin: 20px 0;
        font-size: 1.2em;
        color: #333;
    }

    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-item img {
            margin-bottom: 10px;
        }
    }
</style>

@php
    use App\Models\Size;
    use App\Models\Unit;
    use App\Models\Branch;
    use App\Models\City;
    $sizes = Size::get();
    $decodedUnits = json_decode($order->units);
@endphp

<div class="container">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-16">
                <div class="card text-center">
                    <div class="card-header">
                        <h2>تفاصيل طلب {{$order->id}}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row mt-4">
                            @foreach ($decodedUnits as $unitId)
                                @php
                                    $fullUnitDetails = Unit::find($unitId);
                                    $unitSize = Size::find($fullUnitDetails->size_id);
                                @endphp
                                @if ($fullUnitDetails->type == 'refrigerated')
                                    <div class="col-md-4">
                                        <div class="cart-item">
                                            <img src="{{asset('/assets/images/warehouses/4.png')}}" alt="Product Image">
                                            <div class="cart-item-details">
                                                <h6>وحدة تخزين مبرّدة</h6>
                                                <p>رقم الوحدة: <strong>{{ $unitId }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-4">
                                        <div class="cart-item">
                                            <img src="{{ $unitSize->image }}" alt="Product Image">
                                            <div class="cart-item-details">
                                                <h6>وحدة تخزين {{ $unitSize->name }}</h6>
                                                <p>رقم الوحدة: <strong>{{ $unitId }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @php
                                $branchId = $order->branch_id;
                                $branch = Branch::find($branchId);
                                $branchName = $branch->name;
                                $city = City::find($branch->city_id);
                                $cityName = $city->name;

                            @endphp
                        </div>

                        <h5 class="card-title">عدد الوحدات المحجوزة: {{ count($decodedUnits) }}</h5>
                        <p class="card-text">موقع المخزن: <strong>{{ $branchName }}, {{ $cityName }}</strong></p>
                        <p class="card-text">مدة الإيجار: <strong>{{ $order->rental_duration }} شهر</strong></p>
                        <p class="card-text">تاريخ بدء الإيجار: <strong>{{ \Carbon\Carbon::parse($order->start_date)->format('d-m-Y') }}</strong></p>
                        <p class="card-text">تاريخ انتهاء الإيجار: <strong>{{ \Carbon\Carbon::parse($order->end_date)->format('d-m-Y') }}</strong></p>
                        <p class="card-text">إجمالي المبلغ: <strong>{{ number_format($order->total_price, 2) }}</strong></p>

                        @if($order->status == 'confirmed')
                            <p>حالة الطلب: <strong><span class="text-success">فعّال</span></strong></p>
                        @elseif($order->status == 'canceled')
                            <p>حالة الطلب: <strong><span class="text-danger">ملغي</span></strong></p>
                        @elseif($order->status == 'pending')
                            <p>حالة الطلب: <strong><span class="text-warning">غير مكتمل</span></strong></p>
                            <p class="card-text text-warning">الرجاء السداد وتأكيد الطلب في غضون 24 ساعة وإلا سيتم إلغاء الطلب.</p>
                        @else
                            <p>حالة الطلب: <span class="text-secondary">{{ $order->status }}</span></p>
                        @endif

                    </div>
                    <div class="card-footer text-muted">!شكراً لاختياركم خدماتنا</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection