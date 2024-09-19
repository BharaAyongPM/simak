<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='tukar-deposit'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tukar Deposit"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Tukar Deposit (Minimal 7 Jam)</h6>
                            <div>
                                <!-- Button untuk menambah data -->
                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#tukarDepositModal">
                                    <i class="fas fa-plus"></i> Tambah Tukar Deposit
                                </button>
                                <!-- Button untuk melihat histori deposit -->
                                <a href="{{ route('history-deposit') }}" class="btn btn-secondary">
                                    <i class="fas fa-history"></i> Histori Deposit
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="depositTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tukar</th>
                                            <th>Nama</th>
                                            <th>Departemen</th>
                                            <th>Unit</th>
                                            <th>Jabatan</th>
                                            <th>Jumlah Deposit (Jam)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Contoh data -->
                                        <tr>
                                            <td>1</td>
                                            <td><button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#tukarDepositModal"><i
                                                        class="fas fa-exchange-alt"></i> Tukar</button></td>
                                            <td>Bhara Ayong</td>
                                            <td>IT</td>
                                            <td>Jakarta</td>
                                            <td>Staff IT</td>
                                            <td>10 Jam</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tukar Deposit -->
            <div class="modal fade" id="tukarDepositModal" tabindex="-1" role="dialog"
                aria-labelledby="tukarDepositModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tukarDepositModalLabel">Tukar Deposit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tukarDepositForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="namaKaryawan" class="form-label">Nama Karyawan</label>
                                            <input type="text" class="form-control border rounded" id="namaKaryawan"
                                                name="namaKaryawan" value="Bhara Ayong" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jumlahDeposit" class="form-label">Jumlah Deposit (Jam)</label>
                                            <input type="number" class="form-control border rounded" id="jumlahDeposit"
                                                name="jumlahDeposit" value="10" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggalTukar" class="form-label">Tanggal Tukar Deposit</label>
                                            <input type="date" class="form-control border rounded" id="tanggalTukar"
                                                name="tanggalTukar" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary"
                                onclick="submitTukarDeposit()">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
        <!-- jQuery and DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

        <script>
            // Inisialisasi DataTables untuk tabel
            $(document).ready(function() {
                $('#depositTable').DataTable({
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
                            "next": "Berikutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            });

            function submitTukarDeposit() {
                const form = document.getElementById('tukarDepositForm');
                if (form.checkValidity()) {
                    alert('Tukar deposit berhasil disimpan!');
                    form.reset();
                    var tukarDepositModal = bootstrap.Modal.getInstance(document.getElementById('tukarDepositModal'));
                    tukarDepositModal.hide();
                } else {
                    alert('Mohon lengkapi semua data.');
                }
            }
        </script>
    @endpush
</x-layout>
