<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='libur'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Hari Libur"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Message -->
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

            <!-- Tombol Cek Hari Libur dari API -->
            <div class="d-flex flex-column align-items-end mb-4">
                <a href="{{ route('libur.fetch') }}" class="btn btn-primary mb-2">Cek Hari Libur</a>
                <p class="mb-0">Cek Hari Libur hanya dilakukan setahun sekali</p>
            </div>


            <!-- Hari Libur Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Hari Libur</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#liburModal">
                                + Tambah Hari Libur
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="liburTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($liburs as $index => $libur)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($libur->tanggal)->format('d-M-Y') }}</td>
                                                <td>{{ $libur->keterangan }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editLibur({{ $libur->id }})" data-bs-toggle="modal"
                                                        data-bs-target="#editLiburModal">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Form -->
                                                    <form action="{{ route('libur.destroy', $libur->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus hari libur ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Libur -->
                                <div class="modal fade" id="editLiburModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editLiburModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLiburModalLabel">Edit Hari Libur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editLiburForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editLiburId" name="id">
                                                    <!-- Tanggal Libur -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editTanggalLibur"
                                                                class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control"
                                                                id="editTanggalLibur" name="tanggal" required>
                                                        </div>
                                                    </div>
                                                    <!-- Keterangan Libur -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editKeteranganLibur"
                                                                class="form-label">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                id="editKeteranganLibur" name="keterangan" required>
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
                                <!-- End of Edit Libur Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Hari Libur Table -->

            <!-- Modal untuk Tambah Hari Libur -->
            <div class="modal fade" id="liburModal" tabindex="-1" role="dialog" aria-labelledby="liburModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="liburModalLabel">Tambah Hari Libur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="liburForm" action="{{ route('libur.store') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <!-- Tanggal Libur -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            required>
                                        <div class="invalid-feedback">Tanggal wajib diisi.</div>
                                    </div>
                                </div>
                                <!-- Keterangan Libur -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" id="keterangan" name="keterangan"
                                            required placeholder="Masukkan keterangan hari libur">
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
            <!-- End of Tambah Hari Libur Modal -->

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
                $('#liburTable').DataTable({
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

            // Edit Libur Function
            function editLibur(id) {
                $.ajax({
                    url: '/libur/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#editLiburForm').attr('action', '/libur/update/' + id); // Set action form untuk update
                        $('#editLiburId').val(data.id); // Isi ID Libur yang akan di-edit
                        $('#editTanggalLibur').val(data.tanggal); // Isi tanggal dengan data dari server
                        $('#editKeteranganLibur').val(data.keterangan); // Isi keterangan dengan data dari server
                    },
                    error: function() {
                        alert('Gagal mengambil data hari libur');
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
