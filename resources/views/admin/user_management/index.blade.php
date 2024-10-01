<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='user_management'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>User Management</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-4">
                                <table id="userTable" class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Role
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                                </td>
                                                <td>
                                                    @foreach ($user->roles as $role)
                                                        <span class="badge bg-info">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editRoleModal{{ $user->id }}">
                                                        Edit Role
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal untuk Edit Role -->
                                            <div class="modal fade" id="editRoleModal{{ $user->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editRoleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editRoleModalLabel">Edit Role
                                                                {{ $user->name }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.user.role.update', $user->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="form-group">
                                                                    <label for="roles">Pilih Role</label>
                                                                    <div class="form-check">
                                                                        @foreach ($roles as $role)
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="roles[]"
                                                                                    value="{{ $role->id }}"
                                                                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                                                <label class="form-check-label">
                                                                                    {{ $role->name }}
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('js')
        <!-- Include DataTables -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <!-- Include SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Initialize DataTables and SweetAlert -->
        <script>
            $(document).ready(function() {
                // Inisialisasi DataTables
                $('#userTable').DataTable({
                    "pageLength": 10,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "language": {
                        "paginate": {
                            "previous": "<",
                            "next": ">"
                        },
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Tidak ada data",
                        "zeroRecords": "Data tidak ditemukan",
                        "infoFiltered": "(disaring dari _MAX_ total data)"
                    }
                });

                // Tampilkan pesan SweetAlert jika ada pesan sukses dari controller
                @if (session('success'))
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                @endif
            });
        </script>
    @endpush
</x-layout>
