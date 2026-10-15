<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - STOKPRO</title>

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
            font-size: 14px;
        }

        .menu:hover,
        .menu.active {
            background: #2563eb;
        }


        /* CONTENT */

        .content {
            margin-left: 210px;
            padding: 40px;
        }

        .header {
            margin-bottom: 35px;
        }

        .header h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .header p {
            color: #6b7280;
        }


        /* MENU CARDS */

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .icon {
            font-size: 35px;
            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 7px;
            font-size: 13px;
        }

        .btn:hover {
            background: #1d4ed8;
        }


        /* RESPONSIVE */

        @media(max-width: 800px) {

            .sidebar {
                width: 170px;
            }

            .content {
                margin-left: 170px;
                padding: 25px;
            }

            .cards {
                grid-template-columns: 1fr;
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


        <a href="{{ route('dashboard') }}"
           class="menu active">

            ▦ Dashboard

        </a>


        <a href="{{ route('penjualan.index') }}"
           class="menu">

            🛒 Penjualan

        </a>


        <a href="#"
           class="menu">

            📦 Pembelian

        </a>


        <a href="{{ route('stok.index') }}"
           class="menu">

            📊 Manajemen Stok

        </a>


        <a href="#"
           class="menu">

            💰 Laporan Laba/Rugi

        </a>

    </div>



    {{-- CONTENT --}}

    <div class="content">


        <div class="header">

            <h1>
                Dashboard
            </h1>

            <p>
                Sistem Informasi Keuntungan
            </p>

        </div>



        <div class="cards">


            {{-- PENJUALAN --}}

            <div class="card">

                <div class="icon">
                    🛒
                </div>

                <h2>
                    Penjualan
                </h2>

                <p>
                    Mengelola data pembeli,
                    transaksi penjualan,
                    pengurangan stok,
                    dan pencetakan nota.
                </p>

                <a href="{{ route('penjualan.index') }}"
                   class="btn">

                    Buka Penjualan →

                </a>

            </div>



            {{-- PEMBELIAN --}}

            <div class="card">

                <div class="icon">
                    📦
                </div>

                <h2>
                    Pembelian
                </h2>

                <p>
                    Mengelola data produk,
                    distributor, pembelian barang,
                    dan penambahan stok.
                </p>

                <a href="#"
                   class="btn">

                    Buka Pembelian →

                </a>

            </div>



            {{-- MANAJEMEN STOK --}}

            <div class="card">

                <div class="icon">
                    📊
                </div>

                <h2>
                    Manajemen Stok
                </h2>

                <p>
                    Mengelola produk dan kategori,
                    barang keluar, riwayat stok,
                    serta stok akhir.
                </p>

                <a href="{{ route('stok.index') }}"
                   class="btn">

                    Buka Manajemen Stok →

                </a>

            </div>



            {{-- LAPORAN --}}

            <div class="card">

                <div class="icon">
                    💰
                </div>

                <h2>
                    Laporan Laba/Rugi
                </h2>

                <p>
                    Melihat hasil penjualan,
                    total pembelian,
                    serta laporan laba atau rugi
                    berdasarkan bulan dan tahun.
                </p>

                <a href="#"
                   class="btn">

                    Buka Laporan →

                </a>

            </div>


        </div>

    </div>


</body>

</html>