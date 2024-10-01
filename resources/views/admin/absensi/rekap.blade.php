<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='rekap_absensi'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Rekap Absensi"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Rekap Absensi</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Form Filter karyawan dan periode -->
                            <form method="GET" action="{{ route('admin.absensi.rekap') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="karyawan_id">Pilih Karyawan</label>
                                        <select name="karyawan_id" class="form-control select2">
                                            <option value="">Semua Karyawan</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tanggal_awal">Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" class="form-control"
                                            value="{{ $tanggalAwal }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tanggal_akhir">Tanggal Akhir</label>
                                        <input type="date" name="tanggal_akhir" class="form-control"
                                            value="{{ $tanggalAkhir }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Tabel Rekap Absensi -->
                            <div class="table-responsive p-4">
                                <table id="rekapAbsensiTable" class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Karyawan</th>
                                            <th>Shift</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Lembur</th>
                                            <th>Status (Izin/Sakit)</th>
                                            <th>Cuti Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($absensis as $index => $absensi)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-M-Y') }}</td>
                                                <td>{{ $absensi->user->name ?? 'Data tidak ditemukan' }}</td>
                                                <td>{{ $absensi->shift }}</td>
                                                <td>{{ $absensi->jam_masuk }}</td>
                                                <td>{{ $absensi->jam_pulang }}</td>
                                                <td>{{ $absensi->lembur ?? '-' }}</td>
                                                <td>{{ $absensi->status_izin_sakit ?? '-' }}</td>
                                                <td>{{ $absensi->cuti_keterangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="mt-3">
                                    {{ $absensis->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('js')
        <!-- Include DataTables -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <!-- Include Select2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <!-- Initialize DataTables and Select2 -->
        <script>
            $(document).ready(function() {
                // Inisialisasi DataTables
                $('#rekapAbsensiTable').DataTable({
                    "paging": false, // Paginasi DataTables dinonaktifkan karena kita menggunakan paginasi Laravel
                    "info": false,
                    "searching": true
                });

                // Inisialisasi Select2
                $('.select2').select2({
                    width: '100%',
                });
            });
        </script>
    @endpush
</x-layout>
