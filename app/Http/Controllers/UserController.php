<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sampah;
use App\Models\Transaksi;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sampah = Sampah::all();
        return redirect()->route('user.index', compact('sampah'));
    }

    public function prosesPemilihanSampah(Request $request)
    {
        try {
            $validation = $request->validate([
                'nama' => 'required|exists:sampah,id',
                'jumlah_kg' => 'required|numeric|min:0',
            ]);

            if (!$validation) {
                return redirect()->route('user.index')->withErrors($validation)->withInput();
            }

            $jenisSampah = Sampah::findOrFail($request->nama);
            $hargaPerKg = $jenisSampah->harga_kg;

            $totalHarga = $hargaPerKg * $request->jumlah_kg;

            $transaksi = new Transaksi;
            $transaksi->sampah_id = $request->nama;
            $transaksi->jumlah_kg = $request->jumlah_kg;
            $transaksi->total_harga = $totalHarga;
            $transaksi->user_id = auth()->user()->id;
            $transaksi->save();

            return view('pages.user.hasil', compact('totalHarga'))->with('Success', 'Transaksi berhasil. Total harga: Rp ' . $totalHarga);
        } catch (\Exception $e) {
            return view('pages.user.index')->with('Error', 'Terjadi Kesalahan Server' . $e->getMessage());
        }
    }

    public function dashboard()
    {
        $transaksi = Transaksi::all();
        return view('pages.user.dashboard', compact('transaksi'));
    }
}
