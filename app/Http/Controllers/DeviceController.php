<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Menampilkan halaman Device
     */
    public function index()
    {
        $deviceData = [
            'device_name' => 'ESP32-SIMONAT',
            'status' => 'connected',

            // Data monitoring perangkat
            'ph' => 7.2,
            'temperature' => 28.5,
            'turbidity' => 12,
            'feed_weight' => 2.4,

            // Status kontrol
            'pump_status' => 'AKTIF (Auto)',
            'auto_filter' => true,
            'auto_feeder' => true,

            // Pengaturan pakan
            'feed_schedule' => '16:00 WIB',
            'feed_dose' => 150,
        ];

        return view('device', compact('deviceData'));
    }

    /**
     * Kontrol pemberian pakan manual
     */
    public function feed(Request $request)
    {
        $validated = $request->validate([
            'target_grams' => 'required|numeric|min:1',
        ]);

        $targetGrams = $validated['target_grams'];

        // TODO:
        // Kirim perintah ke ESP32 melalui MQTT/API
        // Contoh:
        // MQTT -> ESP32 -> motor DC / feeder

        return redirect()
            ->route('device')
            ->with('success', "Perintah pemberian pakan {$targetGrams} gram berhasil dikirim.");
    }

    /**
     * Kontrol mode otomatis pompa filtrasi
     */
    public function filter(Request $request)
    {
        $validated = $request->validate([
            'auto_filter' => 'required|boolean',
        ]);

        $autoFilter = $validated['auto_filter'];

        // TODO:
        // Kirim status auto filter ke ESP32 melalui MQTT/API

        return redirect()
            ->route('device')
            ->with(
                'success',
                $autoFilter
                    ? 'Mode otomatis pompa berhasil diaktifkan.'
                    : 'Mode otomatis pompa berhasil dinonaktifkan.'
            );
    }

    /**
     * Override manual pompa
     */
    public function manualPump()
    {
        // TODO:
        // Kirim perintah ON/OFF pompa ke ESP32 melalui MQTT/API

        return redirect()
            ->route('device')
            ->with('success', 'Perintah override manual pompa berhasil dikirim.');
    }
}