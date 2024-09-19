<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Log Absen"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Absensi dan Log Absensi</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Tabs navigation -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="absen-tab" data-bs-toggle="tab" href="#absen"
                                        role="tab" aria-controls="absen" aria-selected="true">Absen</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="log-absen-tab" data-bs-toggle="tab" href="#log-absen"
                                        role="tab" aria-controls="log-absen" aria-selected="false">Log Absensi</a>
                                </li>
                            </ul>

                            <!-- Tabs content -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Tab Absen -->
                                <div class="tab-pane fade show active" id="absen" role="tabpanel"
                                    aria-labelledby="absen-tab">
                                    <div class="row p-4">
                                        <div class="col-md-4 text-center">
                                            <img src="{{ asset('foto.jpg') }}" alt="Foto Karyawan"
                                                class="img-fluid rounded-circle mb-3">
                                        </div>
                                        <div class="col-md-8">
                                            <h5>Nama: {{ Auth::user()->name }}</h5>
                                            <p>Bagian: {{ $lokasi->bag->nama_bagian ?? 'Tidak diketahui' }}</p>
                                            <p>Shift: {{ $lokasi->shift ?? 'Tidak diketahui' }}</p>

                                            <p>Jam Kerja: {{ $lokasi->jam_masuk ?? 'N/A' }} -
                                                {{ $lokasi->jam_pulang ?? 'N/A' }}</p>

                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-success" onclick="showModal('Masuk')">
                                                    {{-- @if ($latestAbsensi && $latestAbsensi->jenis == 'Masuk') disabled @endif> --}}
                                                    Absen Masuk
                                                </button>
                                                <button class="btn btn-danger" onclick="showModal('Pulang')">Absen
                                                    Pulang</button>
                                            </div>

                                            <p class="mt-3">Jam Absen Masuk: <span
                                                    id="jamMasuk">{{ $latestAbsensi->jam ?? 'Belum Absen' }}</span></p>
                                            <p>Jam Absen Pulang: <span
                                                    id="jamPulang">{{ $latestAbsensi->jam_pulang ?? 'Belum Pulang' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Log Absensi -->
                                <div class="tab-pane fade" id="log-absen" role="tabpanel"
                                    aria-labelledby="log-absen-tab">
                                    <div class="table-responsive p-4">
                                        <table class="table align-items-center table-hover table-bordered mb-0"
                                            id="logAbsenTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Shift</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Lokasi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Loop through multiple absensi records -->
                                                @foreach ($absensi as $index => $log)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $log->shift ?? 'N/A' }}</td>
                                                        <td>{{ $log->jam ?? 'Belum Absen' }}</td>
                                                        <td>{{ $log->jam_pulang ?? 'Belum Pulang' }}</td>
                                                        <td>{{ $log->lokasi ?? 'Tidak diketahui' }}</td>
                                                        <td>{{ $log->keterangan ?? 'Tidak diketahui' }}</td>
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

            <!-- Modal untuk Absen -->
            <div class="modal fade" id="absenModal" tabindex="-1" role="dialog" aria-labelledby="absenModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="absenModalLabel">Absen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Silakan ambil foto dan izinkan akses lokasi untuk absen.</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Foto</h6>
                                    <video id="video" width="100%" autoplay></video>
                                    <button id="capture" class="btn btn-primary mt-2">Ambil Foto</button>
                                    <canvas id="canvas" class="d-none"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <h6>Lokasi</h6>
                                    <p id="lokasi">Mendeteksi lokasi...</p>
                                    <input type="hidden" id="latitude">
                                    <input type="hidden" id="longitude">
                                    <p id="namaLokasi">Nama Lokasi: </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success" onclick="submitAbsen()">Submit Absen</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal untuk Peringatan Lokasi Jauh -->
            <div class="modal fade" id="lokasiModal" tabindex="-1" role="dialog" aria-labelledby="lokasiModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lokasiModalLabel">Lokasi Jauh</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>LOKASI ANDA JAUH DARI TEMPAT KERJA. TIDAK BISA ABSEN.</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
        <script>
            let video = document.getElementById('video');
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            let latitude, longitude;
            let absenId = null; // Variable to store the ID of the attendance record

            function showModal(absenType) {
                document.getElementById('absenModalLabel').innerText = `Absen ${absenType}`;
                var absenModal = new bootstrap.Modal(document.getElementById('absenModal'), {});
                absenModal.show();

                navigator.mediaDevices.getUserMedia({
                    video: true
                }).then(function(stream) {
                    video.srcObject = stream;
                }).catch(function(err) {
                    console.log("Error accessing the camera: " + err);
                });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        document.getElementById('lokasi').innerText = `Latitude: ${latitude}, Longitude: ${longitude}`;
                        document.getElementById('latitude').value = latitude;
                        document.getElementById('longitude').value = longitude;

                        fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`
                            )
                            .then(response => response.json())
                            .then(data => {
                                let locationName = data.display_name || 'Lokasi tidak ditemukan';
                                document.getElementById('namaLokasi').innerText = `Nama Lokasi: ${locationName}`;
                            }).catch(err => {
                                console.log("Error fetching location name: ", err);
                                document.getElementById('namaLokasi').innerText = 'Nama lokasi tidak ditemukan';
                            });
                    });
                } else {
                    document.getElementById('lokasi').innerText = 'Geolocation tidak didukung oleh browser ini.';
                }
            }

            document.getElementById('capture').addEventListener('click', function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
                canvas.classList.remove('d-none');
                video.classList.add('d-none');
            });

            function submitAbsen() {
                let kantorLat = {{ $setting->lat }}; // Latitude kantor dari database
                let kantorLon = {{ $setting->lon }}; // Longitude kantor dari database
                let lat = parseFloat(document.getElementById('latitude').value);
                let lon = parseFloat(document.getElementById('longitude').value);

                // Haversine formula to calculate distance between two coordinates in meters
                function haversine(lat1, lon1, lat2, lon2) {
                    let R = 6371000; // Earth's radius in meters
                    let dLat = (lat2 - lat1) * Math.PI / 180;
                    let dLon = (lon2 - lon1) * Math.PI / 180;
                    let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    let distance = R * c;
                    return distance; // distance in meters
                }

                // Calculate the distance
                let distance = haversine(kantorLat, kantorLon, lat, lon);

                // Jika jarak lebih dari 100 meter, munculkan modal peringatan
                if (distance > 100) {
                    var lokasiModal = new bootstrap.Modal(document.getElementById('lokasiModal'), {});
                    lokasiModal.show();
                    return; // Stop form submission
                }

                // Proceed with absen submission if the location is within range
                let absenType = document.getElementById('absenModalLabel').innerText.includes('Masuk') ? 'masuk' : 'pulang';
                let formData = new FormData();
                formData.append('lat', document.getElementById('latitude').value);
                formData.append('lng', document.getElementById('longitude').value);
                formData.append('lokasi', document.getElementById('namaLokasi').innerText);
                formData.append('foto', canvas.toDataURL('image/png'));
                formData.append('_token', '{{ csrf_token() }}'); // Menambahkan CSRF token

                if (absenType === 'masuk') {
                    $.ajax({
                        url: "{{ route('absensi.masuk') }}",
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            absenId = response.absenId; // Store the absen ID
                            $('#jamMasuk').text(response.jamMasuk);
                            alert(response.message);
                            $('#absenModal').modal('hide');
                        },
                        error: function(error) {
                            alert('Gagal melakukan absen. Silakan coba lagi.');
                        }
                    });
                } else {
                    if (absenId) {
                        $.ajax({
                            url: `/absensi/pulang/${absenId}`,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $('#jamPulang').text(response.jamPulang);
                                alert(response.message);
                                $('#absenModal').modal('hide');
                            },
                            error: function(error) {
                                alert('Gagal melakukan absen pulang. Silakan coba lagi.');
                            }
                        });
                    } else {
                        alert('Gagal melakukan absen pulang. ID absensi tidak ditemukan.');
                    }
                }
            }
        </script>
    @endpush
</x-layout>
