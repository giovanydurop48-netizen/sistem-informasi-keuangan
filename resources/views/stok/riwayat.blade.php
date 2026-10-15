<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Stok</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .container {
            width: 94%;
            max-width: 1450px;
            margin: 35px auto;
        }

        /* HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .title-area h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            color: #111827;
        }

        .title-area p {
            margin: 8px 0 0;
            color: #6b7280;
            font-size: 15px;
        }

        .dashboard-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border: 1px solid #2563eb;
            border-radius: 8px;
            color: #2563eb;
            background: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .dashboard-btn:hover {
            background: #2563eb;
            color: white;
        }

        /* CARD */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 25px rgba(15, 23, 42, .07);
            overflow: hidden;
        }

        .card-header {
            padding: 22px 25px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .card-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        .transaction-count {
            background: #eef2ff;
            color: #4338ca;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* TABLE WRAPPER */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1050px;
            border-collapse: collapse;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 15px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        td {
            padding: 15px 16px;
            border-bottom: 1px solid #eef2f7;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr {
            transition: background .15s;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* DATE */
        .date {
            font-weight: 600;
            color: #111827;
            white-space: nowrap;
        }

        .time {
            display: block;
            margin-top: 4px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 400;
        }

        /* PRODUCT */
        .product-name {
            font-weight: 600;
            color: #111827;
        }

        .product-unit {
            display: block;
            margin-top: 4px;
            color: #94a3b8;
            font-size: 12px;
        }

        /* BADGE */
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-pembelian {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-penjualan {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-rusak {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-expired {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-diberikan {
            background: #ede9fe;
            color: #6d28d9;
        }

        .badge-bsb {
            background: #ffe4e6;
            color: #be123c;
        }

        /* NUMBER */
        .number {
            font-weight: 600;
            color: #334155;
        }

        .stock-before {
            color: #64748b;
        }

        .stock-after {
            font-weight: 700;
            color: #111827;
        }

        .arrow {
            margin: 0 7px;
            color: #94a3b8;
        }

        /* DESCRIPTION */
        .description {
            max-width: 330px;
            color: #64748b;
            line-height: 1.5;
        }

        /* EMPTY */
        .empty {
            padding: 55px 20px !important;
            text-align: center;
            color: #94a3b8;
        }

        .empty-icon {
            font-size: 35px;
            margin-bottom: 10px;
        }

        .empty-title {
            font-weight: 700;
            color: #475569;
            margin-bottom: 5px;
        }

        /* FOOTER */
        .table-footer {
            padding: 17px 25px;
            border-top: 1px solid #e5e7eb;
            background: #fafafa;
            color: #64748b;
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {

            .container {
                width: 96%;
                margin: 20px auto;
            }

            .page-header {
                flex-direction: column;
            }

            .title-area h1 {
                font-size: 26px;
            }

            .dashboard-btn {
                width: 100%;
                justify-content: center;
            }

            .card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .table-wrapper {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        {{-- HEADER --}}
        <div class="page-header">

            <div class="title-area">
                <h1>Riwayat Stok</h1>

                <p>
                    Semua aktivitas barang masuk dan barang keluar
                </p>
            </div>

            <a href="{{ route('dashboard') }}" class="dashboard-btn">
                ← Dashboard
            </a>

        </div>


        {{-- CARD --}}
        <div class="card">

            <div class="card-header">

                <h2 class="card-title">
                    Daftar Aktivitas Stok
                </h2>

                <div class="transaction-count">
                    {{ $riwayat->count() }} Transaksi
                </div>

            </div>


            {{-- TABLE --}}
            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>

                            <th style="width: 150px;">
                                TANGGAL & WAKTU
                            </th>

                            <th style="min-width: 180px;">
                                PRODUK
                            </th>

                            <th style="width: 130px;">
                                JENIS
                            </th>

                            <th style="width: 90px;">
                                JUMLAH
                            </th>

                            <th style="width: 180px;">
                                PERUBAHAN STOK
                            </th>

                            <th style="min-width: 300px;">
                                KETERANGAN
                            </th>

                        </tr>
                    </thead>


                    <tbody>

                        @forelse ($riwayat as $item)

                            <tr>

                                {{-- TANGGAL --}}
                                <td>

                                    <div class="date">
                                        {{ $item->created_at?->format('d/m/Y') }}
                                    </div>

                                    <span class="time">
                                        {{ $item->created_at?->format('H:i') }}
                                        WIB
                                    </span>

                                </td>


                                {{-- PRODUK --}}
                                <td>

                                    <div class="product-name">
                                        {{ $item->produk->nama_produk ?? 'Produk dihapus' }}
                                    </div>

                                    @if ($item->produk)
                                        <span class="product-unit">
                                            Satuan:
                                            {{ $item->produk->satuan ?? '-' }}
                                        </span>
                                    @endif

                                </td>


                                {{-- JENIS --}}
                                <td>

                                    @php
                                        $jenis = strtolower($item->jenis);

                                        $badgeClass = match ($jenis) {
                                            'pembelian' => 'badge-pembelian',
                                            'penjualan' => 'badge-penjualan',
                                            'rusak' => 'badge-rusak',
                                            'expired' => 'badge-expired',
                                            'diberikan' => 'badge-diberikan',
                                            'bsb' => 'badge-bsb',
                                            default => '',
                                        };

                                        $label = match ($jenis) {
                                            'pembelian' => 'Pembelian',
                                            'penjualan' => 'Penjualan',
                                            'rusak' => 'Rusak',
                                            'expired' => 'Expired',
                                            'diberikan' => 'Diberikan',
                                            'bsb' => 'BSB',
                                            default => ucfirst($jenis),
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ $label }}
                                    </span>

                                </td>


                                {{-- JUMLAH --}}
                                <td>

                                    <span class="number">
                                        {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </span>

                                </td>


                                {{-- PERUBAHAN STOK --}}
                                <td>

                                    <span class="stock-before">
                                        {{ number_format($item->stok_sebelum, 0, ',', '.') }}
                                    </span>

                                    <span class="arrow">
                                        →
                                    </span>

                                    <span class="stock-after">
                                        {{ number_format($item->stok_sesudah, 0, ',', '.') }}
                                    </span>

                                </td>


                                {{-- KETERANGAN --}}
                                <td>

                                    <div class="description">
                                        {{ $item->keterangan ?: '-' }}
                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="empty">

                                    <div class="empty-icon">
                                        📦
                                    </div>

                                    <div class="empty-title">
                                        Belum ada riwayat stok
                                    </div>

                                    <div>
                                        Aktivitas pembelian dan barang keluar
                                        akan muncul di sini.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- FOOTER --}}
            <div class="table-footer">

                Menampilkan
                <strong>{{ $riwayat->count() }}</strong>
                aktivitas stok terbaru.

            </div>

        </div>

    </div>

</body>

</html>