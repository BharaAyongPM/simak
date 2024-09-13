<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Lokasi;
use App\Models\Setting;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AbsensiController extends Controller
{
    public function index()
    {
        $hari = hari(date('Y/m/d'));
        $iduser = Auth::id();  // Auth::id() is more concise
        $lokasi = Lokasi::all();
        $dkar = Karyawan::where('id_karyawan', $iduser)->first();
        $karyawan = Karyawan::where('id_karyawan', $iduser)->get();
        return view('absensi.index', compact('karyawan', 'hari', 'lokasi', 'dkar'));
    }

    public function listData()
    {
        $iduser = Auth::id();
        $trcogs = Absensi::where('tanggal', date("Y-m-d"))
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'asc')
            ->get();

        $data = [];
        foreach ($trcogs as $list) {
            $karyawan = Karyawan::where('id_karyawan', $list->karyawan)->first();
            $lokasi = Lokasi::where('shift', $list->shift)
                ->where('tanggal', $list->tanggal)
                ->first();

            $row = [];
            $row[] = tgl_indo($list->tanggal);
            $row[] = $list->shift;
            $row[] = $karyawan->nama;
            $row[] = $list->jam;
            $row[] = ($list->jenis == 'masuk') ? $list->lokasi : '';
            $row[] = $list->jam_pulang;
            $row[] = ($list->jenis == 'pulang') ? $list->lokasi : '';
            $row[] = $list->ip_address;
            $row[] = ($list->dt == "1") ? '<small class="label label-danger"><i class="fa fa-check"></i> Ya </small>' : '';
            $row[] = ($list->jenis == 'off') ? '<small class="label label-danger"><i class="fa fa-clock-o"></i> OFF </small>' : $list->keterangan . " - " . $list->catatan;

            $data[] = $row;
        }

        return response()->json(["data" => $data]);
    }

    public function listDataKaryawan()
    {
        $iduser = Auth::id();
        $trcogs = Absensi::where('karyawan', $iduser)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $data = [];
        foreach ($trcogs as $list) {
            $row = [];
            $row[] = tgl_indo($list->tanggal);
            $row[] = $list->shift;

            $cekmasuk = Absensi::where('karyawan', $iduser)
                ->where('jenis', 'masuk')
                ->where('tanggal', $list->tanggal)
                ->first();

            $row[] = $cekmasuk ? $cekmasuk->jam : '';

            $cekpulang = Absensi::where('karyawan', $iduser)
                ->where('jenis', 'pulang')
                ->where('tanggal', $list->tanggal)
                ->first();

            $row[] = $cekpulang ? $cekpulang->jam_pulang : 'Belum Cek Out';

            $data[] = $row;
        }

        return response()->json(["data" => $data]);
    }

    public function store(Request $request)
    {
        $iduser = Auth::id();
        $karyawan = Karyawan::where('id_karyawan', $iduser)->first();
        $setting = Setting::find(1);

        // Handling various absen types (wfh, pulang, etc.)
        if ($request['absen'] == 'wfh') {
            // Code for WFH check-in
        } elseif ($request['absen'] == 'pulang') {
            // Code for check-out
        } elseif ($request['absen'] == 'pulang_wfh') {
            // Code for WFH check-out
        } else {
            // Code for normal check-in
        }

        return response()->json(['msg' => 'success']);
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        return response()->json($absensi);
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return response()->json(['msg' => 'success']);
    }

    public function printCard(Request $request)
    {
        $detail_pembelian = Bon::whereIn('id', $request->id)->get();
        $pdf = PDF::loadView('bon.card', compact('detail_pembelian'));
        $pdf->setPaper('a5', 'landscape');
        return $pdf->stream();
    }
}
