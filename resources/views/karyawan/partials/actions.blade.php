<div class="btn-group" role="group" aria-label="Aksi Karyawan">
    <!-- Tombol Edit -->
    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editKaryawanModal"
        data-id="{{ $karyawan->id }}" data-name="{{ $karyawan->name }}" data-nik="{{ $karyawan->nik }}"
        data-jabatan="{{ $karyawan->jabatan }}" data-tgl_masuk="{{ $karyawan->tgl_masuk }}"
        data-alamat="{{ $karyawan->alamat }}" data-no_telp="{{ $karyawan->no_telp }}"
        data-status_kar="{{ $karyawan->status_kar }}" data-kelamin="{{ $karyawan->kelamin }}"
        data-agama="{{ $karyawan->agama }}" data-tgl_lahir="{{ $karyawan->tgl_lahir }}"
        data-gaji="{{ $karyawan->gaji }}" data-shift="{{ $karyawan->shift }}" data-unit="{{ $karyawan->unit }}">
        <i class="fas fa-edit"></i> Edit
    </button>

    <!-- Tombol Hapus -->
    <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger"
            onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
            <i class="fas fa-trash"></i> Hapus
        </button>
    </form>
</div>
