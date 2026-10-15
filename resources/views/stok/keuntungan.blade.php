<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Keuntungan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="mb-4">
        <h2 class="fw-bold">Laporan Keuntungan</h2>
        <p class="text-muted">
            Ringkasan penjualan dan kerugian stok
        </p>
    </div>

    <div class="row g-4">

        <!-- Total Penjualan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Penjualan</h6>

                    <h3 class="fw-bold">
                        Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Total Modal -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Modal</h6>

                    <h3 class="fw-bold">
                        Rp {{ number_format($totalModal, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Total Kerugian -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Kerugian</h6>

                    <h3 class="fw-bold">
                        Rp {{ number_format($totalKerugian, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 mt-1">

        <!-- Keuntungan Kotor -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h5 class="fw-bold">
                        Keuntungan Kotor
                    </h5>

                    <p class="text-muted">
                        Penjualan - Modal
                    </p>

                    <h2 class="fw-bold">
                        Rp {{ number_format($keuntunganKotor, 0, ',', '.') }}
                    </h2>

                </div>
            </div>
        </div>

        <!-- Keuntungan Bersih -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h5 class="fw-bold">
                        Keuntungan Bersih
                    </h5>

                    <p class="text-muted">
                        Keuntungan Kotor - Kerugian
                    </p>

                    <h2 class="fw-bold">
                        Rp {{ number_format($keuntunganBersih, 0, ',', '.') }}
                    </h2>

                </div>
            </div>
        </div>

    </div>

    <div class="mt-4">
        <a href="{{ route('stok.index') }}"
        class="btn btn-secondary">
            ← Kembali ke Dashboard
        </a>
    </div>

</div>

</body>
</html>