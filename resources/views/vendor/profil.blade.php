@extends('layouts.app')

@section('title', 'Profil Vendor')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-3">
        <div class="card-header text-white" style="background-color: #007b5e;">
            <h4 class="mb-0">Profil Vendor</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Username</th>
                    <td>{{ $vendor->username }}</td>
                </tr>
                <tr>
                    <th>Nomor HP</th>
                    <td>{{ $vendor->No_HP }}</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>
                        <div class="mb-3 position-relative">
                            <input type="password" class="form-control" id="password" value="{{ $vendor->password }}" readonly>
                            
                            <!-- Ikon mata -->
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer;" onclick="showEditPasswordForm()">
                                <i class="bi bi-pencil-square"></i> <!-- Ikon Edit dari Bootstrap Icons -->
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Background Vendor</th>
                    <td>{{ $vendor->background_vendor }}</td>
                </tr>
                <tr>
                    <th>Nilai Akhir</th>
                    <td>{{ $vendor->nilai_akhir ?? '-' }}</td>
                </tr>
            </table>

            <div class="text-end">
                <a href="{{ route('vendor.edit') }}" class="btn btn-warning">Edit Profil</a>
            </div>
        </div>
    </div>
</div>

<script>
    function showEditPasswordForm() {
        window.location.href = "{{ route('vendor.password-edit') }}"; // arahkan ke halaman edit password
    }
</script>

@endsection
