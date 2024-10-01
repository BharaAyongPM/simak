{{-- resources/views/admin/dashboard.blade.php --}}
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="admin_dashboard"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Dashboard Admin"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <!-- Total Karyawan -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Karyawan</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $totalKaryawan }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Absensi -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Absensi</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $totalAbsensi }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                        <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Absensi -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Export Absensi</p>
                                        <h5 class="font-weight-bolder">
                                            <a href="{{ route('admin.absensi.export') }}"
                                                class="btn btn-success btn-sm">Export</a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                        <i class="ni ni-folder-17 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Management -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">User Management</p>
                                        <h5 class="font-weight-bolder">
                                            <a href="{{ route('admin.user.management') }}"
                                                class="btn btn-primary btn-sm">Manage Users</a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                        <i class="ni ni-settings text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absensi Terbaru -->
            <div class="row mt-4">
                <div class="container-fluid py-4">
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Absensi Terbaru</h6>
                                </div>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive p-0">
                                        <table id="absensiTable" class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Karyawan</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Tanggal</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Jam Masuk</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Jam Pulang</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($absensiTerbaru as $absensi)
                                                    <tr>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $absensi->karyn ? $absensi->karyn->name : 'Data tidak ditemukan' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $absensi->tanggal }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $absensi->jam_masuk }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $absensi->jam_pulang }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $absensi->keterangan }}</p>
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
            </div>

            @push('js')
                <!-- Include DataTables -->
                <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

                <!-- Initialize DataTables -->
                <script>
                    $(document).ready(function() {
                        $('#absensiTable').DataTable({
                            "pageLength": 10, // Tampilkan 10 data per halaman
                            "lengthChange": true, // Pengguna dapat mengubah jumlah data yang ditampilkan
                            "searching": true, // Tambahkan fitur pencarian
                            "ordering": true, // Tambahkan fitur pengurutan
                            "info": true, // Menampilkan informasi tentang jumlah data
                            "autoWidth": false, // Otomatis menyesuaikan lebar kolom
                            "language": {
                                "paginate": {
                                    "previous": "<",
                                    "next": ">"
                                }
                            }
                        });
                    });
                </script>
            @endpush
</x-layout>
