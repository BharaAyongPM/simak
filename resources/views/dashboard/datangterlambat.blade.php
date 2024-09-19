<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='datang-terlambat'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Data Permohonan Datang Terlambat Karyawan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Data Permohonan Datang Terlambat Karyawan</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#datangTerlambatModal">
                                + Tambah Permohonan
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <!-- Tabel Data Permohonan Datang Terlambat -->
                                <table id="datangTerlambatTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Departemen</th>
                                            <th>Unit</th>
                                            <th>Keterangan</th>
                                            <th>Approve Level 1</th>
                                            <th>Approve Level 2</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Contoh data --}}
                                        <tr>
                                            <td>1</td>
                                            <td>13-Sep-2024</td>
                                            <td>Bhara Ayong</td>
                                            <td>IT</td>
                                            <td>Jakarta</td>
                                            <td>Datang terlambat karena macet</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                            <td><span class="badge bg-danger">Pending</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk Tambah Permohonan Datang Terlambat -->
            <div class="modal fade" id="datangTerlambatModal" tabindex="-1" role="dialog"
                aria-labelledby="datangTerlambatModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="datangTerlambatModalLabel">Tambah Permohonan Datang Terlambat
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="datangTerlambatForm" enctype="multipart/form-data" class="needs-validation"
                                novalidate>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control border border-1" id="nama"
                                            name="nama" required>
                                        <div class="invalid-feedback">Nama karyawan wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control border border-1" id="tanggal"
                                            name="tanggal" required>
                                        <div class="invalid-feedback">Tanggal wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control border border-1" id="keterangan" name="keterangan" rows="3" required></textarea>
                                        <div class="invalid-feedback">Keterangan wajib diisi.</div>
                                    </div>
                                </div>

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

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('css')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    @endpush

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
                            "next": "Berikutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            });

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
