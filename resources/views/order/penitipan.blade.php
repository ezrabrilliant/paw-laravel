@extends('app')

@if (!auth()->check())
    @section('content')
        <script>
            window.location = "/";
        </script>
    @endsection
@endif

@section('title', 'Penitipan')

@section('content')
    <section>
        <div class="container">
            <header class="header-order">
                <h1 class="h1-order text-white">Penitipan Order Form</h1>
            </header>

            <main class="container-order">
                <div class="left-page">
                    <div class="form pt-2">
                        {{-- Order Form --}}
                        <div class="form template-paw form-order text-white">
                            <h3 class="text-uppercase h3-order">Information Form</h3>
                            <p>Provide the necessary information about your pet for grooming purposes.</p>
                            <form class="form-input" method="POST" action="{{ route('order-jasa.store') }}">
                                @csrf
                                <input type="hidden" class="form-control" id="delivery_cost" name="delivery_cost">
                                <input type="hidden" name="jasa_ids[]" value="1">
                                <div class="form-group row">
                                    <label for="pet_name" class="col-sm-3 col-form-label">Pet Name</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="pet_name" name="pet_name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pet_age" class="col-sm-3 col-form-label">Pet Age</label>
                                    <div class="col-sm-5">
                                        <input type="number" class="form-control" id="pet_age" name="pet_age" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pet_weight" class="col-sm-3 col-form-label">Weight</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="pet_weight" name="pet_weight" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_in_date" class="col-sm-3 col-form-label">Check in Date</label>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="check_in_date" name="check_in_date" required min="{{ date('Y-m-d', strtotime('+0 day')) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="check_out_date" class="col-sm-3 col-form-label">Check out Date</label>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="check_out_date" name="check_out_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                </div>

                            </form>
                        </div>
                        {{-- Address Form --}}
                        <div class="form pt-2">
                            <div class="template-paw form-order text-white">
                                <h3 class="text-uppercase h3-order">Need Delivery?</h3>
                                <p>Do you want us to deliver your pet? Please provide the address below.</p>
                                <div class="form-group row">
                                    <div class="col-sm-5">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="delivery" id="delivery_yes" value="yes" onclick="showAddressForm()">
                                            <label class="form-check-label" for="delivery_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="delivery" id="delivery_no" value="no" onclick="hideAddressForm()">
                                            <label class="form-check-label" for="delivery_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="address_form" style="display: none; padding-bottom: 1rem;">
                                    <div class="form-group row">
                                        <label for="address" class="col-sm-3 col-form-label">Input Alamat:</label>
                                        <div class="col-sm-6 d-flex">
                                            <input type="text" class="form-control" id="address" name="address">
                                            <input type="submit" value="check" class="btn btn-outline-light check-button" style="border-radius: 0.3rem; margin-left: 1rem;">
                                        </div>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert" style="display: none;">
                                        <strong>Error!</strong> <span class="alert-text"></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Overview --}}
            <aside class="right-page pb-5" style="padding-right: 0px;">
                <div class="form pt-2">
                    <div class="form template-paw form-order text-white" style="padding-top: 1px;">
                        <h3 class="text-uppercase h3-order">Product Overview</h3>
                        <div class="form-overview">
                            <p style="margin-bottom: 5px;">Service: Penitipan</p>
                            <p style="margin-bottom: 5px;">menitipkan ... hari</p>
                            <p style="margin-bottom: 5px;">biaya penitipan Rp. 0</p>
                            <p style="margin-bottom: 5px;">Total: Rp. 0</p>
                        </div>
                        <div class="form-group row"  style="padding-bottom: 10px;">
                            <div class="col-sm-5">
                                <input type="submit" value="Submit" class="btn btn-outline-light submit-button" style="border-radius: 0.3rem">
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            </main>
        </div>
    </section>

    <style>
        .alert-dismissible .close {
        position: absolute;
        top: 0;
        right: 0;
        padding: .75rem 1.25rem;
        color: inherit;
        }

        button.close {
            padding: 0;
            background-color: transparent;
            border: 0;
            -webkit-appearance: none;
        }

        .close {
            float: right;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;
        }
    </style>
    <script>
    function showAddressForm() {
        document.getElementById('address_form').style.display = 'block';
    }

    function hideAddressForm() {
        document.getElementById('address_form').style.display = 'none';
    }


    $(document).ready(function() {
        $(".alert .close").on('click', function(){
            $(this).closest(".alert").fadeOut();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.form-input');
        const overviewElement = document.querySelector('.form-overview');
        const submitButton = document.querySelector('.submit-button');
        const deliveryRadioButtons = document.querySelectorAll('input[name="delivery"]');
        const alertElement = document.getElementById('alert');
        const alertTextElement = document.querySelector('.alert-text');
        const deliveryCostInput = document.getElementById('delivery_cost');
        const addressInput = document.getElementById('address');
        const checkButton = document.querySelector('.check-button');
        const checkinDateInput = document.getElementById('check_in_date');
        const checkoutDateInput = document.getElementById('check_out_date');

        //Ketika ttombol check diklik, maka memanggil updateOverview
        checkButton.addEventListener('click', function() {
            const address = addressInput.value;
            if (address === '') {
                document.querySelector('.alert-text').textContent = 'Please input your address.';
                document.getElementById('alert').style.display = 'block';
            } else {
                document.getElementById('alert').style.display = 'none';
                updateOverview();
            }
        });

        
        checkinDateInput.addEventListener('change', updateOverview);

        checkoutDateInput.addEventListener('change', updateOverview);

        deliveryRadioButtons.forEach(button => {
            button.addEventListener('change', updateOverview);
        });

        submitButton.addEventListener('click', function(event) {
            event.preventDefault();

            form.appendChild(deliveryCostInput);
            form.appendChild(addressInput);
            form.submit();
        });

        function updateOverview() {
            const checkInDate = document.getElementById('check_in_date').value;
            const checkOutDate = document.getElementById('check_out_date').value;
            const delivery = document.querySelector('input[name="delivery"]:checked')?.value === 'yes';
            const address = document.getElementById('address').value;
            const jasa_ids = document.querySelector('input[name="jasa_ids[]"]').value;

            if (checkInDate && checkOutDate) {
                fetch(`/penitipan-calculate-overview?check_in_date=${checkInDate}&check_out_date=${checkOutDate}&delivery=${delivery}&address=${encodeURIComponent(address)}&jasa_ids=${jasa_ids}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            showAlert(data.error);
                            return;
                        }
                        let overviewHTML = `
                            <p style="margin-bottom: 5px;">Service: Penitipan</p>
                            <p style="margin-bottom: 5px;">menitipkan ${data.days} hari</p>
                            <p style="margin-bottom: 5px;">biaya penitipan Rp. ${data.serviceCost.toLocaleString()}</p>
                        `;
                        deliveryCostInput.value = 0;
                        if (delivery) {
                            deliveryCostInput.value = data.deliveryCost;
                            overviewHTML += `<p style="margin-bottom: 5px;">biaya delivery Rp. ${data.deliveryCost.toLocaleString()}</p>`;
                        }
                        overviewHTML += `<p style="margin-bottom: 5px;">Total: Rp. ${data.totalCost.toLocaleString()}</p>`;
                        overviewElement.innerHTML = overviewHTML;
                        hideAlert();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        overviewElement.innerHTML = `<p>Error calculating cost.</p>`;
                        showAlert('Terjadi kesalahan saat menghitung biaya.');
                });
            }
        }

        function showAlert(message) {
            alertTextElement.textContent = message;
            alertElement.style.display = 'block';
        }

        function hideAlert() {
            alertElement.style.display = 'none';
        }
    });
    </script>

@endsection
