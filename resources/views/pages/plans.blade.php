@extends('layouts.simpleapp')

@section('content')

<style>
    .storage-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        background-color: #fff;
        display: flex;
        flex-direction: column; /* Stack elements vertically */
        align-items: center; /* Center items horizontally */
    }

    .storage-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        width: 100%; /* Make image responsive */
        height: auto; /* Maintain aspect ratio */
        object-fit: cover;
    }

    .card-body {
        text-align: center; /* Center text */
        padding: 20px; /* Add padding */
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        margin-top: 10px; /* Add some space above the button */
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .header-text {
        margin-bottom: 20px;
    }

    h2 {
        font-size: 2.5em;
        color: #333;
    }

    p {
        font-size: 1.2em;
        color: #555;
    }
</style>

<div class="container text-center">
    <div class="row header-text card-header">
        <h2>قائمة الاشتراكات</h2>
        <p>اشترك في احد الخطط لتحصل على مزايا استثنائية</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($plans as $plan)
        <div class="col">
            <div class="card storage-card">
                <img class="card-img-top" src="{{ asset($plan->image) }}" alt="{{ $plan->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{$plan->name}}</h5>
                    <p class="card-text">{{$plan->description}}</p>
                    @if ($plan->price_per_month == 0)
                    <p class="card-text">مجانًا مع كل حساب</p>
                    @else
                    <p class="card-text">سعر الاشتراك الشهري: {{$plan->price_per_month}} ر.س</p>
                    <a href="/plans/{{$plan->id}}" class="btn btn-primary">اشترك الآن</a>
                    @endif
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection