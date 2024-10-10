<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='admin.absensi.rekap'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Rekap Absensi"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Rekap Absensi</h6>
                            </div>
                            <!-- Filter Bagian, Unit, dan Tanggal -->
                            <form id="filter-form" class="d-flex mb-3">
                                <div class="row">
                                    <!-- Pilih Bagian -->
                                    <div class="col-md-3">
                                        <label for="bagian_id" class="form-label">Pilih Bagian:</label>
                                        <select name="bagian_id" id="bagian_id" class="form-control select2"
                                            style="width: 200px;">
                                            <option value="">Pilih Bagian</option>
                                            @foreach ($bagians as $bagian)
                                            <option value="{{ $bagian->id_bagian }}">
                                                {{ $bagian->nama_bagian }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Pilih Unit -->
                                    <div class="col-md-3">
                                        <label for="unit_id" class="form-label">Pilih Unit:</label>
                                        <select name="unit_id" id="unit_id" class="form-control select2">
                                            <option value="">Semua Unit</option>
                                        </select>
                                    </div>

                                    <!-- Filter Tanggal Awal -->
                                    <div class="col-md-3">
                                        <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
                                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                                            value="{{ $tanggalAwal }}">
                                    </div>

                                    <!-- Filter Tanggal Akhir -->
                                    <div class="col-md-3">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                            class="form-control" value="{{ $tanggalAkhir }}">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="rekapAbsensiTable"
                                    class="table align-items-center table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Bagian</th>
                                            <th>Unit</th>
                                            <!-- Header Tanggal Dinamis -->
                                            @php
                                            $start = \Carbon\Carbon::parse($tanggalAwal);
                                            $end = \Carbon\Carbon::parse($tanggalAkhir);
                                            @endphp
                                            @while ($start->lte($end))
                                            <th>{{ $start->format('d') }}</th>
                                            @php $start->addDay(); @endphp
                                            @endwhile
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables akan mengisi data di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('js')
    <!-- Include DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            var table = $('#rekapAbsensiTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.absensi.rekap') }}",
                    "type": "GET",
                    "data": function(d) {
                        d.bagian_id = $('#bagian_id').val();
                        d.unit_id = $('#unit_id').val();
                        d.tanggal_awal = $('#tanggal_awal').val();
                        d.tanggal_akhir = $('#tanggal_akhir').val();
                    }
                },
                "columns": [{
                        "data": "no"
                    },
                    {
                        "data": "karyawan_name"
                    },
                    {
                        "data": "bagian_name"
                    },
                    {
                        "data": "unit"
                    },
                    @php
                    $start = \Carbon\ Carbon::parse($tanggalAwal);
                    $end = \Carbon\ Carbon::parse($tanggalAkhir);
                    @endphp
                    @while($start - > lte($end)) {
                        "data": "tanggal_{{ $start->format('d') }}"
                    },
                    @php $start - > addDay();@endphp
                    @endwhile
                ],
                "pageLength": 10,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    },
                    "search": "Cari:",

                    "lengthMenu": "Tampilkan _MENU_ karyawan per halaman",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ karyawan",
                    "infoEmpty": "Tidak ada karyawan",
                    "zeroRecords": "Data tidak ditemukan",
                    "infoFiltered": "(disaring dari _MAX_ total karyawan)"
                }
            });

            // Update DataTables saat filter berubah
            $('#filter-form').on('change', 'select, input', function() {
                table.ajax.reload();
            });
        });

        // Load unit berdasarkan bagian yang dipilih
        $('#bagian_id').on('change', function() {
            var bagianId = $(this).val();
            $('#unit_id').empty();
            $('#unit_id').append('<option value="">Pilih Unit</option>');
            if (bagianId) {
                $.ajax({
                    url: "/get-units-by-bagian/" + bagianId,
                    type: "GET",
                    dataType: "json",
                    success: function(units) {
                        if (units.length === 0) {
                            $('#unit_id').append('<option value="">Tidak ada unit tersedia</option>');
                        }
                        $.each(units, function(key, unit) {
                            $('#unit_id').append('<option value="' + unit.id + '">' + unit
                                .unit + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error("Gagal memuat unit", xhr);
                        $('#unit_id').append('<option value="">Gagal memuat unit</option>');
                    }
                });
            }
        });
    </script>
    @endpush
</x-layout>