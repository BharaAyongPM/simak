<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="approval2"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="HRD Approval Lembur"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Approval Lembur oleh HRD</h6>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <ul class="nav nav-tabs" id="lemburTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending"
                                        role="tab" aria-controls="pending" aria-selected="true">Daftar Lembur</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approved-tab" data-bs-toggle="tab" href="#approved"
                                        role="tab" aria-controls="approved" aria-selected="false">Histori Lembur</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="lemburTabContent">
                                <!-- Daftar Lembur yang Butuh Approval 2 -->
                                <div class="tab-pane fade show active" id="pending" role="tabpanel"
                                    aria-labelledby="pending-tab">
                                    @if ($lemburBelumDisetujui->isEmpty())
                                        <p class="text-center">Tidak ada lembur yang memerlukan persetujuan HRD.</p>
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
                                                        <th>Keterangan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lemburBelumDisetujui as $index => $lembur)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $lembur->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($lembur->tanggal)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $lembur->jam_mulai }}</td>
                                                            <td>{{ $lembur->jam_selesai }}</td>
                                                            <td>{{ $lembur->keterangan1 }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('lembur.approval2', $lembur->id) }}"
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

                                <!-- Histori Lembur yang sudah di-approve -->
                                <div class="tab-pane fade" id="approved" role="tabpanel"
                                    aria-labelledby="approved-tab">
                                    @if ($lemburDisetujui->isEmpty())
                                        <p class="text-center">Belum ada lembur yang di-approve oleh HRD.</p>
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
                                                        <th>Keterangan</th>
                                                        <th>Status Approve</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lemburDisetujui as $index => $lembur)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $lembur->user->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($lembur->tanggal)->format('d-M-Y') }}
                                                            </td>
                                                            <td>{{ $lembur->jam_mulai }}</td>
                                                            <td>{{ $lembur->jam_selesai }}</td>
                                                            <td>{{ $lembur->keterangan2 }}</td>
                                                            <td>
                                                                <span class="badge bg-success">Approved</span>
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
