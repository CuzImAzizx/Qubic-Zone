@extends('layouts.app')
@section('content')
<h1>تاريخ العمليّات</h1>
<p>تحت بتشوف كل العمليّات الي دخّلتها. تقدر تبحث, تفلتر, وتستخرج العمليّات</p>
<div class="card" style="width:90vw ">
    <div class="card-body">
        <h2>تصفية العمليات</h2>
        <p>تقدر تحت تبحث عن عمليّة او تعرض العمليّات في فترة معيّنة
        </p>


        <form action="transactions" method="post">
            @csrf
            <div class="mb-3">
                <div class="form-text">كلمة البحث</div>
                <input type="text" class="form-control" name="searchTerm" style="text-align:center" placeholder="بحث" value="{{old('searchTerm')}}">
            </div>
            <div class="mb-3">
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <div style="margin: 15px;">
                                <div class="form-text">الى تاريخ</div>
                                <input class="form-control" type="date" name="endDate" id="endDate" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div style="margin: 15px;">
                                <div class="form-text">من تاريخ</div>
                                <input class="form-control" type="date" name="startDate" value="">
                            </div>
                            <script>
                                //Assumme the end date is today.
                                const today = new Date().toISOString().split('T')[0];
                                document.getElementById('endDate').value = today;
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <div style="margin: 15px;">
                                <div class="form-text">الى مبلغ</div>
                                <input class="form-control" type="number" name="endAmount" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div style="margin: 15px;">
                                <div class="form-text">من مبلغ</div>
                                <input class="form-control" type="number" name="startAmount" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-outline-primary" style="width:100%">بحث</button>
            </div>
        </form>
        <a href="/home"><button type="submit" class="btn btn-outline-secondary"
                style="width: 90%; margin: 10px">العودة</button></a>

    </div>
    <hr>
    @if ($insight->transactionsCount == 0)
        <div class="card-body">
            <h1>لا يوجد أي عمليّات</h1>
            <p>جرب تغيّر في إعدادات البحث, أو دخّل عمليّات جديدة</p>
        </div>
    @else
        <div class="card-body">
            <div class="custom-card-header">
                <h2>ملخّص العمليّات</h2>
            </div>
            <div class="container text-center">
                <div class="row">
                    <div class="col cell">
                        <div style="margin: 15px;">
                            <p>عدد العمليّات</p>
                            <p>{{$insight->transactionsCount}} عمليّة</p>
                        </div>
                    </div>
                    <div class="col cell">
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
                    <div class="col cell">
                        <div style="margin: 15px;">
                            <p>الوارد</p>
                            <p class="badge text-bg-success" style="font-size: 90%">ريال {{$insight->totalIncoming}}</p>

                        </div>

                    </div>
                    <div class="col cell">
                        <div style="margin: 15px;">
                            <p>الصادر</p>
                            <p class="badge text-bg-danger" style="font-size: 90%">{{$insight->totalOutgoing}} ريال</p>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <br>
        <hr>

        <div class="custom-card-header">
            <h2>جميع العمليّات</h2>
        </div>
        <hr>
        <table class="table" role="table">
            <thead style="text-align: right;">
                <tr class="tajawal-bold">
                    <th scope="col">رقم</th>
                    <th scope="col">المبلغ</th>
                    <th scope="col">التاريخ</th>
                    <th scope="col">ملاحظات</th>
                    <th scope="col">تفاصيل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr style="text-align: right;">
                        <td><span class="tajawal-bold">رقم:</span> {{$transaction->id}}</td>
                        @if ($transaction->amount > 0)
                            <td>
                                <span class="badge text-bg-success" style="font-size: 85%">{{$transaction->amount}}</span>
                                <span class="tajawal-bold">:المبلغ</span>
                            </td>
                        @else
                            <td>
                                <span class="badge text-bg-danger" style="font-size: 85%">{{$transaction->amount}}</span>
                                <span class="tajawal-bold">:المبلغ</span>
                            </td>
                        @endif

                        <td><span class="tajawal-bold">التاريخ:</span> {{$transaction->date}}</td>
                        <td>
                            @if ($transaction->note)
                                <span class="tajawal-bold">ملاحظات:</span> {{$transaction->note}}
                            @else
                                <span class="tajawal-extralight">لا توجد ملاحظات</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary">تفاصيل اكثر</button>
                            <br><br>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>
</div>
@endsection