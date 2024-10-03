@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets/img/logos/logorsip.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">SIMAK RS INSAN PERMATA</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Menu khusus admin -->
            @if (auth()->user()->roles->contains('name', 'ADMIN'))
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Admin Menu</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'admin.absensi.cek' ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.absensi.cek') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">schedule</i>
                        </div>
                        <span class="nav-link-text ms-1">Cek Absensi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'admin.absensi.rekap' ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.absensi.rekap') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">assignment</i>
                        </div>
                        <span class="nav-link-text ms-1">Rekap Absensi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'admin.user.management' ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.user.management') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">manage_accounts</i>
                        </div>
                        <span class="nav-link-text ms-1">User Management</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->roles->contains('name', 'ADMIN') || auth()->user()->roles->contains('name', 'HRD'))
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Data Master
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'karyawan' ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('karyawan.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">people</i>
                        </div>
                        <span class="nav-link-text ms-1">Kelola Karyawan</span>
                    </a>
                </li>
            @endif


            {{-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Data Profil
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'profile' ? 'active bg-gradient-primary' : '' }} "
                    href="{{ route('user-profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-user-circle ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'user-management' ? ' active bg-gradient-primary' : '' }} "
                    href="/user">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li> --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'absensi' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('absensi') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Absensi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'form' ? ' active bg-gradient-primary' : '' }}"
                    data-bs-toggle="collapse" href="#submenuForm" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="nav-link-text ms-1">Form</span>
                </a>
                <!-- Submenu -->
                <div class="collapse" id="submenuForm">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'form-izin' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('izin.index') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Form Izin</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'form-cuti' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('cuti.index') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Form Cuti</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'form-lembur' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('lembur.index') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Form Lembur</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'tukar-shift' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('tukarshift') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Tukar Shift</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'dinas-luar' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('dinasluar') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Dinas Luar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'datang-terlambat' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('datangterlambat') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Datang Terlambat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'dokumen' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('dokumen') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Upload Dokumen</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'pelatihan' ? ' active bg-gradient-primary' : '' }}"
                                href="{{ route('pelatihan') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Pelatihan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'kalender-kerja' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('kalender') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Kalender Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'kalender-kerja' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('kalender_kerja.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Kalender Kerja2</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'virtual-reality' ? ' active bg-gradient-primary' : '' }}  "
                    href="/vr">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'rtl' ? ' active bg-gradient-primary' : '' }}  "
                    href="/rtl">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'notifications' ? ' active bg-gradient-primary' : '' }}  "
                    href="/notifikasi">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">NOTES</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'profile' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('user-profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">Peraturan & SK</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('login') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengumuman</span>
                </a>
            </li>

        </ul>
    </div>

</aside>
