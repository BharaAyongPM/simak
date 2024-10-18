<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Profil Karyawan"></x-navbars.navs.auth>
        <div class="container-fluid py-4">

            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="col-xl-4 col-lg-5 col-md-6 mb-4">
                    <div class="card card-profile shadow-lg">
                        <div class="card-body text-center">
                            <!-- Foto Profil -->
                            @if ($user->foto)
                                <img src="{{ asset('storage/foto/' . $user->foto) }}" class="rounded-circle img-fluid"
                                    style="width: 150px; height: 150px;" alt="Foto Profil">
                            @else
                                <img src="{{ asset('foto.jpg') }}" class="rounded-circle img-fluid" alt="Foto Default">
                            @endif
                            <h5 class="mt-3">{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->jabatan->nama ?? 'Tidak ada jabatan' }}</p>

                            <div class="d-flex flex-column align-items-center">
                                <p class="mb-0"><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Telepon:</strong> {{ $user->no_telp }}</p>
                            </div>

                        </div>
                    </div>
                    <!-- Tombol Ganti Foto Profil -->
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                        data-bs-target="#gantiFotoProfilModal">Ganti
                        Foto Profil</button>
                </div>


                <!-- Modal untuk Unggah Foto Profil -->
                <div class="modal fade" id="gantiFotoProfilModal" tabindex="-1"
                    aria-labelledby="gantiFotoProfilModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="gantiFotoProfilModalLabel">Ganti Foto Profil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="cropForm" method="POST" action="{{ route('profil.update.foto') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="foto" id="uploadFoto" accept="image/*"
                                        class="form-control mb-3">

                                    <!-- Tempat gambar yang akan di-crop -->
                                    <div class="img-container" style="display: none;">
                                        <img id="cropImage" style="max-width: 100%;">
                                    </div>

                                    <input type="hidden" id="croppedImageData" name="croppedImageData">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary" id="saveFotoBtn">Simpan
                                            Foto</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Profil -->
                <div class="col-xl-8 col-lg-7 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Profil Karyawan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">NIK</label>
                                        <input type="text" class="form-control" value="{{ $user->nik }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ $user->email }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" value="{{ $user->no_telp }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Divisi</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->bag->nama_bagian ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Unit</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->unt->unit ?? '-' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->jabatan->nama ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Status Karyawan</label>
                                        <input type="text" class="form-control" value="{{ $user->status_kar }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Agama</label>
                                        <input type="text" class="form-control" value="{{ $user->agama }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($user->kelamin) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($user->tgl_lahir)->format('d M Y') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Tanggal Masuk</label>
                                        <input type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($user->tgl_masuk)->format('d M Y') }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="border p-3 rounded">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" rows="2" readonly>{{ $user->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#updateProfilModal">Update Profil</button>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="updateProfilModal" tabindex="-1"
                    aria-labelledby="updateProfilModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateProfilModalLabel">Update Profil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('profil.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_telp" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                                            value="{{ $user->no_telp }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="agama" class="form-label">Agama</label>
                                        <select class="form-control" id="agama" name="agama" required>
                                            <option value="Islam" {{ $user->agama == 'Islam' ? 'selected' : '' }}>
                                                Islam
                                            </option>
                                            <option value="Kristen" {{ $user->agama == 'Kristen' ? 'selected' : '' }}>
                                                Kristen
                                            </option>
                                            <option value="Hindu" {{ $user->agama == 'Hindu' ? 'selected' : '' }}>
                                                Hindu
                                            </option>
                                            <option value="Budha" {{ $user->agama == 'Budha' ? 'selected' : '' }}>
                                                Budha
                                            </option>
                                            <option value="Lainnya" {{ $user->agama == 'Lainnya' ? 'selected' : '' }}>
                                                Lainnya
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" id="kelamin" name="kelamin" required>
                                            <option value="Pria" {{ $user->kelamin == 'Pria' ? 'selected' : '' }}>
                                                Pria
                                            </option>
                                            <option value="Wanita" {{ $user->kelamin == 'Wanita' ? 'selected' : '' }}>
                                                Wanita
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $user->alamat }}</textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <x-footers.auth></x-footers.auth>
                </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
        <!-- Cropper.js CSS -->


        <!-- Cropper.js JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

        <script>
            document.getElementById('uploadFoto').addEventListener('change', function(e) {
                var image = document.getElementById('cropImage');
                var files = e.target.files;

                if (files && files.length > 0) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        image.src = event.target.result;
                        document.querySelector('.img-container').style.display = 'block';

                        // Inisialisasi Cropper.js
                        var cropper = new Cropper(image, {
                            aspectRatio: 1, // Rasio 1:1
                            viewMode: 2,
                            preview: '.preview',
                        });

                        // Saat tombol Simpan ditekan
                        document.getElementById('saveFotoBtn').addEventListener('click', function(event) {
                            event.preventDefault();

                            // Dapatkan data gambar yang telah di-crop
                            var canvas = cropper.getCroppedCanvas({
                                width: 150, // Lebar output yang diinginkan
                                height: 150, // Tinggi output yang diinginkan
                            });

                            // Ubah gambar yang di-crop menjadi base64
                            canvas.toBlob(function(blob) {
                                var reader = new FileReader();
                                reader.readAsDataURL(blob);
                                reader.onloadend = function() {
                                    var base64data = reader.result;
                                    document.getElementById('croppedImageData').value =
                                        base64data;

                                    // Submit form dengan data gambar
                                    document.getElementById('cropForm').submit();
                                };
                            });
                        });
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        </script>
    @endpush
</x-layout>
