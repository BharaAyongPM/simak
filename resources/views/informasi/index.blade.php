<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='informasi'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Informasi"></x-navbars.navs.auth>
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

            <!-- Tombol Tambah Informasi -->
            <div class="d-flex justify-content-between mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahInformasiModal">
                    + Tambah Informasi
                </button>
            </div>

            <!-- Tabel Informasi -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Daftar Informasi</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="informasiTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Informasi</th>
                                            <th>Foto</th>
                                            <th>Status</th>
                                            <th>Jenis</th>
                                            <th>Bagian</th>
                                            <th>Unit</th>
                                            <th>Nama Pengirim</th>
                                            <th>Display Info</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($informasis as $index => $informasi)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($informasi->tanggal)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ Str::limit($informasi->informasi, 50) }}</td>
                                                <td>
                                                    @if ($informasi->foto)
                                                        <a href="{{ asset('storage/' . $informasi->foto) }}"
                                                            target="_blank">
                                                            <img src="{{ asset('storage/' . $informasi->foto) }}"
                                                                alt="File" width="100px" class="img-thumbnail">
                                                        </a>
                                                    @else
                                                        Tidak ada foto
                                                    @endif
                                                </td>
                                                <td>{{ $informasi->status_informasi == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                                                <td>{{ $informasi->jenis }}</td>
                                                <td>{{ $informasi->bagian ? $informasi->bag->nama_bagian : '-' }}
                                                </td>
                                                <td>{{ $informasi->unit ? $informasi->unt->unit : '-' }}</td>
                                                <td>{{ $informasi->user->name }}</td>

                                                <td>{{ ucfirst($informasi->display_info) }}</td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editInformasi({{ $informasi->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#editInformasiModal">
                                                        Edit
                                                    </button>
                                                    <!-- Form Hapus -->
                                                    <form action="{{ route('informasi.destroy', $informasi->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit Informasi -->
                                <div class="modal fade" id="editInformasiModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editInformasiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editInformasiModalLabel">Edit Informasi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editInformasiForm" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Tanggal -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editTanggal" class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control" id="editTanggal"
                                                                name="tanggal" required>
                                                        </div>
                                                    </div>

                                                    <!-- Informasi -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editInformasi"
                                                                class="form-label">Informasi</label>
                                                            <textarea class="form-control" id="editInformasi" name="informasi" rows="3" required></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Foto (opsional) -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editFoto" class="form-label">Foto
                                                                (opsional)</label>
                                                            <input type="file" class="form-control" id="editFoto"
                                                                name="foto">
                                                        </div>
                                                    </div>

                                                    <!-- Status Informasi -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editStatusInformasi" class="form-label">Status
                                                                Informasi</label>
                                                            <select class="form-control" id="editStatusInformasi"
                                                                name="status_informasi" required>
                                                                <option value="1">Aktif</option>
                                                                <option value="0">Nonaktif</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Jenis -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editJenis" class="form-label">Jenis</label>
                                                            <select class="form-control" id="editJenis" name="jenis"
                                                                required>
                                                                <option value="semua">Semua Karyawan</option>
                                                                <option value="bagian">Bagian Tertentu</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Bagian -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editBagian" class="form-label">Bagian</label>
                                                            <select class="form-control" id="editBagian"
                                                                name="bagian">
                                                                <option value="">Pilih Bagian</option>
                                                                @foreach ($bags as $bagian)
                                                                    <option value="{{ $bagian->id_bagian }}">
                                                                        {{ $bagian->nama_bagian }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Unit -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editUnit" class="form-label">Unit</label>
                                                            <select class="form-control" id="editUnit"
                                                                name="unit">
                                                                <option value="">Pilih Unit</option>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{ $unit->id }}">
                                                                        {{ $unit->unit }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Display Info -->
                                                    <div class="mb-3">
                                                        <div class="card p-3 shadow-sm">
                                                            <label for="editDisplayInfo" class="form-label">Display
                                                                Info</label>
                                                            <select class="form-control" id="editDisplayInfo"
                                                                name="display_info" required>
                                                                <option value="diam">Diam</option>
                                                                <option value="bergerak">Bergerak</option>
                                                            </select>
                                                        </div>
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
                                <!-- End of Edit Informasi Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Tabel Informasi -->

            <!-- Modal untuk Tambah Informasi -->
            <div class="modal fade" id="tambahInformasiModal" tabindex="-1" role="dialog"
                aria-labelledby="tambahInformasiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahInformasiModalLabel">Tambah Informasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahInformasiForm" action="{{ route('informasi.store') }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                <!-- Tanggal -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            required>
                                        <div class="invalid-feedback">Tanggal wajib diisi.</div>
                                    </div>
                                </div>

                                <!-- Informasi -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="informasi" class="form-label">Informasi</label>
                                        <textarea class="form-control" id="informasi" name="informasi" rows="3" required></textarea>
                                        <div class="invalid-feedback">Informasi wajib diisi.</div>
                                    </div>
                                </div>

                                <!-- Foto (opsional) -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="foto" class="form-label">Foto (opsional)</label>
                                        <input type="file" class="form-control" id="foto" name="foto">
                                    </div>
                                </div>

                                <!-- Status Informasi -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="status_informasi" class="form-label">Status Informasi</label>
                                        <select class="form-control" id="status_informasi" name="status_informasi"
                                            required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                        <div class="invalid-feedback">Status wajib dipilih.</div>
                                    </div>
                                </div>

                                <!-- Jenis -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="jenis" class="form-label">Jenis</label>
                                        <select class="form-control" id="jenis" name="jenis" required>
                                            <option value="semua">Semua Karyawan</option>
                                            <option value="bagian">Bagian Tertentu</option>
                                        </select>
                                        <div class="invalid-feedback">Jenis wajib dipilih.</div>
                                    </div>
                                </div>

                                <!-- Bagian -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="bagian" class="form-label">Bagian</label>
                                        <select class="form-control" id="bagian" name="bagian">
                                            <option value="">Pilih Bagian</option>
                                            @foreach ($bags as $bagian)
                                                <option value="{{ $bagian->id_bagian }}">{{ $bagian->nama_bagian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Unit -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="unit" class="form-label">Unit</label>
                                        <select class="form-control" id="unit" name="unit">
                                            <option value="">Pilih Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Display Info -->
                                <div class="mb-3">
                                    <div class="card p-3 shadow-sm">
                                        <label for="display_info" class="form-label">Display Info</label>
                                        <select class="form-control" id="display_info" name="display_info" required>
                                            <option value="diam">Diam</option>
                                            <option value="bergerak">Bergerak</option>
                                        </select>
                                        <div class="invalid-feedback">Display Info wajib dipilih.</div>
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
            <!-- End of Tambah Informasi Modal -->



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
            // Setup CSRF token untuk semua request AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                $('#informasiTable').DataTable({
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

            // Edit Informasi Function
            // Edit Informasi Function
            function editInformasi(id) {
                $.ajax({
                    url: '/informasi/edit/' + id, // Mengambil data informasi berdasarkan ID
                    method: 'GET',
                    success: function(data) {
                        $('#editInformasiForm').attr('action', '/informasi/' +
                            id); // Set action URL untuk form update
                        $('#editInformasiForm').attr('method', 'POST'); // Mengganti method menjadi POST
                        $('#editInformasiForm input[name="_method"]')
                            .remove(); // Hapus input _method yang lama jika ada
                        $('#editInformasiForm').append(
                            '<input type="hidden" name="_method" value="PUT">'
                        ); // Method spoofing untuk PUT request
                        $('#editInformasiForm input[name="_token"]')
                            .remove(); // Hapus input _token yang lama jika ada
                        $('#editInformasiForm').append('<input type="hidden" name="_token" value="' + $(
                            'meta[name="csrf-token"]').attr('content') + '">'); // Menambahkan CSRF token

                        // Isi form dengan data yang diterima
                        $('#editInformasiId').val(data.id);
                        $('#editTanggal').val(data.tanggal);
                        $('#editInformasi').val(data.informasi);
                        $('#editStatusInformasi').val(data.status_informasi);
                        $('#editJenis').val(data.jenis);
                        $('#editBagian').val(data.bagian);
                        $('#editUnit').val(data.unit);
                        $('#editDisplayInfo').val(data.display_info);
                    },
                    error: function() {
                        alert('Gagal mengambil data informasi');
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
