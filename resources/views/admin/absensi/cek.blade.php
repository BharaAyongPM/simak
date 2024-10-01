<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='cek_absensi'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Cek Absensi"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Cek Absensi</h6>
                            </div>
                            <!-- Filter Karyawan dan Tanggal -->
                            <form method="GET" action="{{ route('admin.absensi.cek') }}" class="d-flex mb-3">
                                <div class="row">
                                    <!-- Pilih Karyawan -->
                                    <div class="col-md-4">
                                        <label for="karyawan_id" class="form-label">Pilih Karyawan:</label>
                                        <select name="karyawan_id" class="form-control select2" style="width: 200px;">
                                            <option value="">Pilih Karyawan</option>
                                            @foreach ($karyawanList as $karyawan)
                                                <option value="{{ $karyawan->id }}"
                                                    {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                                    {{ $karyawan->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter Tanggal -->
                                    <div class="col-md-3">
                                        <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
                                        <input type="date" name="tanggal_awal" class="form-control"
                                            value="{{ request('tanggal_awal', now()->startOfMonth()->toDateString()) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                                        <input type="date" name="tanggal_akhir" class="form-control"
                                            value="{{ request('tanggal_akhir', now()->endOfMonth()->toDateString()) }}">
                                    </div>

                                    <!-- Tombol Filter -->
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="absensiTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Karyawan</th>
                                            <th>Shift</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Lembur</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($absensis as $absensi)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $absensi->tanggal }}</td>
                                                <td>{{ $absensi->karyn->name ?? 'Tidak ditemukan' }}</td>
                                                <td>{{ $absensi->shift }}</td>
                                                <td>{{ $absensi->jam }}</td>
                                                <td>{{ $absensi->jam_pulang }}</td>
                                                <td>{{ $absensi->lembur }}</td>
                                                <td>{{ $absensi->status }}</td>
                                                <td>{{ $absensi->keterangan }}</td>
                                                <td>
                                                    <!-- Aksi (bisa diisi dengan tombol edit atau delete) -->
                                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data absensi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
                $('#absensiTable').DataTable({
                    "pageLength": 10,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "language": {
                        "paginate": {
                            "previous": "<",
                            "next": ">"
                        },
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Tidak ada data",
                        "zeroRecords": "Data tidak ditemukan",
                        "infoFiltered": "(disaring dari _MAX_ total data)"
                    }
                });

                // Inisialisasi Select2 untuk dropdown karyawan

            });
        </script>

        <!-- SweetAlert for success and error messages -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        </script>
    @endpush
</x-layout>
