<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="hrdizin"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="HRD Approval 2"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>HRD Approval 2</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs" id="approvalTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="data-izin-tab" data-bs-toggle="tab" href="#data-izin"
                                        role="tab" aria-controls="data-izin" aria-selected="true">Data Izin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history"
                                        role="tab" aria-controls="history" aria-selected="false">History</a>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="approvalTabContent">
                                <!-- Data Izin Tab -->
                                <div class="tab-pane fade show active" id="data-izin" role="tabpanel"
                                    aria-labelledby="data-izin-tab">
                                    @if ($izinBelumDisetujui->isEmpty())
                                        <p class="text-center">Tidak ada izin untuk di-approve pada level 2.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Izin</th>
                                                        <th>Jenis Izin</th>
                                                        <th>Keterangan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($izinBelumDisetujui as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $item->jenis }}</td>
                                                            <td>{{ $item->keterangan1 }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('hrd.approval2.approve', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <textarea name="keterangan2" class="form-control mb-2" placeholder="Keterangan" required></textarea>
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm">Approve</button>
                                                                </form>
                                                                <form action="{{ route('izin.reject2', $item->id) }}"
                                                                    method="POST" style="margin-top: 5px;">
                                                                    @csrf
                                                                    <textarea name="keterangan2" class="form-control mb-2" placeholder="Keterangan" required></textarea>
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

                                <!-- History Tab -->
                                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
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
                                                        <th>Status Approve </th>
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
                                                                @if ($izin->approve_2 == 1)
                                                                    <span class="badge bg-success">Approved</span>
                                                                @elseif ($izin->approve_2 == -1)
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
