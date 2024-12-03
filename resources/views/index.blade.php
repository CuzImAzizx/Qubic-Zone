@extends('layouts.app')
@section('content')
<h1 class="tajawal-bold">{{auth('')->user()->name}} أهلًا</h1>
<div class="card">

    <div class="card-body">
        <div class="custom-card-header">
            <h2>ملخّص حسابك</h2>
        </div>
        <div class="container text-center">
            <div class="row" >
                <div class="col cell">
                    <div style="margin: 15px;">
                        <p>عدد العمليّات</p>
                        <p>{{$insight->transactionsCount}} عمليّة</p>
                    </div> 
                </div>
                <div class="col cell" >
                    <div style="margin: 15px;">
                        <p>إجمالي المبلغ</p>
                        @if ($insight->total >= 0)
                        <p class="badge text-bg-success" style="font-size: 90%">ريال {{$insight->total}}</p>
                        @else
                        <p class="badge text-bg-danger" style="font-size: 90%">ريال {{$insight->total}}</p>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col cell" >
                    <div style="margin: 15px;">
                        <p>الوارد</p>
                        <p class="badge text-bg-success" style="font-size: 90%">ريال {{$insight->totalIncoming}}</p>

                    </div>

                </div>
                <div class="col cell" >
                    <div style="margin: 15px;">
                        <p>الصادر</p>
                        <p class="badge text-bg-danger" style="font-size: 90%">{{$insight->totalOutgoing}} ريال</p>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<a href="/addTransaction"><button type="button" class="btn btn-primary" style="width: 90%; margin:10px; ">إدخال عمليّة جديدة</button></a>

<a href="/transactions"><button type="button" class="btn btn-secondary" style="width: 90%; margin:5px;">عرض تاريخ العمليّات</button>    
</a>
@endsection
