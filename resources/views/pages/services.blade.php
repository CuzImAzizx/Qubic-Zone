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
    }

    .storage-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        text-align: right;
        /* Align text to the right for Arabic */
    }

    .btn-primary {
        background-color: #007bff;
        /* Primary color */
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        /* Darker shade on hover */
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
    <div class="row header-text">
        <h2>الخدمات</h2>
        <p>Qubic Zone اختر احد الخدمات المقدمة من</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card storage-card">
                <img class="card-img-top" src="{{ asset('/assets/images/welcome-hero/welcome-banner.jpg') }}"
                    alt="">
                <div class="card-body">
                    <h5 class="card-title">استئجار وحدات تخزين</h5>
                    <p class="card-text">استئجر مساحة تخزين في احد المستودعات بالحجم اللي تبيه</p>
                    <a href="/rent-storage" class="btn btn-primary">ابدأ الحجز</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card storage-card">
                <img class="card-img-top" src="{{ asset('/assets/images/warehouses/rwh1.png') }}"
                    alt="استئجار وحدات تخزين مبرّدة">
                <div class="card-body">
                    <h5 class="card-title">استئجار وحدات تخزين مبرّدة</h5>
                    <p class="card-text">استئجر وحدات تخزين مبرّدة مصممة خصيصًا لحماية منتجاتك الحساسة</p>
                    <a href="/rent-cold-storage" class="btn btn-primary">ابدأ الحجز</a>
                </div>
            </div>
        </div>


        <div class="col">
            <div class="card storage-card">
                <img class="card-img-top" src="{{ asset('/assets/images/warehouses/wh1.png') }}"
                    alt="">
                <div class="card-body">
                    <h5 class="card-title">استئجار مستودع كامل</h5>
                    <p class="card-text">استئجر مستودع كامل بكل اللي فيه</p>
                    <a href="/contact" class="btn btn-primary">تواصل معنا</a>
                </div>
            </div>
        </div>        
    </div>
</div>

@endsection