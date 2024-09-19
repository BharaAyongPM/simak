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
                                <table id="izinTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Nama</th>
                                            <th>Bagian</th>

                                            <th>Tanggal Izin/Cuti/Lembur/Sakit</th>
                                            <th>Keterangan</th>
                                            <th>Approve Level 1</th>
                                            <th>Approve Level 2</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cutilembur as $index => $izin)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><img src="{{ asset('uploads/dokumen/' . $izin->fhoto) }}"
                                                        alt="Dokumen" class="img-fluid rounded-circle" width="50">
                                                </td>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d-M-Y') }}</td>
                                                <td>{{ $izin->jenis }}</td>
                                                <td>{{ Auth::user()->name }}</td>
                                                <td>{{ $izin->bag->nama_bagian }}</td>

                                                <td>{{ \Carbon\Carbon::parse($izin->tgl_cl)->format('d-M-Y') }}</td>
                                                <td>{{ $izin->keterangan }}</td>
                                                <td>
                                                    @if ($izin->approve_1 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($izin->approve_2 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editIzin({{ $izin->id }})" data-bs-toggle="modal"
                                                        data-bs-target="#editModal">Edit</button>

                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('cutilembur.destroy', $izin->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Izin -->
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Izin, Cuti, Lembur,
                                                    Sakit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editIzinForm" enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editIzinId" name="id">

                                                    <!-- Jenis -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="editJenis" class="form-label">Jenis</label>
                                                            <select class="form-control border border-1" id="editJenis"
                                                                name="jenis" required>
                                                                <option value="">Pilih Jenis</option>
                                                                <option value="Sakit">Sakit</option>
                                                                <option value="Izin">Izin</option>
                                                                <option value="Lembur">Lembur</option>
                                                                <option value="Cuti">Cuti</option>
                                                            </select>
                                                        </div>

                                                        <!-- Nama Karyawan -->

                                                    </div>

                                                    <!-- Tanggal Izin/Cuti/Lembur/Sakit -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="editTanggalMulai" class="form-label">Tanggal
                                                                Mulai</label>
                                                            <input type="date" class="form-control border border-1"
                                                                id="editTanggalMulai" name="tanggal_awal" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="editTanggalAkhir" class="form-label">Tanggal
                                                                Akhir</label>
                                                            <input type="date" class="form-control border border-1"
                                                                id="editTanggalAkhir" name="tanggal_akhir" required>
                                                        </div>
                                                    </div>

                                                    <!-- Keterangan -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="editKeterangan"
                                                                class="form-label">Keterangan</label>
                                                            <textarea class="form-control border border-1" id="editKeterangan" name="keterangan" rows="3" required></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Foto/Dokumen -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="editDokumen" class="form-label">Dokumen/Gambar
                                                                (Opsional)</label>
                                                            <input type="file" class="form-control border border-1"
                                                                id="editDokumen" name="dokumen">
                                                        </div>
                                                    </div>

                                                    <!-- Approve Status -->


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

                            </div>
                        </div>

                        <!-- Modal untuk Tambah Izin -->
                        <div class="modal fade" id="izinModal" tabindex="-1" role="dialog"
                            aria-labelledby="izinModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="izinModalLabel">Tambah Izin, Cuti, Lembur, Sakit
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="izinForm" action="{{ route('cutilembur.store') }}" method="POST"
                                            enctype="multipart/form-data" class="needs-validation" novalidate>
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="jenis" class="form-label">Jenis</label>
                                                    <select class="form-control border border-1" id="jenis"
                                                        name="jenis" onchange="toggleCuti()" required>
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
                                                    <input type="text" class="form-control border border-1"
                                                        id="nama" name="nama"
                                                        value="{{ Auth::user()->name }}" readonly>
                                                    <div class="invalid-feedback">Nama karyawan wajib diisi.</div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                                    <input type="date" class="form-control border border-1"
                                                        id="tanggal_awal" name="tanggal_awal" required>
                                                    <div class="invalid-feedback">Tanggal awal wajib diisi.</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="tanggal_akhir" class="form-label">Tanggal
                                                        Akhir</label>
                                                    <input type="date" class="form-control border border-1"
                                                        id="tanggal_akhir" name="tanggal_akhir" required>
                                                    <div class="invalid-feedback">Tanggal akhir wajib diisi.</div>
                                                </div>
                                            </div>

                                            <!-- Select Sisa Cuti, hanya tampil jika jenis cuti -->
                                            <div class="row mb-3" id="sisaCutiDiv" style="display: none;">
                                                <div class="col-md-12">
                                                    <label for="sisa_cuti" class="form-label">Sisa Cuti</label>
                                                    <select class="form-control border border-1" id="sisa_cuti"
                                                        name="sisa_cuti">
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
                                                    <input type="file" class="form-control border border-1"
                                                        id="dokumen" name="dokumen">
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

            function editIzin(id) {
                $.ajax({
                    url: '/form-izin/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        // Populate the form fields with the data from the server
                        $('#editIzinForm').attr('action', '/form-izin/' + id);
                        $('#editIzinId').val(data.id);
                        $('#editJenis').val(data.jenis);
                        $('#editTanggalMulai').val(data.tanggal_awal);
                        $('#editTanggalAkhir').val(data.tanggal_akhir);
                        $('#editKeterangan').val(data.keterangan);

                    },
                    error: function() {
                        alert('Gagal mengambil data izin');
                    }
                });
            }
        </script>
    @endpush
</x-layout>
