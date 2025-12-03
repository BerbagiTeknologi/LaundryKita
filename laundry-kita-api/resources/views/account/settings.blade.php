@extends('layouts.app')

@section('title', 'Pengaturan Akun | Laundry Kita')

@section('content')
  <div class="row justify-content-center mt-4">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <h4 class="card-title mb-0">Pengaturan Akun</h4>
              <small class="text-muted">Perbarui email dan password akun Anda</small>
            </div>
          </div>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <form method="POST" action="{{ route('account.settings.update') }}">
            @csrf
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
              <label>Password lama</label>
              <input type="password" name="current_password" class="form-control" required>
              @error('current_password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
              <label>Password baru (opsional)</label>
              <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
              <label>Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <small class="text-muted">Verifikasi email: buka Gmail untuk memeriksa tautan verifikasi.</small>
              </div>
              <a class="btn btn-outline-secondary btn-sm" href="https://mail.google.com" target="_blank" rel="noopener">Buka Gmail</a>
            </div>
            <div class="text-end mt-3">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
