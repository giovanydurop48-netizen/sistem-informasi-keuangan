
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            color: #1e293b;
        }

        .content {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .category-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            background: #eef2ff;
            color: #4338ca;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-badge {
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-safe {
            background: #dcfce7;
            color: #166534;
        }

        .stock-low {
            background: #fef3c7;
            color: #92400e;
        }

        .stock-empty {
            background: #fee2e2;
            color: #991b1b;
        }

        .table th,
        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .content {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Manajemen Produk</h2>
            <p class="text-muted mb-0">
                Kelola produk, kategori, dan data stok barang.
            </p>
        </div>

        <a href="{{ route('stok.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum berhasil disimpan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-plus-circle me-2"></i>Tambah Produk
            </h5>

            <form action="{{ route('stok.produk.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">Pilih kategori</option>

                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode Produk</label>
                        <input
                            type="text"
                            name="kode_produk"
                            class="form-control"
                            value="{{ old('kode_produk') }}"
                            placeholder="Contoh: PRD-001"
                            required
                        >
                        <small class="text-muted">
                            Setiap produk harus memiliki kode unik.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input
                            type="text"
                            name="nama_produk"
                            class="form-control"
                            list="daftarNamaProduk"
                            value="{{ old('nama_produk') }}"
                            placeholder="Contoh: Semen"
                            autocomplete="off"
                            required
                        >

                        <datalist id="daftarNamaProduk">
                            @foreach($produk as $item)
                                <option value="{{ $item->nama_produk }}">
                                    {{ $item->kode_produk }}
                                </option>
                            @endforeach
                        </datalist>

                        <small class="text-muted">
                            Periksa produk yang sudah terdaftar sebelum menambahkan produk baru.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Satuan</label>
                        <select name="satuan" class="form-select" required>
                            @foreach([
                                'pcs', 'kg', 'sak', 'ret',
                                'meter', 'batang', 'liter'
                            ] as $satuan)
                                <option value="{{ $satuan }}"
                                    {{ old('satuan', 'pcs') == $satuan ? 'selected' : '' }}>
                                    {{ $satuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- KOLOM BARU: STOK AWAL -->
                    <div class="col-md-4 mb-3">
                        <label for="stok_awal" class="form-label">
                            Stok Awal
                        </label>

                        <input
                            type="number"
                            name="stok_awal"
                            id="stok_awal"
                            class="form-control"
                            value="{{ old('stok_awal', 0) }}"
                            min="0"
                            step="1"
                            required
                        >

                        <small class="text-muted">
                            Jumlah stok yang tersedia saat produk didaftarkan.
                        </small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga Beli (Rp)</label>
                        <input
                            type="number"
                            name="harga_beli"
                            class="form-control"
                            value="{{ old('harga_beli') }}"
                            min="0"
                            step="1"
                            required
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga Jual (Rp)</label>
                        <input
                            type="number"
                            name="harga_jual"
                            class="form-control"
                            value="{{ old('harga_jual') }}"
                            min="0"
                            step="1"
                            required
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stok Minimum</label>
                        <input
                            type="number"
                            name="stok_minimum"
                            class="form-control"
                            value="{{ old('stok_minimum', 5) }}"
                            min="0"
                            step="1"
                            required
                        >
                        <small class="text-muted">
                            Batas untuk status stok menipis.
                        </small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Produk
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Produk</h5>
                    <p class="text-muted small mb-0">
                        Stok saat ini dan informasi setiap produk.
                    </p>
                </div>

                <span class="badge bg-primary">
                    {{ $produk->count() }} produk
                </span>
            </div>

            <div class="mb-3">
                <input
                    type="search"
                    id="cariProduk"
                    class="form-control"
                    placeholder="Cari kode, nama, atau kategori produk..."
                >
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Stok Minimum</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                        </tr>
                    </thead>

                    <tbody id="tabelProduk">
                        @forelse($produk as $item)
                            <tr>
                                <td>{{ $item->kode_produk }}</td>

                                <td>
                                    <strong>{{ $item->nama_produk }}</strong>
                                </td>

                                <td>
                                    @if($item->kategori)
                                        <span class="category-badge">
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            Belum ada kategori
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if((int) $item->stok <= 0)
                                        <span class="stock-badge stock-empty">
                                            HABIS
                                        </span>
                                    @elseif((int) $item->stok <= (int) $item->stok_minimum)
                                        <span class="stock-badge stock-low">
                                            MENIPIS
                                        </span>
                                    @else
                                        <span class="stock-badge stock-safe">
                                            AMAN
                                        </span>
                                    @endif

                                    <div class="small mt-1">
                                        {{ number_format($item->stok, 0, ',', '.') }}
                                        {{ $item->satuan }}
                                    </div>
                                </td>

                                <td>
                                    {{ number_format($item->stok_minimum, 0, ',', '.') }}
                                    {{ $item->satuan }}
                                </td>

                                <td>
                                    Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                                </td>

                                <td>
                                    Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada produk.
                                </td>
                            </tr>
                        @endforelse

                        <tr id="tidakDitemukan" style="display:none">
                            <td colspan="7" class="text-center text-muted py-4">
                                Produk tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const inputCari = document.getElementById('cariProduk');
    const tabelProduk = document.getElementById('tabelProduk');

    const barisProduk = Array.from(
        tabelProduk.querySelectorAll('tr')
    ).filter(row => row.id !== 'tidakDitemukan');

    const pesanKosong = document.getElementById('tidakDitemukan');

    inputCari.addEventListener('input', function () {
        const kataKunci = this.value.toLowerCase().trim();
        let jumlahCocok = 0;

        barisProduk.forEach(function (baris) {
            const cocok = baris.textContent
                .toLowerCase()
                .includes(kataKunci);

            baris.style.display = cocok ? '' : 'none';

            if (cocok) {
                jumlahCocok++;
            }
        });

        pesanKosong.style.display =
            jumlahCocok === 0 ? '' : 'none';
    });
</script>

</body>
</html>
