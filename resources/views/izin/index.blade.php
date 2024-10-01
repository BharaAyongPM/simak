<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='form-izin'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Form Izin"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Izin Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Daftar Izin/Sakit</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#izinModal">
                                + Tambah Izin
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="izinTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Dokumen</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jenis</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Keterangan</th>
                                            <th>Approve Level 1</th>
                                            <th>Approve Level 2</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($izin as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($item->dokumen)
                                                        <a href="{{ asset('uploads/izin/' . $item->dokumen) }}"
                                                            target="_blank">Lihat</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                                                <td>{{ $item->jenis }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    @if ($item->approve_1 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->approve_2 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Disable buttons if approve_1 is 1 -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editCuti({{ $item->id }})" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        @if ($item->approve_1 == 1) disabled @endif>
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('cuti.destroy', $item->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            @if ($item->approve_1 == 1) disabled @endif
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Izin -->
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Izin/Sakit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editIzinForm" enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editIzinId" name="id">

                                                    <!-- Jenis -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="editJenis" class="form-label">Jenis</label>
                                                            <select class="form-control border border-1" id="editJenis"
                                                                name="jenis" required>
                                                                <option value="">Pilih Jenis</option>
                                                                <option value="Sakit">Sakit</option>
                                                                <option value="Izin">Izin</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Tanggal Izin/Sakit -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="editTanggalMulai" class="form-label">Tanggal
                                                                Mulai</label>
                                                            <input type="date" class="form-control border border-1"
                                                                id="editTanggalMulai" name="tanggal_mulai" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="editTanggalSelesai" class="form-label">Tanggal
                                                                Selesai</label>
                                                            <input type="date" class="form-control border border-1"
                                                                id="editTanggalSelesai" name="tanggal_selesai" required>
                                                        </div>
                                                    </div>

                                                    <!-- Keterangan -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="editKeterangan"
                                                                class="form-label">Keterangan</label>
                                                            <textarea class="form-control border border-1" id="editKeterangan" name="keterangan" rows="3" required></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Dokumen -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="editDokumen" class="form-label">Dokumen/Gambar
                                                                (Opsional)</label>
                                                            <input type="file" class="form-control border border-1"
                                                                id="editDokumen" name="dokumen">
                                                        </div>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <button type="submit"
                                                                class="btn btn-success mt-3">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Edit Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Izin Table -->

            <!-- Modal untuk Tambah Izin -->
            <div class="modal fade" id="izinModal" tabindex="-1" role="dialog" aria-labelledby="izinModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="izinModalLabel">Tambah Izin/Sakit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="izinForm" action="{{ route('izin.store') }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                <!-- Jenis -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jenis" class="form-label">Jenis</label>
                                        <select class="form-control border border-1" id="jenis" name="jenis"
                                            required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Izin">Izin</option>
                                        </select>
                                        <div class="invalid-feedback">Jenis wajib diisi.</div>
                                    </div>
                                </div>

                                <!-- Tanggal Izin/Sakit -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control border border-1" id="tanggal_mulai"
                                            name="tanggal_mulai" required>
                                        <div class="invalid-feedback">Tanggal mulai wajib diisi.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control border border-1"
                                            id="tanggal_selesai" name="tanggal_selesai" required>
                                        <div class="invalid-feedback">Tanggal selesai wajib diisi.</div>
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control border border-1" id="keterangan" name="keterangan" rows="3" required></textarea>
                                        <div class="invalid-feedback">Keterangan wajib diisi.</div>
                                    </div>
                                </div>

                                <!-- Dokumen -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="dokumen" class="form-label">Dokumen/Gambar (Opsional)</label>
                                        <input type="file" class="form-control border border-1" id="dokumen"
                                            name="dokumen">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-success mt-3">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Tambah Izin Modal -->

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
        <!-- jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#izinTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "lengthMenu": [5, 10, 15, 20],
                    "language": {
                        "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                        "zeroRecords": "Tidak ada data yang ditemukan",
                        "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                        "infoEmpty": "Tidak ada data tersedia",
                        "infoFiltered": "(disaring dari _MAX_ total entri)",
                        "search": "Cari:",
                        "paginate": {
                            "next": ">>",
                            "previous": "<<"
                        }
                    }
                });
            });

            // Edit Izin Function
            function editIzin(id) {
                $.ajax({
                    url: '/izin/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        // Populate the form fields with the data from the server
                        $('#editIzinForm').attr('action', '/izin/update/' + id);
                        $('#editIzinId').val(data.id);
                        $('#editJenis').val(data.jenis);
                        $('#editTanggalMulai').val(data.tanggal_mulai);
                        $('#editTanggalSelesai').val(data.tanggal_selesai);
                        $('#editKeterangan').val(data.keterangan);
                    },
                    error: function() {
                        alert('Gagal mengambil data izin');
                    }
                });
            }

            // Form Validation
            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>
    @endpush
</x-layout>
