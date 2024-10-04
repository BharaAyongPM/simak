<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='bagian'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Data Bagian"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Bagian Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Bagian</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bagianModal">
                                + Tambah Bagian
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="bagianTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Bagian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bagians as $index => $bagian)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $bagian->nama_bagian }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editBagian({{ $bagian->id_bagian }})"
                                                        data-bs-toggle="modal" data-bs-target="#editBagianModal">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Form -->
                                                    <form action="{{ route('bagian.destroy', $bagian->id_bagian) }}"
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

                                <!-- Modal Edit Bagian -->
                                <div class="modal fade" id="editBagianModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editBagianModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editBagianModalLabel">Edit Bagian</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editBagianForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editBagianId" name="id_bagian">
                                                    <!-- Nama Bagian -->
                                                    <div class="mb-3">
                                                        <label for="editNamaBagian" class="form-label">Nama
                                                            Bagian</label>
                                                        <input type="text" class="form-control" id="editNamaBagian"
                                                            name="nama_bagian" required>
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
                                <!-- End of Edit Bagian Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Bagian Table -->

            <!-- Modal untuk Tambah Bagian -->
            <div class="modal fade" id="bagianModal" tabindex="-1" role="dialog" aria-labelledby="bagianModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bagianModalLabel">Tambah Bagian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="bagianForm" action="{{ route('bagian.store') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <!-- Nama Bagian -->
                                <div class="mb-3">
                                    <label for="nama_bagian" class="form-label">Nama Bagian</label>
                                    <input type="text" class="form-control" id="nama_bagian" name="nama_bagian"
                                        required>
                                    <div class="invalid-feedback">Nama Bagian wajib diisi.</div>
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
            <!-- End of Tambah Bagian Modal -->

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
                $('#bagianTable').DataTable({
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

            // Edit Bagian Function
            function editBagian(id_bagian) {
                $.ajax({
                    url: '/bagian/edit/' + id_bagian,
                    method: 'GET',
                    success: function(data) {
                        $('#editBagianForm').attr('action', '/bagian/update/' + id_bagian);
                        $('#editBagianId').val(data.id_bagian);
                        $('#editNamaBagian').val(data.nama_bagian);
                    },
                    error: function() {
                        alert('Gagal mengambil data bagian');
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
