<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="kalender-kerja"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Kalender Kerja Saya"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Kalender Kerja Periode {{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Shift</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kalenderKerja as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}
                                                </td> <!-- Hari dalam bahasa Indonesia -->
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge
                                                        @if ($item->shift != 'OFF') bg-success
                                                        @else
                                                            bg-danger @endif">
                                                        {{ $item->shift }}
                                                    </span>
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
    </main>
</x-layout>
