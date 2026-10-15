<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use App\Models\StokRiwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Menampilkan halaman penjualan
     */
    public function index()
    {
        $produk = Produk::with('kategori')
            ->orderBy('nama_produk')
            ->get();

        $penjualan = Penjualan::latest()
            ->get();

        return view('penjualan.index', compact(
            'produk',
            'penjualan'
        ));
    }


    /**
     * Menyimpan transaksi penjualan
     */
    public function store(Request $request)
    {
        // Validasi data pembeli dan produk
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        try {

            DB::beginTransaction();

            // Ambil produk
            // lockForUpdate mencegah stok berubah bersamaan
            $produk = Produk::where('id', $request->produk_id)
                ->lockForUpdate()
                ->firstOrFail();

            // CEK STOK
            if ($produk->stok < $request->jumlah) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Stok tidak mencukupi. ' .
                        'Stok tersedia: ' . $produk->stok .
                        ', jumlah pesanan: ' . $request->jumlah
                    );
            }

            // Simpan stok sebelum dikurangi
            $stokSebelum = $produk->stok;

            // Ambil harga
            $hargaBeli = $produk->harga_beli;
            $hargaJual = $produk->harga_jual;

            // Hitung subtotal
            $subtotal = $request->jumlah * $hargaJual;

            // Hitung modal
            $modal = $request->jumlah * $hargaBeli;

            // Hitung keuntungan
            $keuntungan = $subtotal - $modal;

            // Kurangi stok
            $produk->stok -= $request->jumlah;
            $produk->save();

            // Buat nomor invoice
            $invoice = 'INV-' . date('YmdHis');

            // Simpan transaksi utama
            $penjualan = Penjualan::create([
                'invoice' => $invoice,
                'nama_pembeli' => $request->nama_pembeli,
                'tanggal' => now()->toDateString(),
                'total' => $subtotal,
                'total_modal' => $modal,
                'total_keuntungan' => $keuntungan,
            ]);

            // Simpan detail penjualan
            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produk->id,
                'jumlah' => $request->jumlah,
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaJual,
                'subtotal' => $subtotal,
                'keuntungan' => $keuntungan,
            ]);

            // Simpan riwayat stok
            StokRiwayat::create([
                'produk_id' => $produk->id,
                'jenis' => 'penjualan',
                'jumlah' => $request->jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $produk->stok,
                'harga' => $hargaJual,
                'keterangan' => 'Penjualan ' . $invoice,
            ]);

            DB::commit();

            return redirect()
                ->route('penjualan.index')
                ->with(
                    'success',
                    'Penjualan berhasil disimpan. ' .
                    'Keuntungan: Rp ' .
                    number_format(
                        $keuntungan,
                        0,
                        ',',
                        '.'
                    )
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Penjualan gagal disimpan: ' . $e->getMessage()
                );
        }
    }


    /**
     * Menampilkan detail transaksi
     */
    public function show($id)
    {
        $penjualan = Penjualan::with([
            'detailPenjualan.produk'
        ])->findOrFail($id);

        return view(
            'penjualan.show',
            compact('penjualan')
        );
    }


    /**
     * Halaman untuk mencetak nota
     */
    public function nota($id)
    {
        $penjualan = Penjualan::with([
            'detailPenjualan.produk'
        ])->findOrFail($id);

        return view(
            'penjualan.nota',
            compact('penjualan')
        );
    }
}