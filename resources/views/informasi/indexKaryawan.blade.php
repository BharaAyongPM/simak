<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="informasi"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Pengumuman & Informasi"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Loop through each informasi item -->
                @foreach ($informasi as $item)
                    <div class="col-xl-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header pb-0">
                                <h5 class="text-primary">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Foto/Dokumen jika ada -->
                                @if ($item->foto)
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Dokumen Informasi"
                                            class="img-fluid rounded" style="max-height: 300px;">
                                    </div>
                                @endif

                                <!-- Teks informasi -->
                                <div class="{{ $item->display_info == 'bergerak' ? 'marquee-text' : '' }}">
                                    <p class="card-text">{{ $item->informasi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    @push('css')
        <!-- CSS for marquee effect if the text should move -->
        <style>
            .marquee-text {
                white-space: nowrap;
                overflow: hidden;
                box-sizing: border-box;
            }

            .marquee-text p {
                display: inline-block;
                padding-left: 100%;
                animation: marquee 10s linear infinite;
            }

            @keyframes marquee {
                0% {
                    transform: translateX(0%);
                }

                100% {
                    transform: translateX(-100%);
                }
            }
        </style>
    @endpush
</x-layout>
