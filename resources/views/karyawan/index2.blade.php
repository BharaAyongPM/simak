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
                                    <div class="col-md-2 d-flex align-items-end">
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
                            <div class="row">
                                <!-- Input fields for new karyawan data -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <select name="divisi" class="form-control select2" required>
                                        @foreach ($bagians as $bagian)
                                            <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                    <input type="date" name="tgl_masuk" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="unit" class="form-label">Unit</label>
                                    <select name="unit" class="form-control select2" required>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                        @endforeach
                                    </select>
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
                    <form id="editKaryawanForm" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="karyawan_id" name="id">
                        <div class="modal-body">
                            <!-- Input fields for editing karyawan data -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="edit_name" class="form-label">Nama</label>
                                    <input type="text" name="name" id="edit_name" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_nik" class="form-label">NIK</label>
                                    <input type="text" name="nik" id="edit_nik" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_divisi" class="form-label">Divisi</label>
                                    <select name="divisi" id="edit_divisi" class="form-control select2" required>
                                        @foreach ($bagians as $bagian)
                                            <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_jabatan" class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" id="edit_jabatan" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_tgl_masuk" class="form-label">Tanggal Masuk</label>
                                    <input type="date" name="tgl_masuk" id="edit_tgl_masuk" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_unit" class="form-label">Unit</label>
                                    <select name="unit" id="edit_unit" class="form-control select2" required>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                        @endforeach
                                    </select>
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
    </main>

    @push('js')
        <script>
            $(document).ready(function() {
                // DataTables initialization
                $('#karyawanTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('karyawan.index') }}",
                        "type": "GET",
                        "data": function(d) {
                            d.bagian_id = $('#bagian_id').val();
                            d.unit_id = $('#unit_id').val();
                        }
                    },
                    "columns": [{
                            "data": "no"
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "nik"
                        },
                        {
                            "data": "divisi",
                            defaultContent: "-"
                        },
                        {
                            "data": "unit",
                            defaultContent: "-"
                        },
                        {
                            "data": "jabatan"
                        },
                        {
                            "data": "actions"
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

                // Apply filter
                $('#applyFilter').on('click', function() {
                    $('#karyawanTable').DataTable().ajax.reload();
                });

                // Load unit based on selected bagian
                $('#bagian_id').on('change', function() {
                    let bagianId = $(this).val();
                    $('#unit_id').empty().append(
                    '<option value="">Semua Unit</option>'); // Clear and add default option
                    if (bagianId) {
                        $.ajax({
                            url: "/get-units-by-bagian/" + bagianId,
                            type: "GET",
                            success: function(units) {
                                $.each(units, function(key, unit) {
                                    $('#unit_id').append('<option value="' + unit.id +
                                        '">' + unit.nama_unit + '</option>');
                                });
                            }
                        });
                    }
                });

                // Edit Karyawan - fill modal form
                function editKaryawan(karyawan) {
                    $('#edit_name').val(karyawan.name);
                    $('#edit_nik').val(karyawan.nik);
                    $('#edit_divisi').val(karyawan.divisi).trigger('change');
                    $('#edit_jabatan').val(karyawan.jabatan);
                    $('#edit_tgl_masuk').val(karyawan.tgl_masuk);
                    $('#edit_unit').val(karyawan.unit).trigger('change');
                    $('#editKaryawanForm').attr('action', '/karyawan/' + karyawan.id);
                    $('#editKaryawanModal').modal('show');
                }
            });
        </script>
    @endpush
</x-layout>
