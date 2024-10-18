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
                            <div class="row g-3">
                                <!-- Nama -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Masukkan nama karyawan" required>
                                    </div>
                                </div>
                                <!-- NIK -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" name="nik" class="form-control"
                                            placeholder="Masukkan NIK" required>
                                    </div>
                                </div>
                                <!-- Divisi -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="divisi" class="form-label">Divisi</label>
                                        <select name="divisi" class="form-control select2" required>
                                            @foreach ($bagians as $bagian)
                                                <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Jabatan -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="jabatan_id" class="form-label">Jabatan</label>
                                        <select name="jabatan_id" class="form-control select2" required>
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Tanggal Masuk -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                        <input type="date" name="tgl_masuk" class="form-control" required>
                                    </div>
                                </div>
                                <!-- Unit -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="unit" class="form-label">Unit</label>
                                        <select name="unit" class="form-control select2" required>
                                            <option value="">-- Pilih Unit (Opsional) --</option>
                                            <!-- Opsi kosong -->
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Alamat -->
                                <div class="col-md-12">
                                    <div class="card p-3 shadow-sm">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat" required></textarea>
                                    </div>
                                </div>
                                <!-- No Telepon -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="no_telp" class="form-label">No Telepon</label>
                                        <input type="text" name="no_telp" class="form-control"
                                            placeholder="Masukkan nomor telepon" required>
                                    </div>
                                </div>
                                <!-- Status Karyawan -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="status_kar" class="form-label">Status Karyawan</label>
                                        <select name="status_kar" class="form-control select2" required>
                                            <option value="Karyawan">Karyawan</option>
                                            <option value="THL">THL</option>
                                            <option value="Part Time">Part Time</option>
                                            <option value="Kontrak">Kontrak</option>
                                            <option value="Mitra">Mitra</option>
                                            <option value="In Fall">In Fall</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Status Aktif -->

                                <!-- Jenis Kelamin -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="kelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="kelamin" class="form-control select2" required>
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita">Wanita</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="absensi" class="form-label">Jenis Absensi</label>
                                        <select name="absensi" class="form-control select2" required>
                                            <option value="WFO">WFO</option>
                                            <option value="WFA">WFA</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Agama -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="agama" class="form-label">Agama</label>
                                        <select name="agama" class="form-control select2" required>
                                            <option value="ISLAM">ISLAM</option>
                                            <option value="KRISTEN">KRISTEN</option>
                                            <option value="HINDU">HINDU</option>
                                            <option value="BUDHA">BUDHA</option>
                                            <option value="LAINNYA">LAINNYA</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" class="form-control" required>
                                    </div>
                                </div>
                                <!-- Gaji -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="gaji" class="form-label">Gaji</label>
                                        <input type="number" name="gaji" class="form-control" step="0.01"
                                            placeholder="Masukkan gaji" required>
                                    </div>
                                </div>
                                <!-- Shift -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="shift" class="form-label">Shift</label>
                                        <select name="shift" class="form-control select2" required>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}">{{ $shift->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Masukkan email" required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Masukkan password minimal 5 huruf" required>
                                    </div>
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

        <!-- Modal Edit Karyawan -->
        <div class="modal fade" id="editKaryawanModal" tabindex="-1" aria-labelledby="editKaryawanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKaryawanModalLabel">Edit Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="editKaryawanForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-3">
                                <!-- ID Karyawan (hidden) -->
                                <input type="hidden" name="id" id="edit-id">

                                <!-- Nama -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-name" class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control" id="edit-name"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-nik" class="form-label">NIK</label>
                                        <input type="text" name="nik" class="form-control" id="edit-nik"
                                            required>
                                    </div>
                                </div>
                                <!-- NIK -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-email" class="form-label">email</label>
                                        <input type="email" name="email" class="form-control" id="edit-email"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="edit-password">
                                    </div>
                                </div>

                                <!-- Dropdown Jabatan -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-jabatan_id" class="form-label">Jabatan</label>
                                        <select name="jabatan_id" class="form-control" id="edit-jabatan_id" required>
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Tanggal Masuk -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-tgl_masuk" class="form-label">Tanggal Masuk</label>
                                        <input type="date" name="tgl_masuk" class="form-control"
                                            id="edit-tgl_masuk" required>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="col-md-12">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" class="form-control" id="edit-alamat" rows="2" required></textarea>
                                    </div>
                                </div>

                                <!-- No Telepon -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-no_telp" class="form-label">No Telepon</label>
                                        <input type="text" name="no_telp" class="form-control" id="edit-no_telp"
                                            required>
                                    </div>
                                </div>

                                <!-- Status Karyawan -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-status_kar" class="form-label">Status Karyawan</label>
                                        <select name="status_kar" class="form-control" id="edit-status_kar" required>
                                            <option value="Karyawan">Karyawan</option>
                                            <option value="THL">THL</option>
                                            <option value="Part Time">Part Time</option>
                                            <option value="Kontrak">Kontrak</option>
                                            <option value="Mitra">Mitra</option>
                                            <option value="In Fall">In Fall</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-kelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="kelamin" class="form-control" id="edit-kelamin" required>
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita">Wanita</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Jenis ABSEN -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-absensi" class="form-label">Jenis Absen</label>
                                        <select name="absensi" class="form-control" id="edit-absensi" required>
                                            <option value="WFO">WFO</option>
                                            <option value="WFA">WFA</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Agama -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-agama" class="form-label">Agama</label>
                                        <select name="agama" class="form-control" id="edit-agama" required>
                                            <option value="ISLAM">ISLAM</option>
                                            <option value="Islam">ISLAM</option>
                                            <option value="KRISTEN">KRISTEN</option>
                                            <option value="HINDU">HINDU</option>
                                            <option value="BUDHA">BUDHA</option>
                                            <option value="LAINNYA">LAINNYA</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-tgl_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" class="form-control"
                                            id="edit-tgl_lahir" required>
                                    </div>
                                </div>

                                <!-- Gaji -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-gaji" class="form-label">Gaji</label>
                                        <input type="number" name="gaji" class="form-control" id="edit-gaji"
                                            step="0.01" required>
                                    </div>
                                </div>

                                <!-- Bagian -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-bagian" class="form-label">Bagian</label>
                                        <select name="bagian" class="form-control" id="edit-bagian" required>
                                            @foreach ($bagians as $bagian)
                                                <option value="{{ $bagian->id_bagian }}">
                                                    {{ $bagian->nama_bagian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Dropdown Unit -->
                                <div class="col-md-6">
                                    <div class="card p-3 shadow-sm">
                                        <label for="edit-unit" class="form-label">Unit</label>
                                        <select name="unit" class="form-control" id="edit-unit" required>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>





    </main>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            "data": "jabatan_name",
                            "name": "jabatan_name"
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
                $(document).ready(function() {
                    // Tangkap event saat modal edit ditampilkan
                    $('#editKaryawanModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Tombol yang diklik untuk membuka modal

                        // Ambil data dari tombol edit
                        var id = button.data('id');
                        var name = button.data('name');
                        var nik = button.data('nik');
                        var jabatan_id = button.data('jabatan');
                        var tgl_masuk = button.data('tgl_masuk');
                        var alamat = button.data('alamat');
                        var no_telp = button.data('no_telp');
                        var status_kar = button.data('status_kar');
                        var kelamin = button.data('kelamin');
                        var agama = button.data('agama');
                        var tgl_lahir = button.data('tgl_lahir');
                        var gaji = button.data('gaji');
                        var bagian = button.data('bagian');
                        var unit = button.data('unit');
                        var email = button.data('email');

                        // Isi form di modal dengan data yang diambil
                        var modal = $(this);
                        modal.find('#edit-id').val(id);
                        modal.find('#edit-name').val(name);
                        modal.find('#edit-nik').val(nik);
                        modal.find('#edit-jabatan_id').val(jabatan_id);
                        modal.find('#edit-tgl_masuk').val(tgl_masuk);
                        modal.find('#edit-alamat').val(alamat);
                        modal.find('#edit-no_telp').val(no_telp);
                        modal.find('#edit-status_kar').val(status_kar);
                        modal.find('#edit-kelamin').val(kelamin);
                        modal.find('#edit-agama').val(agama);
                        modal.find('#edit-tgl_lahir').val(tgl_lahir);
                        modal.find('#edit-gaji').val(gaji);
                        modal.find('#edit-bagian').val(bagian);
                        modal.find('#edit-unit').val(unit);
                        modal.find('#edit-email').val(email);
                        modal.find('#edit-password').val(''); // Kosongkan password

                        // Sesuaikan action URL pada form dengan ID karyawan
                        modal.find('form').attr('action', '/karyawan/' + id);
                    });
                });


            });
        </script>
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
        @if ($errors->any())
            <script>
                Swal.fire({
                    title: 'Gagal!',
                    html: `
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
    @endpush
</x-layout>
