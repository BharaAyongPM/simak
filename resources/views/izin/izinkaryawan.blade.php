<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="dataizin"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Izin Karyawan"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Izin Karyawan - Unit {{ Auth::user()->unt->unit ?? 'Tidak ada data' }}</h6>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <ul class="nav nav-tabs" id="izinTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending"
                                        role="tab" aria-controls="pending" aria-selected="true">Daftar Izin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approved-tab" data-bs-toggle="tab" href="#approved"
                                        role="tab" aria-controls="approved" aria-selected="false">Histori Izin</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="izinTabContent">
                                <!-- Daftar Izin Pending -->
                                <div class="tab-pane fade show active" id="pending" role="tabpanel"
                                    aria-labelledby="pending-tab">
                                    @if ($izinPending->isEmpty())
                                        <p class="text-center">Tidak ada izin yang diajukan oleh karyawan di unit ini.
                                        </p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Jenis Izin</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Keterangan</th>
                                                        <th>Status Approve 1</th>
                                                        <th>Approve 1</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($izinPending as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $izin->jenis }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $izin->keterangan }}</td>
                                                            <td>
                                                                <span class="badge bg-warning">Pending</span>
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('approve1', $izin->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <textarea name="keterangan1" class="form-control mb-2" placeholder="Keterangan" required></textarea>
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm">Approve</button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('unit.approval1.rejectizin', $izin->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <textarea name="keterangan1" class="form-control mb-2" placeholder="Alasan Penolakan" required></textarea>
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

                                <!-- Histori Izin -->
                                <div class="tab-pane fade" id="approved" role="tabpanel"
                                    aria-labelledby="approved-tab">
                                    @if ($izinApprovedOrRejected->isEmpty())
                                        <p class="text-center">Tidak ada histori izin yang di-approve atau ditolak.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Jenis Izin</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Keterangan</th>
                                                        <th>Status Approve 1</th>
                                                        <th>Keterangan Approve/Reject</th>
                                                        <th>Disetujui/Ditolak Oleh</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($izinApprovedOrRejected as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $izin->jenis }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $izin->keterangan }}</td>
                                                            <td>
                                                                @if ($izin->approve_1 == 1)
                                                                    <span class="badge bg-success">Approved</span>
                                                                @elseif ($izin->approve_1 == -1)
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $izin->keterangan1 }}</td>
                                                            <td>{{ $izin->approvedBy1->name ?? 'N/A' }}</td>
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
