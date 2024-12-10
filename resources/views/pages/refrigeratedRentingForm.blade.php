@extends('layouts.simpleapp')
@section('content')
<div class="container text-center content">
    <h1>❄️اختيار وحدات التخزين مبرّدة</h1>
    <h5>📍{{$city->name}} -> {{$branch->name}}</h5>
</div>
<div class="row row-cols-1 row-cols-md-3 g-4">
    <style>
        .storage-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .storage-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .summary-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .card-img-top {
            height: 400px;
            object-fit: cover;
        }

        .counter-container {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 18px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .counter {
            width: 50px;
            text-align: center;
            border: none;
            font-size: 18px;
            margin: 0 10px;
        }
    </style>

    <div class="col" style="text-align: center;">
        <div class="storage-card">
            <img class="card-img-top" src="{{ asset('/assets/images/warehouses/4.png') }}">
            <div class="card-body">
                <h5 class="card-title">وحدة تخزين مبرّدة</h5>
                <p class="card-text">5x5"</p>
                <p class="card-text">وحدات تخزين مبرّدة مصممة خصيصًا لحماية منتجاتك الحساسة</p>
                @php
                    $count = $availableUnits->count();
                @endphp
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <p class="card-text">السعر: 300 /شهري</p>
                        </div>
                        <div class="col">
                            <p class="card-text">المتوفر: {{ $count }} وِحدة</p>
                        </div>
                    </div>
                </div>
                <br>

                <div class="counter-container" style="display:block; align-content: center;">
                    <button class="btn btn-primary" id="1DecrementBtn">-</button>
                    <input type="number" class="counter" id="1Counter" value="0" data-price="300" readonly>
                    <button class="btn btn-primary" id="1IncrementBtn">+</button>
                </div>
                <script>
                    // Function to update the availability of the review button and total price
                    function updateReviewButtonState() {
                        const counters = document.querySelectorAll('.counter');
                        const reviewButton = document.getElementById('reviewOrderButton');
                        const rentalMonthsSelect = document.getElementById('rentalMonthsSelect');
                        const rentalMonthsLable = document.getElementById('rentalMonthsLable');
                        let totalQuantity = 0;
                        let totalPrice = 0;

                        counters.forEach(counter => {
                            const quantity = parseInt(counter.value) || 0; // Ensure quantity is a number
                            const pricePerMonth = parseFloat(counter.dataset.price) || 0; // Ensure price is a number
                            totalQuantity += quantity;
                            totalPrice += quantity * pricePerMonth;
                        });

                        // Enable or disable the review button based on the total
                        reviewButton.disabled = totalQuantity === 0;

                        // Show rental months select if any quantity is added
                        rentalMonthsSelect.style.display = totalQuantity > 0 ? 'block' : 'none';
                        rentalMonthsLable.style.display = totalQuantity > 0 ? 'block' : 'none';


                        // Update the total in the offcanvas
                        document.getElementById('totalItems').innerText = totalQuantity;
                        const rentalMonths = document.getElementById('rentalMonthsSelect').value
                        document.getElementById('totalPrice').innerText = (totalPrice * rentalMonths).toFixed(2); // Format to 2 decimal places
                    }

                    // Increment button event listener
                    document.getElementById('1IncrementBtn').addEventListener('click', function () {
                        const counterInput = document.getElementById('1Counter');
                        const currentValue = parseInt(counterInput.value);
                        const availableUnits = {{ $count }};

                        if (currentValue < availableUnits) {
                            counterInput.value = currentValue + 1;
                            updateReviewButtonState();
                        } else {
                            alert("لا يوجد وحدات متاحة لزيادة الكمية."); // Alert message in Arabic
                        }
                    });

                    // Decrement button event listener
                    document.getElementById('1DecrementBtn').addEventListener('click', function () {
                        const counterInput = document.getElementById('1Counter');
                        const currentValue = parseInt(counterInput.value);
                        if (currentValue > 0) {
                            counterInput.value = currentValue - 1;
                            updateReviewButtonState();
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="container" style="text-align: center;">
        <br>
        <h5 id="rentalMonthsLable">:أجّرها لمدة</h5>
        <select id="rentalMonthsSelect" class="form-select">
            <option value="1" selected>شهر واحد</option>
            <option value="3">ثلاثة أشهر</option>
            <option value="6">ستة أشهر</option>
            <option value="12">سنة واحدة</option>
            <option value="24">سنتين</option>
        </select>


        <br>
        <div class="summary-card" id="Product">
            <div class="cart-item-details">
                <h5>ملخص الطلب</h5>
                <h6 class="card-text">إجمالي عدد الوحدات: <span id="totalItems">0</span></h6>
                <h6 class="card-text">إجمالي السعر: <span id="totalPrice">0.00</span>ر.س</h6>
            </div>
            <br>
            <button class="btn btn-primary" style="width:90%" id="reviewOrderButton" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom" disabled>الدفع</button>
        </div>
        <br>
        <br>

        <div class="offcanvas offcanvas-bottom" style="min-height: 80%;" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">تفاصيل الدفع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body small">
                <div class="payment-form-container" style="margin-top: 30px; text-align: center; max-width:50%; margin-left:25%">
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
                    <input type="hidden" name="city_id" value="{{ $city->id }}">
                    <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <button type="submit" class="btn btn-lg btn-primary">اتمام الطلب</button>
                </form>
                <script>
            document.getElementById('storageForm').addEventListener('submit', function (event) {
                // Prevent the default form submission
                event.preventDefault();

                // Create hidden inputs for quantities
                const counters = document.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const quantity = parseInt(counter.value) || 0;
                    const sizeId = counter.id.replace('Counter', ''); // Extract size ID from the counter ID

                    // Create a hidden input for the quantity
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `sizes[${sizeId}]`; // Use an array to collect quantities
                    hiddenInput.value = quantity;

                    // Append the hidden input to the form
                    this.appendChild(hiddenInput);
                });

                // Get the selected rental months
                const rentalMonthsSelect = document.getElementById('rentalMonthsSelect');
                const selectedMonths = rentalMonthsSelect.value;

                // Create a hidden input for the rental months
                const monthsInput = document.createElement('input');
                monthsInput.type = 'hidden';
                monthsInput.name = 'rentalMonths';
                monthsInput.value = selectedMonths;

                // Append the hidden input to the form
                this.appendChild(monthsInput);

                // Now submit the form
                this.submit();
            });
        </script>

            </div>
        </div>

        <script>
            document.getElementById('rentalMonthsSelect').addEventListener('change', function () {
                updateReviewButtonState();
            });

            // Initial call to set the summary correctly on page load
            updateReviewButtonState();
        </script>
    </div>
</div>
@endsection