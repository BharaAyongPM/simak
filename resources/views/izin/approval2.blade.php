<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="dapproval2"></x-navbars.sidebar>
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
                                    @if ($izinDisetujui->isEmpty())
                                        <p class="text-center">Tidak ada izin yang sudah di-approve pada level 2.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Izin</th>
                                                        <th>Jenis Izin</th>
                                                        <th>Keterangan Approve 1</th>
                                                        <th>Keterangan Approve 2</th>
                                                        <th>Tanggal Approve 2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($izinDisetujui as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $item->jenis }}</td>
                                                            <td>{{ $item->keterangan1 }}</td>
                                                            <td>{{ $item->keterangan2 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-M-Y') }}
                                                            </td>
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
