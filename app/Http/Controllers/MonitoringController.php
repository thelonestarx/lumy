<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        // Data dummy untuk status saat ini
        $currentStatus = [
            'suhu' => 29.4,
            'ph' => 7.4,
            'turbidity' => 29,
        ];

        // Data dummy untuk grafik & tabel riwayat
        $historyLogs = [
            ['time' => '10:00', 'suhu' => 28.5, 'ph' => 7.1, 'turbidity' => 12, 'status' => 'Normal'],
            ['time' => '11:00', 'suhu' => 29.0, 'ph' => 7.2, 'turbidity' => 15, 'status' => 'Normal'],
            ['time' => '12:00', 'suhu' => 29.8, 'ph' => 7.5, 'turbidity' => 22, 'status' => 'Waspada'],
            ['time' => '13:00', 'suhu' => 29.4, 'ph' => 7.4, 'turbidity' => 29, 'status' => 'Darurat'],
        ];

        return view('monitoring', compact('currentStatus', 'historyLogs'));
    }
}