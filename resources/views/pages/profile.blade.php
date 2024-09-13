<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Profile'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('{{ asset('assets/img/logos/logorsip.png') }}');" <span
                class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('foto.jpg') }}" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $user->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-4">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                                <h6 class="mb-0">Profile Information</h6>
                            </div>
                            <div class="card-body p-3">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Full Name:</strong> &nbsp; {{ $user->name }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Email:</strong> &nbsp; {{ $user->email }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Status:</strong> &nbsp;
                                        @if ($user->aktif)
                                            Aktif
                                        @else
                                            Non-Aktif
                                        @endif
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Level:</strong> &nbsp;
                                        {{ $user->lv->nama ?? 'N/A' }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Divisi:</strong> &nbsp;
                                        {{ $user->bag->nama_bagian ?? 'N/A' }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Unit:</strong> &nbsp;
                                        {{ $user->unt->unit ?? 'N/A' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>
</x-layout>
