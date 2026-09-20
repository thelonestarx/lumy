<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PakanController extends Controller
{
    /**
     * Menampilkan halaman manajemen pakan
     */
    public function index()
    {
        // Data default yang dapat dipassing dari database jika ada
        $dataPakan = [
            'jumlah_ikan' => 1000,
            'jenis_ikan' => 'nila',
            'fase' => 'pembesaran',
            'berat_ikan' => 150,
            'sisa_pakan_kg' => 15.0,
            'kapasitas_maks_kg' => 20.0,
            'persentase_stok' => 75,
        ];

        return view('pakan', compact('dataPakan'));
    }

    /**
     * Menyimpan/Memperbarui threshold pengaturan pakan
     */
    public function storeThreshold(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_ikan' => 'required|string',
            'jumlah_ikan' => 'required|integer|min:1',
            'fase' => 'required|string',
            'berat_ikan' => 'required|numeric|min:1',
        ]);

        // TODO: Simpan ke Database atau kirim via MQTT/API ke ESP32

        return redirect()->back()->with('success', 'Threshold pakan berhasil diperbarui!');
    }
}