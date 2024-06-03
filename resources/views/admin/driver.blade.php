@extends('app')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

@section('title', 'Driver')

@section('content')
<div class="container" style="padding: 40px 0 20px 0;">
    <div class="card animate template-paw text-white mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"><strong>Riwayat Pembelian User</strong></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" style="background-color: rgba(0, 0, 0, 0) !important" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Alamat</th>
                            <th>Harga Delivery</th>
                            <th>Tanggal</th>
                            <th>Jenis Layanan</th>
                            <th>Status Invoice</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filteredInvoices as $index => $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_id }}</td>
                            <td>{{ $invoice->alamat }}</td>
                            <td>{{ $invoice->harga_delivery }}</td>
                            <td>{{ $invoice->tanggal }}</td>
                            <td>{{ $invoice->layanan }}</td>
                            <td>{{ $invoice->statusText }}</td>
                            <td>
                                {{-- log ke console, isi dari button --}}
                                @if ($invoice->button == "Disabled")

                                <button type="button" class="btn btn-secondary" disabled>{{ $invoice->button }}</button>
                                @else
                                    <button type="button" class="btn btn-primary confirmButton" data-invoice-id="{{ $invoice->invoice_id }}" data-newStatus="{{ $invoice->newStatus }}">{{ $invoice->button }}</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });

    $(document).ready(function() {
        function fetchUpdatePesanan(invoiceId, newStatus) {
            $.ajax({
                url: '{{ route('updatePesanan') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    invoice_id: invoiceId,
                    newStatus: newStatus
                },
                success: function(data) {
                    if (data.error) {
                        showAlert(data.error);
                    } else {
                        showAlert('Pesanan berhasil diupdate');
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    showAlert('An error occurred while fetching the invoice details.');
                }
            });
        }

        function showAlert(message) {
            alert(message);
        }

        $(document).on('click', '.confirmButton', function() {
            const invoiceId = $(this).data('invoice-id');
            const newStatus = $(this).data('newstatus');
            fetchUpdatePesanan(invoiceId, newStatus);
        });
    });
</script>
@endsection
