@extends('app')

@section('title', 'Admin Page')

@section('content')
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card animate bg-light text-white template-paw">
                    <div class="card-body p-5 text-center">
                        <div class="md-5 mt-md-4 pb-5">
                            <h2 class="fw-bold m-5 text-uppercase">Input Invoice ID</h2>
                            <form name="invoice-form" action="{{ route('search') }}" method="post" class="m-3" style="display: flex; justify-content: center;">
                                @csrf
                                <div class="col-lg-8 d-flex">
                                    <input type="text" class="form-control" id="invoice_id" name="invoice_id">
                                    <input type="submit" value="Check" class="btn btn-outline-light check-button" style="border-radius: 0.3rem; margin-left: 0.5rem;">
                                    <input type="hidden" id="jenis_jasa_hidden" name="jenis_jasa_hidden">
                                    <input type="hidden" id="newStatus_hidden" name="newStatus_hidden">
                                    <input type="hidden" id="state_check_hidden" name="state_check_hidden">
                                    <input type="hidden" id="denda_hidden" name="denda_hidden">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- detail invoice modal--}}
    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="invoiceDetails">
                        {{-- invoice details will be displayed here --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal input nomor kandang --}}
    <div class="modal fade" id="cageNumberModal" tabindex="-1" role="dialog" aria-labelledby="cageNumberModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cageNumberModalLabel">Input Cage Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cageNumberForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="cage_number">Cage Number</label>
                            <input type="text" class="form-control" id="cage_number" name="cage_number" required>
                            <input type="hidden" id="invoice_id_hidden" name="invoice_id_hidden">
                            <input type="hidden" id="checkCage" name="checkCage">
                        </div>
                        <button type="submit" class="btn btn-primary" id="cageButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal denda --}}
    <div class="modal fade" id="DendaModal" tabindex="-1" role="dialog" aria-labelledby="DendaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DendaModalLabel">Denda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="dendaDetails">
                        {{-- Denda details will be displayed here --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="payDendaButton">Pay Denda</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let alertShown = false;

            $('form[name="invoice-form"]').on('submit', function(event) {
                event.preventDefault();
                const invoiceId = $('#invoice_id').val();

                if (invoiceId === '') {
                    showAlert('Please input invoice id.');
                } else {
                    fetchInvoiceDetails(invoiceId);
                }
            });

            function fetchInvoiceDetails(invoiceId) {
                $.ajax({
                    url: '{{ route('search') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        invoice_id: invoiceId
                    },
                    success: function(data) {
                        if (data.error) {
                            showAlert(data.error);
                        } else {
                            $('#jenis_jasa_hidden').val(data.jenis_jasa);
                            $('#invoice_id_hidden').val(data.invoice_id);
                            updateModalContent(data, data.jenis_jasa);
                            $('#invoiceModal').modal('show');
                            fetchCekStatus(invoiceId, data.status);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('An error occurred while fetching the invoice details.');
                    }
                });
            }

            function fetchCekStatus(invoiceId, status) {
                $.ajax({
                    url: '{{ route('cekStatus') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        invoice_id: invoiceId,
                        status: status
                    },
                    success: function(data) {
                        if (data.error) {
                            $('#invoiceModal').modal('hide');
                            showAlert(data.error);
                        } if (data.denda){
                            $('#denda_hidden').val(data.denda);
                        }
                        else {
                            $('#newStatus_hidden').val(data.newStatus);
                            $('#state_check_hidden').val(data.state_check);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('An error occurred while fetching the invoice details.');
                    }
                });
            }

            function fetchCekTanggal(invoiceId, state_check) {
                $.ajax({
                    url: '{{ route('cekTanggal') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        invoice_id: invoiceId,
                        state_check: state_check
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            showAlert(data.message);
                        } else if (data.status == -1){
                            fetchInsertStatus(invoiceId, 10);
                        }
                        else if (data.denda != 0){
                            $('#denda_hidden').val(data.denda);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('An error occurred while fetching the invoice details.');
                    }
                });
            }

            function fetchInsertStatus(invoiceId, newStatus) {
                $.ajax({
                    url: '{{ route('insertStatus') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        invoice_id: invoiceId,
                        newStatus: newStatus
                    },
                    success: function(data) {
                        if (data.error) {
                            showAlert(data.error);
                        } else if (data.message) {
                            showAlert(data.message);
                        } else {
                            showAlert('Status has been updated.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        showAlert('An error occurred while inserting the status.');
                    }
                });
            }

            function fetchCageNumber(invoiceId, cageNumber) {
                $.ajax({
                    url: '{{ route('saveCageNumber') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        invoice_id: invoiceId,
                        cage_number: cageNumber

                    },
                    success: function(data) {
                        $('#checkCage').val(data.checkCage);
                        if (data.error) {
                            showAlert(data.error);
                        } else {
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('An error occurred while fetching the invoice details.');
                    }
                });
            }

            function fetchPaidDenda(invoiceId) {
                $.ajax({
                    url: '{{ route('PaidDenda') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        invoice_id: invoiceId
                    },
                    success: function(data) {
                        if (data.error) {
                            showAlert(data.error);
                        } else {
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('An error occurred while fetching the invoice details.');
                    }
                });
            }

            function showAlert(message) {
                if (!alertShown) {
                    alertShown = true;
                    alert(message);
                    setTimeout(function() {
                        alertShown = false;
                    }, 500);
                }
            }

            function updateModalContent(data, jenis_jasa) {
                if(jenis_jasa === 'penitipan') {
                    invoiceModalLabel.innerHTML = 'Penitipan Details';
                } else {
                    invoiceModalLabel.innerHTML = 'Grooming Details';
                }
                console.log(data)
                let detailsHtml = `
                    <p><strong>Invoice ID:</strong> ${data.invoice_id}</p>
                    <p><strong>Customer Name:</strong> ${data.nama_hewan}</p>
                    <p><strong>Biaya Delivery:</strong> ${data.harga_delivery}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                    <p><strong>Ordered At:</strong> ${data.tanggal_masuk}</p>
                `;

                if (jenis_jasa === 'penitipan') {
                    detailsHtml += `<p><strong>Out At:</strong> ${data.tanggal_keluar}</p>`;
                }

                $('#invoiceDetails').html(detailsHtml);
            }

            function updateModalDenda(denda){
                let detailsHtml = `
                    <p>jumlah <strong>Denda</strong> yang harus dibayar customer :  ${denda.denda}</p>
                `;

                $('#dendaDetails').html(detailsHtml);
            }

            $('#nextButton').on('click', function() {
                const invoiceId = $('#invoice_id').val();
                const state_check = $('#state_check_hidden').val();
                fetchCekTanggal(invoiceId, state_check);
                const jenisJasa = $('#jenis_jasa_hidden').val();
                console.log(jenisJasa);
                if ($('#denda_hidden').val() != 0) {
                    console.log('masuk denda');
                    updateModalDenda($('#denda_hidden').val());
                    $('#DendaModal').modal('show');
                } else if ($('#state_check_hidden').val() == 'Check In'){
                    if (jenisJasa === 'penitipan') {
                        console.log('masuk penitipan');
                        $('#cageNumberModal').modal('show');
                        $('#invoiceModal').modal('hide');
                    } else {
                        console.log('masuk grooming');
                        const invoiceId = $('#invoice_id').val();
                        fetchInsertStatus(invoiceId, $('#newStatus_hidden').val());
                    }
                } else {
                    const invoiceId = $('#invoice_id').val();
                    console.log('masuk terluar');
                    fetchInsertStatus(invoiceId, $('#newStatus_hidden').val());
                }
            });

            $('#cageButton').on('click', function() {
                console.log('masuk cage');
                $invoice_id = $('#invoice_id_hidden').val();
                $cage_number = $('#cage_number').val();
                fetchCageNumber($('#invoice_id_hidden').val(), $('#cage_number').val());
                if($('#checkCage').val() == 1){
                    fetchInsertStatus($('#invoice_id_hidden').val(), 3);
                }
                $('#cageNumberModal').modal('hide');
            });

            $('#payDendaButton').on('click', function() {
                $('#DendaModal').modal('hide');
                fetchPaidDenda($('#invoice_id').val());
            });
        });
    </script>
@endsection
