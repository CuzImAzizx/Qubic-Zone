@extends('layouts.simpleapp')
@section('content')
<div class="container text-center content">
    <h1>اختيار وحدات التخزين</h1>
    <h5>{{$city->name}} -> {{$branch->name}}</h5>
</div>
<div class="row row-cols-1 row-cols-md-3 g-4">
    <style>
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
            <div class="card">
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

                            // Update the total in the offcanvas
                            document.getElementById('totalItems').innerText = totalQuantity;
                            document.getElementById('totalPrice').innerText = totalPrice.toFixed(2); // Format to 2 decimal places
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

        @foreach ($sizes as $size)
            <div class="cart-item" id="{{ $size->id }}Product" style="display:none">
                <img src="{{ $size->image }}" alt="Product Image">
                <div class="cart-item-details">
                    <h6>وحدة تخزين {{ $size->name }}</h6>
                    <p class="card-text">عدد الوحدات: <span id='{{ $size->id }}CounterFinal'>0</span></p>
                    <p class="card-text">إجمالي السعر: <span id='{{ $size->id }}TotalPrice'>0.00</span></p>
                    <!-- Total price display -->
                </div>
            </div>
        @endforeach

        <br>
        <div class="cart-item" id="Product">
            <div class="cart-item-details">
                <h5>ملخص الطلب</h5>
                <h6 class="card-text">إجمالي عدد الوحدات: <span id="totalItems">0</span>
                    <h6 class="card-text">إجمالي السعر: <span id="totalPrice">0.00</span> <!-- Total price display -->
            </div>
        </div>
        <br>
        <form method="POST" action="{{ url()->current() . '/' . 'process' }}" id="storageForm">
            @csrf

            <!-- Hidden inputs for city ID, branch ID, and current user ID -->
            <input type="hidden" name="city_id" value="{{ $city->id }}">
            <input type="hidden" name="branch_id" value="{{ $branch->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}"> <!-- Auth user ID -->
            <button type="submit" id="reviewOrderButton" class="btn btn-lg btn-primary" type="button" disabled>
                مراجعة الطلب
            </button>

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

                // Now submit the form
                this.submit();
            });

        </script>
    </div>
    @endsection

