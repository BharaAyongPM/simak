<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='pelatihan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Data Pelatihan Karyawan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h6>Data Pelatihan Karyawan</h6>
                            <div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pelatihanModal">
                                    + Tambah Pelatihan
                                </button>
                                <a href="{{ route('rekap-pelatihan') }}" class="btn btn-secondary ms-2">
                                    <i class="fas fa-file-alt"></i> Rekap Pelatihan
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <!-- Tabel Pelatihan -->
                                <table id="pelatihanTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Lampiran</th>
                                            <th>Nama Karyawan</th>
                                            <th>Departemen</th>
                                            <th>Unit</th>
                                            <th>Tanggal Pelatihan</th>
                                            <th>Jam</th>
                                            <th>Waktu</th>
                                            <th>Nara Sumber</th>
                                            <th>Materi Pelatihan</th>
                                            <th>Approve Level 1</th>
                                            <th>Approve Level 2</th>
                                            <th>Control</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Contoh data --}}
                                        <tr>
                                            <td>1</td>
                                            <td><img src="{{ asset('path/to/document') }}" alt="Lampiran"
                                                    class="img-fluid rounded" width="50"></td>
                                            <td>Bhara Ayong</td>
                                            <td>IT</td>
                                            <td>Jakarta</td>
                                            <td>15-Sep-2024</td>
                                            <td>08:00 - 12:00</td>
                                            <td>4 Jam</td>
                                            <td>John Doe</td>
                                            <td>Basic Telecommunication Training</td>
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

            <!-- Modal untuk Tambah Pelatihan -->
            <div class="modal fade" id="pelatihanModal" tabindex="-1" role="dialog"
                aria-labelledby="pelatihanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pelatihanModalLabel">Tambah Pelatihan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="pelatihanForm" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <!-- Form elements go here -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
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
                $('#pelatihanTable').DataTable({
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
