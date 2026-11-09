<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CalculatorController extends Controller
{
    public function hitungIpk(string $ip1, string $ip2): View
    {
        // Konversi input ke float
        $ip1 = (float) $ip1;
        $ip2 = (float) $ip2;

        // Logika perhitungan
        $totalIP = $ip1 + $ip2;
        $rataRataIPK = $totalIP / 2;

        // Return view Blade dan passing datanya
        return view('hitung-ipk', compact('ip1', 'ip2', 'totalIP', 'rataRataIPK'));
    }
}
