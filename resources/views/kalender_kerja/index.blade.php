<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='kalender_kerja'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Kalender Kerja"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Kalender Kerja</h6>
                            <form method="GET" action="{{ route('kalender_kerja.index') }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="date" name="tanggal_awal" class="form-control"
                                            value="{{ $tanggalAwal }}">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="date" name="tanggal_akhir" class="form-control"
                                            value="{{ $tanggalAkhir }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            @if ($kalenderKerja->isEmpty())
                                <p class="text-center">Tidak ada data kalender kerja untuk periode yang dipilih.</p>
                            @else
                                <div class="table-responsive p-4">
                                    <table class="table align-items-center table-hover table-bordered mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Shift</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Pulang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kalenderKerja as $index => $data)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-M-Y') }}
                                                    </td>
                                                    <td>{{ $data->shift }}</td>
                                                    <td>{{ $data->jam_masuk }}</td>
                                                    <td>{{ $data->jam_pulang }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <form action="{{ route('kalender_kerja.upload') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="import_file" class="form-control mb-3" required>
                                <button type="submit" class="btn btn-success">Upload Kalender Kerja</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
