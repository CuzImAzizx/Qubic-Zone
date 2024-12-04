@extends('layouts.simpleapp')
@section('content')
<div class="container text-center content">
    <h1>اختيار وحدات التخزين</h1>
    <h5>{{$city->name}} -> {{$branch->name}}</h5>
</div>
<div class="row row-cols-1 row-cols-md-3 g-4">
    <style>
        .card-img-top {
            height: 400px; /* Set a fixed height */
            object-fit: cover; /* Ensure the image covers the area without distortion */
        }
    </style>

@foreach ($availableUnits as $unit)
    <div class="col">
    <div class="card">
      <img class="card-img-top" src="{{$unit->image}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">{{$unit->size_name}}</h5>
        <p class="card-text">{{$unit->size_inch}}</p>
        <p class="card-text">{{$unit->description}}</p>
        <a href="" class="btn btn-primary">اختر الفرع</a>
    </div>
    </div>
  </div>

    @endforeach

  <div class="col">
    <div class="card">
      <img class="card-img-top" src="/assets/images/unit-sizes/small.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">5"x5"</h5>
        <p class="card-text">مناسب لـ أغراض صغيرة، وثائق، حقائب صغيرة</p>
        <a href="" class="btn btn-primary">اختر الفرع</a>
    </div>
    </div>
  </div>

    
  <div class="col">
    <div class="card">
      <img class="card-img-top" src="/assets/images/unit-sizes/small.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">5"x5"</h5>
        <p class="card-text">مناسب لـ أغراض صغيرة، وثائق، حقائب صغيرة</p>
        <a href="" class="btn btn-primary">اختر الفرع</a>
    </div>
    </div>
  </div>

  <div class="col">
    <div class="card">
      <img class="card-img-top" src="/assets/images/unit-sizes/small.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">5"x5"</h5>
        <p class="card-text">مناسب لـ أغراض صغيرة، وثائق، حقائب صغيرة</p>
        <a href="" class="btn btn-primary">اختر الفرع</a>
    </div>
    </div>
  </div>


</div>

@endsection