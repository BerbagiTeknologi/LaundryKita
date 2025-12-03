@extends('layouts.app')

@section('title', 'Jam Operasional | Laundry Kita')

@section('content')
  <div class="row justify-content-center mt-4">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <h4 class="card-title mb-0">Jam Operasional</h4>
              <small class="text-muted">Atur hari operasional serta jam buka/tutup</small>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm"><i class="mdi mdi-arrow-left"></i> Kembali</a>
          </div>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <form method="POST" action="{{ route('outlet.hours.update') }}">
            @csrf
            <div class="table-responsive">
              <table class="table table-bordered align-middle">
                <thead>
                  <tr>
                    <th style="width: 160px;">Hari</th>
                    <th style="width: 140px;">Aktif</th>
                    <th style="width: 180px;">Jam Buka</th>
                    <th style="width: 180px;">Jam Tutup</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($days as $day)
                    <tr>
                      <td>{{ $day }}</td>
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="days[]" value="{{ $day }}" id="day-{{ $day }}" {{ ($hours[$day]->is_open ?? false) ? 'checked' : '' }}>
                          <label class="form-check-label" for="day-{{ $day }}">Buka</label>
                        </div>
                      </td>
                      <td>
                        <input type="time" class="form-control" name="open[{{ $day }}]" value="{{ $hours[$day]->open_time ?? '' }}" placeholder="08:00">
                      </td>
                      <td>
                        <input type="time" class="form-control" name="close[{{ $day }}]" value="{{ $hours[$day]->close_time ?? '' }}" placeholder="17:00">
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="text-end mt-3">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form><!--  -->
        </div>
      </div>
    </div>
  </div>
@endsection
