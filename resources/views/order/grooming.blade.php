
@extends('app')

@if (!auth()->check())
    @section('content')
        <script>
            window.location = "/";
        </script>
    @endsection
@endif

@section('title', 'Grooming Order Form')

@section('content')
    <section>
        <div class="container">
            <header class="header-order">
                <h1 class="h1-order text-white">Grooming Order Form</h1>
            </header>

            <main class="container-order">
                <!-- 2/3 page -->
                <div class="left-page">
                    <div class ="form pt-2">
                        <div class="form template-paw form-order text-white">
                            <h3 class="text-uppercase h3-order">Information Form</h3>
                            <p>Provide the necessary information about your pet for grooming purposes.</p>
                            <form class="form-input" action="{{ route('order-jasa.store') }}" method="POST">
                                @csrf
                                <input type="hidden" class="form-control" id="check_out_date" name="check_out_date">
                                <input type="hidden" class="form-control" id="delivery_cost" name="delivery_cost">
                                <input type="hidden" id="jasa_ids" name="jasa_ids[]">
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
                                    <label for="check_in_date" class="col-sm-3 col-form-label">Pick Date</label>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="check_in_date" name="check_in_date" required min="{{ date('Y-m-d') }}"  onchange="syncCheckoutDate()">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Service Form -->
                    <div class="form pt-2">
                        <div class="template-paw form-order text-white">
                            <div class="service-form">
                                <h3 class="text-uppercase h3-order">Grooming Services</h3>
                                <p>Choose grooming service:</p>
                                <form class="service-form" action="{{ route('order-jasa.store') }}" method="POST">
                                    @foreach ($jasas as $index => $jasa)
                                    <label class="image-checkbox rounded animate-slide">
                                        <div class="image-container">
                                            <input type="checkbox" id="service{{ $jasa['jasa_id'] }}" value="{{ $jasa['harga'] }}" name="{{ $jasa['nama_jasa'] }}" class="service-checkbox" style="display: none;">
                                            <img src="{{ asset($jasa['image_path']) }}" alt="{{ $jasa['nama_jasa'] }} Image" class="img-fluid service-image">
                                            <p class="description" style="text-align: center">{{ $jasa['nama_jasa'] }}</p>
                                        </div>
                                    </label>
                                    @endforeach
                                </form>
                            </div>
                        </div>
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
                                        <input class="form-check-input"  checked="checked" type="radio" name="delivery" id="delivery_no" value="no" onclick="hideAddressForm()">
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

                {{-- Overview --}}
                <aside class="right-page pb-5" style="padding-right: 0px;">
                    <div class="form pt-2">
                        <div class="form template-paw form-order text-white" style="padding-top: 1px;">
                            <h3 class="text-uppercase h3-order">Product Overview</h3>
                            <div class="form-overview">
                                <p style="margin-bottom: 5px;">Service: Grooming</p>
                                <p style="margin-bottom: 5px;">Selected Grooming Service: </p>
                                <p style="margin-bottom: 5px;">Biaya Grooming Service: Rp. 0</p>
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
    .image-checkbox{
    border-radius: 5px;
    border-width: 5px;
    border-style: solid;
    border-color: rgba(255, 255, 255, 0.2) !important;
    background-image: rgba(255, 255, 255, 0.2) !important;
    margin: auto;
    }

    .image-container{
    background: rgba(255, 255, 255, 0.2) !important;
    }

    .service-image{
        border-radius: 5px;
    }

    .description{
    margin: 0%;
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


    function syncCheckoutDate() {
        var checkinDate = document.getElementById('check_in_date').value;
        document.getElementById('check_out_date').value = checkinDate;
    }


    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.form-input');
        const overviewElement = document.querySelector('.form-overview');
        const submitButton = document.querySelector('.submit-button');
        const deliveryRadioButtons = document.querySelectorAll('input[name="delivery"]');
        const addressInput = document.getElementById('address');
        const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
        const checkButton = document.querySelector('.check-button');
        const deliveryCostInput = document.getElementById('delivery_cost');

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

        serviceCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateOverview);
        });

        deliveryRadioButtons.forEach(button => {
            button.addEventListener('change', updateOverview);
        });

        submitButton.addEventListener('click', function(event) {
        event.preventDefault();

        // Bikin array lalu simpan ke hidden input jasa_ids
        const selectedServices = [];
        const checkedCheckboxes = document.querySelectorAll('.service-checkbox:checked');
        checkedCheckboxes.forEach(checkbox => {
            selectedServices.push(parseInt(checkbox.id.replace('service', ''), 10));
        });
        document.querySelectorAll('input[name="jasa_ids[]"]').forEach(input => input.remove());

        // Tambahkan input hidden baru untuk setiap jasa_id
        selectedServices.forEach(id => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'jasa_ids[]';
            hiddenInput.value = id;
            form.appendChild(hiddenInput);
        });

        form.appendChild(deliveryCostInput);
        form.appendChild(addressInput);
        form.submit();
    });


    function updateOverview() {
        const selectedServices = [];
        const checkedCheckboxes = document.querySelectorAll('.service-checkbox:checked');
        const delivery = document.querySelector('input[name="delivery"]:checked')?.value === 'yes';
        const address = document.getElementById('address').value;

        checkedCheckboxes.forEach(checkbox => {
            selectedServices.push({
                id: parseInt(checkbox.id.replace('service', '')),
                price: parseInt(checkbox.value),
                name: checkbox.name,
            });
        });

        fetch(`/grooming-calculate-overview?jasa_ids=${encodeURIComponent(JSON.stringify(selectedServices))}&delivery=${delivery}&address=${encodeURIComponent(address)}`)
            .then(response => response.json())
            .then(data => {
                let overviewHTML = `<p>Service: Grooming</p>`;
                if (selectedServices.length > 0) {
                    overviewHTML += `<p>Selected Grooming Service:</p>`;
                    selectedServices.forEach(service => {
                        overviewHTML += `<p>- ${service.name}: Rp. ${parseInt(service.price).toLocaleString()}</p>`;
                    });
                }
                deliveryCostInput.value = 0;
                overviewHTML += `<p>Biaya Grooming Service: Rp. ${data.serviceCost.toLocaleString()}</p>`;
                if (delivery) {
                    deliveryCostInput.value = data.deliveryCost;
                    overviewHTML += `<p>Biaya Delivery: Rp. ${data.deliveryCost.toLocaleString()}</p>`;
                }
                overviewHTML += `<p>Total: Rp. ${data.totalCost.toLocaleString()}</p>`;
                overviewElement.innerHTML = overviewHTML;
            })
            .catch(error => {
                console.error('Error:', error);
                overviewElement.innerHTML = `<p>Error calculating cost.</p>`;
            });
    }
});

    </script>


@endsection
