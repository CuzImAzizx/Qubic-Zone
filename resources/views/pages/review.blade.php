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

    .action-buttons a {
        margin-right: 10px;
    }

    .status-label {
        font-weight: bold;
    }

    .status-pending {
        color: #ffc107; /* Warning color */
    }

    .status-confirmed {
        color: #28a745; /* Success color */
    }

    .status-canceled {
        color: #dc3545; /* Danger color */
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
    use App\Models\User;

    $sizes = Size::get();
    $decodedUnits = json_decode($order->units);
    $user = User::find($order->user_id);
@endphp

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    <h2>تفاصيل طلب {{$order->id}}</h2>
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        @foreach ($decodedUnits as $unitId)
                            @php
                                $fullUnitDetails = Unit::find($unitId);
                                $unitSize = Size::find($fullUnitDetails->size_id);
                            @endphp
                            <div class="col-md-4">
                                <div class="cart-item">
                                    <img src="{{ $unitSize->image }}" alt="Product Image">
                                    <div class="cart-item-details">
                                        <h6>وحدة تخزين {{ $unitSize->name }}</h6>
                                        <p>رقم الوحدة: <strong>{{ $unitId }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div style="text-align:center">
                    <h5 class="card-title mt-4">عدد الوحدات المحجوزة: {{ count($decodedUnits) }}</h5>
                    <p class="card-text">إجمالي المبلغ: <strong>{{ number_format($order->total_price, 2) }} ر.س</strong></p>
                    <p class="card-text">{{$user->name}} :صاحب الطلب</p>
                    <p class="card-text">{{$user->email}} :البريد الاكتروني لصاحب الطلب</p>
                    <p class="card-text">{{$order->created_at->format('d-m-Y H:i')}} :تاريخ الطلب</p>

                    <div class="mt-3">
                        @if($order->status == 'pending')
                            <p class="status-label status-pending">حالة الطلب: <strong>غير مكتمل</strong></p>
                            <div class="action-buttons">
                                <a href="/orderConfirm/{{$order->id}}" class="btn btn-success">قبول الطلب</a>
                                <a href="/orderCancel/{{$order->id}}" class="btn btn-danger">رفض الطلب</a>
                            </div>
                        @elseif($order->status == 'confirmed')
                            <p class="status-label status-confirmed">حالة الطلب: <strong>مكتمل</strong></p>
                        @elseif($order->status == 'canceled')
                            <p class="status-label status-canceled">حالة الطلب: <strong>ملغي</strong></p>
                        @else
                            <p class="status-label"><span class="text-secondary">حالة الطلب: {{ $order->status }}</span></p>
                        @endif

                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection