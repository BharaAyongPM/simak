<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='kalender-kerja'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Kalender Kerja"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Kalender Kerja - {{ now()->format('F Y') }}</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="p-4">
                                <h5>Nama: Bhara Ayong Purna Mustika</h5>
                                <p>Departemen: IT</p>
                                <p>Shift: Back Office (08:00 - 17:00)</p>

                                <!-- Kalender Kerja dalam Bentuk Tabel -->
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="calendar-body">
                                        {{-- Kalender akan diisi oleh JavaScript --}}
                                    </tbody>
                                </table>
                            </div>
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
            document.addEventListener('DOMContentLoaded', function() {
                let calendarBody = document.getElementById('calendar-body');
                let currentMonth = {{ now()->month }};
                let currentYear = {{ now()->year }};
                let daysInMonth = new Date(currentYear, currentMonth, 0).getDate();

                // Ambil data dari API
                fetch('https://dayoffapi.vercel.app/api')
                    .then(response => response.json())
                    .then(data => {
                        let holidays = data;

                        // Buat kalender kerja berdasarkan hari dalam bulan ini
                        for (let day = 1; day <= daysInMonth; day++) {
                            let date = new Date(currentYear, currentMonth - 1, day);
                            let formattedDate = date.toISOString().split('T')[0]; // Format YYYY-MM-DD

                            // Cek apakah hari libur atau akhir pekan
                            let isHoliday = holidays.some(holiday => holiday.tanggal === formattedDate);
                            let isWeekend = (date.getDay() === 0 || date.getDay() === 6); // 0 = Minggu, 6 = Sabtu

                            let status = '';
                            if (isWeekend) {
                                status = '<span class="badge bg-danger">Off (Weekend)</span>';
                            } else if (isHoliday) {
                                let holiday = holidays.find(holiday => holiday.tanggal === formattedDate);
                                status = `<span class="badge bg-danger">${holiday.keterangan}</span>`;
                            } else {
                                status = '<span class="badge bg-success">Masuk Back Office</span>';
                            }

                            // Tampilkan data ke dalam tabel
                            calendarBody.innerHTML += `
                                <tr>
                                    <td>${date.getDate()} ${date.toLocaleString('id-ID', { month: 'long', year: 'numeric' })}</td>
                                    <td>${date.toLocaleString('id-ID', { weekday: 'long' })}</td>
                                    <td>${status}</td>
                                </tr>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            });
        </script>
    @endpush
</x-layout>
