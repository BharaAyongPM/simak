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
                                                            $isEditable = \Carbon\Carbon::now()->lt(
                                                                \Carbon\Carbon::parse($tanggal)->subDay(),
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

        <!-- Modal for Editing Shift -->
        <div class="modal fade" id="shiftModal" tabindex="-1" role="dialog" aria-labelledby="shiftModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shiftModalLabel">Edit Shift</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editShiftForm">
                            <input type="hidden" id="kalender_id">
                            <div class="form-group">
                                <label for="shift">Pilih Shift</label>
                                <select class="form-control" id="shift" name="shift">
                                    <!-- Load dynamic shifts from controller -->
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->nama }}">{{ $shift->nama }}
                                            ({{ $shift->masuk }} - {{ $shift->pulang }})
                                        </option>
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

                // Fill modal with data
                $('#kalender_id').val(kalenderId);
                $('#shift').val(shift);
                $('#shiftModal').modal('show');
            });

            // Handle saving the shift change
            $('#saveShiftBtn').click(function() {
                var kalenderId = $('#kalender_id').val();
                var shift = $('#shift').val();

                // Send AJAX request to update the shift
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
                        location.reload(); // Reload page to update table
                    },
                    error: function(response) {
                        alert('Gagal mengubah shift.');
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
