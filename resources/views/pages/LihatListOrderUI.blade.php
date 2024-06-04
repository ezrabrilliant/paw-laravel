@extends('app')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

@section('title', 'History')

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
                                        <th>Nama Hewan</th>
                                        <th>Umur Hewan</th>
                                        <th>Berat Hewan</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Harga Jasa</th>
                                        <th>Alamat</th>
                                        <th>Harga Delivery</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($invoices as $index => $invoice)
                                        <tr>
                                            <td>{{ $invoice->invoice_id  }}</td>
                                            <td>{{ $invoice->nama_hewan }}</td>
                                            <td>{{ $invoice->umur }}</td>
                                            <td>{{ $invoice->weight }}</td>
                                            <td>{{ $invoice->tanggal_masuk }}</td>
                                            <td>{{ $invoice->tanggal_keluar }}</td>
                                            <td>Rp. {{ number_format($invoice->serviceCost, 0, ',', '.') }}</td>
                                            <td>{{ $invoice->alamat }}</td>
                                            <td>{{ $invoice->harga_delivery }}</td>
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
</script>
@endsection
