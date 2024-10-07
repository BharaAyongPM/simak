<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='unit'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Data Unit"></x-navbars.navs.auth>
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

            <!-- Unit Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Unit</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unitModal">
                                + Tambah Unit
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="unitTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Bagian</th>
                                            <th>Nama Unit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($units as $index => $unit)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td> {{ $unit->bag->nama_bagian }}</td>
                                                <td>{{ $unit->unit }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editUnit({{ $unit->id }})" data-bs-toggle="modal"
                                                        data-bs-target="#editUnitModal">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Form -->
                                                    <form action="{{ route('unit.destroy', $unit->id) }}" method="POST"
                                                        style="display:inline;">
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

                                <!-- Modal Edit Unit -->
                                <div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editUnitModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editUnitForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editUnitId" name="id">
                                                    <!-- Bagian -->
                                                    <div class="mb-3">
                                                        <label for="editBagian" class="form-label">Bagian</label>
                                                        <select class="form-control" id="editBagian" name="bagian"
                                                            required>
                                                            @foreach ($bagians as $bagian)
                                                                <option value="{{ $bagian->id_bagian }}">
                                                                    {{ $bagian->nama_bagian }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Nama Unit -->
                                                    <div class="mb-3">
                                                        <label for="editNamaUnit" class="form-label">Nama Unit</label>
                                                        <input type="text" class="form-control" id="editNamaUnit"
                                                            name="unit" required>
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
                                <!-- End of Edit Unit Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Unit Table -->

            <!-- Modal untuk Tambah Unit -->
            <div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="unitModalLabel">Tambah Unit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="unitForm" action="{{ route('unit.store') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <!-- Bagian -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="bagian" class="form-label">Bagian</label>
                                        <select class="form-control" id="bagian" name="bagian" required>
                                            <option value="" selected>Pilih Bagian</option>
                                            @foreach ($bagians as $bagian)
                                                <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Bagian wajib dipilih.</div>
                                    </div>
                                </div>

                                <!-- Nama Unit -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="unit" class="form-label">Nama Unit</label>
                                        <input type="text" class="form-control" id="unit" name="unit"
                                            required placeholder="Masukkan Nama Unit">
                                        <div class="invalid-feedback">Nama Unit wajib diisi.</div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Tambah Unit Modal -->


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
                $('#unitTable').DataTable({
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

            // Edit Unit Function
            function editUnit(id) {
                $.ajax({
                    url: '/unit/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#editUnitForm').attr('action', '/unit/update/' + id); // Set action form untuk update
                        $('#editUnitId').val(data.id); // Isi ID Unit yang akan di-edit
                        $('#editBagian').val(data.bagian); // Isi bagian_id dengan data dari server
                        $('#editNamaUnit').val(data.unit); // Isi nama unit dengan data dari server
                    },
                    error: function() {
                        alert('Gagal mengambil data unit');
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
