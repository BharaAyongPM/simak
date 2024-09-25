<?php

namespace App\Imports;

use App\Models\KalenderKerja;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class KalenderKerjaImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new KalenderKerja([
            'tanggal'    => Carbon::parse($row['tanggal']),
            'shift'      => $row['shift'],
            'jam_masuk'  => $row['jam_masuk'],
            'jam_pulang' => $row['jam_pulang'],
            'karyawan'   => $row['karyawan'], // ID karyawan dari file Excel
            'divisi'     => $row['divisi'],
            'unit'       => $row['unit'],
        ]);
    }
}
