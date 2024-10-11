<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="approval2-datangterlambat"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="HRD Approval Datang Terlambat"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Approval Datang Terlambat HRD</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <ul class="nav nav-tabs" id="approvalTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="daftar-datangterlambat-tab" data-bs-toggle="tab"
                                        href="#daftar-datangterlambat" role="tab"
                                        aria-controls="daftar-datangterlambat" aria-selected="true">Daftar Datang
                                        Terlambat</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="history-datangterlambat-tab" data-bs-toggle="tab"
                                        href="#history-datangterlambat" role="tab"
                                        aria-controls="history-datangterlambat" aria-selected="false">History Datang
                                        Terlambat</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="approvalTabsContent">
                                <!-- Daftar Datang Terlambat -->
                                <div class="tab-pane fade show active" id="daftar-datangterlambat" role="tabpanel"
                                    aria-labelledby="daftar-datangterlambat-tab">
                                    @if ($datangTerlambatBelumDisetujui->isEmpty())
                                        <p class="text-center">Tidak ada pengajuan datang terlambat yang perlu
                                            di-approve.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Keterangan</th>
                                                        <th>Keterangan Approve 1</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($datangTerlambatBelumDisetujui as $index => $datangTerlambat)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $datangTerlambat->karyn->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($datangTerlambat->tanggal)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $datangTerlambat->keterangan }}</td>
                                                            <td>{{ $datangTerlambat->keterangan1 }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('datang-terlambat.approve-sdi', $datangTerlambat->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <textarea name="keterangan2" class="form-control mb-2" placeholder="Keterangan" required></textarea>
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm">Approve</button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('datang-terlambat.reject-sdi', $datangTerlambat->id) }}"
                                                                    method="POST" class="mt-2">
                                                                    @csrf
                                                                    <textarea name="keterangan2" class="form-control mb-2" placeholder="Alasan Penolakan" required></textarea>
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
                                <!-- History Datang Terlambat -->
                                <div class="tab-pane fade" id="history-datangterlambat" role="tabpanel"
                                    aria-labelledby="history-datangterlambat-tab">
                                    @if ($datangTerlambatDisetujui->isEmpty())
                                        <p class="text-center">Belum ada history datang terlambat yang di-approve HRD.
                                        </p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Keterangan</th>
                                                        <th>Status Approve 2</th>
                                                        <th>Keterangan Approve 2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($datangTerlambatDisetujui as $index => $datangTerlambat)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $datangTerlambat->karyn->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($datangTerlambat->tanggal)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $datangTerlambat->keterangan }}</td>
                                                            <td>
                                                                @if ($datangTerlambat->app_2 == 1)
                                                                    <span class="badge bg-success">Approved</span>
                                                                @else
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $datangTerlambat->keterangan2 }}</td>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Cek jika ada session success atau error
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
