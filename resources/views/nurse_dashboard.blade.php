@extends('base')

@section('content')
<div class="card shadow-lg p-4">
    <h3 class="mb-4">Dashboard Perawat</h3>
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="{{ $searchQuery }}">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </div>
    </form>
    <button type="button" class="btn btn-success mb-4" id="toggleFormBtn">Tambah Pasien</button>

    <!-- Collapsible Form Section -->
    <div class="collapsible-form" id="addPatientFormSection" style="max-height: 0; overflow: hidden;">
        <div class="form-wrapper">
            <form method="POST" id="addPatientForm" action="{{ route('nurse_dashboard') }}">
                @csrf
                <div class="mb-3">
                    <label for="patient_name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="patient_name" id="patient_name" class="form-control shake-on-focus" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="mb-3">
                    <label for="family_member_name" class="form-label">Nama Anggota Keluarga</label>
                    <input type="text" name="family_member_name" id="family_member_name" class="form-control shake-on-focus" placeholder="Masukkan nama anggota keluarga">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control shake-on-focus" placeholder="Masukkan nomor telepon">
                </div>
                <div class="mb-3">
                    <label for="emergency_phone_number" class="form-label">Nomor Telepon Darurat</label>
                    <input type="text" name="emergency_phone_number" id="emergency_phone_number" class="form-control shake-on-focus" placeholder="Masukkan nomor telepon darurat">
                </div>
                <div class="mb-3">
                    <label for="id_card_number" class="form-label">No KTP</label>
                    <input type="text" name="id_card_number" id="id_card_number" class="form-control shake-on-focus" placeholder="Masukkan nomor KTP">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" id="address" class="form-control shake-on-focus" placeholder="Masukkan alamat"></textarea>
                </div>
                <div class="mb-3">
                    <label for="room_responsible_person" class="form-label">Penanggung Jawab Ruangan</label>
                    <input type="text" name="room_responsible_person" id="room_responsible_person" class="form-control shake-on-focus" placeholder="Masukkan nama penanggung jawab ruangan">
                </div>
                <div class="mb-3">
                    <label for="room_responsible_phone" class="form-label">Nomor Penanggung Jawab Ruangan</label>
                    <input type="text" name="room_responsible_phone" id="room_responsible_phone" class="form-control shake-on-focus" placeholder="Masukkan nomor penanggung jawab ruangan">
                </div>
                <div class="mb-3">
                    <label for="doctor_name" class="form-label">Nama Dokter</label>
                    <input type="text" name="doctor_name" id="doctor_name" class="form-control shake-on-focus" placeholder="Masukkan nama dokter">
                </div>
                <div class="mb-3">
                    <label for="doctor_phone" class="form-label">Nomor Telepon Dokter</label>
                    <input type="text" name="doctor_phone" id="doctor_phone" class="form-control shake-on-focus" placeholder="Masukkan nomor telepon dokter">
                </div>
                <button type="submit" class="btn btn-success w-100">Simpan Pasien</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Pasien</th>
                    <th>Key Akses</th>
                    <th>Kondisi Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->access_key }}</td>
                    <td>{{ $p->condition ?: '-' }}</td>
                    <td>
                        <a href="{{ route('patient_detail', $p->id) }}" class="btn btn-primary btn-sm">Update</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada pasien.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('toggleFormBtn').addEventListener('click', function () {
        const formSection = document.getElementById('addPatientFormSection');
        const formWrapper = document.querySelector('.form-wrapper');
        if (formSection.style.maxHeight === '0px' || formSection.style.maxHeight === '') {
            formSection.style.display = 'block';
            const fullHeight = formWrapper.scrollHeight + 20;
            setTimeout(() => {
                formSection.style.maxHeight = fullHeight + 'px';
                formSection.classList.add('active');
                document.getElementById('patient_name').focus();
            }, 10);
        } else {
            formSection.classList.remove('active');
            setTimeout(() => {
                formSection.style.maxHeight = '0';
                setTimeout(() => {
                    formSection.style.display = 'none';
                }, 300);
            }, 10);
        }
    });

    document.querySelectorAll('.shake-on-focus').forEach(input => {
        input.addEventListener('focus', function () {
            console.log('Input focused:', this.id);
        });
    });
</script>
@endsection
