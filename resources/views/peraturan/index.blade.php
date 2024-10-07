<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='peraturan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Peraturan"></x-navbars.navs.auth>
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

            <!-- Tombol Tambah Peraturan -->
            <div class="d-flex justify-content-between mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPeraturanModal">
                    + Tambah Peraturan
                </button>
            </div>

            <!-- Tabel Peraturan -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Daftar Peraturan</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="peraturanTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Judul</th>
                                            <th>Keterangan</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Jenis</th>
                                            <th>Karyawan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peraturans as $index => $peraturan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($peraturan->tanggal)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ $peraturan->judul }}</td>
                                                <td>{{ $peraturan->keterangan }}</td>
                                                <td>
                                                    @if ($peraturan->fhoto)
                                                        @if (Str::endsWith($peraturan->fhoto, ['.jpg', '.png']))
                                                            <a href="{{ asset('storage/' . $peraturan->fhoto) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/' . $peraturan->fhoto) }}"
                                                                    alt="File" width="100px" class="img-thumbnail">
                                                            </a>
                                                        @elseif (Str::endsWith($peraturan->fhoto, ['.pdf']))
                                                            <a href="{{ asset('storage/' . $peraturan->fhoto) }}"
                                                                target="_blank">
                                                                Lihat PDF
                                                            </a>
                                                        @endif
                                                    @else
                                                        Tidak ada file
                                                    @endif
                                                </td>
                                                <td>{{ $peraturan->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}</td>
                                                <td>{{ $peraturan->jenis }}</td>
                                                <td>{{ $peraturan->user->name }}</td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editPeraturan({{ $peraturan->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#editPeraturanModal">
                                                        Edit
                                                    </button>
                                                    <!-- Form Hapus -->
                                                    <form action="{{ route('peraturan.destroy', $peraturan->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus peraturan ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Peraturan -->
                                <div class="modal fade" id="editPeraturanModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editPeraturanModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPeraturanModalLabel">Edit Peraturan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editPeraturanForm" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Hidden ID Field -->
                                                    <input type="hidden" id="editPeraturanId" name="id">
                                                    <!-- Tanggal -->
                                                    <div class="mb-3">
                                                        <label for="editTanggal" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" id="editTanggal"
                                                            name="tanggal" required>
                                                    </div>
                                                    <!-- Judul -->
                                                    <div class="mb-3">
                                                        <label for="editJudul" class="form-label">Judul</label>
                                                        <input type="text" class="form-control" id="editJudul"
                                                            name="judul" required>
                                                    </div>
                                                    <!-- Keterangan -->
                                                    <div class="mb-3">
                                                        <label for="editKeterangan"
                                                            class="form-label">Keterangan</label>
                                                        <textarea class="form-control" id="editKeterangan" name="keterangan" rows="3" required></textarea>
                                                    </div>
                                                    <!-- File -->
                                                    <div class="mb-3">
                                                        <label for="editFhoto" class="form-label">File
                                                            (Foto/PDF)</label>
                                                        <input type="file" class="form-control" id="editFhoto"
                                                            name="fhoto">
                                                    </div>
                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label for="editStatus" class="form-label">Status</label>
                                                        <select class="form-control" id="editStatus" name="status"
                                                            required>
                                                            <option value="aktif">Aktif</option>
                                                            <option value="nonaktif">Nonaktif</option>
                                                        </select>
                                                    </div>
                                                    <!-- Jenis -->
                                                    <div class="mb-3">
                                                        <label for="editJenis" class="form-label">Jenis</label>
                                                        <input type="text" class="form-control" id="editJenis"
                                                            name="jenis" required>
                                                    </div>
                                                    <!-- Display Info -->
                                                    <div class="mb-3">
                                                        <label for="editDisplayInfo" class="form-label">Display
                                                            Info</label>
                                                        <input type="text" class="form-control"
                                                            id="editDisplayInfo" name="display_info">
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
                                <!-- End of Edit Peraturan Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Tabel Peraturan -->

            <!-- Modal untuk Tambah Peraturan -->
            <div class="modal fade" id="tambahPeraturanModal" tabindex="-1" role="dialog"
                aria-labelledby="tambahPeraturanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPeraturanModalLabel">Tambah Peraturan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahPeraturanForm" action="{{ route('peraturan.store') }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                <!-- Tanggal -->
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        required>
                                    <div class="invalid-feedback">Tanggal wajib diisi.</div>
                                </div>
                                <!-- Judul -->
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul"
                                        required>
                                    <div class="invalid-feedback">Judul wajib diisi.</div>
                                </div>
                                <!-- Keterangan -->
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                                    <div class="invalid-feedback">Keterangan wajib diisi.</div>
                                </div>
                                <!-- File (Foto/PDF) -->
                                <div class="mb-3">
                                    <label for="fhoto" class="form-label">File (Foto/PDF)</label>
                                    <input type="file" class="form-control" id="fhoto" name="fhoto"
                                        required>
                                    <div class="invalid-feedback">File wajib diunggah.</div>
                                </div>
                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                    <div class="invalid-feedback">Status wajib dipilih.</div>
                                </div>
                                <!-- Jenis -->
                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis"
                                        required>
                                    <div class="invalid-feedback">Jenis wajib diisi.</div>
                                </div>
                                <!-- Display Info -->
                                <div class="mb-3">
                                    <label for="display_info" class="form-label">Display Info</label>
                                    <input type="text" class="form-control" id="display_info"
                                        name="display_info">
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
            <!-- End of Tambah Peraturan Modal -->

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
                $('#peraturanTable').DataTable({
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

            // Edit Peraturan Function
            function editPeraturan(id) {
                $.ajax({
                    url: '/peraturan/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#editPeraturanForm').attr('action', '/peraturan/update/' + id);
                        $('#editPeraturanId').val(data.id);
                        $('#editTanggal').val(data.tanggal);
                        $('#editJudul').val(data.judul);
                        $('#editKeterangan').val(data.keterangan);
                        $('#editStatus').val(data.status);
                        $('#editJenis').val(data.jenis);
                        $('#editDisplayInfo').val(data.display_info);
                    },
                    error: function() {
                        alert('Gagal mengambil data peraturan');
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
