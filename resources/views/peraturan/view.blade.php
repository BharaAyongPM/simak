<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='peraturanview'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Peraturan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif



            <!-- Tabel Peraturan -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Daftar Peraturan & SK</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="peraturanTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Judul</th>
                                            <th>Keterangan</th>
                                            <th>File</th>
                                            <th>Jenis</th>
                                            <th>Karyawan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peraturans as $index => $peraturan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($peraturan->tanggal)->format('d-M-Y') }}
                                                </td>
                                                <td>{{ $peraturan->judul }}</td>
                                                <td>{{ $peraturan->keterangan }}</td>
                                                <td>
                                                    @if ($peraturan->fhoto)
                                                        @if (Str::endsWith($peraturan->fhoto, ['.jpg', '.png']))
                                                            <a href="{{ asset('storage/' . $peraturan->fhoto) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/' . $peraturan->fhoto) }}"
                                                                    alt="File" width="100px" class="img-thumbnail">
                                                            </a>
                                                        @elseif (Str::endsWith($peraturan->fhoto, ['.pdf']))
                                                            <a href="{{ asset('storage/' . $peraturan->fhoto) }}"
                                                                target="_blank">
                                                                Lihat PDF
                                                            </a>
                                                        @endif
                                                    @else
                                                        Tidak ada file
                                                    @endif
                                                </td>
                                                <td>{{ $peraturan->jenis }}</td>
                                                <td>{{ $peraturan->user->name }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <!-- End of Edit Peraturan Modal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Tabel Peraturan -->



            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
        <!-- jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#peraturanTable').DataTable({
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

            // Edit Peraturan Function
            function editPeraturan(id) {
                $.ajax({
                    url: '/peraturan/edit/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#editPeraturanForm').attr('action', '/peraturan/update/' + id);
                        $('#editPeraturanId').val(data.id);
                        $('#editTanggal').val(data.tanggal);
                        $('#editJudul').val(data.judul);
                        $('#editKeterangan').val(data.keterangan);
                        $('#editStatus').val(data.status);
                        $('#editJenis').val(data.jenis);
                        $('#editDisplayInfo').val(data.display_info);
                    },
                    error: function() {
                        alert('Gagal mengambil data peraturan');
                    }
                });
            }

            // Form Validation
            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>
    @endpush
</x-layout>
