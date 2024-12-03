@extends('layouts.app')
@section('content')
@if($status == "success")
    <div class="card" style="width:90vw ">
        <div class="card-body">
            <div class="alert alert-success" role="alert">
                <div class="mb-3">
                    <h1>تم انشاء العمليّة</h1>
                </div>
                <div class="mb-3">
                    <p>تم انشاء العمليّة برقم {{$insertedTransaction->id}}</p>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" style="width: 100%;">الذهاب الى تفاصيل العلميّة</button>

                </div>
                <div class="mb-3">
                <button type="button" class="btn btn-secondary" style="width: 100%;">عرض جميع العمليّات</button>

                </div>
            </div>

        </div>

    </div>
    <div class="mb-3" style="margin:15px">
                <button type="button" class="btn btn-outline-secondary" style="width: 90%;">العودة للصفحة الرئيسية</button>
                </div>


@endif
@endsection