<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='datastockcuti'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Data Stok Cuti"></x-navbars.navs.auth>
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

            <!-- Tombol Tambah Cuti dan Tambah Cuti Semua -->
            <div class="d-flex justify-content-between mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahCutiModal">
                    + Tambah Cuti
                </button>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahCutiSemuaModal">
                    + Tambah Cuti untuk Semua Karyawan
                </button>
            </div>

            <!-- Stok Cuti Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Stok Cuti Karyawan</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="stockCutiTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>Awal Cuti</th>
                                            <th>Akhir Cuti</th>
                                            <th>Jumlah</th>
                                            <th>Pakai</th>
                                            <th>Sisa</th>
                                            <th>Tukar</th>
                                            <th>Jenis Cuti</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $index => $stock)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $stock->user->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($stock->awal_cuti)->format('d-M-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($stock->akhir_cuti)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ $stock->jumlah }}</td>
                                                <td>{{ $stock->pakai }}</td>
                                                <td>{{ $stock->sisa }}</td>
                                                <td>{{ $stock->tukar }}</td>
                                                <td>{{ $stock->jenisCuti->nama }}</td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editStockCuti({{ $stock->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#editStockCutiModal">
                                                        Edit
                                                    </button>
                                                    <!-- Form Hapus -->
                                                    <form action="{{ route('datastockcuti.destroy', $stock->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus stok cuti ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Stok Cuti -->
                                <div class="modal fade" id="editStockCutiModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editStockCutiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStockCutiModalLabel">Edit Stok Cuti</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editStockCutiForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editStockCutiId" name="id">
                                                    <!-- User -->
                                                    <div class="mb-3">
                                                        <label for="editUserId" class="form-label">Karyawan</label>
                                                        <select class="form-control" id="editUserId" name="user_id"
                                                            required>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Awal Cuti -->
                                                    <div class="mb-3">
                                                        <label for="editAwalCuti" class="form-label">Awal Cuti</label>
                                                        <input type="date" class="form-control" id="editAwalCuti"
                                                            name="awal_cuti" required>
                                                    </div>
                                                    <!-- Akhir Cuti -->
                                                    <div class="mb-3">
                                                        <label for="editAkhirCuti" class="form-label">Akhir Cuti</label>
                                                        <input type="date" class="form-control" id="editAkhirCuti"
                                                            name="akhir_cuti" required>
                                                    </div>
                                                    <!-- Jumlah -->
                                                    <div class="mb-3">
                                                        <label for="editJumlah" class="form-label">Jumlah Cuti</label>
                                                        <input type="number" class="form-control" id="editJumlah"
                                                            name="jumlah" required>
                                                    </div>
                                                    <!-- Pakai -->
                                                    <div class="mb-3">
                                                        <label for="editPakai" class="form-label">Pakai</label>
                                                        <input type="number" class="form-control" id="editPakai"
                                                            name="pakai" required>
                                                    </div>
                                                    <!-- Sisa -->
                                                    <div class="mb-3">
                                                        <label for="editSisa" class="form-label">Sisa</label>
                                                        <input type="number" class="form-control" id="editSisa"
                                                            name="sisa" required>
                                                    </div>
                                                    <!-- Tukar -->
                                                    <div class="mb-3">
                                                        <label for="editTukar" class="form-label">Tukar</label>
                                                        <input type="number" class="form-control" id="editTukar"
                                                            name="tukar" required>
                                                    </div>
                                                    <!-- Jenis Cuti -->
                                                    <div class="mb-3">
                                                        <label for="editJenisCuti" class="form-label">Jenis
                                                            Cuti</label>
                                                        <select class="form-control" id="editJenisCuti"
                                                            name="jenis_cuti" required>
                                                            @foreach ($jenisCutis as $jenisCuti)
                                                                <option value="{{ $jenisCuti->id }}">
                                                                    {{ $jenisCuti->nama }}</option>
                                                            @endforeach
                                                        </select>
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
                                <!-- End of Edit Stok Cuti Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Stok Cuti Table -->

            <!-- Modal untuk Tambah Cuti -->
            <div class="modal fade" id="tambahCutiModal" tabindex="-1" role="dialog"
                aria-labelledby="tambahCutiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahCutiModalLabel">Tambah Stok Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahCutiForm" action="{{ route('datastockcuti.store') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <!-- Karyawan -->
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Karyawan</label>
                                    <select class="form-control" id="user_id" name="user_id" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Karyawan wajib dipilih.</div>
                                </div>
                                <!-- Awal Cuti -->
                                <div class="mb-3">
                                    <label for="awal_cuti" class="form-label">Awal Cuti</label>
                                    <input type="date" class="form-control" id="awal_cuti" name="awal_cuti"
                                        required>
                                    <div class="invalid-feedback">Awal cuti wajib diisi.</div>
                                </div>
                                <!-- Akhir Cuti -->
                                <div class="mb-3">
                                    <label for="akhir_cuti" class="form-label">Akhir Cuti</label>
                                    <input type="date" class="form-control" id="akhir_cuti" name="akhir_cuti"
                                        required>
                                    <div class="invalid-feedback">Akhir cuti wajib diisi.</div>
                                </div>
                                <!-- Jumlah Cuti -->
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Cuti</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah"
                                        required>
                                    <div class="invalid-feedback">Jumlah cuti wajib diisi.</div>
                                </div>
                                <!-- Pakai -->
                                <div class="mb-3">
                                    <label for="pakai" class="form-label">Pakai</label>
                                    <input type="number" class="form-control" id="pakai" name="pakai"
                                        required>
                                    <div class="invalid-feedback">Cuti yang dipakai wajib diisi.</div>
                                </div>
                                <!-- Sisa -->
                                <div class="mb-3">
                                    <label for="sisa" class="form-label">Sisa</label>
                                    <input type="number" class="form-control" id="sisa" name="sisa"
                                        required>
                                    <div class="invalid-feedback">Sisa cuti wajib diisi.</div>
                                </div>
                                <!-- Tukar -->
                                <div class="mb-3">
                                    <label for="tukar" class="form-label">Tukar</label>
                                    <input type="number" class="form-control" id="tukar" name="tukar"
                                        required>
                                    <div class="invalid-feedback">Jumlah tukar wajib diisi.</div>
                                </div>
                                <!-- Jenis Cuti -->
                                <div class="mb-3">
                                    <label for="jenis_cuti" class="form-label">Jenis Cuti</label>
                                    <select class="form-control" id="jenis_cuti" name="jenis_cuti" required>
                                        @foreach ($jenisCutis as $jenisCuti)
                                            <option value="{{ $jenisCuti->id }}">{{ $jenisCuti->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Jenis cuti wajib dipilih.</div>
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
            <!-- End of Tambah Cuti Modal -->

            <!-- Modal untuk Tambah Cuti untuk Semua Karyawan -->
            <div class="modal fade" id="tambahCutiSemuaModal" tabindex="-1" role="dialog"
                aria-labelledby="tambahCutiSemuaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahCutiSemuaModalLabel">Tambah Cuti untuk Semua Karyawan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahCutiSemuaForm" action="{{ route('datastockcuti.storeForAll') }}"
                                method="POST" class="needs-validation" novalidate>
                                @csrf
                                <!-- Awal Cuti -->
                                <div class="mb-3">
                                    <label for="awal_cuti_semua" class="form-label">Awal Cuti</label>
                                    <input type="date" class="form-control" id="awal_cuti_semua" name="awal_cuti"
                                        required>
                                    <div class="invalid-feedback">Awal cuti wajib diisi.</div>
                                </div>
                                <!-- Akhir Cuti -->
                                <div class="mb-3">
                                    <label for="akhir_cuti_semua" class="form-label">Akhir Cuti</label>
                                    <input type="date" class="form-control" id="akhir_cuti_semua"
                                        name="akhir_cuti" required>
                                    <div class="invalid-feedback">Akhir cuti wajib diisi.</div>
                                </div>
                                <!-- Jumlah Cuti -->
                                <div class="mb-3">
                                    <label for="jumlah_semua" class="form-label">Jumlah Cuti</label>
                                    <input type="number" class="form-control" id="jumlah_semua" name="jumlah"
                                        required>
                                    <div class="invalid-feedback">Jumlah cuti wajib diisi.</div>
                                </div>
                                <!-- Jenis Cuti -->
                                <div class="mb-3">
                                    <label for="jenis_cuti_semua" class="form-label">Jenis Cuti</label>
                                    <select class="form-control" id="jenis_cuti_semua" name="jenis_cuti" required>
                                        @foreach ($jenisCutis as $jenisCuti)
                                            <option value="{{ $jenisCuti->id }}">{{ $jenisCuti->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Jenis cuti wajib dipilih.</div>
                                </div>
                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-success mt-3">Simpan untuk
                                            Semua</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Tambah Cuti Semua Modal -->

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
                $('#stockCutiTable').DataTable({
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

            // Edit Stok Cuti Function
            function editStockCuti(id) {
                $.ajax({
                    url: '/datastockcuti/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#editStockCutiForm').attr('action', '/datastockcuti/update/' + id);
                        $('#editStockCutiId').val(data.id);
                        $('#editUserId').val(data.user_id);
                        $('#editAwalCuti').val(data.awal_cuti);
                        $('#editAkhirCuti').val(data.akhir_cuti);
                        $('#editJumlah').val(data.jumlah);
                        $('#editPakai').val(data.pakai);
                        $('#editSisa').val(data.sisa);
                        $('#editTukar').val(data.tukar);
                        $('#editJenisCuti').val(data.jenis_cuti);
                    },
                    error: function() {
                        alert('Gagal mengambil data stok cuti');
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
