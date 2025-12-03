@extends('layouts.app')

@section('title', 'Jam Antar Jemput | Laundry Kita')

@section('content')
  <div class="row justify-content-center mt-4">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <h4 class="card-title mb-0">Jam Antar Jemput</h4>
              <small class="text-muted">Atur jam mulai dan jam selesai antar jemput</small>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm"><i class="mdi mdi-arrow-left"></i> Kembali</a>
          </div>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <form method="POST" action="{{ route('outlet.pickup.update') }}">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jam Mulai</label>
                  <input type="time" class="form-control" name="start_time" value="{{ old('start_time', $pickup->start_time ?? '') }}" required>
                  @error('start_time')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jam Selesai</label>
                  <input type="time" class="form-control" name="end_time" value="{{ old('end_time', $pickup->end_time ?? '') }}" required>
                  @error('end_time')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
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
