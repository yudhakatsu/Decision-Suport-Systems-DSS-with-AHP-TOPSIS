<!-- resources/views/vendor/edit.blade.php -->

@extends('layouts.app')

@section('title', 'Edit Profil Vendor')

@section('content')
<div class="container">
    <h2>Edit Profil Vendor</h2>
    <form action="{{ route('vendor.update', $vendor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="username" class="form-label">Nama Vendor (Username)</label>
            <input type="text" name="username" class="form-control" id="username" value="{{ $vendor->username }}" required>
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-control" id="no_hp" value="{{ $vendor->No_HP }}" required>
        </div>

        <div class="mb-3">
            <label for="background_vendor" class="form-label">Latar Belakang Vendor</label>
            <input name="background_vendor" class="form-control" id="background_vendor" rows="3" value="{{ $vendor->background_vendor }}" required >
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
