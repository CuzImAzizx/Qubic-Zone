@extends('layouts.simpleapp')
@section('content')
<div class="container text-center content">
    <h1>اختيار وحدات التخزين</h1>
    <h5>{{$city->name}} -> {{$branch->name}}</h5>
</div>
<div class="row row-cols-1 row-cols-md-3 g-4">
    <style>
        .storage-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            /* Prevents image overflow */
            margin-bottom: 20px;
            /* Space between cards */
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

        .summary-card h5 {
            margin-bottom: 15px;
        }

        .summary-card .card-text {
            margin: 0;
        }


        .card-img-top {
            height: 400px;
            /* Set a fixed height */
            object-fit: cover;
            /* Ensure the image covers the area without distortion */
        }

        .counter-container {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .btn1 {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .btn1:hover {
            background-color: #0056b3;
        }

        .counter {
            width: 50px;
            text-align: center;
            border: none;
            font-size: 18px;
            margin: 0 10px;
        }

        #counter {
            width: 50px;
            text-align: center;
            border: none;
            font-size: 18px;
            margin: 0 10px;
        }
    </style>
    @foreach ($sizes as $size)
        <div class="col" style="text-align: center;">
            <div class="storage-card">
                <img class="card-img-top" src="{{ $size->image }}" alt="{{ $size->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $size->name }}</h5>
                    <p class="card-text">{{ $size->dimensions }}</p>
                    <p class="card-text">{{ $size->description }}</p>
                    @php
                        $count = $availableUnits->where('size_id', $size->id)->count();
                    @endphp
                    <div class="container text-center">
                        <div class="row">
                            <div class="col">
                                <p class="card-text">السعر: {{ $size->price_per_month }} /شهري</p>
                            </div>
                            <div class="col">
                                <p class="card-text">المتوفر: {{ $count }} وِحدة</p>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="counter-container" style="display:block; align-content: center;">
                        <button class="btn btn-primary" id="{{ $size->id }}DecrementBtn">-</button>
                        <input type="number" class="counter" id="{{ $size->id }}Counter" value="0"
                            data-price="{{ $size->price_per_month }}" readonly>
                        <button class="btn btn-primary" id="{{ $size->id }}IncrementBtn">+</button>
                    </div>
                    <script>
                        // Function to update the availability of the review button and total price
                        function updateReviewButtonState() {
                            const counters = document.querySelectorAll('.counter');
                            const reviewButton = document.getElementById('reviewOrderButton');
                            const rentalMonthsSelect = document.getElementById('rentalMonthsSelect');
                            const rentalMonthsLable = document.getElementById('rentalMonthsLable');
                            let totalQuantity = 0;

                            counters.forEach(counter => {
                                const quantity = parseInt(counter.value) || 0; // Ensure quantity is a number
                                totalQuantity += quantity;
                            });

                            // Enable or disable the review button based on the total
                            reviewButton.disabled = totalQuantity === 0;

                            // Show rental months select if any quantity is added
                            rentalMonthsSelect.style.display = totalQuantity > 0 ? 'block' : 'none';
                            rentalMonthsLable.style.display = totalQuantity > 0 ? 'block' : 'none';

                            // Update the total in the offcanvas
                            document.getElementById('totalItems').innerText = totalQuantity;
                            const totalPrice = Array.from(counters).reduce((acc, counter) => {
                                const pricePerMonth = parseFloat(counter.dataset.price) || 0;
                                return acc + (parseInt(counter.value) || 0) * pricePerMonth;
                            }, 0);
                            const rentalMonths = document.getElementById('rentalMonthsSelect').value
                            document.getElementById('totalPrice').innerText = totalPrice.toFixed(2) * rentalMonths; // Format to 2 decimal places
                        }


                        // Increment button event listener
                        document.getElementById('{{ $size->id }}IncrementBtn').addEventListener('click', function () {
                            const counterInput = document.getElementById('{{ $size->id }}Counter');
                            const currentValue = parseInt(counterInput.value);
                            const availableUnits = {{ $count }};

                            if (currentValue + 1 === 0) {
                                document.getElementById('{{ $size->id }}Product').style.display = 'none';
                            } else {
                                document.getElementById('{{ $size->id }}Product').style.display = 'flex';
                            }

                            if (currentValue < availableUnits) {
                                counterInput.value = currentValue + 1;
                                document.getElementById('{{ $size->id }}CounterFinal').innerHTML = currentValue + 1;

                                // Update the total price display
                                const itemPrice = (currentValue + 1) * parseFloat(counterInput.dataset.price);
                                document.getElementById('{{ $size->id }}TotalPrice').innerText = itemPrice.toFixed(2);
                            } else {
                                alert("لا يوجد وحدات متاحة لزيادة الكمية."); // Alert message in Arabic
                            }
                            updateReviewButtonState(); // Check the button state after increment
                        });

                        // Decrement button event listener
                        document.getElementById('{{ $size->id }}DecrementBtn').addEventListener('click', function () {
                            const counterInput = document.getElementById('{{ $size->id }}Counter');
                            const currentValue = parseInt(counterInput.value);

                            if (currentValue - 1 <= 0) {
                                document.getElementById('{{ $size->id }}Product').style.display = 'none';
                            } else {
                                document.getElementById('{{ $size->id }}Product').style.display = 'flex';
                            }

                            if (currentValue > 0) {
                                counterInput.value = currentValue - 1;
                                document.getElementById('{{ $size->id }}CounterFinal').innerHTML = currentValue - 1;

                                // Update the total price display
                                const itemPrice = (currentValue - 1) * parseFloat(counterInput.dataset.price);
                                document.getElementById('{{ $size->id }}TotalPrice').innerText = itemPrice.toFixed(2);
                            }
                            updateReviewButtonState(); // Check the button state after decrement
                        });
                    </script>
                </div>
            </div>
        </div>
    @endforeach

    <div class="container" style="text-align: center;">
        <br>

        <style>
            .cart-item {
                display: flex;
                align-items: center;
                border-bottom: 1px solid #ccc;
                padding: 15px;
            }

            .cart-item img {
                height: 100px;
                margin-right: 15px;
            }

            .cart-item-details {
                flex-grow: 1;
            }

            .cart-item-details h6 {
                margin-bottom: 5px;
            }

            .cart-item-actions {
                display: flex;
                align-items: center;
            }

            .cart-item-actions input {
                width: 100px;
                text-align: center;
            }
        </style>
        <style>
            .payment-form-container {
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 20px;
                background-color: #f9f9f9;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                margin-top: 30px;
            }

            .form-control {
                border-radius: 5px;
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 15px;
                font-size: 16px;
            }

            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            .btn-primary {
                background-color: #007bff;
                border: none;
                border-radius: 5px;
                padding: 10px 15px;
                font-size: 18px;
            }

            .btn-primary:disabled {
                background-color: #ccc;
            }
        </style>

        <div class="container" style="text-align: center;">
            <h5 id="rentalMonthsLable" style="display: none;">:أجّرها لمدة</h5>
            <select id="rentalMonthsSelect" class="form-select" style="display: none;">
                <option value="1" selected>شهر واحد</option>
                <option value="3">ثلاثة أشهر</option>
                <option value="6">ستة أشهر</option>
                <option value="12">سنة واحدة</option>
                @php
        use App\Models\Subscription;
        $sub = Subscription::where('user_id', auth()->id())->first();
        @endphp
                @if ($sub->plan_id == 1)
                <option disabled value="24"> 💎 سنتين</option>
                @else
                <option value="24">سنتين</option>
                @endif
                
            </select>
        </div>
        @foreach ($sizes as $size)
            <div class="cart-item" id="{{ $size->id }}Product" style="display:none">
                <img src="{{ $size->image }}" alt="Product Image">
                <div class="cart-item-details">
                    <h6>وحدة تخزين {{ $size->name }}</h6>
                    <p class="card-text">عدد الوحدات: <span id='{{ $size->id }}CounterFinal'>0</span></p>
                    <p class="card-text">سعر التأجير الشهري: <span id='{{ $size->id }}TotalPrice'>0.00</span>ر.س</p>
                    <!-- Total price display -->
                </div>
            </div>
        @endforeach

        <br>
        <div class="summary-card" id="Product">
            <div class="cart-item-details">
                <h5>ملخص الطلب</h5>
                <h6 class="card-text">إجمالي عدد الوحدات: <span id="totalItems">0</span></h6>
                <h6 class="card-text">مدة التأجير: <span id="rentalMonth">1</span> أشهر</h6>
                <h6 class="card-text">إجمالي السعر: <span id="totalPrice">0.00</span>ر.س</h6>
            </div>
            <br>
            <button class="btn btn-primary" style="width:90%" id="reviewOrderButton" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"
                disabled>الدفع</button>

        </div>
        <br>
        <br>

        <div class="offcanvas offcanvas-bottom" style="min-height: 80%;" tabindex="-1" id="offcanvasBottom"
            aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Offcanvas bottom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body small">
                <div class="payment-form-container"
                    style="margin-top: 30px; text-align: center; max-width:50%; margin-left:25%">
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

                    <!-- Hidden inputs for city ID, branch ID, and current user ID -->
                    <input type="hidden" name="city_id" value="{{ $city->id }}">
                    <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}"> <!-- Auth user ID -->
                    <button type="submit" class="btn btn-lg btn-primary" type="button">
                        اتمام الطلب
                    </button>

                </form>

            </div>
        </div>



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
        <script>
            // Function to update total items and price
            function updateSummary() {
                const counters = document.querySelectorAll('.counter');
                const rentalMonthsSelect = document.getElementById('rentalMonthsSelect');
                const rentalMonths = parseInt(rentalMonthsSelect.value);
                let totalPrice = 0;
                let totalQuantity = 0;

                counters.forEach(counter => {
                    const quantity = parseInt(counter.value) || 0;
                    const pricePerMonth = parseFloat(counter.dataset.price) || 0;
                    totalQuantity += quantity;
                    totalPrice += quantity * pricePerMonth;
                });

                // Update total price with rental months
                totalPrice *= rentalMonths;

                document.getElementById('totalItems').innerText = totalQuantity;
                document.getElementById('totalPrice').innerText = totalPrice.toFixed(2); // Format to 2 decimal places
                document.getElementById('rentalMonth').innerText = rentalMonths; // Update rental month display
            }
        </script>
        <script>
            // Update summary when rental months change
            document.getElementById('rentalMonthsSelect').addEventListener('change', function () {
                updateSummary();
            });

            // Initial call to set the summary correctly on page load
            updateSummary();
        </script>
    </div>
    @endsection