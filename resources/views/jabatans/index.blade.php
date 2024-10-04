<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='jabatans'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Data Jabatan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Jabatan Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Jabatan</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jabatanModal">
                                + Tambah Jabatan
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="jabatanTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Jabatan</th>

                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jabatans as $index => $jabatan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $jabatan->nama }}</td>

                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editJabatan({{ $jabatan->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#editJabatanModal">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Form -->
                                                    <form action="{{ route('jabatans.destroy', $jabatan->id) }}"
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

                                <!-- Modal Edit Jabatan -->
                                <div class="modal fade" id="editJabatanModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editJabatanModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editJabatanModalLabel">Edit Jabatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editJabatanForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editJabatanId" name="id">
                                                    <!-- Nama Jabatan -->
                                                    <div class="mb-3">
                                                        <label for="editNama" class="form-label">Nama Jabatan</label>
                                                        <input type="text" class="form-control" id="editNama"
                                                            name="nama" required>
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
                                <!-- End of Edit Jabatan Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Jabatan Table -->

            <!-- Modal untuk Tambah Jabatan -->
            <div class="modal fade" id="jabatanModal" tabindex="-1" role="dialog" aria-labelledby="jabatanModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jabatanModalLabel">Tambah Jabatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="jabatanForm" action="{{ route('jabatans.store') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <!-- Nama Jabatan -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Jabatan</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                    <div class="invalid-feedback">Nama Jabatan wajib diisi.</div>
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
            <!-- End of Tambah Jabatan Modal -->

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
                $('#jabatanTable').DataTable({
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

            // Edit Jabatan Function
            function editJabatan(id) {
                $.ajax({
                    url: '/jabatans/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        // Populate the form fields with the data from the server
                        $('#editJabatanForm').attr('action', '/jabatans/update/' + id);
                        $('#editJabatanId').val(data.id);
                        $('#editNama').val(data.nama);

                    },
                    error: function() {
                        alert('Gagal mengambil data jabatan');
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
