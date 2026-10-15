<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\StokRiwayat;
use App\Models\Kas;
use App\Models\PembelianStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('stok');

        $stokMenipis = Produk::whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        )->count();

        $nilaiStok = Produk::selectRaw(
            'COALESCE(SUM(stok * harga_beli), 0) AS total'
        )->value('total');

        $saldoKas = Kas::latest('id')
            ->value('saldo_sesudah') ?? 0;

        $produk = Produk::with('kategori')
            ->orderBy('nama_produk')
            ->get();

        return view('stok.index', compact(
            'totalProduk',
            'totalStok',
            'stokMenipis',
            'nilaiStok',
            'saldoKas',
            'produk'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUK
    |--------------------------------------------------------------------------
    */

    public function produk()
    {
        $produk = Produk::with('kategori')
            ->orderBy('nama_produk')
            ->get();

        $kategori = Kategori::orderBy('nama_kategori')
            ->get();

        return view('stok.produk', compact(
            'produk',
            'kategori'
        ));
    }

   
public function storeProduk(Request $request)
{
    $request->merge([
        'kode_produk' => trim((string) $request->kode_produk),
        'nama_produk' => trim((string) $request->nama_produk),
        'satuan' => trim((string) $request->satuan),
    ]);

    $data = $request->validate([
        'kategori_id' => 'required|exists:kategoris,id',
        'kode_produk' => 'required|string|max:255|unique:produks,kode_produk',
        'nama_produk' => 'required|string|max:255',
        'satuan' => 'required|string|max:50',
        'stok_awal' => 'required|integer|min:0',
        'harga_beli' => 'required|numeric|min:0',
        'harga_jual' => 'required|numeric|min:0',
        'stok_minimum' => 'required|integer|min:0',
    ]);

    $namaSama = Produk::whereRaw(
        'LOWER(nama_produk) = ?',
        [mb_strtolower($data['nama_produk'])]
    )->exists();

    if ($namaSama) {
        return back()
            ->withInput()
            ->with(
                'error',
                'Nama produk sudah terdaftar. Gunakan produk yang sudah ada.'
            );
    }

    $produk = DB::transaction(function () use ($data) {
        $produk = Produk::create([
            'kategori_id' => $data['kategori_id'],
            'kode_produk' => $data['kode_produk'],
            'nama_produk' => $data['nama_produk'],
            'satuan' => $data['satuan'],
            'stok' => (int) $data['stok_awal'],
            'harga_beli' => $data['harga_beli'],
            'harga_jual' => $data['harga_jual'],
            'stok_minimum' => $data['stok_minimum'],
        ]);

        // Catat stok awal jika jumlahnya lebih dari nol.
        if ((int) $data['stok_awal'] > 0) {
            StokRiwayat::create([
                'produk_id' => $produk->id,
                'jenis' => 'pembelian',
                'jumlah' => (int) $data['stok_awal'],
                'stok_sebelum' => 0,
                'stok_sesudah' => (int) $data['stok_awal'],
                'harga' => (float) $data['harga_beli'],
                'keterangan' => 'Stok awal saat produk didaftarkan.',
            ]);
        }

        return $produk;
    });

    return redirect()
        ->route('stok.produk')
        ->with(
            'success',
            'Produk berhasil ditambahkan dengan stok awal ' .
            $produk->stok . ' ' . $produk->satuan . '.'
        );
}


    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    */

    public function storeKategori(Request $request)
    {
        $request->merge([
            'nama_kategori' => trim(
                (string) $request->nama_kategori
            ),
        ]);

        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $sudahAda = Kategori::whereRaw(
            'LOWER(nama_kategori) = ?',
            [mb_strtolower($data['nama_kategori'])]
        )->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Kategori tersebut sudah tersedia.');
        }

        Kategori::create([
            'nama_kategori' => $data['nama_kategori'],
            'keterangan' => $data['keterangan'] ?? null,
        ]);

        return back()->with(
            'success',
            'Kategori berhasil ditambahkan.'
        );
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->merge([
            'nama_kategori' => trim(
                (string) $request->nama_kategori
            ),
        ]);

        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $sudahAda = Kategori::whereRaw(
            'LOWER(nama_kategori) = ?',
            [mb_strtolower($data['nama_kategori'])]
        )
            ->where('id', '!=', $kategori->id)
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Nama kategori sudah digunakan.');
        }

        $kategori->update([
            'nama_kategori' => $data['nama_kategori'],
            'keterangan' => $data['keterangan'] ?? null,
        ]);

        return back()->with(
            'success',
            'Kategori berhasil diperbarui.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBELIAN / BARANG MASUK
    |--------------------------------------------------------------------------
    */

    public function pembelian(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $namaBarang = trim($data['nama_barang']);
        $jumlah = (int) $data['jumlah'];
        $harga = (float) $data['harga'];
        $satuan = trim($data['satuan']);

        return DB::transaction(function () use (
            $data,
            $namaBarang,
            $jumlah,
            $harga,
            $satuan
        ) {
            $produk = Produk::whereRaw(
                'LOWER(nama_produk) = ?',
                [mb_strtolower($namaBarang)]
            )
                ->lockForUpdate()
                ->first();

            // Produk belum terdaftar: simpan untuk diproses nanti.
            if (!$produk) {
                PembelianStok::create([
                    'produk_id' => null,
                    'kode_produk' => '',
                    'nama_produk' => $namaBarang,
                    'satuan' => $satuan,
                    'supplier' => $data['supplier'] ?? null,
                    'jumlah' => $jumlah,
                    'harga_beli' => $harga,
                    'tanggal_pembelian' => now()->toDateString(),
                    'keterangan' => $data['keterangan'] ?? null,
                    'status' => 'menunggu',
                ]);

                return redirect()
                    ->route('stok.index')
                    ->with(
                        'success',
                        'Pembelian dicatat. Produk belum terdaftar sehingga stok belum berubah.'
                    );
            }

            // Jangan mencampur satuan yang berbeda.
            if (
                mb_strtolower(trim($produk->satuan)) !==
                mb_strtolower($satuan)
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'satuan' => 'Satuan pembelian harus sama dengan satuan produk: ' .
                            $produk->satuan . '.',
                    ]);
            }

            $stokSebelum = (int) $produk->stok;
            $stokSesudah = $stokSebelum + $jumlah;

            $produk->stok = $stokSesudah;
            $produk->harga_beli = $harga;
            $produk->save();

            PembelianStok::create([
                'produk_id' => $produk->id,
                'kode_produk' => $produk->kode_produk,
                'nama_produk' => $produk->nama_produk,
                'satuan' => $satuan,
                'supplier' => $data['supplier'] ?? null,
                'jumlah' => $jumlah,
                'harga_beli' => $harga,
                'tanggal_pembelian' => now()->toDateString(),
                'keterangan' => $data['keterangan'] ?? null,
                'status' => 'diterima',
                'diterima_pada' => now(),
            ]);

            StokRiwayat::create([
                'produk_id' => $produk->id,
                'jenis' => 'pembelian',
                'jumlah' => $jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'harga' => $harga,
                'keterangan' => 'Pembelian dari ' .
                    ($data['supplier'] ?? 'distributor') .
                    '. ' . ($data['keterangan'] ?? ''),
            ]);

            $totalPembelian = $jumlah * $harga;

            $saldoSebelum = (float) (
                Kas::latest('id')
                    ->lockForUpdate()
                    ->value('saldo_sesudah') ?? 0
            );

            Kas::create([
                'jenis' => 'keluar',
                'jumlah' => $totalPembelian,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSebelum - $totalPembelian,
                'sumber' => 'pembelian',
                'keterangan' => 'Pembelian ' .
                    $produk->nama_produk .
                    ' sebanyak ' . $jumlah . ' ' . $produk->satuan,
            ]);

            return redirect()
                ->route('stok.index')
                ->with(
                    'success',
                    'Pembelian berhasil diterima. Stok ' .
                    $produk->nama_produk . ' bertambah dari ' .
                    $stokSebelum . ' menjadi ' .
                    $stokSesudah . ' ' . $produk->satuan . '.'
                );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | TERIMA PEMBELIAN
    |--------------------------------------------------------------------------
    */

    public function terimaPembelian($id)
    {
        return DB::transaction(function () use ($id) {
            $pembelian = PembelianStok::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($pembelian->status === 'diterima') {
                return back()->with(
                    'error',
                    'Pembelian ini sudah diterima sebelumnya.'
                );
            }

            $produk = null;

            if ($pembelian->produk_id) {
                $produk = Produk::where(
                    'id',
                    $pembelian->produk_id
                )
                    ->lockForUpdate()
                    ->first();
            }

            // Jika belum terhubung, cari berdasarkan nama produk.
            if (!$produk) {
                $produk = Produk::whereRaw(
                    'LOWER(nama_produk) = ?',
                    [mb_strtolower(trim($pembelian->nama_produk))]
                )
                    ->lockForUpdate()
                    ->first();
            }

            if (!$produk) {
                return back()->with(
                    'error',
                    'Produk belum terdaftar. Daftarkan produk terlebih dahulu.'
                );
            }

            if (
                mb_strtolower(trim($produk->satuan)) !==
                mb_strtolower(trim($pembelian->satuan))
            ) {
                return back()->with(
                    'error',
                    'Satuan pembelian tidak cocok dengan satuan produk.'
                );
            }

            $jumlah = (int) $pembelian->jumlah;
            $harga = (float) $pembelian->harga_beli;
            $stokSebelum = (int) $produk->stok;
            $stokSesudah = $stokSebelum + $jumlah;

            $produk->stok = $stokSesudah;
            $produk->harga_beli = $harga;
            $produk->save();

            StokRiwayat::create([
                'produk_id' => $produk->id,
                'jenis' => 'pembelian',
                'jumlah' => $jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'harga' => $harga,
                'keterangan' => 'Pembelian dari ' .
                    ($pembelian->supplier ?: 'distributor') .
                    '. ' . ($pembelian->keterangan ?? ''),
            ]);

            $saldoSebelum = (float) (
                Kas::latest('id')
                    ->lockForUpdate()
                    ->value('saldo_sesudah') ?? 0
            );

            $totalPembelian = $jumlah * $harga;

            Kas::create([
                'jenis' => 'keluar',
                'jumlah' => $totalPembelian,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSebelum - $totalPembelian,
                'sumber' => 'pembelian',
                'keterangan' => 'Pembelian ' .
                    $produk->nama_produk .
                    ' sebanyak ' . $jumlah . ' ' . $produk->satuan,
            ]);

            $pembelian->produk_id = $produk->id;
            $pembelian->kode_produk = $produk->kode_produk;
            $pembelian->status = 'diterima';
            $pembelian->diterima_pada = now();
            $pembelian->save();

            return back()->with(
                'success',
                'Pembelian diterima. Stok ' .
                $produk->nama_produk . ' sekarang ' .
                $stokSesudah . ' ' . $produk->satuan . '.'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | BARANG KELUAR
    |--------------------------------------------------------------------------
    */

    public function barangKeluar(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jenis' => 'required|in:penjualan,rusak,expired,diberikan,bsb',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($data) {
            $produk = Produk::where(
                'id',
                $data['produk_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $jumlah = (int) $data['jumlah'];

            if ($jumlah > (int) $produk->stok) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Stok ' . $produk->nama_produk .
                        ' tidak mencukupi. Stok tersedia: ' .
                        $produk->stok . ' ' . $produk->satuan . '.'
                    );
            }

            $jenis = $data['jenis'];

            $harga = $jenis === 'penjualan'
                ? (float) ($data['harga'] ?? $produk->harga_jual)
                : (float) $produk->harga_beli;

            $stokSebelum = (int) $produk->stok;
            $stokSesudah = $stokSebelum - $jumlah;

            $produk->stok = $stokSesudah;
            $produk->save();

            $keterangan = trim($data['keterangan'] ?? '');

            if ($keterangan === '') {
                $keterangan = match ($jenis) {
                    'penjualan' => 'Barang terjual',
                    'rusak' => 'Barang rusak',
                    'expired' => 'Barang kedaluwarsa',
                    'diberikan' => 'Barang diberikan',
                    'bsb' => 'Barang BSB',
                };
            }

            StokRiwayat::create([
                'produk_id' => $produk->id,
                'jenis' => $jenis,
                'jumlah' => $jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'harga' => $harga,
                'keterangan' => $keterangan,
            ]);

            if ($jenis === 'penjualan') {
                $totalPenjualan = $jumlah * $harga;

                $saldoSebelum = (float) (
                    Kas::latest('id')
                        ->lockForUpdate()
                        ->value('saldo_sesudah') ?? 0
                );

                Kas::create([
                    'jenis' => 'masuk',
                    'jumlah' => $totalPenjualan,
                    'saldo_sebelum' => $saldoSebelum,
                    'saldo_sesudah' => $saldoSebelum + $totalPenjualan,
                    'sumber' => 'penjualan',
                    'keterangan' => 'Penjualan ' .
                        $produk->nama_produk .
                        ' sebanyak ' . $jumlah . ' ' . $produk->satuan,
                ]);
            }

            return back()->with(
                'success',
                'Transaksi berhasil. Stok ' .
                $produk->nama_produk . ' sekarang ' .
                $stokSesudah . ' ' . $produk->satuan . '.'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT STOK
    |--------------------------------------------------------------------------
    */

    public function riwayat()
    {
        $riwayat = StokRiwayat::with('produk')
            ->latest()
            ->get();

        return view('stok.riwayat', compact('riwayat'));
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function transaksi()
    {
        $produk = Produk::with('kategori')
            ->orderBy('nama_produk')
            ->get();

        return view('stok.transaksi', compact('produk'));
    }

    /*
    |--------------------------------------------------------------------------
    | KEUNTUNGAN / LABA RUGI
    |--------------------------------------------------------------------------
    */

    public function keuntungan()
    {
        $penjualan = StokRiwayat::with('produk')
            ->where('jenis', 'penjualan')
            ->get();

        $kerugian = StokRiwayat::with('produk')
            ->whereIn('jenis', [
                'rusak',
                'expired',
                'diberikan',
                'bsb',
            ])
            ->get();

        $totalPenjualan = 0;
        $totalModal = 0;
        $totalKerugian = 0;

        foreach ($penjualan as $item) {
            $totalPenjualan +=
                (float) $item->jumlah * (float) $item->harga;

            if ($item->produk) {
                $totalModal +=
                    (float) $item->jumlah *
                    (float) $item->produk->harga_beli;
            }
        }

        foreach ($kerugian as $item) {
            if ($item->produk) {
                $totalKerugian +=
                    (float) $item->jumlah *
                    (float) $item->produk->harga_beli;
            }
        }

        $keuntunganKotor = $totalPenjualan - $totalModal;
        $keuntunganBersih = $keuntunganKotor - $totalKerugian;

        $saldoKas = Kas::latest('id')
            ->value('saldo_sesudah') ?? 0;

        return view('stok.keuntungan', compact(
            'totalPenjualan',
            'totalModal',
            'totalKerugian',
            'keuntunganKotor',
            'keuntunganBersih',
            'saldoKas'
        ));
    }
}
