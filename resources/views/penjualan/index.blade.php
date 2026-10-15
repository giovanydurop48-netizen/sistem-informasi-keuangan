<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penjualan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Penjualan</h2>
            <p class="text-muted mb-0">
                Kelola penjualan produk dan data pembeli
            </p>
        </div>

        <a href="{{ route('stok.index') }}"
        class="btn btn-secondary">
            Manajemen Stok
        </a>

    </div>


    <!-- PESAN SUCCESS -->
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <!-- PESAN ERROR -->
    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    <!-- ERROR VALIDASI -->
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- FORM PENJUALAN -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                Buat Penjualan Baru
            </h5>

        </div>

        <div class="card-body">

            <form action="{{ route('penjualan.store') }}"
                method="POST">

                @csrf

                <div class="row g-3">

                    <!-- NAMA PEMBELI -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Nama Pembeli
                        </label>

                        <input type="text"
                            name="nama_pembeli"
                            class="form-control"
                            placeholder="Masukkan nama pembeli"
                            value="{{ old('nama_pembeli') }}"
                            required>

                    </div>


                    <!-- PRODUK -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Produk
                        </label>

                        <select name="produk_id"
                                id="produk_id"
                                class="form-select"
                                required>

                            <option value="">
                                -- Pilih Produk --
                            </option>

                            @foreach($produk as $item)

                                <option value="{{ $item->id }}"
                                        data-stok="{{ $item->stok }}"
                                        data-harga="{{ $item->harga_jual }}">

                                    {{ $item->nama_produk }}
                                    -
                                    Stok: {{ $item->stok }}
                                    -
                                    Rp {{ number_format($item->harga_jual, 0, ',', '.') }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- JUMLAH -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Jumlah
                        </label>

                        <input type="number"
                            name="jumlah"
                            id="jumlah"
                            class="form-control"
                            min="1"
                            value="1"
                            required>

                    </div>


                    <!-- STOK -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Stok Tersedia
                        </label>

                        <input type="text"
                            id="stok"
                            class="form-control"
                            readonly>

                    </div>


                    <!-- TOTAL -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Total
                        </label>

                        <input type="text"
                            id="total"
                            class="form-control"
                            readonly>

                    </div>

                </div>


                <div class="mt-4">

                    <button type="submit"
                            class="btn btn-primary">

                        Simpan Penjualan

                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- RIWAYAT PENJUALAN -->
    <div class="card shadow-sm border-0">

        <div class="card-header">

            <h5 class="mb-0">
                Riwayat Penjualan
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>No</th>
                            <th>Invoice</th>
                            <th>Pembeli</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Keuntungan</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($penjualan as $key => $item)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ $item->invoice }}
                                </td>

                                <td>
                                    {{ $item->nama_pembeli }}
                                </td>

                                <td>
                                    {{ $item->tanggal }}
                                </td>

                                <td>
                                    Rp
                                    {{ number_format($item->total, 0, ',', '.') }}
                                </td>

                                <td>
                                    Rp
                                    {{ number_format($item->total_keuntungan, 0, ',', '.') }}
                                </td>

                                <td>

                                    <a href="{{ route('penjualan.show', $item->id) }}"
                                    class="btn btn-sm btn-info">

                                        Detail

                                    </a>

                                    <a href="{{ route('penjualan.nota', $item->id) }}"
                                        class="btn btn-sm btn-success"
                                        target="_blank">

                                        Print Nota

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-muted">

                                    Belum ada transaksi penjualan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- JAVASCRIPT -->
<script>

    const produk = document.getElementById('produk_id');
    const jumlah = document.getElementById('jumlah');
    const stok = document.getElementById('stok');
    const total = document.getElementById('total');


    function hitungTotal()
    {
        const pilihan =
            produk.options[produk.selectedIndex];

        const stokProduk =
            pilihan.dataset.stok || 0;

        const harga =
            pilihan.dataset.harga || 0;

        const jumlahProduk =
            jumlah.value || 0;


        stok.value = stokProduk;


        const hasil =
            harga * jumlahProduk;


        total.value =
            'Rp ' +
            new Intl.NumberFormat('id-ID').format(hasil);
    }


    produk.addEventListener(
        'change',
        hitungTotal
    );


    jumlah.addEventListener(
        'input',
        hitungTotal
    );

</script>

</body>
</html>