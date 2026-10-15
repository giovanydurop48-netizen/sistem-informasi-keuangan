<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Transaksi Stok</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <style>

        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .content {
            padding: 35px;
        }

        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .title {
            font-weight: bold;
        }

        .btn-custom {
            border-radius: 10px;
            padding: 10px 18px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 13px;
        }

        .info-box {
            border-radius: 12px;
            padding: 14px;
        }

        .money {
            font-weight: 600;
        }

    </style>

</head>


<body>

<div class="content">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="title">
                Transaksi Stok
            </h2>

            <p class="text-muted mb-0">
                Kelola barang masuk dan barang keluar.
                Tanggal dan waktu transaksi dicatat otomatis oleh sistem.
            </p>

        </div>

        <a
            href="{{ route('stok.index') }}"
            class="btn btn-outline-primary btn-custom">

            <i class="bi bi-arrow-left"></i>

            Dashboard

        </a>

    </div>


    <!-- PESAN BERHASIL -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

        </div>

    @endif


    <!-- PESAN ERROR -->

    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle"></i>

            {{ session('error') }}

        </div>

    @endif


    <!-- VALIDATION ERROR -->

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Periksa data berikut:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="row g-4">


        <!-- ===================================================== -->
        <!-- BARANG MASUK -->
        <!-- ===================================================== -->

        <div class="col-lg-6">

            <div class="card">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">

                        <div class="me-3">

                            <i class="bi bi-box-arrow-in-down fs-1 text-success"></i>

                        </div>

                        <div>

                            <h4 class="fw-bold mb-0">
                                Barang Masuk
                            </h4>

                            <small class="text-muted">
                                Catat pembelian atau barang masuk
                            </small>

                        </div>

                    </div>


                    <div class="alert alert-success info-box">

                        <i class="bi bi-info-circle"></i>

                        <strong>Alur pembelian</strong>

                        <br>

                        Masukkan nama barang terlebih dahulu.
                        Jika barang belum ada di database, sistem akan
                        membuat produk secara otomatis.

                    </div>


                    <form
                        action="{{ route('stok.pembelian') }}"
                        method="POST">

                        @csrf


                        <!-- NAMA BARANG -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Barang
                            </label>

                            <input
                                type="text"
                                name="nama_barang"
                                class="form-control"
                                value="{{ old('nama_barang') }}"
                                placeholder="Contoh: Semen 50 Kg"
                                required>

                            <small class="text-muted">
                                Jika sudah ada, stok akan ditambahkan.
                                Jika belum ada, produk dibuat otomatis.
                            </small>

                        </div>


                        <!-- JUMLAH -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                name="jumlah"
                                class="form-control"
                                value="{{ old('jumlah') }}"
                                min="1"
                                placeholder="Masukkan jumlah"
                                required>

                        </div>


                        <!-- SATUAN -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Satuan
                            </label>

                            <select
                                name="satuan"
                                class="form-select"
                                required>

                                <option value="">
                                    Pilih satuan
                                </option>

                                <option
                                    value="pcs"
                                    {{ old('satuan') == 'pcs' ? 'selected' : '' }}>
                                    Pcs
                                </option>

                                <option
                                    value="unit"
                                    {{ old('satuan') == 'unit' ? 'selected' : '' }}>
                                    Unit
                                </option>

                                <option
                                    value="buah"
                                    {{ old('satuan') == 'buah' ? 'selected' : '' }}>
                                    Buah
                                </option>

                                <option
                                    value="dus"
                                    {{ old('satuan') == 'dus' ? 'selected' : '' }}>
                                    Dus
                                </option>

                                <option
                                    value="box"
                                    {{ old('satuan') == 'box' ? 'selected' : '' }}>
                                    Box
                                </option>

                                <option
                                    value="pak"
                                    {{ old('satuan') == 'pak' ? 'selected' : '' }}>
                                    Pak
                                </option>

                                <option
                                    value="kg"
                                    {{ old('satuan') == 'kg' ? 'selected' : '' }}>
                                    Kg
                                </option>

                                <option
                                    value="liter"
                                    {{ old('satuan') == 'liter' ? 'selected' : '' }}>
                                    Liter
                                </option>

                                <option
                                    value="meter"
                                    {{ old('satuan') == 'meter' ? 'selected' : '' }}>
                                    Meter
                                </option>

                            </select>

                        </div>


                        <!-- HARGA BELI -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Harga Beli per Satuan
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="harga"
                                    class="form-control"
                                    value="{{ old('harga') }}"
                                    min="0"
                                    placeholder="Contoh: 50000"
                                    required>

                            </div>

                            <small class="text-muted">
                                Harga beli terakhir akan disimpan ke produk.
                            </small>

                        </div>


                        <!-- SUPPLIER -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Supplier
                            </label>

                            <input
                                type="text"
                                name="supplier"
                                class="form-control"
                                value="{{ old('supplier') }}"
                                placeholder="Nama supplier / pemasok">

                        </div>


                        <!-- KETERANGAN -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Keterangan
                            </label>

                            <textarea
                                name="keterangan"
                                class="form-control"
                                rows="3"
                                placeholder="Catatan pembelian jika diperlukan">{{ old('keterangan') }}</textarea>

                        </div>


                        <div class="alert alert-light border">

                            <i class="bi bi-clock-history"></i>

                            <strong>Tanggal & waktu otomatis</strong>

                            <br>

                            Sistem akan mencatat tanggal dan waktu
                            transaksi secara otomatis.

                        </div>


                        <button
                            type="submit"
                            class="btn btn-success w-100 btn-custom">

                            <i class="bi bi-cart-plus"></i>

                            Simpan Barang Masuk

                        </button>

                    </form>

                </div>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- BARANG KELUAR -->
        <!-- ===================================================== -->

        <div class="col-lg-6">

            <div class="card">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">

                        <div class="me-3">

                            <i class="bi bi-box-arrow-up fs-1 text-danger"></i>

                        </div>

                        <div>

                            <h4 class="fw-bold mb-0">
                                Barang Keluar
                            </h4>

                            <small class="text-muted">
                                Penjualan atau pengurangan stok
                            </small>

                        </div>

                    </div>


                    <div class="alert alert-danger info-box">

                        <i class="bi bi-exclamation-triangle"></i>

                        Barang keluar akan otomatis mengurangi stok.
                        Sistem tidak mengizinkan stok menjadi minus.

                    </div>


                    <form
                        action="{{ route('stok.barang-keluar') }}"
                        method="POST">

                        @csrf


                        <!-- PRODUK -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Produk
                            </label>

                            <select
                                name="produk_id"
                                id="produk_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Pilih produk
                                </option>

                                @foreach($produk as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        data-harga="{{ $item->harga_jual }}"
                                        data-stok="{{ $item->stok }}">

                                        {{ $item->kode_produk }}
                                        -
                                        {{ $item->nama_produk }}

                                        | Stok:
                                        {{ $item->stok }}
                                        {{ $item->satuan }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- JENIS -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Jenis Barang Keluar
                            </label>

                            <select
                                name="jenis"
                                id="jenis"
                                class="form-select"
                                required>

                                <option value="">
                                    Pilih jenis
                                </option>

                                <option value="penjualan">
                                    🛒 Barang Terjual
                                </option>

                                <option value="rusak">
                                    ⚠ Barang Rusak
                                </option>

                                <option value="expired">
                                    ⏰ Expired
                                </option>

                                <option value="diberikan">
                                    🎁 Diberikan
                                </option>

                                <option value="bsb">
                                    📦 BSB
                                </option>

                            </select>

                        </div>


                        <!-- HARGA JUAL -->

                        <div
                            class="mb-3"
                            id="harga-jual-wrapper"
                            style="display: none;">

                            <label class="form-label fw-semibold">
                                Harga Jual Transaksi
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="harga"
                                    id="harga"
                                    class="form-control"
                                    min="0"
                                    placeholder="Kosongkan untuk memakai harga jual produk">

                            </div>

                            <small class="text-muted">
                                Jika dikosongkan, sistem menggunakan harga jual
                                dari data produk.
                            </small>

                        </div>


                        <!-- JUMLAH -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                name="jumlah"
                                class="form-control"
                                min="1"
                                placeholder="Masukkan jumlah"
                                required>

                        </div>


                        <!-- KETERANGAN -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Keterangan / Alasan
                            </label>

                            <textarea
                                name="keterangan"
                                class="form-control"
                                rows="3"
                                placeholder="Contoh: 2 unit rusak terkena air"></textarea>

                        </div>


                        <div class="alert alert-light border">

                            <i class="bi bi-clock-history"></i>

                            <strong>Tanggal & waktu otomatis</strong>

                            <br>

                            Setiap barang keluar akan dicatat otomatis
                            ke riwayat transaksi.

                        </div>


                        <button
                            type="submit"
                            class="btn btn-danger w-100 btn-custom">

                            <i class="bi bi-dash-circle"></i>

                            Simpan Barang Keluar

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- ===================================================== -->
    <!-- PENJELASAN ALUR -->
    <!-- ===================================================== -->

    <div class="card mt-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">

                <i class="bi bi-diagram-3"></i>

                Alur Sistem

            </h5>


            <div class="row text-center">


                <div class="col-md-3">

                    <div class="p-3">

                        <i class="bi bi-cart-plus fs-1 text-success"></i>

                        <h6 class="fw-bold mt-2">
                            Pembelian
                        </h6>

                        <small class="text-muted">
                            Barang masuk otomatis menambah stok.
                        </small>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="p-3">

                        <i class="bi bi-cart-check fs-1 text-primary"></i>

                        <h6 class="fw-bold mt-2">
                            Penjualan
                        </h6>

                        <small class="text-muted">
                            Stok berkurang dan harga jual dicatat.
                        </small>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="p-3">

                        <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>

                        <h6 class="fw-bold mt-2">
                            Barang Keluar
                        </h6>

                        <small class="text-muted">
                            Rusak, expired, diberikan, dan BSB mengurangi stok.
                        </small>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="p-3">

                        <i class="bi bi-clock-history fs-1 text-secondary"></i>

                        <h6 class="fw-bold mt-2">
                            Riwayat
                        </h6>

                        <small class="text-muted">
                            Semua transaksi tersimpan dengan tanggal dan waktu.
                        </small>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>


<script>

    const jenis = document.getElementById('jenis');

    const hargaWrapper =
        document.getElementById('harga-jual-wrapper');

    const hargaInput =
        document.getElementById('harga');

    const produkSelect =
        document.getElementById('produk_id');


    function updateHargaJual()
    {
        if (jenis.value === 'penjualan') {

            hargaWrapper.style.display = 'block';

        } else {

            hargaWrapper.style.display = 'none';

            hargaInput.value = '';
        }
    }


    jenis.addEventListener(
        'change',
        updateHargaJual
    );


    produkSelect.addEventListener(
        'change',
        function () {

            if (jenis.value !== 'penjualan') {
                return;
            }

            const option =
                produkSelect.options[
                    produkSelect.selectedIndex
                ];

            const harga =
                option.dataset.harga;

            if (
                harga &&
                harga !== '0'
            ) {
                hargaInput.placeholder =
                    'Harga produk: Rp ' + harga;
            }

        }
    );

</script>


</body>

</html>