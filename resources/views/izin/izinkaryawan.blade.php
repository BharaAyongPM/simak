<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="izin"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Izin Karyawan"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Daftar Izin Karyawan di Unit {{ Auth::user()->unt->unit ?? 'Tidak ada data' }}</h6>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            @if ($izinKaryawan->isEmpty())
                                <p class="text-center">Tidak ada izin yang diajukan oleh karyawan di unit ini.</p>
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
                                            @foreach ($izinKaryawan as $index => $izin)
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
                                                        @elseif ($izin->approve_1 == 0 && $izin->keterangan1)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @else
                                                            <span class="badge bg-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Form untuk Approve atau Reject -->
                                                        @if ($izin->approve_1 == 0)
                                                            <form action="{{ route('approve1', $izin->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <textarea name="keterangan1" class="form-control mb-2" placeholder="Keterangan" required></textarea>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-success">Approve</button>
                                                            </form>
                                                        @else
                                                            -
                                                        @endif
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
    </main>

    @push('js')
        <!-- jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.table').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "lengthMenu": [5, 10, 15, 20],
                    "language": {
                        "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                        "zeroRecords": "Tidak ada data yang ditemukan",
                        "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                        "infoEmpty": "Tidak ada data tersedia",
                        "infoFiltered": "(disaring dari _MAX_ total entri)",
                        "search": "Cari:",
                        "paginate": {
                            "next": ">>",
                            "previous": "<<"
                        }
                    }
                });
            });
        </script>

        <!-- Sweet Alert for Success or Error Messages -->
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
