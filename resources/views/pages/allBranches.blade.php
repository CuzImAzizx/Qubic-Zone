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
@php
use App\Models\Branch;
@endphp

<div class="container text-center">

    @foreach ($cities as $city)
    <div class="row header-text card-header">
        <h2>فروع {{$city->name}}</h2>
        <p>جميع فروعنا في مدينة {{$city->name}}</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">

    
        @php
            $branches = Branch::where('city_id', $city->id)->get();
        @endphp
        @foreach ($branches as $branch)
            <div class="col">
                <div class="card storage-card">
                    <img class="card-img-top" src="{{asset($branch->image)}}" alt="">
                    <div class="card-body">
                        <h5 class="card-title">{{$branch->name}}</h5>
                        <p class="card-text">{{$branch->description}}</p>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
    <hr>
    <br>
    @endforeach
</div>

@endsection