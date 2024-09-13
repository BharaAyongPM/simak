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
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h6>Form Izin, Cuti, Lembur, Sakit</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#izinModal">
                                + Tambah Izin
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Tab Persetujuan -->
                            <div class="table-responsive p-4">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Gambar</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jenis</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Bagian</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Unit</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Izin/Cuti/Lembur/Sakit</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Keterangan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Approve Level 1</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Approve Level 2</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Loop data persetujuan di sini --}}
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

    @push('js')
        <script>
            function toggleCuti() {
                const jenis = document.getElementById('jenis').value;
                const sisaCutiDiv = document.getElementById('sisaCutiDiv');
                if (jenis === 'Cuti') {
                    sisaCutiDiv.style.display = 'block';
                } else {
                    sisaCutiDiv.style.display = 'none';
                }
            }

            // Form validation
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
