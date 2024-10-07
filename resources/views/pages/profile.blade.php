<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Profil Karyawan"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 mb-4">
                    <div class="card card-profile shadow-lg">
                        <div class="card-body text-center">
                            <!-- Foto Profil -->
                            {{-- @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" class="rounded-circle img-fluid"
                                    style="width: 150px; height: 150px;" alt="Foto Profil">
                            @else --}}
                            <img src="{{ asset('foto.jpg') }}" class="rounded-circle img-fluid" alt="Foto Default">

                            {{-- @endif --}}
                            <h5 class="mt-3">{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->jabatan->nama ?? 'Tidak ada jabatan' }}</p>

                            <div class="d-flex flex-column align-items-center">
                                <p class="mb-0"><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Telepon:</strong> {{ $user->no_telp }}</p>
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
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" value="{{ $user->nik }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" value="{{ $user->no_telp }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Divisi</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->bag->nama_bagian ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control" value="{{ $user->unt->unit ?? '-' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->jabatan->nama ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status Karyawan</label>
                                    <input type="text" class="form-control" value="{{ $user->status_kar }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Agama</label>
                                    <input type="text" class="form-control" value="{{ $user->agama }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->kelamin) }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="text" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($user->tgl_lahir)->format('d M Y') }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Masuk</label>
                                    <input type="text" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($user->tgl_masuk)->format('d M Y') }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control" rows="2" readonly>{{ $user->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
