<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='karyawan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Data Karyawan"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Data Karyawan</h6>
                            </div>
                            <!-- Tombol Tambah Karyawan -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKaryawanModal">
                                Tambah Karyawan
                            </button>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Filter Bagian dan Unit -->
                            <form id="filterForm" class="d-flex mb-3">
                                <div class="row">
                                    <!-- Filter Bagian -->
                                    <div class="col-md-3">
                                        <label for="bagian_id" class="form-label">Pilih Bagian:</label>
                                        <select name="bagian_id" id="bagian_id" class="form-control select2">
                                            <option value="">Semua Bagian</option>
                                            @foreach ($bagians as $bagian)
                                                <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter Unit -->
                                    <div class="col-md-3">
                                        <label for="unit_id" class="form-label">Pilih Unit:</label>
                                        <select name="unit_id" id="unit_id" class="form-control select2">
                                            <option value="">Semua Unit</option>
                                        </select>
                                    </div>

                                    <!-- Tombol Filter -->
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" id="applyFilter"
                                            class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Tabel Karyawan -->
                            <div class="table-responsive p-4">
                                <table id="karyawanTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Bagian</th>
                                            <th>Unit</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data akan diisi oleh DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Karyawan -->
        <div class="modal fade" id="tambahKaryawanModal" tabindex="-1" aria-labelledby="tambahKaryawanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKaryawanModalLabel">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="tambahKaryawanForm" action="{{ route('karyawan.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Input fields for new karyawan data -->
                            <div class="row">
                                <!-- Nama -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <!-- NIK -->
                                <div class="col-md-6">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" required>
                                </div>
                                <!-- Divisi -->
                                <div class="col-md-6">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <select name="divisi" class="form-control select2" required>
                                        @foreach ($bagians as $bagian)
                                            <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Jabatan -->
                                <div class="col-md-6">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" required>
                                </div>
                                <!-- Tanggal Masuk -->
                                <div class="col-md-6">
                                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                    <input type="date" name="tgl_masuk" class="form-control" required>
                                </div>
                                <!-- Unit -->
                                <div class="col-md-6">
                                    <label for="unit" class="form-label">Unit</label>
                                    <select name="unit" class="form-control select2" required>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Alamat -->
                                <div class="col-md-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2" required></textarea>
                                </div>
                                <!-- No Telepon -->
                                <div class="col-md-6">
                                    <label for="no_telp" class="form-label">No Telepon</label>
                                    <input type="text" name="no_telp" class="form-control" required>
                                </div>
                                <!-- Status Karyawan -->
                                <div class="col-md-6">
                                    <label for="status_kar" class="form-label">Status Karyawan</label>
                                    <select name="status_kar" class="form-control select2" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6">
                                    <label for="kelamin" class="form-label">Jenis Kelamin</label>
                                    <select name="kelamin" class="form-control select2" required>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <!-- Agama -->
                                <div class="col-md-6">
                                    <label for="agama" class="form-label">Agama</label>
                                    <input type="text" name="agama" class="form-control" required>
                                </div>
                                <!-- Tanggal Lahir -->
                                <div class="col-md-6">
                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" required>
                                </div>
                                <!-- Gaji -->
                                <div class="col-md-6">
                                    <label for="gaji" class="form-label">Gaji</label>
                                    <input type="number" name="gaji" class="form-control" step="0.01"
                                        required>
                                </div>
                                <!-- Shift -->
                                <div class="col-md-6">
                                    <label for="shift" class="form-label">Shift</label>
                                    <input type="text" name="shift" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    @push('js')
        <script>
            $(document).ready(function() {
                // Inisialisasi DataTables
                var table = $('#karyawanTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('karyawan.index') }}",
                        "type": "GET",
                        "data": function(d) {
                            d.bagian_id = $('#bagian_id').val(); // Mengirim filter bagian
                            d.unit_id = $('#unit_id').val(); // Mengirim filter unit
                        }
                    },
                    "columns": [{
                            "data": "DT_RowIndex",
                            "name": "DT_RowIndex",
                            "orderable": false,
                            "searchable": false
                        }, // Nomor urut
                        {
                            "data": "name",
                            "name": "name"
                        }, // Nama karyawan
                        {
                            "data": "nik",
                            "name": "nik"
                        }, // NIK karyawan
                        {
                            "data": "bagian.nama_bagian",
                            "name": "bagian.nama_bagian",
                            "defaultContent": "-"
                        }, // Bagian karyawan
                        {
                            "data": "unit_name",
                            "name": "unit_name",
                            "defaultContent": "-"
                        }, // Nama Unit dari relasi
                        {
                            "data": "jabatan",
                            "name": "jabatan"
                        }, // Jabatan karyawan
                        {
                            "data": "actions",
                            "name": "actions",
                            "orderable": false,
                            "searchable": false
                        } // Kolom aksi
                    ],
                    "pageLength": 10,
                    "lengthChange": true, // Memungkinkan pengguna memilih jumlah baris yang ditampilkan
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

                // Apply filter saat tombol "Filter" diklik
                $('#applyFilter').on('click', function() {
                    table.ajax.reload(); // Reload DataTables dengan filter baru
                });

                // Load unit berdasarkan bagian yang dipilih
                $('#bagian_id').on('change', function() {
                    let bagianId = $(this).val();
                    $('#unit_id').empty().append(
                        '<option value="">Semua Unit</option>'); // Kosongkan dropdown unit

                    if (bagianId) {
                        $.ajax({
                            url: "/get-units-by-bagian/" + bagianId,
                            type: "GET",
                            success: function(units) {
                                $.each(units, function(key, unit) {
                                    $('#unit_id').append('<option value="' + unit.id +
                                        '">' + unit.unit + '</option>');
                                });
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
</x-layout>
