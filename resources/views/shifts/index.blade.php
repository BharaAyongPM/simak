<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='shifts'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Data Shift"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <!-- Shift Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Shift</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shiftModal">
                                + Tambah Shift
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="shiftTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Shift</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shifts as $index => $shift)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $shift->nama }}</td>
                                                <td>{{ $shift->masuk }}</td>
                                                <td>{{ $shift->pulang }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editShift({{ $shift->id }})" data-bs-toggle="modal"
                                                        data-bs-target="#editShiftModal">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Form -->
                                                    <form action="{{ route('shifts.destroy', $shift->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Shift -->
                                <div class="modal fade" id="editShiftModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editShiftModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editShiftModalLabel">Edit Shift</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <form id="editShiftForm" method="POST">

                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editShiftId" name="id">
                                                    <!-- Nama Shift -->
                                                    <div class="mb-3">
                                                        <label for="editNama" class="form-label">Nama Shift</label>
                                                        <input type="text" class="form-control" id="editNama"
                                                            name="nama" required>
                                                    </div>
                                                    <!-- Jam Masuk -->
                                                    <div class="mb-3">
                                                        <label for="editMasuk" class="form-label">Jam Masuk</label>
                                                        <input type="time" class="form-control" id="editMasuk"
                                                            name="masuk" required>
                                                    </div>

                                                    <!-- Jam Pulang -->
                                                    <div class="mb-3">
                                                        <label for="editPulang" class="form-label">Jam Pulang</label>
                                                        <input type="time" class="form-control" id="editPulang"
                                                            name="pulang" required>
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
                                <!-- End of Edit Shift Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Shift Table -->

            <!-- Modal untuk Tambah Shift -->
            <div class="modal fade" id="shiftModal" tabindex="-1" role="dialog" aria-labelledby="shiftModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="shiftModalLabel">Tambah Shift</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="shiftForm" action="{{ route('shifts.store') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <!-- Nama Shift -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Shift</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        required>
                                    <div class="invalid-feedback">Nama Shift wajib diisi.</div>
                                </div>
                                <!-- Jam Masuk -->
                                <div class="mb-3">
                                    <label for="masuk" class="form-label">Jam Masuk</label>
                                    <input type="time" class="form-control" id="masuk" name="masuk"
                                        required>
                                    <div class="invalid-feedback">Jam Masuk wajib diisi.</div>
                                </div>
                                <!-- Jam Pulang -->
                                <div class="mb-3">
                                    <label for="pulang" class="form-label">Jam Pulang</label>
                                    <input type="time" class="form-control" id="pulang" name="pulang"
                                        required>
                                    <div class="invalid-feedback">Jam Pulang wajib diisi.</div>
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
            <!-- End of Tambah Shift Modal -->

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
                $('#shiftTable').DataTable({
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

            // Edit Shift Function
            function editShift(id) {
                $.ajax({
                    url: '/shifts/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        // Set form action URL dengan ID shift yang benar
                        $('#editShiftForm').attr('action', '/shifts/update/' + id);

                        // Isi field hidden dengan ID shift
                        $('#editShiftId').val(data.id);

                        // Isi form dengan data shift yang diterima dari server
                        $('#editNama').val(data.nama);
                        $('#editMasuk').val(data.masuk);
                        $('#editPulang').val(data.pulang);
                    },
                    error: function() {
                        alert('Gagal mengambil data shift');
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
