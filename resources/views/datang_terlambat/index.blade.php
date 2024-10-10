<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='form-datang-terlambat'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Form Datang Terlambat"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Datang Terlambat Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Daftar Datang Terlambat</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#datangTerlambatModal">
                                + Tambah Datang Terlambat
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="datangTerlambatTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Approve Level 1</th>
                                            <th>Approve Level 2</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datangTerlambat as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    @if ($item->app_1 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif ($item->app_1 == -1)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->app_2 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif ($item->app_2 == -1)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Disable buttons if app_1 is approved -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editDatangTerlambat({{ $item->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        @if ($item->app_1 == 1) disabled @endif>
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('datang_terlambat.destroy', $item->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            @if ($item->app_1 == 1) disabled @endif
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Datang Terlambat -->
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Datang Terlambat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editDatangTerlambatForm" enctype="multipart/form-data"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editDatangTerlambatId" name="id">

                                                    <!-- Tanggal -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="editTanggal" class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control border border-1"
                                                                id="editTanggal" name="tanggal" required>
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
            <!-- End of Datang Terlambat Table -->

            <!-- Modal untuk Tambah Datang Terlambat -->
            <div class="modal fade" id="datangTerlambatModal" tabindex="-1" role="dialog"
                aria-labelledby="datangTerlambatModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="datangTerlambatModalLabel">Tambah Datang Terlambat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="datangTerlambatForm" action="{{ route('datang_terlambat.store') }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                <!-- Tanggal -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control border border-1" id="tanggal"
                                            name="tanggal" required>
                                        <div class="invalid-feedback">Tanggal wajib diisi.</div>
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
            <!-- End of Tambah Datang Terlambat Modal -->

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
                $('#datangTerlambatTable').DataTable({
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

            // Edit Datang Terlambat Function
            function editDatangTerlambat(id) {
                $.ajax({
                    url: '/datang_terlambat/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        // Populate the form fields with the data from the server
                        $('#editDatangTerlambatForm').attr('action', '/datang_terlambat/update/' + id);
                        $('#editDatangTerlambatId').val(data.id);
                        $('#editTanggal').val(data.tanggal);
                        $('#editKeterangan').val(data.keterangan);
                    },
                    error: function() {
                        alert('Gagal mengambil data datang terlambat');
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
