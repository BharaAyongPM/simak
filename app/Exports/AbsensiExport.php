<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\User;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\KalenderKerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell, WithTitle, WithStyles, WithEvents
{
    protected $bagian_id, $unit_id, $tanggal_awal, $tanggal_akhir;

    public function __construct($bagian_id, $unit_id, $tanggal_awal, $tanggal_akhir)
    {
        $this->bagian_id = $bagian_id;
        $this->unit_id = $unit_id;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua karyawan berdasarkan divisi dan unit
        $karyawans = User::with('bagian', 'unt')
            ->when($this->bagian_id, function ($query) {
                $query->where('divisi', $this->bagian_id);
            })
            ->when($this->unit_id, function ($query) {
                $query->where('unit', $this->unit_id);
            })
            ->get();

        $data = [];

        // Loop setiap karyawan dan isi data absensi berdasarkan tanggal
        foreach ($karyawans as $karyawan) {
            $row = [
                'nama' => $karyawan->name,
                'bagian' => $karyawan->bagian->nama_bagian ?? '-',
                'unit' => $karyawan->unt->unit ?? '-'
            ];

            // Looping untuk setiap tanggal dalam periode
            $currentDate = \Carbon\Carbon::parse($this->tanggal_awal);
            $endDate = \Carbon\Carbon::parse($this->tanggal_akhir);

            while ($currentDate->lte($endDate)) {
                $tanggal = $currentDate->format('Y-m-d');

                // Cek kalender kerja untuk tanggal ini
                $kalenderKerja = KalenderKerja::where('tanggal', $tanggal)
                    ->where('karyawan', $karyawan->id) // Sesuaikan filter jika ada
                    ->first();

                if ($kalenderKerja && $kalenderKerja->shift == 'OFF') {
                    // Jika di kalender kerja shift-nya Off, tampilkan Off
                    $row['tanggal_' . $currentDate->day] = 'OFF';
                } else {
                    // Cek absensi pada tanggal tersebut
                    $absen = Absensi::where('karyawan', $karyawan->id)
                        ->whereDate('tanggal', $tanggal) // Pastikan format tanggal benar
                        ->first();

                    if ($absen) {
                        $row['tanggal_' . $currentDate->day] = $absen->shift; // Menampilkan shift jika hadir
                    } else {
                        // Cek cuti atau izin
                        $cuti = Cuti::where('user_id', $karyawan->id)
                            ->whereDate('tanggal_mulai', '<=', $tanggal)
                            ->whereDate('tanggal_selesai', '>=', $tanggal)
                            ->first();

                        $izin = Izin::where('user_id', $karyawan->id)
                            ->whereDate('tanggal_mulai', '<=', $tanggal)
                            ->whereDate('tanggal_selesai', '>=', $tanggal)
                            ->first();

                        if ($cuti) {
                            $row['tanggal_' . $currentDate->day] = 'Cuti';
                        } elseif ($izin) {
                            $row['tanggal_' . $currentDate->day] = 'Izin';
                        } else {
                            $row['tanggal_' . $currentDate->day] = 'Alpa'; // Tidak ada kehadiran, cuti, atau izin
                        }
                    }
                }

                $currentDate->addDay(); // Tambah 1 hari dalam loop
            }

            $data[] = $row;
        }

        return collect($data); // Mengembalikan data sebagai koleksi
    }

    public function headings(): array
    {
        $headings = ['Nama Karyawan', 'Bagian', 'Unit'];

        $currentDate = \Carbon\Carbon::parse($this->tanggal_awal);
        $endDate = \Carbon\Carbon::parse($this->tanggal_akhir);

        while ($currentDate->lte($endDate)) {
            $headings[] = $currentDate->format('d'); // Tambahkan tanggal dalam format 'd' sebagai heading
            $currentDate->addDay();
        }

        return $headings;
    }

    /**
     * Mapping data yang akan di-export
     */
    public function map($row): array
    {
        return array_values($row); // Mengembalikan array dari data row
    }

    /**
     * Headings untuk file Excel
     */


    /**
     * Tentukan sel awal untuk data
     */
    public function startCell(): string
    {
        return 'A6'; // Data mulai dari baris 6
    }

    /**
     * Title untuk sheet Excel
     */
    public function title(): string
    {
        return 'Rekap Absensi';
    }

    /**
     * Gaya untuk sheet Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]], // Judul
            2 => ['font' => ['bold' => true, 'size' => 12]], // Periode
            6 => ['font' => ['bold' => true]], // Judul kolom
        ];
    }

    /**
     * Event untuk menambahkan header custom
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header Rekap Absensi
                $sheet->mergeCells('A1:J1');
                $sheet->setCellValue('A1', 'REKAP ABSENSI RS INSAN PERMATA');
                $sheet->mergeCells('A2:J2');
                $sheet->setCellValue('A2', 'PERIODE: ' . \Carbon\Carbon::parse($this->tanggal_awal)->format('d-M-Y') . ' s/d ' . \Carbon\Carbon::parse($this->tanggal_akhir)->format('d-M-Y'));

                // Set alignment
                $sheet->getStyle('A1:J2')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
