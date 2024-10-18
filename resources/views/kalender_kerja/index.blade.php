<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='kalender_kerja'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Kalender Kerja"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Kalender Kerja</h6>
                                <small>Divisi: {{ Auth::user()->bag->nama_bagian ?? 'Tidak ada data' }} | Unit:
                                    {{ Auth::user()->unt->unit ?? 'Tidak ada data' }}</small>
                            </div>
                            <div>
                                <!-- Tombol Tambah Jadwal -->
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#tambahJadwalModal">Tambah Jadwal</button>
                            </div>
                            <form method="GET" action="{{ route('kalender_kerja.index') }}" class="d-flex">
                                <div class="input-group">
                                    <input type="date" name="tanggal_awal" class="form-control"
                                        value="{{ $tanggalAwal }}">
                                    <input type="date" name="tanggal_akhir" class="form-control ms-2"
                                        value="{{ $tanggalAkhir }}">
                                    <button type="submit" class="btn btn-primary ms-2">Filter</button>
                                </div>
                            </form>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            @if ($karyawanDivisi->isEmpty())
                                <p class="text-center">Tidak ada data karyawan di unit ini.</p>
                            @else
                                <div class="table-responsive p-4">
                                    <table class="table align-items-center table-hover table-bordered mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nama Karyawan</th>
                                                @for ($i = 1; $i <= \Carbon\Carbon::parse($tanggalAkhir)->day; $i++)
                                                    <th>Tanggal {{ $i }}</th>
                                                @endfor
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawanDivisi as $karyawan)
                                                <tr>
                                                    <td>{{ $karyawan->name }}</td>
                                                    @for ($i = 1; $i <= \Carbon\Carbon::parse($tanggalAkhir)->day; $i++)
                                                        @php
                                                            $tanggal = \Carbon\Carbon::createFromFormat(
                                                                'Y-m-d',
                                                                $tanggalAwal,
                                                            )
                                                                ->addDays($i - 1)
                                                                ->toDateString();
                                                            $kalenderKaryawan = $kalenderKerja->get($karyawan->id);
                                                            $kalender = $kalenderKaryawan
                                                                ? $kalenderKaryawan->where('tanggal', $tanggal)->first()
                                                                : null;
                                                            // Tanggal bisa diedit jika hari ini atau masa depan
                                                            $isEditable = \Carbon\Carbon::parse($tanggal)->gte(
                                                                \Carbon\Carbon::today(),
                                                            );
                                                        @endphp
                                                        <td>
                                                            @if ($isEditable)
                                                                @if ($kalender)
                                                                    <a href="javascript:void(0);" class="edit-shift"
                                                                        data-id="{{ $kalender->id }}"
                                                                        data-shift="{{ $kalender->shift }}"
                                                                        data-tanggal="{{ $tanggal }}"
                                                                        data-karyawan="{{ $karyawan->id }}">
                                                                        {{ $kalender->shift }}
                                                                        ({{ $kalender->jam_masuk }}
                                                                        - {{ $kalender->jam_pulang }})
                                                                    </a>
                                                                @else
                                                                    Kosong
                                                                @endif
                                                            @else
                                                                @if ($kalender)
                                                                    {{ $kalender->shift }} ({{ $kalender->jam_masuk }}
                                                                    - {{ $kalender->jam_pulang }})
                                                                @else
                                                                    Kosong
                                                                @endif
                                                            @endif
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>


                        <div class="card-footer">
                            <form action="{{ route('kalender_kerja.uploadkplunit') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="import_file" class="form-control mb-3" required>
                                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                                <button type="submit" class="btn btn-success">Upload Kalender Kerja</button>
                            </form>
                            <form method="GET" action="{{ route('kalender_kerja.download_template') }}">
                                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                                <button type="submit" class="btn btn-primary">Download Template Excel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Jadwal -->
        <div class="modal fade" id="tambahJadwalModal" tabindex="-1" role="dialog"
            aria-labelledby="tambahJadwalModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahJadwalModalLabel">Tambah Jadwal Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahJadwalForm">
                            @csrf

                            <!-- Pilih Karyawan -->
                            <div class="form-group">
                                <label for="karyawan">Pilih Karyawan</label>
                                <select name="karyawan_id" id="karyawan" class="form-control" required>
                                    @foreach ($karyawanDivisi as $karyawan)
                                        <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Pilih Tanggal -->
                            <div class="form-group mt-3">
                                <label for="tanggal">Pilih Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>

                            <!-- Pilih Shift -->
                            <div class="form-group mt-3">
                                <label for="shift">Pilih Shift</label>
                                <select name="shift_id" id="shift" class="form-control" required>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->nama }} ({{ $shift->masuk }}
                                            - {{ $shift->pulang }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" id="saveJadwalBtn">Simpan
                                    Jadwal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Shift -->
        <div class="modal fade" id="shiftModal" tabindex="-1" role="dialog" aria-labelledby="shiftModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shiftModalLabel">Edit Shift</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editShiftForm">
                            <input type="hidden" id="kalender_id">
                            <!-- Dropdown untuk Pilihan Shift -->
                            <div class="form-group">
                                <label for="shift">Pilih Shift</label>
                                <select class="form-control" id="shift" name="shift" required>
                                    <!-- Tambahkan "required" -->
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->nama }}">{{ $shift->nama }} ({{ $shift->masuk }}
                                            - {{ $shift->pulang }})</option>
                                    @endforeach
                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveShiftBtn">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('js')
        <script>
            // Handle when user clicks on a shift to edit it
            $(document).on('click', '.edit-shift', function() {
                var kalenderId = $(this).data('id');
                var shift = $(this).data('shift');
                var tanggal = $(this).data('tanggal');

                // Set nilai di modal form
                $('#kalender_id').val(kalenderId);
                $('#shift').val(shift); // Isi dropdown shift dengan nilai yang ada
                $('#shiftModal').modal('show');
            });

            // Handle saving the shift change
            $('#saveShiftBtn').click(function() {
                var kalenderId = $('#kalender_id').val();
                var shift = $('#shift').val();

                // Pastikan shift sudah dipilih
                if (!shift || shift === '') {
                    alert('Pilih shift terlebih dahulu.');
                    return;
                }

                // Kirim request AJAX untuk memperbarui shift
                $.ajax({
                    url: '/kalender_kerja/update-shift',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        kalender_id: kalenderId,
                        shift: shift
                    },
                    success: function(response) {
                        alert('Shift berhasil diubah!');
                        location.reload(); // Reload halaman untuk memperbarui tabel
                    },
                    error: function(response) {
                        alert('Gagal mengubah shift.');
                    }
                });
            });


            $('#tambahJadwalForm').submit(function(e) {
                e.preventDefault(); // Prevent form submission

                var formData = {
                    _token: '{{ csrf_token() }}',
                    karyawan_id: $('#karyawan').val(),
                    tanggal: $('#tanggal').val(),
                    shift_id: $('#shift').val(),
                };

                // Kirim data melalui AJAX
                $.ajax({
                    url: '{{ route('kalender_kerja.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Jika sukses, tampilkan pesan dan reload halaman
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Jadwal baru berhasil ditambahkan.',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        // Reload halaman setelah 2 detik
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(response) {
                        // Jika ada error, tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menambahkan jadwal.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });
        </script>
    @endpush
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
