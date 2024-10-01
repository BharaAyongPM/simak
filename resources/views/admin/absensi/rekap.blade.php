<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='rekap_absensi'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Rekap Absensi"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Rekap Absensi</h6>
                            </div>
                            <!-- Filter Bagian, Unit, dan Tanggal -->
                            <form method="GET" action="{{ route('admin.absensi.rekap') }}" class="d-flex mb-3">
                                <div class="row">
                                    <!-- Pilih Bagian -->
                                    <div class="col-md-3">
                                        <label for="bagian_id" class="form-label">Pilih Bagian:</label>
                                        <select name="bagian_id" class="form-control select2" style="width: 200px;">
                                            <option value="">Pilih Bagian</option>
                                            @foreach ($bagians as $bagian)
                                                <option value="{{ $bagian->id_bagian }}"
                                                    {{ request('id_bagian') == $bagian->id_bagian ? 'selected' : '' }}>
                                                    {{ $bagian->nama_bagian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Pilih Unit -->
                                    <div class="col-md-3">
                                        <label for="unit_id" class="form-label">Pilih Unit:</label>
                                        <select name="unit_id" class="form-control select2">
                                            <option value="">Semua Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter Tanggal Awal -->
                                    <div class="col-md-3">
                                        <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
                                        <input type="date" name="tanggal_awal" class="form-control"
                                            value="{{ request('tanggal_awal', now()->startOfMonth()->toDateString()) }}">
                                    </div>

                                    <!-- Filter Tanggal Akhir -->
                                    <div class="col-md-3">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                                        <input type="date" name="tanggal_akhir" class="form-control"
                                            value="{{ request('tanggal_akhir', now()->endOfMonth()->toDateString()) }}">
                                    </div>

                                    <!-- Tombol Filter -->

                                </div>
                            </form>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="rekapAbsensiTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Karyawan</th>
                                            <th>Bagian</th>
                                            <th>Unit</th>
                                            <th>Shift</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Lembur</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($absensis as $absensi)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $absensi->tanggal }}</td>
                                                <td>{{ $absensi->karyn->name ?? 'Tidak ditemukan' }}</td>
                                                <td>{{ $absensi->karyn->bagian->nama_bagian ?? '-' }}</td>
                                                <td>{{ $absensi->karyn->unit->nama_unit ?? '-' }}</td>
                                                <td>{{ $absensi->shift }}</td>
                                                <td>{{ $absensi->jam_masuk }}</td>
                                                <td>{{ $absensi->jam_pulang }}</td>
                                                <td>{{ $absensi->lembur }}</td>
                                                <td>{{ $absensi->status }}</td>
                                                <td>{{ $absensi->keterangan }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada data absensi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $absensis->links() }}
                            </div>

                            <!-- Tombol Export Excel -->
                            <div class="mt-3">
                                <a href="{{ route('admin.absensi.export', ['bagian_id' => request('bagian_id'), 'unit_id' => request('unit_id'), 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                                    class="btn btn-success">Export Excel</a>
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
                $('#rekapAbsensiTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('admin.absensi.rekap') }}",
                        "type": "GET",
                        "data": function(d) {
                            d.bagian_id = $('select[name="bagian_id"]').val();
                            d.unit_id = $('select[name="unit_id"]').val();
                            d.tanggal_awal = $('input[name="tanggal_awal"]').val();
                            d.tanggal_akhir = $('input[name="tanggal_akhir"]').val();
                        }
                    },
                    "columns": [{
                            "data": "no"
                        }, // Nomor urut
                        {
                            "data": "tanggal"
                        }, // Tanggal
                        {
                            "data": "karyawan_name",
                            defaultContent: "Data tidak ditemukan"
                        }, // Nama Karyawan
                        {
                            "data": "bagian_name",
                            defaultContent: "-"
                        }, // Nama Bagian
                        {
                            "data": "unit",

                        }, // Nama Unit
                        {
                            "data": "shift"
                        }, // Shift
                        {
                            "data": "jam"
                        }, // Jam Masuk
                        {
                            "data": "jam_pulang"
                        }, // Jam Pulang
                        {
                            "data": "lembur",
                            defaultContent: "-"
                        }, // Lembur
                        {
                            "data": "status",
                            defaultContent: "-"
                        }, // Status
                        {
                            "data": "keterangan",
                            defaultContent: "-"
                        } // Keterangan
                    ],
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

                // Re-fetch DataTables data when filter is applied
                $('.select2, input[type="date"]').on('change', function() {
                    $('#rekapAbsensiTable').DataTable().ajax.reload();
                });
            });
        </script>
    @endpush
</x-layout>
