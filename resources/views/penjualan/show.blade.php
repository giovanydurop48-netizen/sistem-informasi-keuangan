<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Detail Penjualan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm">

        <div class="card-body">

            <h3 class="fw-bold">
                Detail Penjualan
            </h3>

            <hr>

            <p>
                <strong>Invoice:</strong>
                {{ $penjualan->invoice }}
            </p>

            <p>
                <strong>Pembeli:</strong>
                {{ $penjualan->nama_pembeli }}
            </p>

            <p>
                <strong>Tanggal:</strong>
                {{ $penjualan->tanggal }}
            </p>


            <table class="table table-bordered mt-4">

                <thead class="table-dark">

                    <tr>

                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Keuntungan</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($penjualan->detailPenjualan as $detail)

                        <tr>

                            <td>
                                {{ $detail->produk->nama_produk }}
                            </td>

                            <td>
                                {{ $detail->jumlah }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($detail->harga_jual, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($detail->keuntungan, 0, ',', '.') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>


            <div class="text-end">

                <h5>
                    Total:
                    Rp {{ number_format($penjualan->total, 0, ',', '.') }}
                </h5>

                <h5>
                    Modal:
                    Rp {{ number_format($penjualan->total_modal, 0, ',', '.') }}
                </h5>

                <h5 class="text-success">

                    Keuntungan:
                    Rp {{ number_format($penjualan->total_keuntungan, 0, ',', '.') }}

                </h5>

            </div>


            <a href="{{ route('penjualan.index') }}"
               class="btn btn-secondary mt-3">

                Kembali

            </a>

        </div>

    </div>

</div>

</body>

</html>