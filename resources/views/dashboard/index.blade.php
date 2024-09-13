<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='log-absensi'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
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
                                            <h5>Nama: Bhara Ayong Purna Mustika</h5>
                                            <p>Bagian: TIM SIMRS</p>
                                            <p>Jam Kerja: 08:00 - 17:00</p>
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-success" onclick="showModal('Masuk')">Absen
                                                    Masuk</button>
                                                <button class="btn btn-danger" onclick="showModal('Pulang')">Absen
                                                    Pulang</button>
                                            </div>
                                            <p class="mt-3">Jam Absen Masuk: <span id="jamMasuk">Belum Absen</span>
                                            </p>
                                            <p>Jam Absen Pulang: <span id="jamPulang">Belum Pulang</span></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Log Absensi -->
                                <div class="tab-pane fade" id="log-absen" role="tabpanel"
                                    aria-labelledby="log-absen-tab">
                                    <div class="table-responsive p-4">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        No</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Shift</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Jam Masuk</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Jam Pulang</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Lokasi</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Foto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Loop data absensi di sini --}}
                                                <tr>
                                                    <td>1</td>
                                                    <td>Back Office</td>
                                                    <td>08:00</td>
                                                    <td>17:00</td>
                                                    <td>Jakarta</td>
                                                    <td><img src="{{ asset('path/to/foto') }}" alt="Foto Absen"
                                                            class="img-fluid rounded-circle" width="50"></td>
                                                </tr>
                                                {{-- @endforeach --}}
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
                            <button type="button" class="btn btn-success" onclick="submitAbsen()">Submit
                                Absen</button>
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

            function showModal(absenType) {
                // Set the modal title
                document.getElementById('absenModalLabel').innerText = `Absen ${absenType}`;
                // Show the modal
                var absenModal = new bootstrap.Modal(document.getElementById('absenModal'), {});
                absenModal.show();

                // Start video stream
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        video.srcObject = stream;
                    })
                    .catch(function(err) {
                        console.log("Error accessing the camera: " + err);
                    });

                // Get geolocation
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        document.getElementById('lokasi').innerText = `Latitude: ${latitude}, Longitude: ${longitude}`;
                        document.getElementById('latitude').value = latitude;
                        document.getElementById('longitude').value = longitude;

                        // Call Nominatim API to get the location name
                        fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`)
                            .then(response => response.json())
                            .then(data => {
                                let locationName = data.display_name || 'Lokasi tidak ditemukan';
                                document.getElementById('namaLokasi').innerText = `Nama Lokasi: ${locationName}`;
                            })
                            .catch(err => {
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
                let jamAbsen = new Date().toLocaleTimeString();
                if (document.getElementById('absenModalLabel').innerText.includes('Masuk')) {
                    document.getElementById('jamMasuk').innerText = jamAbsen;
                } else {
                    document.getElementById('jamPulang').innerText = jamAbsen;
                }
                alert("Absen berhasil dengan foto dan lokasi.");
                var absenModal = bootstrap.Modal.getInstance(document.getElementById('absenModal'));
                absenModal.hide();
            }
        </script>
    @endpush
</x-layout>
