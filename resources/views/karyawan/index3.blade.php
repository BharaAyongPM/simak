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

                        <!-- Filter Bagian dan Unit -->
                        <div class="card-body px-0 pt-0 pb-2">
                            <form id="filterForm" class="d-flex mb-3">
                                <div class="row">
                                    <!-- Filter Bagian -->
                                    <div class="col-md-4">
                                        <label for="bagian" class="form-label">Filter Bagian</label>
                                        <select id="filterBagian" class="form-control select2" style="width: 100%;">
                                            <option value="">Semua Bagian</option>
                                            @foreach ($bagians as $bagian)
                                                <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter Unit -->
                                    <div class="col-md-4">
                                        <label for="unit" class="form-label">Filter Unit</label>
                                        <select id="filterUnit" class="form-control select2" style="width: 100%;">
                                            <option value="">Semua Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tombol Apply Filter -->
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Tabel Data Karyawan -->
                            <div class="table-responsive p-4">
                                <table id="karyawanTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Bagian</th>
                                            <th>Unit</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data akan dimuat dengan AJAX dari DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
                                    <option value="">Pilih Divisi</option>
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

                            <!-- Alamat -->
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control">
                            </div>

                            <!-- No Telp -->
                            <div class="col-md-6">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" name="no_telp" class="form-control" required>
                            </div>

                            <!-- Status Karyawan -->
                            <div class="col-md-6">
                                <label for="status_kar" class="form-label">Status Karyawan</label>
                                <select name="status_kar" class="form-control" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <!-- Kelamin -->
                            <div class="col-md-6">
                                <label for="kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="kelamin" class="form-control" required>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- Agama -->
                            <div class="col-md-6">
                                <label for="agama" class="form-label">Agama</label>
                                <input type="text" name="agama" class="form-control">
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control">
                            </div>

                            <!-- Gaji -->
                            <div class="col-md-6">
                                <label for="gaji" class="form-label">Gaji</label>
                                <input type="number" step="0.01" name="gaji" class="form-control">
                            </div>

                            <!-- Deposit -->
                            <div class="col-md-6">
                                <label for="deposit" class="form-label">Deposit</label>
                                <input type="number" step="0.01" name="deposit" class="form-control">
                            </div>

                            <!-- Shift -->
                            <div class="col-md-6">
                                <label for="shift" class="form-label">Shift</label>
                                <input type="text" name="shift" class="form-control">
                            </div>

                            <!-- Grup -->
                            <div class="col-md-6">
                                <label for="grup" class="form-label">Grup</label>
                                <input type="text" name="grup" class="form-control">
                            </div>

                            <!-- Absensi -->
                            <div class="col-md-6">
                                <label for="absensi" class="form-label">Absensi</label>
                                <input type="text" name="absensi" class="form-control">
                            </div>

                            <!-- Potongan DT -->
                            <div class="col-md-6">
                                <label for="pot_dt" class="form-label">Potongan DT</label>
                                <input type="number" step="0.01" name="pot_dt" class="form-control">
                            </div>

                            <!-- Unit -->
                            <div class="col-md-6">
                                <label for="unit" class="form-label">Unit</label>
                                <select name="unit" class="form-control select2" required>
                                    <option value="">Pilih Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Unit -->
                            <div class="col-md-6">
                                <label for="nama_unit" class="form-label">Nama Unit</label>
                                <input type="text" name="nama_unit" class="form-control">
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editKaryawanForm" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="karyawan_id" name="id"> <!-- Input hidden untuk ID karyawan -->
                    <div class="modal-body">
                        <div class="row">
                            <!-- Nama -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>

                            <!-- NIK -->
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" name="nik" id="edit_nik" class="form-control" required>
                            </div>

                            <!-- Divisi -->
                            <div class="col-md-6">
                                <label for="divisi" class="form-label">Divisi</label>
                                <select name="divisi" id="edit_divisi" class="form-control select2" required>
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($bagians as $bagian)
                                        <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jabatan -->
                            <div class="col-md-6">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" id="edit_jabatan" class="form-control"
                                    required>
                            </div>

                            <!-- Tanggal Masuk -->
                            <div class="col-md-6">
                                <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" id="edit_tgl_masuk" class="form-control"
                                    required>
                            </div>

                            <!-- Alamat -->
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" id="edit_alamat" class="form-control">
                            </div>

                            <!-- No Telp -->
                            <div class="col-md-6">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" name="no_telp" id="edit_no_telp" class="form-control"
                                    required>
                            </div>

                            <!-- Status Karyawan -->
                            <div class="col-md-6">
                                <label for="status_kar" class="form-label">Status Karyawan</label>
                                <select name="status_kar" id="edit_status_kar" class="form-control" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <!-- Kelamin -->
                            <div class="col-md-6">
                                <label for="kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="kelamin" id="edit_kelamin" class="form-control" required>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- Agama -->
                            <div class="col-md-6">
                                <label for="agama" class="form-label">Agama</label>
                                <input type="text" name="agama" id="edit_agama" class="form-control">
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" id="edit_tgl_lahir" class="form-control">
                            </div>

                            <!-- Gaji -->
                            <div class="col-md-6">
                                <label for="gaji" class="form-label">Gaji</label>
                                <input type="number" step="0.01" name="gaji" id="edit_gaji"
                                    class="form-control">
                            </div>

                            <!-- Deposit -->
                            <div class="col-md-6">
                                <label for="deposit" class="form-label">Deposit</label>
                                <input type="number" step="0.01" name="deposit" id="edit_deposit"
                                    class="form-control">
                            </div>

                            <!-- Shift -->
                            <div class="col-md-6">
                                <label for="shift" class="form-label">Shift</label>
                                <input type="text" name="shift" id="edit_shift" class="form-control">
                            </div>

                            <!-- Grup -->
                            <div class="col-md-6">
                                <label for="grup" class="form-label">Grup</label>
                                <input type="text" name="grup" id="edit_grup" class="form-control">
                            </div>

                            <!-- Absensi -->
                            <div class="col-md-6">
                                <label for="absensi" class="form-label">Absensi</label>
                                <input type="text" name="absensi" id="edit_absensi" class="form-control">
                            </div>

                            <!-- Potongan DT -->
                            <div class="col-md-6">
                                <label for="pot_dt" class="form-label">Potongan DT</label>
                                <input type="number" step="0.01" name="pot_dt" id="edit_pot_dt"
                                    class="form-control">
                            </div>

                            <!-- Unit -->
                            <div class="col-md-6">
                                <label for="unit" class="form-label">Unit</label>
                                <select name="unit" id="edit_unit" class="form-control select2" required>
                                    <option value="">Pilih Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Unit -->
                            <div class="col-md-6">
                                <label for="nama_unit" class="form-label">Nama Unit</label>
                                <input type="text" name="nama_unit" id="edit_nama_unit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script untuk mengisi form edit
        function editKaryawan(karyawan) {
            $('#karyawan_id').val(karyawan.id);
            $('#edit_name').val(karyawan.name);
            $('#edit_nik').val(karyawan.nik);
            $('#edit_divisi').val(karyawan.divisi).trigger('change');
            $('#edit_jabatan').val(karyawan.jabatan);
            $('#edit_tgl_masuk').val(karyawan.tgl_masuk);
            $('#edit_alamat').val(karyawan.alamat);
            $('#edit_no_telp').val(karyawan.no_telp);
            $('#edit_status_kar').val(karyawan.status_kar).trigger('change');
            $('#edit_kelamin').val(karyawan.kelamin).trigger('change');
            $('#edit_agama').val(karyawan.agama);
            $('#edit_tgl_lahir').val(karyawan.tgl_lahir);
            $('#edit_gaji').val(karyawan.gaji);
            $('#edit_deposit').val(karyawan.deposit);
            $('#edit_shift').val(karyawan.shift);
            $('#edit_grup').val(karyawan.grup);
            $('#edit_absensi').val(karyawan.absensi);
            $('#edit_pot_dt').val(karyawan.pot_dt);
            $('#edit_unit').val(karyawan.unit).trigger('change');
            $('#edit_nama_unit').val(karyawan.nama_unit);

            $('#editKaryawanForm').attr('action', `/karyawan/${karyawan.id}`);
            $('#editKaryawanModal').modal('show');
        }
    </script>


    @push('js')
        <!-- Include DataTables and Select2 -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <!-- Initialize DataTables and Select2 -->
        <script>
            $(document).ready(function() {
                    // Inisialisasi DataTables
                    var table = $('#karyawanTable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "{{ route('karyawan.index') }}",
                            "data": function(d) {
                                d.bagian_id = $('#filterBagian').val();
                                d.unit_id = $('#filterUnit').val();
                            }
                        },
                        "columns": [{
                                "data": "no"
                            },
                            {
                                "data": "nik"
                            },
                            {
                                "data": "name"
                            },
                            {
                                "data": "bagian"
                            },
                            {
                                "data": "unit"
                            },
                            {
                                "data": "jabatan"
                            },
                            {
                                "data": null,
                                "render": function(data, type, row) {
                                    return `
                                    <button class="btn btn-sm btn-warning editBtn" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#editKaryawanModal">Edit</button>
                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.id}">Hapus</button>
                                `;
                                }
                            }
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
                    $('#filterBagian, #filterUnit').on('change', function() {
                        table.ajax.reload();
                    });

                    // Handle Edit button click
                    $(document).on('click', '.editBtn', function() {
                        var id = $(this).data('id');
                        $.ajax({
                            url: `/karyawan/${id}/edit`,
                            type: 'GET',
                            success: function(data) {
                                // Isi form edit dengan data yang didapat
                                $('#editKaryawanForm').attr('action', `/karyawan/${id}`);
                                $('#editKaryawanForm input[name="name"]').val(data.name);
                                // Isi field lainnya...
                                $('#editKaryawanModal').modal('show');
                            }
                        });
                    });

                    // Handle Delete button click
                    $(document).on('click', '.deleteBtn', function() {
                        var id = $(this).data('id');
                        if (confirm('Apakah anda yakin ingin menghapus karyawan ini?')) {
                            $.ajax({
                                url: `/karyawan/${id}`,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    table.ajax.reload(); // Reload tabel setelah penghapusan
                                }
                            });
                        }
                    });
                }


                // Handle form submission for adding a new karyawan
                $('#tambahKaryawanForm').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: '{{ route('karyawan.store') }}',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#tambahKaryawanModal').modal('hide'); // Close modal
                            $('#tambahKaryawanForm')[0].reset(); // Reset form
                            table.ajax.reload(); // Reload DataTable
                        },
                        error: function(xhr) {
                            alert('Gagal menambahkan karyawan.');
                        }
                    });
                });

                // Handle form submission for editing karyawan
                $('#editKaryawanForm').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    var actionUrl = $(this).attr('action'); // Get the action URL from the form

                    $.ajax({
                        url: actionUrl,
                        type: 'PUT',
                        data: formData,
                        success: function(response) {
                            $('#editKaryawanModal').modal('hide'); // Close modal
                            table.ajax.reload(); // Reload DataTable
                        },
                        error: function(xhr) {
                            alert('Gagal mengedit karyawan.');
                        }
                    });
                });
            );
        </script>
    @endpush
</x-layout>
