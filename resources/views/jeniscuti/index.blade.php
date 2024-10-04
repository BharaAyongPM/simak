<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='jeniscuti'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Jenis Cuti"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Jenis Cuti Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Jenis Cuti</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">
                                + Tambah Jenis Cuti
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="cutiTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Cuti</th>
                                            <th>Jumlah Cuti</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jenis_cutis as $index => $jenis_cuti)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $jenis_cuti->nama }}</td>
                                                <td>{{ $jenis_cuti->jumlah }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editCuti({{ $jenis_cuti->id }})" data-bs-toggle="modal"
                                                        data-bs-target="#editCutiModal">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Form -->
                                                    <form action="{{ route('jeniscuti.destroy', $jenis_cuti->id) }}"
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

                                <!-- Modal Edit Jenis Cuti -->
                                <div class="modal fade" id="editCutiModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editCutiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCutiModalLabel">Edit Jenis Cuti</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editCutiForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editCutiId" name="id">
                                                    <!-- Nama Jenis Cuti -->
                                                    <div class="mb-3">
                                                        <label for="editNama" class="form-label">Nama Cuti</label>
                                                        <input type="text" class="form-control" id="editNama"
                                                            name="nama" required>
                                                    </div>
                                                    <!-- Jumlah Cuti -->
                                                    <div class="mb-3">
                                                        <label for="editJumlah" class="form-label">Jumlah Cuti</label>
                                                        <input type="number" class="form-control" id="editJumlah"
                                                            name="jumlah" required>
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
                                <!-- End of Edit Cuti Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Jenis Cuti Table -->

            <!-- Modal untuk Tambah Jenis Cuti -->
            <div class="modal fade" id="cutiModal" tabindex="-1" role="dialog" aria-labelledby="cutiModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cutiModalLabel">Tambah Jenis Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="cutiForm" action="{{ route('jeniscuti.store') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <!-- Nama Jenis Cuti -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Cuti</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                    <div class="invalid-feedback">Nama Cuti wajib diisi.</div>
                                </div>
                                <!-- Jumlah Cuti -->
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Cuti</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah"
                                        required>
                                    <div class="invalid-feedback">Jumlah Cuti wajib diisi.</div>
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
            <!-- End of Tambah Jenis Cuti Modal -->

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
                $('#cutiTable').DataTable({
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

            // Edit Jenis Cuti Function
            function editCuti(id) {
                $.ajax({
                    url: '/jeniscuti/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#editCutiForm').attr('action', '/jeniscuti/update/' + id);
                        $('#editCutiId').val(data.id);
                        $('#editNama').val(data.nama);
                        $('#editJumlah').val(data.jumlah);
                    },
                    error: function() {
                        alert('Gagal mengambil data jenis cuti');
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
