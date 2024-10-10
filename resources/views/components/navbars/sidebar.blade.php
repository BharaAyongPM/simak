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
                    <a class="nav-link text-white {{ $activePage == 'admin.absensi.cek' ? 'active bg-gradient-success' : '' }}"
                        href="{{ route('admin.absensi.cek') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">schedule</i>
                        </div>
                        <span class="nav-link-text ms-1">Cek Absensi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'admin.absensi.rekap' ? 'active bg-gradient-success' : '' }}"
                        href="{{ route('admin.absensi.rekap') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">assignment</i>
                        </div>
                        <span class="nav-link-text ms-1">Rekap Absensi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'user_managements' ? 'active bg-gradient-success' : '' }}"
                        href="{{ route('admin.user.management') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">manage_accounts</i>
                        </div>
                        <span class="nav-link-text ms-1">User Management</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->roles->contains('name', 'ADMIN') || auth()->user()->roles->contains('name', 'HRD'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'data-master' ? ' active bg-gradient-success' : '' }}"
                        data-bs-toggle="collapse" href="#submenuForm" aria-expanded="false">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">

                        </div>
                        <span class="nav-link-text ms-1">Data Master</span>
                    </a>
                    <!-- Submenu -->
                    <div class="collapse" id="submenuForm">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'karyawan' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('karyawan.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">people</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Karyawan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'jabatans' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('jabatans.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">person</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Jabatan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'shifts' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('shifts.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">access_time</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Shift</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'jeniscuti' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('jeniscuti.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">beach_access</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Jenis Cuti</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'bagian' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('bagian.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">person</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Departemen</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'unit' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('unit.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">group_work</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Unit</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'libur' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('libur.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">event</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Hari Libur</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'datastockcuti' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('datastockcuti.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">card_travel</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Data Cuti Karyawan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'peraturan' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('peraturan.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">gavel</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Data Peraturan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'informasi' ? 'active bg-gradient-success' : '' }}"
                                    href="{{ route('informasi.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">gavel</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Data Pengumuman</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif


            {{-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Data Profil
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'profile' ? 'active bg-gradient-success' : '' }} "
                    href="{{ route('user-profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-user-circle ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'user-management' ? ' active bg-gradient-success' : '' }} "
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
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-success' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'absensi' ? ' active bg-gradient-success' : '' }} "
                    href="{{ route('absensi') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Absensi</span>
                </a>
            </li>
            @if (Auth::user()->hasRole('KEPALA UNIT') || Auth::user()->hasRole('KEPALA BAGIAN') || Auth::user()->hasRole('DIREKTUR'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'dataizin' ? ' active bg-gradient-success' : '' }} "
                        href="{{ route('dataizin') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Izin Karyawan</span>
                        @if ($pendingIzin > 0)
                            <span class="badge2 badge-danger">{{ $pendingIzin }}</span>
                            <!-- Menampilkan jumlah izin pending -->
                        @endif
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasRole('HRD'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'hrdizin' ? ' active bg-gradient-success' : '' }} "
                        href="{{ route('hrd.approval2.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Izin Karyawan SDI</span>
                        @if ($pendingIzinsdi > 0)
                            <span class="badge2 badge-danger">{{ $pendingIzinsdi }}</span>
                            <!-- Menampilkan jumlah izin pending -->
                        @endif
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasRole('KEPALA UNIT') || Auth::user()->hasRole('KEPALA BAGIAN') || Auth::user()->hasRole('DIREKTUR'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'approval1-lembur' ? ' active bg-gradient-success' : '' }} "
                        href="{{ route('lembur.view.kepalaunit') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Lembur Karyawan</span>
                        @if ($pendingLembur > 0)
                            <span class="badge2 badge-danger">{{ $pendingLembur }}</span>
                            <!-- Tampilkan badge lembur -->
                        @endif
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasRole('HRD'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'approval2' ? ' active bg-gradient-success' : '' }} "
                        href="{{ route('lembur.view.hrd') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Lembur Karyawan SDI</span>
                        @if ($pendingLembursdi > 0)
                            <span class="badge2 badge-danger">{{ $pendingLembursdi }}</span>
                            <!-- Tampilkan badge lembur -->
                        @endif
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasRole('KEPALA UNIT') || Auth::user()->hasRole('KEPALA BAGIAN') || Auth::user()->hasRole('DIREKTUR'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'datacutiunit' ? ' active bg-gradient-success' : '' }} "
                        href="{{ route('unit.cuti') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Cuti Karyawan</span>
                        @if ($pendingCuti > 0)
                            <span class="badge2 badge-danger">{{ $pendingCuti }}</span> <!-- Tampilkan badge cuti -->
                        @endif
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasRole('HRD'))
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'approval2-cuti' ? ' active bg-gradient-success' : '' }} "
                        href="{{ route('hrd.cuti') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Cuti Karyawan SDI</span>
                        @if ($pendingCutisdi > 0)
                            <span class="badge2 badge-danger">{{ $pendingCutisdi }}</span>
                            <!-- Tampilkan badge cuti -->
                        @endif
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'form' ? ' active bg-gradient-success' : '' }}"
                    data-bs-toggle="collapse" href="#submenuForm2" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="nav-link-text ms-1">Form</span>
                </a>
                <!-- Submenu -->
                <div class="collapse" id="submenuForm2">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'form-izin' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('izin.index') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Form Izin</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'form-cuti' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('cuti.index') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Form Cuti</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'form-lembur' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('lembur.index') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Form Lembur</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'tukar-shift' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('tukarshift') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Tukar Shift</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'dinas-luar' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('dinasluar') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Dinas Luar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'datang-terlambat' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('datangterlambat') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Datang Terlambat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'dokumen' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('dokumen') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Upload Dokumen</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'pelatihan' ? ' active bg-gradient-success' : '' }}"
                                href="{{ route('pelatihan') }}">
                                <i class="material-icons opacity-10">receipt_long</i>
                                <span class="nav-link-text">Pelatihan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'kalender' ? ' active bg-gradient-success' : '' }}"
                    data-bs-toggle="collapse" href="#submenuForm3" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="nav-link-text ms-1">Kalender Kerja</span>
                </a>
                <!-- Submenu -->
                <div class="collapse" id="submenuForm3">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'kalender-kerja' ? ' active bg-gradient-success' : '' }}  "
                                href="{{ route('kalender-kerja.karyawan.index') }}">
                                <div
                                    class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">receipt_long</i>
                                </div>
                                <span class="nav-link-text ms-1">Kalender Kerja</span>
                            </a>
                        </li>
                        @if (auth()->user()->roles->contains('name', 'ADMIN') ||
                                auth()->user()->roles->contains('name', 'HRD') ||
                                auth()->user()->roles->contains('name', 'KEPALA UNIT') ||
                                auth()->user()->roles->contains('name', 'KEPALA BAGIAN') ||
                                auth()->user()->roles->contains('name', 'DIREKTUR'))
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'kalender-kerja' ? ' active bg-gradient-success' : '' }}  "
                                    href="{{ route('kalender_kerja.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">receipt_long</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kalender Kerja</span>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'hari-libur' ? ' active bg-gradient-success' : '' }}  "
                                href="{{ route('libur.karyawan.index') }}">
                                <div
                                    class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">today</i>

                                </div>
                                <span class="nav-link-text ms-1">Hari Libur/Cuti</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'virtual-reality' ? ' active bg-gradient-success' : '' }}  "
                    href="/vr">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'rtl' ? ' active bg-gradient-success' : '' }}  "
                    href="/rtl">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'notifications' ? ' active bg-gradient-success' : '' }}  "
                    href="/notifikasi">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li> --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">NOTES</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'peraturanview' ? ' active bg-gradient-success' : '' }}  "
                    href="{{ route('peraturan.view') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">Peraturan & SK</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'informasi' ? ' active bg-gradient-success' : '' }}  "
                    href="{{ route('informasi.karyawan.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengumuman / Informasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('user-profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">account_circle</i>

                    </div>
                    <span class="nav-link-text ms-1">Profil</span>
                </a>
            </li>

        </ul>
    </div>
    <style>
        .badge2 {
            background-color: red;
            color: white;
            padding: 5px;
            border-radius: 50%;
            font-size: 12px;
        }
    </style>
</aside>
