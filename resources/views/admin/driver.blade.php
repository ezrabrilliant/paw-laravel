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
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Jenis Layanan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($filteredInvoices as $index => $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_id  }}</td>
                                        <td>{{ $invoice->alamat }}</td>
                                        <td>{{ $invoice->harga_delivery }}</td>
                                        <td>{{ $invoice->tanggal_masuk }}</td>
                                        <td>{{ $invoice->tanggal_keluar }}</td>
                                        <td>{{ $invoice->layanan }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                {{ $invoice->layanan }} Pesanan ini
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</div>

<script>

    $(document).ready(function () {
            $('#dataTable').DataTable();
    });


    $(document).ready(function() {

        function fetchUpdatePesanan(invoice_id, layanan) {
            $.ajax({
                url: '{{ route('updatePesanan') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    invoice_id: invoiceId,
                    layanan: layanan
                },
                success: function(data) {
                    if (data.error) {
                        showAlert(data.error);
                    } else {
                        showAlert('Gagal mengupdate pesanan.');
                    }
                },
                error: function(xhr, status, error) {
                    showAlert('An error occurred while fetching the invoice details.');
                }
            });
        }

    });
</script>
@endsection
