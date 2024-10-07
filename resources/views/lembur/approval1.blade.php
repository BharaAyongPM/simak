<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="approval1-lembur"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Approval Lembur 1"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <!-- Tabs for Daftar Lembur and Histori -->
            <ul class="nav nav-tabs" id="lemburTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="daftar-lembur-tab" data-bs-toggle="tab"
                        data-bs-target="#daftar-lembur" type="button" role="tab" aria-controls="daftar-lembur"
                        aria-selected="true">Daftar Lembur</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="histori-lembur-tab" data-bs-toggle="tab"
                        data-bs-target="#histori-lembur" type="button" role="tab" aria-controls="histori-lembur"
                        aria-selected="false">Histori Lembur</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="lemburTabsContent">
                <!-- Daftar Lembur Tab -->
                <div class="tab-pane fade show active" id="daftar-lembur" role="tabpanel"
                    aria-labelledby="daftar-lembur-tab">
                    <div class="row mt-4">
                        <div class="col-xl-12 mb-4">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Daftar Lembur Karyawan untuk Approval 1</h6>
                                </div>
                                <div class="card-body px-0 pt-0 pb-2">
                                    @if ($lemburBelumDisetujui->isEmpty())
                                        <p class="text-center">Tidak ada lembur untuk di-approve pada level 1.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Lembur</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Selesai</th>
                                                        <th>Keterangan Lembur</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lemburBelumDisetujui as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lembur)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $item->jam_mulai }}</td>
                                                            <td>{{ $item->jam_selesai }}</td>
                                                            <td>{{ $item->keterangan }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('lembur.approval1', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <textarea name="keterangan1" class="form-control mb-2" placeholder="Keterangan Approval 1" required></textarea>
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Histori Lembur Tab -->
                <div class="tab-pane fade" id="histori-lembur" role="tabpanel" aria-labelledby="histori-lembur-tab">
                    <div class="row mt-4">
                        <div class="col-xl-12 mb-4">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Histori Lembur yang Telah Disetujui</h6>
                                </div>
                                <div class="card-body px-0 pt-0 pb-2">
                                    @if ($lemburDisetujui->isEmpty())
                                        <p class="text-center">Tidak ada lembur yang telah di-approve.</p>
                                    @else
                                        <div class="table-responsive p-4">
                                            <table class="table align-items-center table-hover table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal Lembur</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Selesai</th>
                                                        <th>Keterangan Lembur</th>
                                                        <th>Keterangan Approve 1</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lemburDisetujui as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lembur)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $item->jam_mulai }}</td>
                                                            <td>{{ $item->jam_selesai }}</td>
                                                            <td>{{ $item->keterangan }}</td>
                                                            <td>{{ $item->keterangan1 }}</td>
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
