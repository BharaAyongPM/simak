<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\KalenderKerja;
use App\Models\Karyawan;
use App\Models\Lokasi;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AbsensiController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');

        // Fetch today's shift information for the logged-in user
        $lokasi = KalenderKerja::with(['karyn', 'bag', 'unt'])
            ->where('karyawan', Auth::id())
            ->whereDate('tanggal', $today)
            ->first();

        // Fetch the latest attendance record for display
        $latestAbsensi = Absensi::where('karyawan', Auth::id())
            ->whereDate('tanggal', $today)  // Ensure it's only for today
            ->first();

        // Fetch all attendance records for the current month
        $absensi = Absensi::where('karyawan', Auth::id())
            ->whereMonth('tanggal', now()->month)
            ->get();

        // Fetch setting data to get office latitude and longitude
        $setting = Setting::first();  // Assuming there's only one setting record

        // Pass lokasi, latestAbsensi, absensi, and setting data to the view
        return view('absensi.index', compact('lokasi', 'latestAbsensi', 'absensi', 'setting'));
    }
    // Fungsi untuk mencatat absensi masuk
    public function absenMasuk(Request $request)
    {
        $validatedData = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi' => 'required|string',
        ]);

        $today = now()->toDateString();
        $currentTime = now();

        // Pastikan user belum absen hari ini
        $existingAbsensi = Absensi::where('karyawan', Auth::id())
            ->where('tanggal', $today)
            ->where('jenis', 'Masuk')
            ->first();

        if ($existingAbsensi) {
            return response()->json(['message' => 'Anda sudah absen masuk hari ini.'], 400);
        }

        // Ambil informasi shift untuk user
        $lokasi = KalenderKerja::where('karyawan', Auth::id())
            ->whereDate('tanggal', $today)
            ->first();

        if (!$lokasi) {
            return response()->json(['message' => 'Shift tidak ditemukan untuk hari ini.'], 400);
        }

        // Ambil lokasi kantor dari tabel settings
        $setting = Setting::first();

        if (!$setting || !$setting->lat || !$setting->lon) {
            return response()->json(['message' => 'Lokasi kantor tidak ditemukan atau belum diatur.'], 400);
        }

        // Kalkulasi jarak lokasi user dan kantor
        $kantorLat = $setting->lat;
        $kantorLng = $setting->lon;
        $distance = $this->haversineGreatCircleDistance($request->lat, $request->lng, $kantorLat, $kantorLng);

        if ($distance > 100) {
            return response()->json(['message' => 'Anda berada di luar jangkauan untuk absen.'], 400);
        }

        // Buat entri absensi baru
        $absensi = new Absensi();
        $absensi->tanggal = $today;
        $absensi->lat = $request->lat;
        $absensi->lng = $request->lng;
        $absensi->karyawan = Auth::id();
        $absensi->jenis = 'Masuk';
        $absensi->jam = $currentTime;
        $absensi->lokasi = $request->lokasi;
        $absensi->shift = $lokasi->shift;
        $absensi->ip_address = $request->ip();

        // Cek keterlambatan
        $jamMasukShift = Carbon::parse($lokasi->jam_masuk);
        if ($currentTime->greaterThan($jamMasukShift)) {
            $absensi->dt = 1;
            $absensi->keterangan = 'Datang Terlambat';
            $absensi->waktu_dt = $currentTime->diffInMinutes($jamMasukShift);
        } else {
            $absensi->dt = 0;
            $absensi->keterangan = 'Tepat Waktu';
            $absensi->waktu_dt = 0;
        }

        // Upload foto absen
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if ($file->isValid()) {
                $filename = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/absensi'), $filename);
                $absensi->foto = $filename;
            } else {
                return response()->json(['message' => 'Gagal mengunggah foto.'], 500);
            }
        }

        $absensi->save();

        return response()->json([
            'message' => 'Absen Masuk berhasil disimpan!',
            'jamMasuk' => $absensi->jam->format('H:i:s'),
            'absenId' => $absensi->id,  // Kembalikan ID absen untuk digunakan saat absen pulang
        ]);
    }
    private function haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2, $earthRadius = 6371000)
    {
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius; // Jarak dalam meter
    }

    // Fungsi untuk mencatat absensi pulang
    public function absenPulang(Request $request)
    {
        // Cari absensi untuk karyawan yang login dengan tanggal hari ini
        $absensi = Absensi::where('karyawan', Auth::id())
            ->where('tanggal', now()->toDateString())
            ->where('jenis', 'Masuk')  // Pastikan absensi jenis "Masuk" (karena yang akan di-update adalah absen masuk)
            ->first();

        // Jika absensi tidak ditemukan
        if (!$absensi) {
            return response()->json(['message' => 'Absensi masuk tidak ditemukan untuk hari ini.'], 404);
        }

        // Update jam pulang
        $absensi->jam_pulang = now();
        $absensi->save();

        return response()->json([
            'message' => 'Absen Pulang berhasil disimpan!',
            'jamPulang' => $absensi->jam_pulang->format('H:i:s'),
        ]);
    }
}
