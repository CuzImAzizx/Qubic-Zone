@extends('layouts.simpleapp')
@section('content')
<style>
            .storage-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden; /* Prevents image overflow */
            margin-bottom: 20px; /* Space between cards */
        }

        .storage-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

</style>
<div class="container text-center content">
    <div class="row">
        <h2>فروع {{$city->name}}</h2>
        <p>اختر احد الفروع الموجودة في {{$city->name}}</p>
    </div>
    <div class="row row-cols-1 row-cols-md-2 g-4">
    <style>
        .card-img-top {
            height: 200px; /* Set a fixed height */
            object-fit: cover; /* Ensure the image covers the area without distortion */
        }
    </style>
    @foreach ($branches as $branch)
    <div class="col">
    <div class="card storage-card">
      <img class="card-img-top" src="{{$branch->image}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">{{$branch->name}}</h5>
        <p class="card-text">{{$branch->description}}</p>
        <a href="{{ url()->current() . '/' . $branch->id }}" class="btn btn-primary">اختر الفرع</a>
    </div>
    </div>
  </div>

    @endforeach
</div>
</div>
@endsection