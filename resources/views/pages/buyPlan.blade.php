@extends('layouts.simpleapp')

@section('content')

<style>
    .plan-details-container {
        max-width: 800px;
        margin: 40px auto;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .plan-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .plan-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .plan-title {
        font-size: 2.5em;
        color: #333;
    }

    .plan-description {
        font-size: 1.2em;
        color: #555;
        margin-bottom: 20px;
    }

    .plan-price {
        font-size: 1.5em;
        color: #007bff;
        margin-bottom: 20px;
    }

    .btn-subscribe {
        background-color: #007bff;
        border: none;
        width: 100%;
        padding: 10px;
        color: #fff;
        font-size: 1.2em;
        border-radius: 5px;
    }

    .btn-subscribe:hover {
        background-color: #0056b3;
    }
</style>
<style>
        .right-aligned-list {
    direction: rtl; /* Set text direction to right-to-left */
    text-align: right; /* Align text to the right */
}

.right-aligned-list ul {
    list-style-position: inside; /* Optional: change bullet position */
    padding: 0; /* Remove default padding */
    margin: 0; /* Remove default margin */
}
    </style>


<div class="container">
    <div class="plan-details-container" style="text-align: right;">
        <div class="plan-header">
            <h2 class="plan-title">{{ $plan->name }}</h2>
            <img src="{{ asset($plan->image) }}" alt="{{ $plan->name }}" class="plan-image">
        </div>
        <p class="plan-description">{!! $plan->description !!}</p>
        <p class="plan-description">
    بداية الإشتراك: {{ now()->format('Y-m-d') }}
</p>
<p class="plan-description">
    نهاية الاشتراك: {{ now()->copy()->addMonth()->format('Y-m-d') }}
</p>        <p class="plan-description">لمدة: 1 شهر</p>
        <p class="plan-price">السعر: {{ $plan->price_per_month }} ر.س شهريًا</p>
        
        <button class="btn btn-lg btn-primary" style="width:90%" id="reviewOrderButton" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"
                >الدفع</button>
    </div>
</div>
<style>
            .payment-form-container {
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 20px;
                background-color: #f9f9f9;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                margin-top: 30px;
            }

            .form-control {
                border-radius: 5px;
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 15px;
                font-size: 16px;
            }

            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            .btn-primary {
                background-color: #007bff;
                border: none;
                border-radius: 5px;
                padding: 10px 15px;
                font-size: 18px;
            }

            .btn-primary:disabled {
                background-color: #ccc;
            }
        </style>

<div class="offcanvas offcanvas-bottom" style="min-height: 80%;" tabindex="-1" id="offcanvasBottom"
            aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">بوابة الدفع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body small">
                <div class="payment-form-container"
                    style="margin-top: 30px; text-align: center; max-width:50%; margin-left:25%">
                    <h2>تفاصيل الدفع</h2>

                    <div class="form-group">
                        <label for="cardNumber">رقم البطاقة:</label>
                        <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX" required>
                    </div>

                    <div class="form-group">
                        <label for="expiryDate">تاريخ الانتهاء:</label>
                        <input type="text" class="form-control" placeholder="MM/YY" required>
                    </div>

                    <div class="form-group">
                        <label for="cvv">CVV:</label>
                        <input type="text" class="form-control" placeholder="XXX" required>
                    </div>

                    <div class="form-group">
                        <label for="nameOnCard">الاسم على البطاقة:</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="billingAddress">عنوان الفاتورة:</label>
                        <input type="text" class="form-control" placeholder="عنوانك هنا" required>
                    </div>

                </div>
                <br>


                <form method="POST" action="{{ url()->current() . '/' . 'process' }}" id="storageForm">
                    @csrf

                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                    <button type="submit" class="btn btn-lg btn-primary" type="button" style="text-align:center">
                        اتمام الطلب
                    </button>

                </form>

            </div>
        </div>


@endsection