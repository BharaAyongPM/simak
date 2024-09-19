<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
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
        $lokasi = Lokasi::with(['karyn', 'bag', 'unt'])
            ->where('karyawan', Auth::id())
            ->whereDate('tanggal', $today)
            ->first();

        // Fetch the latest attendance record for display
        $latestAbsensi = Absensi::where('karyawan', Auth::id())
            ->whereMonth('tanggal', now()->month)
            ->latest()
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
            'lat' => 'required',
            'lng' => 'required',
            'foto' => 'required',
            'lokasi' => 'required',
        ]);

        // Get today's date and the current time
        $today = now()->toDateString();
        $currentTime = now();

        // Get shift information for the current user and today's date
        $lokasi = Lokasi::where('karyawan', Auth::id())
            ->whereDate('tanggal', $today)
            ->first();

        // If no shift information is found for today, return an error
        if (!$lokasi) {
            return response()->json(['message' => 'Shift tidak ditemukan untuk hari ini.'], 400);
        }

        // Get company location (latitude and longitude) from the settings table
        $setting = Setting::first();  // Assuming there's only one settings entry

        if (!$setting) {
            return response()->json(['message' => 'Lokasi kantor tidak ditemukan.'], 400);
        }

        $kantorLat = $setting->lat;
        $kantorLng = $setting->lon;

        // Calculate the distance between user location and office location (in meters)
        $distance = $this->haversineGreatCircleDistance($request->lat, $request->lng, $kantorLat, $kantorLng);

        // If the distance is greater than 100 meters, return an error
        if ($distance > 100) {
            return response()->json(['message' => 'Anda berada di luar jangkauan untuk absen. Jarak ke kantor terlalu jauh.'], 400);
        }

        // Create a new Absensi entry
        $absensi = new Absensi();
        $absensi->tanggal = $today;  // Set today's date
        $absensi->lat = $request->lat;
        $absensi->lng = $request->lng;
        $absensi->karyawan = Auth::id();
        $absensi->jenis = 'Masuk';
        $absensi->jam = $currentTime;  // Set current time
        $absensi->lokasi = $request->lokasi;
        $absensi->shift = $lokasi->shift;  // Get shift from Lokasi table
        $absensi->ip_address = $request->ip();  // Get user's IP address

        // Determine if the user is late (dt = 1 if late, 0 otherwise)
        $jamMasukShift = Carbon::parse($lokasi->jam_masuk);  // Parse shift's jam_masuk time
        if ($currentTime->greaterThan($jamMasukShift)) {
            $absensi->dt = 1;  // Mark as late
            $absensi->keterangan = 'Datang Terlambat';
            $absensi->waktu_dt = $currentTime->diffInMinutes($jamMasukShift);  // Store the number of minutes late
        } else {
            $absensi->dt = 0;  // On time
            $absensi->keterangan = 'Tepat Waktu';
            $absensi->waktu_dt = 0;
        }

        // Upload foto absen masuk
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/absensi'), $filename);
            $absensi->fhoto = $filename;
        }

        $absensi->save();

        return response()->json([
            'message' => 'Absen Masuk berhasil disimpan!',
            'jamMasuk' => $absensi->jam->format('H:i:s'),
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
    public function absenPulang(Request $request, $id)
    {
        $absensi = Absensi::where('karyawan', Auth::id())
            ->where('jenis', 'Masuk')
            ->whereNull('jam_pulang')
            ->firstOrFail();

        $absensi->jam_pulang = now();
        $absensi->tgl_pulang = now();
        $absensi->save();

        return response()->json([
            'message' => 'Absen Pulang berhasil disimpan!',
            'jamPulang' => $absensi->jam_pulang->format('H:i:s'),
        ]);
    }
}
