<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='form-lembur'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Lembur"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Pengajuan Lembur dan Histori Redeem</h6>
                            <div class="d-flex justify-content-end">
                                <!-- Tambahkan div pembungkus dengan justify-content-end -->
                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#lemburModal">
                                    + Ajukan Lembur
                                </button>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#redeemModal">
                                    Redeem Deposit
                                </button>
                            </div>
                        </div>

                        <!-- Tabs navigation -->
                        <ul class="nav nav-tabs" id="lemburTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pengajuan-tab" data-bs-toggle="tab" href="#pengajuan"
                                    role="tab" aria-controls="pengajuan" aria-selected="true">Pengajuan Lembur</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="redeem-tab" data-bs-toggle="tab" href="#redeem" role="tab"
                                    aria-controls="redeem" aria-selected="false">Histori Redeem</a>
                            </li>
                        </ul>

                        <!-- Tabs content -->
                        <div class="tab-content" id="lemburTabsContent">
                            <!-- Tab Pengajuan Lembur -->
                            <div class="tab-pane fade show active" id="pengajuan" role="tabpanel"
                                aria-labelledby="pengajuan-tab">
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive p-4">
                                        <table id="lemburTable"
                                            class="table align-items-center table-hover table-bordered mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Lembur</th>
                                                    <th>Jam Mulai</th>
                                                    <th>Jam Selesai</th>
                                                    <th>Jenis Lembur</th>
                                                    <th>Total Jam</th>
                                                    <th>Total Bayar / Deposit</th>
                                                    <th>Approve 1</th>
                                                    <th>Approve 2</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lembur as $index => $data)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($data->tanggal_lembur)->format('d-M-Y') }}
                                                        </td>
                                                        <td>{{ $data->jam_mulai }}</td>
                                                        <td>{{ $data->jam_selesai }}</td>
                                                        <td>{{ ucfirst($data->jenis_lembur) }}</td>
                                                        <td>{{ $data->total_jam }} Jam</td>
                                                        <td>
                                                            @if ($data->jenis_lembur == 'bayar')
                                                                Rp{{ number_format($data->total_bayar, 0, ',', '.') }}
                                                            @else
                                                                {{ $data->deposit_jam }} Jam
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($data->approve_1)
                                                                <span class="badge bg-success">Approved</span>
                                                            @else
                                                                <span class="badge bg-danger">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($data->approve_2)
                                                                <span class="badge bg-success">Approved</span>
                                                            @else
                                                                <span class="badge bg-danger">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm"
                                                                onclick="editLembur({{ $data->id }})"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal">Edit</button>
                                                            <form action="{{ route('lembur.destroy', $data->id) }}"
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
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Histori Redeem -->
                            <div class="tab-pane fade" id="redeem" role="tabpanel" aria-labelledby="redeem-tab">
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive p-4">
                                        <table id="redeemTable"
                                            class="table align-items-center table-hover table-bordered mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Redeem</th>
                                                    <th>Hari Libur</th>
                                                    <th>Jam yang Diredeem</th>
                                                    <th>Approve 1</th>
                                                    <th>Approve 2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($redeemHistory as $index => $redeem)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($redeem->created_at)->format('d-M-Y') }}
                                                        </td>
                                                        <td>{{ $redeem->hari_libur }}</td>
                                                        <td>{{ $redeem->jam_yang_diredeem }} Jam</td>
                                                        <td>
                                                            @if ($redeem->approve_1)
                                                                <span class="badge bg-success">Approved</span>
                                                            @else
                                                                <span class="badge bg-danger">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($redeem->approve_2)
                                                                <span class="badge bg-success">Approved</span>
                                                            @else
                                                                <span class="badge bg-danger">Pending</span>
                                                            @endif
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
                </div>
            </div>
            <!-- Modal Tambah Lembur -->
            <div class="modal fade" id="lemburModal" tabindex="-1" role="dialog" aria-labelledby="lemburModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lemburModalLabel">Ajukan Lembur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>

                        </div>
                        <div class="modal-body">
                            <form id="lemburForm" action="{{ route('lembur.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_lembur" class="form-label">Tanggal Lembur</label>
                                        <input type="date" class="form-control border border-1"
                                            id="tanggal_lembur" name="tanggal_lembur" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_lembur" class="form-label">Jenis Lembur</label>
                                        <select class="form-control border border-1" id="jenis_lembur"
                                            name="jenis_lembur" required>
                                            <option value="bayar">Bayar</option>
                                            <option value="deposit">Deposit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                        <input type="time" class="form-control border border-1" id="jam_mulai"
                                            name="jam_mulai" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                        <input type="time" class="form-control border border-1" id="jam_selesai"
                                            name="jam_selesai" required>
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
                                        <label for="dokumen" class="form-label">Dokumen/Gambar (Opsional)</label>
                                        <input type="file" class="form-control border border-1" id="dokumen"
                                            name="dokumen">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-success mt-3">Ajukan Lembur</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="redeemModal" tabindex="-1" role="dialog"
                aria-labelledby="redeemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="redeemModalLabel">Redeem Deposit Lembur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="redeemForm" action="{{ route('lembur.redeem') }}" method="POST">
                                @csrf
                                <p>Total Deposit Anda: <span id="totalDeposit">{{ $totalDeposit }} jam</span></p>
                                @if ($totalDeposit >= 7)
                                    <p class="text-success">Anda dapat menukar deposit dengan hari libur.</p>
                                @else
                                    <p class="text-danger">Deposit belum cukup untuk redeem. Minimal 7 jam.</p>
                                @endif

                                <div class="mb-3">
                                    <label for="hari_libur" class="form-label">Pilih Hari Libur</label>
                                    <input type="date" class="form-control" name="hari_libur" required>
                                </div>

                                <button type="submit" class="btn btn-success"
                                    {{ $totalDeposit < 7 ? 'disabled' : '' }}>Tukar Deposit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Edit Lembur -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Lembur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editLemburForm" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Jenis Lembur -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="editJenisLembur" class="form-label">Jenis Lembur</label>
                                        <select class="form-control border border-1" id="editJenisLembur"
                                            name="jenis_lembur" required>
                                            <option value="bayar">Bayar</option>
                                            <option value="deposit">Deposit</option>
                                        </select>
                                    </div>
                                    <!-- Tanggal Lembur -->
                                    <div class="col-md-6">
                                        <label for="editTanggalLembur" class="form-label">Tanggal Lembur</label>
                                        <input type="date" class="form-control border border-1"
                                            id="editTanggalLembur" name="tanggal_lembur" required>
                                    </div>
                                </div>

                                <!-- Jam Mulai dan Selesai -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="editJamMulai" class="form-label">Jam Mulai</label>
                                        <input type="time" class="form-control border border-1" id="editJamMulai"
                                            name="jam_mulai" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editJamSelesai" class="form-label">Jam Selesai</label>
                                        <input type="time" class="form-control border border-1"
                                            id="editJamSelesai" name="jam_selesai" required>
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="editKeterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control border border-1" id="editKeterangan" name="keterangan" rows="3" required></textarea>
                                    </div>
                                </div>

                                <!-- Dokumen -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="editDokumen" class="form-label">Dokumen/Gambar</label>
                                        <input type="file" class="form-control border border-1" id="editDokumen"
                                            name="dokumen">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-success mt-3">Update Lembur</button>
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
                $('#lemburTable, #redeemTable').DataTable({
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

            function editLembur(id) {
                $.ajax({
                    url: '/lembur/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#editLemburForm').attr('action', '/lembur/' + id);
                        $('#editJenisLembur').val(data.jenis_lembur);
                        $('#editTanggalLembur').val(data.tanggal_lembur);
                        $('#editJamMulai').val(data.jam_mulai);
                        $('#editJamSelesai').val(data.jam_selesai);
                        $('#editKeterangan').val(data.keterangan);
                    },
                    error: function() {
                        alert('Gagal mengambil data lembur');
                    }
                });
            }
        </script>
    @endpush
</x-layout>
