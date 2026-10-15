<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Stok - STOKPRO</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6fb;
            color: #111827;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            width: 210px;
            height: 100vh;
            background: #111827;
            color: white;
            padding: 25px 15px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .menu {
            display: block;
            color: white;
            text-decoration: none;
            padding: 13px;
            margin-bottom: 7px;
            border-radius: 8px;
            font-size: 13px;
        }

        .menu:hover {
            background: #2563eb;
        }

        .menu.active {
            background: #2563eb;
        }

        /* CONTENT */

        .content {
            margin-left: 210px;
            padding: 35px;
        }

        /* HEADER */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 6px;
        }

        .header p {
            color: #6b7280;
            font-size: 13px;
        }

        /* BUTTON */

        .buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 11px 17px;
            border-radius: 7px;
            font-size: 13px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        /* ALERT */

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* CARDS */

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .card-title {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .card-number {
            font-size: 25px;
            font-weight: bold;
        }

        .red {
            color: #ef4444;
        }

        /* TABLE */

        .table-box {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h2 {
            font-size: 17px;
        }

        .table-header span {
            color: #6b7280;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 7px;
            font-size: 12px;
            color: #374151;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
        }

        td {
            padding: 13px 7px;
            font-size: 12px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        /* BADGE */

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
        }

        .aman {
            background: #159447;
            color: white;
        }

        .menipis {
            background: #ffb000;
            color: #111;
        }

        .habis {
            background: #ef4444;
            color: white;
        }

        /* AKSI */

        .aksi {
            min-width: 180px;
        }

        .aksi-button {
            display: block;
            width: 40%;
            border: none;
            padding: 10px 8px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 10px;
            font-weight: 600;
            color: white;
        }

        .btn-tambah {
            background: #2563eb;
        }

        .btn-tambah:hover {
            background: #1d4ed8;
        }

        .btn-batal {
            background: #64748b;
            display: inline-block;
            width: auto;
            margin-left: 4px;
        }

        /* FORM TAMBAH STOK */

        .form-tambah-stok {
            display: none;
            margin-top: 8px;
            padding: 10px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
        }

        .form-stok-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #374151;
        }

        .form-stok-input {
            width: 100%;
            padding: 7px;
            margin-bottom: 7px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
        }

        .form-actions {
            white-space: nowrap;
        }

        /* RESPONSIVE */

        @media(max-width: 900px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .buttons {
                flex-wrap: wrap;
            }

        }

    </style>

</head>

<body>

    {{-- SIDEBAR --}}

    <div class="sidebar">

        <div class="logo">
            📦 STOKPRO
        </div>

        <a href="{{ route('dashboard') }}" class="menu">
            ▦ Dashboard
        </a>

        <a href="{{ route('stok.index') }}" class="menu active">
            📊 Manajemen Stok
        </a>

        <a href="{{ route('stok.produk') }}" class="menu">
            📦 Produk & Kategori
        </a>

        <a href="{{ route('stok.transaksi') }}" class="menu">
            ⇆ Barang Keluar
        </a>

        <a href="{{ route('stok.riwayat') }}" class="menu">
            ◷ Riwayat Stok
        </a>

        <a href="{{ route('stok.keuntungan') }}" class="menu">
            💰 Keuntungan
        </a>

    </div>


    {{-- CONTENT --}}

    <div class="content">

        {{-- HEADER --}}

        <div class="header">

            <div>

                <h1>
                    Manajemen Stok
                </h1>

                <p>
                    Kelola produk, kategori, barang keluar,
                    dan stok akhir.
                </p>

            </div>


<div class="buttons">
    <a href="{{ route('stok.produk') }}"
        class="btn btn-primary">
        + Kelola Produk
    </a>

    <a href="{{ route('stok.transaksi') }}"
        class="btn btn-success">
        + Pembelian Barang
    </a>

    <a href="{{ route('stok.transaksi') }}"
        class="btn btn-danger">
        Barang Keluar
    </a>
</div>

        </div>


        {{-- SUCCESS --}}

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR --}}

        @if(session('error'))

            <div class="alert alert-error">
                {{ session('error') }}
            </div>

        @endif


        {{-- VALIDATION ERROR --}}

        @if($errors->any())

            <div class="alert alert-error">

                <strong>Terjadi kesalahan:</strong>

                <ul style="margin: 8px 0 0 18px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- RINGKASAN --}}

        <div class="cards">

            <div class="card">

                <div class="card-title">
                    Total Produk
                </div>

                <div class="card-number">
                    {{ $totalProduk }}
                </div>

            </div>


            <div class="card">

                <div class="card-title">
                    Total Stok
                </div>

                <div class="card-number">
                    {{ number_format($totalStok, 0, ',', '.') }}
                </div>

            </div>


            <div class="card">

                <div class="card-title">
                    Stok Menipis
                </div>

                <div class="card-number red">
                    {{ $stokMenipis }}
                </div>

            </div>

        </div>


        {{-- STOK AKHIR --}}

        <div class="table-box">

            <div class="table-header">

                <h2>
                    Stok Akhir
                </h2>

                <span>
                    Kondisi stok saat ini
                </span>

            </div>


            <table>

                <thead>

                    <tr>

                        <th>Kode</th>

                        <th>Produk</th>

                        <th>Kategori</th>

                        <th>Stok</th>

                        <th>Satuan</th>

                        {{-- STOK MINIMUM DITAMPILKAN --}}

                        <th>Stok Minimum</th>

                        <th>Harga Beli</th>

                        {{-- HARGA JUAL TIDAK DITAMPILKAN --}}

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($produk as $item)

                        <tr>

                            <td>
                                {{ $item->kode_produk }}
                            </td>

                            <td>
                                {{ $item->nama_produk }}
                            </td>

                            <td>
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td>
                                {{ number_format($item->stok, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->satuan }}
                            </td>

                            {{-- STOK MINIMUM --}}

                            <td>
                                <strong>
                                    {{ number_format($item->stok_minimum, 0, ',', '.') }}
                                </strong>
                            </td>

                            {{-- HARGA BELI --}}

                            <td>
                                Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                            </td>

                            {{-- HARGA JUAL DIHAPUS --}}


                            {{-- STATUS --}}

                            <td>

                                @if($item->stok == 0)

                                    <span class="badge habis">
                                        HABIS
                                    </span>

                                @elseif($item->stok < 50)

                                    <span class="badge menipis">
                                        MENIPIS
                                    </span>

                                @else

                                    <span class="badge aman">
                                        AMAN
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="aksi">

                                <button type="button"
                                    class="aksi-button btn-tambah"
                                    onclick="document.getElementById('formStok{{ $item->id }}').style.display='block'">

                                    + Tambah Stok

                                </button>


                                {{-- FORM TAMBAH STOK --}}

                                <div id="formStok{{ $item->id }}"
                                     class="form-tambah-stok">

                                    <form action="{{ route('stok.pembelian') }}"
                                          method="POST">

                                        @csrf

                                        {{-- DATA PRODUK --}}

                                        <input type="hidden"
                                               name="produk_id"
                                               value="{{ $item->id }}">

                                        <input type="hidden"
                                               name="nama_barang"
                                               value="{{ $item->nama_produk }}">

                                        <input type="hidden"
                                               name="satuan"
                                               value="{{ $item->satuan }}">


                                        <label class="form-stok-label">
                                            Jumlah Stok Masuk
                                        </label>

                                        <input type="number"
                                               name="jumlah"
                                               min="1"
                                               required
                                               class="form-stok-input"
                                               placeholder="Jumlah">


                                        <label class="form-stok-label">
                                            Harga Beli
                                        </label>

                                        <input type="number"
                                               name="harga"
                                               min="0"
                                               required
                                               class="form-stok-input"
                                               placeholder="Harga beli">


                                        <div class="form-actions">

                                            <button type="submit"
                                                    class="aksi-button btn-tambah"
                                                    style="display:inline-block;width:auto;">

                                                Simpan

                                            </button>


                                            <button type="button"
                                                    class="aksi-button btn-batal"
                                                    onclick="document.getElementById('formStok{{ $item->id }}').style.display='none'">

                                                Batal

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="9"
                                style="text-align:center;padding:25px;">

                                Belum ada data produk.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>