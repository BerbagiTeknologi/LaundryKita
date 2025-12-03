@extends('layouts.app')

@section('title', 'Edit Outlet | Laundry Kita')

@section('content')
  <div class="row justify-content-center mt-4">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <h4 class="card-title mb-0">Edit Outlet</h4>
              <small class="text-muted">Kelola identitas outlet dan zona waktu</small>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm"><i class="mdi mdi-arrow-left"></i> Kembali</a>
          </div>
          
          <form method="POST" action="{{ route('outlet.update') }}">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Outlet</label>
                  <input type="text" class="form-control" name="outlet_name" value="{{ old('outlet_name', $user->name) }}" placeholder="Nama outlet" required>
                  @error('outlet_name')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Telepon</label>
                  <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" required>
                  @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Provinsi</label>
                  <input type="text" class="form-control" name="province" value="{{ old('province', $user->province) }}" placeholder="Provinsi">
                  @error('province')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kabupaten/Kota</label>
                  <input type="text" class="form-control" name="city" value="{{ old('city', $user->city) }}" placeholder="Kabupaten/Kota">
                  @error('city')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" name="address" rows="3" placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
              @error('address')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
              <label>Zona Waktu</label>
              <select class="form-control" name="timezone" required>
                <option value="WIB" {{ old('timezone', $user->timezone) === 'WIB' ? 'selected' : '' }}>WIB</option>
                <option value="WITA" {{ old('timezone', $user->timezone) === 'WITA' ? 'selected' : '' }}>WITA</option>
                <option value="WIT" {{ old('timezone', $user->timezone) === 'WIT' ? 'selected' : '' }}>WIT</option>
              </select>
              @error('timezone')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
