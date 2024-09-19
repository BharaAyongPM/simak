<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
    public function form()
    {
        return view('dashboard.form');
    }
    public function kalender()
    {
        return view('dashboard.kalender');
    }
    public function tukarshift()
    {
        return view('dashboard.tukarshift');
    }
    public function tukardepo()
    {
        return view('dashboard.tukar_deposit');
    }
    public function dinasluar()
    {
        return view('dashboard.dinasluar');
    }
    public function datangterlambat()
    {
        return view('dashboard.datangterlambat');
    }
    public function dokumen()
    {
        return view('dashboard.dokumen');
    }
    public function pelatihan()
    {
        return view('dashboard.pelatihan');
    }
    public function historydepo()
    {
        return view('dashboard.historydepo');
    }
    public function rekappelatihan()
    {
        return view('dashboard.rekap-pelatihan');
    }
}
