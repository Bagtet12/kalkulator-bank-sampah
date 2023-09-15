<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sampah;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sampah = Sampah::all();
        return view('pages.admin.index', compact('sampah'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validationData = $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'foto' => 'required|file|image|mimes:png,jpg,jpeg',
                'harga_kg' => 'required|numeric|min:0',
            ]);

            if (!$validationData) {
                return redirect()->route('admin.create')->withErrors($validationData)->withInput();
            }

            $file = $request->file('foto');

            $nama_file = time() . "_" . $file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'sampah_foto';
            if (!file_exists($tujuan_upload)) {
                mkdir($tujuan_upload, 0755, true);
            }
            $file->move($tujuan_upload, $nama_file);

            $saveData = Sampah::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'foto' => $nama_file,
                'harga_kg' => $request->harga_kg,
            ]);

            return redirect()->route('admin.index')->with('success', 'Berhasil Menyimpan Data');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.create')->with('error', 'Gagal Menyimpan Data' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sampah = Sampah::findOrFail($id);
        return view('pages.admin.edit', compact('sampah'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validation = $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'foto' => 'required|image|file|mimes:png,jpg,jpeg',
                'harga_kg' => 'required|numeric|min:0',
            ]);

            if (!$validation) {
                return redirect()->route('admin.edit', ['id' => $id])->withErrors($validation)->withInput();
            }

            $sampah = Sampah::findOrFail($id);
            $sampah->nama = $request->nama;
            $sampah->deskripsi = $request->deskripsi;
            $sampah->harga_kg = $request->harga_kg;

            // Check if a new photo is provided
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_file = time() . "_" . $file->getClientOriginalName();

                // Move the new photo to the folder
                $tujuan_upload = 'sampah_foto';
                if (!file_exists($tujuan_upload)) {
                    mkdir($tujuan_upload, 0755, true);
                }
                $file->move($tujuan_upload, $nama_file);

                // Update the photo field in the database
                $sampah->foto = $nama_file;
            }

            $sampah->save();

            return redirect()->route('admin.index')->with('success', 'Berhasil Mengedit data');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit', ['id' => $id])->with('error', 'Gagal Mengedit Data' . $e->getMessage());
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $sampah = Sampah::findOrFail($id);
            $sampah->delete();

            return redirect()->route('admin.index')->with('Success', 'Menghapus Data Sampah');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('Error', 'Id tidak ditemukan' . $e->getMessage());
        }
    }
}
