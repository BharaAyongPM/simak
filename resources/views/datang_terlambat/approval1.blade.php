<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="datadt"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Datang Terlambat Approval 1"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Approval Datang Terlambat Karyawan</h6>
                        </div>
                        <div class="card-body">
                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs" id="datangTerlambatTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="daftar-datang-terlambat-tab" data-bs-toggle="tab"
                                        href="#daftarDatangTerlambat" role="tab"
                                        aria-controls="daftarDatangTerlambat" aria-selected="true">Daftar Datang
                                        Terlambat</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="history-datang-terlambat-tab" data-bs-toggle="tab"
                                        href="#historyDatangTerlambat" role="tab"
                                        aria-controls="historyDatangTerlambat" aria-selected="false">History</a>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="datangTerlambatTabsContent">
                                <!-- Tab Daftar Datang Terlambat -->
                                <div class="tab-pane fade show active" id="daftarDatangTerlambat" role="tabpanel"
                                    aria-labelledby="daftar-datang-terlambat-tab">
                                    @if ($datangTerlambatKaryawan->isEmpty())
                                        <p class="text-center mt-3">Tidak ada pengajuan datang terlambat untuk
                                            di-approve pada level ini.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($datangTerlambatKaryawan as $index => $datangTerlambat)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $datangTerlambat->karyn->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($datangTerlambat->tanggal)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $datangTerlambat->keterangan }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('datang-terlambat.approve', $datangTerlambat->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <textarea name="keterangan" class="form-control mb-2" placeholder="Keterangan" required></textarea>
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm">Approve</button>
                                                                </form>

                                                                <form
                                                                    action="{{ route('datang-terlambat.reject', $datangTerlambat->id) }}"
                                                                    method="POST" class="mt-2">
                                                                    @csrf
                                                                    <textarea name="keterangan" class="form-control mb-2" placeholder="Alasan Penolakan" required></textarea>
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Reject</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                                <!-- Tab History -->
                                <div class="tab-pane fade" id="historyDatangTerlambat" role="tabpanel"
                                    aria-labelledby="history-datang-terlambat-tab">
                                    @if ($datangTerlambatHistory->isEmpty())
                                        <p class="text-center mt-3">Tidak ada history datang terlambat.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal</th>
                                                        <th>Status Approve</th>
                                                        <th>Approve / Rejected By</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($datangTerlambatHistory as $index => $datangTerlambat)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $datangTerlambat->karyn->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($datangTerlambat->tanggal)->format('d-M-Y') }}
                                                            </td>
                                                            <td>
                                                                @if ($datangTerlambat->app_1 == 1)
                                                                    <span class="badge bg-success">Approved</span>
                                                                @elseif ($datangTerlambat->app_1 == -1)
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $datangTerlambat->approveAtasan->name ?? 'N/A' }}
                                                            </td>

                                                            </td>
                                                            <td>{{ $datangTerlambat->keterangan }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('js')
        <!-- jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.table').DataTable({
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
        </script>

        <!-- Sweet Alert for Success or Error Messages -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        </script>
    @endpush
</x-layout>
