<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function hitungIpk($ip1, $ip2)
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