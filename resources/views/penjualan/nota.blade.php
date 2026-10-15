<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Nota {{ $penjualan->invoice }}</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            width: 80mm;
            margin: auto;
            font-size: 12px;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px 0;
        }

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
        }

        @media print {

            .no-print {
                display: none;
            }

        }

    </style>

</head>

<body>

<div class="center">

    <h2>SISTEM INFORMASI KEUNTUNGAN</h2>

    <p>
        Nota Penjualan
    </p>

</div>


<div class="line"></div>


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


<div class="line"></div>


<table>

    @foreach($penjualan->detailPenjualan as $detail)

        <tr>

            <td colspan="2">

                {{ $detail->produk->nama_produk }}

            </td>

        </tr>

        <tr>

            <td>

                {{ $detail->jumlah }}
                ×
                Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}

            </td>

            <td class="right">

                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}

            </td>

        </tr>

    @endforeach

</table>


<div class="line"></div>


<table>

    <tr>

        <td class="total">
            TOTAL
        </td>

        <td class="right total">

            Rp {{ number_format($penjualan->total, 0, ',', '.') }}

        </td>

    </tr>

</table>


<div class="line"></div>


<div class="center">

    <p>
        Terima kasih
    </p>

</div>


<div class="center no-print">

    <button onclick="window.print()">
        PRINT NOTA
    </button>

</div>


</body>

</html>