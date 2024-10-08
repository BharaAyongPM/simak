<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="approval2"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="HRD Approval Cuti"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Approval Cuti HRD</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <ul class="nav nav-tabs" id="approvalTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="daftar-cuti-tab" data-bs-toggle="tab"
                                        href="#daftar-cuti" role="tab" aria-controls="daftar-cuti"
                                        aria-selected="true">Daftar Cuti</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="history-cuti-tab" data-bs-toggle="tab" href="#history-cuti"
                                        role="tab" aria-controls="history-cuti" aria-selected="false">History
                                        Cuti</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="approvalTabsContent">
                                <!-- Daftar Cuti -->
                                <div class="tab-pane fade show active" id="daftar-cuti" role="tabpanel"
                                    aria-labelledby="daftar-cuti-tab">
                                    @if ($cutiBelumDisetujui->isEmpty())
                                        <p class="text-center">Tidak ada cuti yang perlu di-approve.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Jenis Cuti</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Keterangan Approve 1</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cutiBelumDisetujui as $index => $cuti)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $cuti->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($cuti->created_at)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $cuti->jenisCuti->nama }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $cuti->keterangan1 }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('hrd.approval2.approvecuti', $cuti->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <textarea name="keterangan2" class="form-control mb-2" placeholder="Keterangan" required></textarea>
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm">Approve</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                                <!-- History Cuti -->
                                <div class="tab-pane fade" id="history-cuti" role="tabpanel"
                                    aria-labelledby="history-cuti-tab">
                                    @if ($cutiDisetujui->isEmpty())
                                        <p class="text-center">Belum ada history cuti yang di-approve HRD.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Jenis Cuti</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Status Approve 2</th>
                                                        <th>Keterangan Approve 2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cutiDisetujui as $index => $cuti)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $cuti->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($cuti->created_at)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $cuti->jenisCuti->nama }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d-M-Y') }}
                                                            </td>
                                                            <td>
                                                                @if ($cuti->approve_2 == 1)
                                                                    <span class="badge bg-success">Approved</span>
                                                                @else
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $cuti->keterangan2 }}</td>
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
