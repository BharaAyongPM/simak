<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='cuti'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Form Cuti"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Form Cuti</h6>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">
                                + Ajukan Cuti
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="cutiTable" class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Cuti</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Sisa Cuti</th>
                                            <th>Keterangan</th>
                                            <th>Approve 1</th>
                                            <th>Approve 2</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cuti as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $data->jenisCuti->nama ?? 'Tidak diketahui' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($data->tanggal_mulai)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ $data->sisa_cuti ?? 'N/A' }}</td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td>
                                                    @if ($data->approve_1 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->approve_2 == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Disable buttons if approve_1 is 1 -->
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="editCuti({{ $data->id }})" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        @if ($data->approve_1 == 1) disabled @endif>
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('cuti.destroy', $data->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            @if ($data->approve_1 == 1) disabled @endif
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal Tambah Cuti -->
            <div class="modal fade" id="cutiModal" tabindex="-1" role="dialog" aria-labelledby="cutiModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cutiModalLabel">Ajukan Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="cutiForm" action="{{ route('cuti.store') }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jenis_cuti_id" class="form-label">Jenis Cuti</label>
                                        <select class="form-control border border-1" id="jenis_cuti_id"
                                            name="jenis_cuti_id" required>
                                            <option value="">Pilih Jenis Cuti</option>
                                            @foreach ($jenisCuti as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Jenis cuti wajib diisi.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control border border-1" id="nama"
                                            name="nama" value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control border border-1" id="tanggal_mulai"
                                            name="tanggal_mulai" required>
                                        <div class="invalid-feedback">Tanggal mulai wajib diisi.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control border border-1" id="tanggal_selesai"
                                            name="tanggal_selesai" required>
                                        <div class="invalid-feedback">Tanggal selesai wajib diisi.</div>
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
                                        <button type="submit" class="btn btn-success mt-3">Ajukan Cuti</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Cuti -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editCutiForm" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="editJenisCuti" class="form-label">Jenis Cuti</label>
                                        <select class="form-control border border-1" id="editJenisCuti"
                                            name="jenis_cuti_id" required>
                                            <option value="">Pilih Jenis Cuti</option>
                                            @foreach ($jenisCuti as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="editTanggalMulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control border border-1"
                                            id="editTanggalMulai" name="tanggal_mulai" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="editTanggalSelesai" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control border border-1"
                                            id="editTanggalSelesai" name="tanggal_selesai" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="editKeterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control border border-1" id="editKeterangan" name="keterangan" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-success mt-3">Update Cuti</button>
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
            $(document).ready(function() {
                $('#cutiTable').DataTable({
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

            function editCuti(id) {
                $.ajax({
                    url: '/cuti/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        // Populate the form fields with the data from the server
                        $('#editCutiForm').attr('action', '/cuti/' + id);
                        $('#editJenisCuti').val(data.jenis_cuti_id);
                        $('#editTanggalMulai').val(data.tanggal_mulai);
                        $('#editTanggalSelesai').val(data.tanggal_selesai);
                        $('#editKeterangan').val(data.keterangan);
                    },
                    error: function() {
                        alert('Gagal mengambil data cuti');
                    }
                });
            }
        </script>
    @endpush
</x-layout>
