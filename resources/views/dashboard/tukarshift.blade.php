<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='tukar-shift'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Form Tukar Shift"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h6>Daftar Tukar Shift</h6>
                            <!-- Button tambah tukar shift -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tukarShiftModal">
                                Tambah Tukar Shift
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Tabel tukar shift -->
                            <div class="table-responsive p-4">
                                <table class="table align-items-center mb-0 table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Tukar</th>
                                            <th>Nama Karyawan Asal</th>
                                            <th>Shift Asal</th>
                                            <th>Departemen</th>
                                            <th>Unit</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal Kerja Asal</th>
                                            <th>Nama Karyawan Pengganti</th>
                                            <th>Tanggal Ganti</th>
                                            <th>Shift Pengganti</th>
                                            <th>Approve</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Contoh data, ganti dengan loop dari database --}}
                                        <tr>
                                            <td>1</td>
                                            <td>12-09-2024</td>
                                            <td>Bhara Ayong</td>
                                            <td>Back Office</td>
                                            <td>IT</td>
                                            <td>Jakarta</td>
                                            <td>Staff IT</td>
                                            <td>12-09-2024</td>
                                            <td>Fajar Setiawan</td>
                                            <td>13-09-2024</td>
                                            <td>Front Office</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Tukar Shift -->
            <div class="modal fade" id="tukarShiftModal" tabindex="-1" role="dialog"
                aria-labelledby="tukarShiftModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tukarShiftModalLabel">Tambah Tukar Shift</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tukarShiftForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_tukar">Tanggal Tukar</label>
                                            <input type="date" class="form-control border" id="tanggal_tukar"
                                                name="tanggal_tukar" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="karyawan_asal">Nama Karyawan Asal</label>
                                            <input type="text" class="form-control border" id="karyawan_asal"
                                                name="karyawan_asal" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_kerja_asal">Tanggal Kerja Asal</label>
                                            <input type="date" class="form-control border" id="tanggal_kerja_asal"
                                                name="tanggal_kerja_asal" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="karyawan_pengganti">Nama Karyawan Pengganti</label>
                                            <input type="text" class="form-control border" id="karyawan_pengganti"
                                                name="karyawan_pengganti" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_ganti">Tanggal Ganti</label>
                                            <input type="date" class="form-control border" id="tanggal_ganti"
                                                name="tanggal_ganti" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" onclick="submitTukarShift()">Simpan</button>
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
            function submitTukarShift() {
                const form = document.getElementById('tukarShiftForm');
                // Validasi sederhana
                if (form.checkValidity()) {
                    alert('Form Tukar Shift berhasil disimpan!');
                    // Logika penyimpanan di sini, misal dengan AJAX untuk menyimpan ke database
                    form.reset();
                    var tukarShiftModal = bootstrap.Modal.getInstance(document.getElementById('tukarShiftModal'));
                    tukarShiftModal.hide();
                } else {
                    alert('Mohon lengkapi semua data.');
                }
            }
        </script>
    @endpush
</x-layout>
