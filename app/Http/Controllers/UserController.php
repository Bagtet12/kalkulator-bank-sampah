<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sampah;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        return view('pages.user.index', compact('sampah'));
    }

    public function prosesPemilihanSampah(Request $request)
    {
        try {
            $validation = $request->validate([
                'nama' => 'required|exists:sampah,id',
                'jumlah_kg' => 'required|numeric|min:0',
            ]);

            if (!$validation) {
                return view('pages.user.index')->with('Validation Error');
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

    public function dashboard($id)
    {
        $user = User::findOrFail($id);
        $dateNow = date('Y-m-d H:i:s');
        
        $transaksi = DB::select('SELECT s.nama, t.verifikasi, t.total_harga, t.jumlah_kg, t.created_at
        FROM transaksi as t
        JOIN sampah as s ON s.id = t.sampah_id
        WHERE t.user_id = ' .$user->id.' ');

        $verifiedTransaksi = DB::select('SELECT s.nama, t.verifikasi, SUM(t.total_harga) as harga, t.jumlah_kg
        FROM transaksi as t
        JOIN sampah as s ON s.id = t.sampah_id
        WHERE t.user_id = ' .$user->id.' AND t.verifikasi = "Sudah Verifikasi" 
        GROUP BY s.nama, t.verifikasi, t.total_harga, t.jumlah_kg');

        return view('pages.user.dashboard', compact('transaksi','verifiedTransaksi'));
    }
}
