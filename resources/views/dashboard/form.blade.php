<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='form-izin'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Form Izin"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Form Izin, Cuti, Lembur, Sakit</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#izinModal">
                                + Tambah Izin
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <!-- Tabel dengan border lebih jelas -->
                                <table id="izinTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Nama</th>
                                            <th>Bagian</th>
                                            <th>Unit</th>
                                            <th>Tanggal Izin/Cuti/Lembur/Sakit</th>
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
                                            <td><img src="{{ asset('path/to/image') }}" alt="Dokumen"
                                                    class="img-fluid rounded-circle" width="50"></td>
                                            <td>12-Sep-2024</td>
                                            <td>Cuti</td>
                                            <td>Bhara Ayong</td>
                                            <td>IT</td>
                                            <td>Jakarta</td>
                                            <td>12-14 Sep 2024</td>
                                            <td>Keperluan pribadi</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                            <td><span class="badge bg-danger">Pending</span></td>
                                            <td><button class="btn btn-primary btn-sm">Aksi</button></td>
                                        </tr>
                                        {{-- Tambahkan loop data dari database --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk Tambah Izin -->
            <div class="modal fade" id="izinModal" tabindex="-1" role="dialog" aria-labelledby="izinModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="izinModalLabel">Tambah Izin, Cuti, Lembur, Sakit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="izinForm" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jenis" class="form-label">Jenis</label>
                                        <select class="form-control border border-1" id="jenis" name="jenis"
                                            onchange="toggleCuti()" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Lembur">Lembur</option>
                                            <option value="Cuti">Cuti</option>
                                        </select>
                                        <div class="invalid-feedback">Jenis wajib diisi.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control border border-1" id="nama"
                                            name="nama" required>
                                        <div class="invalid-feedback">Nama karyawan wajib diisi.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                        <input type="date" class="form-control border border-1" id="tanggal_awal"
                                            name="tanggal_awal" required>
                                        <div class="invalid-feedback">Tanggal awal wajib diisi.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                        <input type="date" class="form-control border border-1" id="tanggal_akhir"
                                            name="tanggal_akhir" required>
                                        <div class="invalid-feedback">Tanggal akhir wajib diisi.</div>
                                    </div>
                                </div>

                                <!-- Select Sisa Cuti, hanya tampil jika jenis cuti -->
                                <div class="row mb-3" id="sisaCutiDiv" style="display: none;">
                                    <div class="col-md-12">
                                        <label for="sisa_cuti" class="form-label">Sisa Cuti</label>
                                        <select class="form-control border border-1" id="sisa_cuti" name="sisa_cuti">
                                            <option value="10">10 Hari</option>
                                            <option value="5">5 Hari</option>
                                            <option value="0">0 Hari</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control border border-1" id="keterangan" name="keterangan" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="dokumen" class="form-label">Dokumen/Gambar</label>
                                        <input type="file" class="form-control border border-1" id="dokumen"
                                            name="dokumen">
                                    </div>
                                </div>

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
                $('#izinTable').DataTable({
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

            function toggleCuti() {
                const jenis = document.getElementById('jenis').value;
                const sisaCutiDiv = document.getElementById('sisaCutiDiv');
                if (jenis === 'Cuti') {
                    sisaCutiDiv.style.display = 'block';
                } else {
                    sisaCutiDiv.style.display = 'none';
                }
            }

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
