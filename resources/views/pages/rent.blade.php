@extends('layouts.simpleapp')
@section('content')
<div class="container text-center content">
                    <div class="row">
                        <h2>اختر موقع المستودع</h2>
                        <p>نتوفر في كافة مناطق المملكة بخدمات تخزين متواجدة وكلام فاضي هنا</p>
                        <div class="col">
                            <img style="width:500px;"
                                src="https://alwedad.sa/sites/default/files/users/2/map_image.png">
                        </div>
                        <div class="col">
                            <select id="citySelect" class="form-select form-select-lg mb-3" style="margin-top: 30%;">
                            <option selected>اختر المدينة</option>
                            @foreach ($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                            </select>
                            <script>
                                document.getElementById('citySelect').addEventListener('change', function () {
                                    const selectedValue = this.value;
                                    if (selectedValue) {
                                        // Redirect to a new URL with the selected city as a query parameter
                                        window.location.href = `/rent-storage/${selectedValue}`;
                                    }
                                });
                            </script>

                        </div>
                    </div>
                </div>

@endsection