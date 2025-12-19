
@extends('layouts.app')

@section('title', 'Kelola Pegawai | Laundry Kita')

@section('head')
  {{-- Leaflet tanpa SRI integrity supaya tidak diblok jika hash berubah di CDN --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
  <div class="row">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <!-- @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif -->

          <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center mb-3">
            <div>
              <h4 class="card-title mb-0">Kelola Pegawai</h4>
              <small class="text-muted">Atur shift, presensi, golongan, gaji, dan komunikasi tim</small>
            </div>
            
          </div>

          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-shift-tab" data-bs-toggle="tab" data-bs-target="#tab-shift" type="button" role="tab" aria-controls="tab-shift" aria-selected="true">Jam Kerja / Shift</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-presensi-tab" data-bs-toggle="tab" data-bs-target="#tab-presensi" type="button" role="tab" aria-controls="tab-presensi" aria-selected="false">Aturan Presensi</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-golongan-tab" data-bs-toggle="tab" data-bs-target="#tab-golongan" type="button" role="tab" aria-controls="tab-golongan" aria-selected="false">Golongan Pegawai</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-pegawai-tab" data-bs-toggle="tab" data-bs-target="#tab-pegawai" type="button" role="tab" aria-controls="tab-pegawai" aria-selected="false">Daftar Pegawai</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-jadwal-tab" data-bs-toggle="tab" data-bs-target="#tab-jadwal" type="button" role="tab" aria-controls="tab-jadwal" aria-selected="false">Jadwal Pegawai</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-gaji-tab" data-bs-toggle="tab" data-bs-target="#tab-gaji" type="button" role="tab" aria-controls="tab-gaji" aria-selected="false">Komponen Gaji</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-slip-tab" data-bs-toggle="tab" data-bs-target="#tab-slip" type="button" role="tab" aria-controls="tab-slip" aria-selected="false">Slip Gaji</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-instruksi-tab" data-bs-toggle="tab" data-bs-target="#tab-instruksi" type="button" role="tab" aria-controls="tab-instruksi" aria-selected="false">Instruksi ke Pegawai</button>
            </li>
          </ul>

          <div class="tab-content pt-3">
            <div class="tab-pane fade show active" id="tab-shift" role="tabpanel" aria-labelledby="tab-shift-tab">
              
              <div class="row g-3">
                <div class="col-12">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                        <div>
                          <h5 class="mb-0">Daftar Shift</h5>
                          <small class="text-muted">Definisi shift dan kuota</small>
                        </div>
                        <div class="d-flex gap-2">
                          <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#form-shift">Tambah Shift</button>
                        </div>
                      </div>
                      <div class="collapse mb-3" id="form-shift">
                        <form class="card card-body border" method="POST" action="{{ route('employees.shifts.store') }}">
                          @csrf
                          <div class="row g-2">
                            <div class="col-md-3">
                              <label class="form-label small mb-1">Nama Shift</label>
                              <input type="text" name="name" class="form-control form-control-sm" placeholder="Pagi" required>
                            </div>
                            <div class="col-md-2">
                              <label class="form-label small mb-1">Mulai</label>
                              <input type="time" name="start_time" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-2">
                              <label class="form-label small mb-1">Selesai</label>
                              <input type="time" name="end_time" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small mb-1">Hari</label>
                              <input type="text" name="days" class="form-control form-control-sm" placeholder="Senin - Sabtu">
                            </div>
                            <div class="col-md-2">
                              <label class="form-label small mb-1">Kuota</label>
                              <input type="number" name="quota" min="0" class="form-control form-control-sm" value="0" required>
                            </div>
                          </div>
                          <div class="mt-2 d-flex gap-2 align-items-center">
                            <button class="btn btn-sm btn-primary" id="shift-submit-btn">Simpan Shift</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="shift-reset-btn">Batal</button>
                          </div>
                        </form>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                          <thead>
                            <tr>
                              <th>Shift</th>
                              <th>Jam</th>
                              <th>Hari</th>
                              <th>Kuota</th>
                              <th class="text-end">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse($shifts as $shift)
                              @php $shiftId = $shift['id'] ?? null; @endphp
                              <tr>
                                <td><span class="badge bg-light text-primary">{{ $shift['name'] ?? '' }}</span></td>
                                <td>{{ ($shift['start_time'] ?? $shift['start'] ?? '') }} - {{ ($shift['end_time'] ?? $shift['end'] ?? '') }}</td>
                                <td>{{ $shift['days'] ?? '-' }}</td>
                                <td>{{ $shift['quota'] ?? 0 }}</td>
                                <td class="text-end">
                                  <button
                                    class="btn btn-xs btn-outline-primary shift-edit-btn"
                                    type="button"
                                    data-shift-id="{{ $shiftId }}"
                                    data-name="{{ $shift['name'] ?? '' }}"
                                    data-start="{{ $shift['start_time'] ?? $shift['start'] ?? '' }}"
                                    data-end="{{ $shift['end_time'] ?? $shift['end'] ?? '' }}"
                                    data-days="{{ $shift['days'] ?? '' }}"
                                    data-quota="{{ $shift['quota'] ?? 0 }}"
                                    data-update-url="{{ $shiftId ? route('employees.shifts.update', ['shift' => $shiftId]) : '' }}"
                                  >Edit</button>
                                  @if($shiftId)
                                    <form method="POST" action="{{ route('employees.shifts.delete', ['shift' => $shiftId]) }}" class="d-inline">
                                      @csrf
                                      <button class="btn btn-xs btn-outline-danger" type="submit" onclick="return confirm('Hapus shift ini?');">Delete</button>
                                    </form>
                                  @endif
                                </td>
                              </tr>
                            @empty
                              <tr><td colspan="5" class="text-muted text-center">Belum ada shift</td></tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="tab-presensi" role="tabpanel" aria-labelledby="tab-presensi-tab">
              <div class="row g-3">
              <div>
                  <h5 class="mb-0">Aturan Presensi</h5>
                  <small class="text-muted">Poin kontrol kehadiran</small>
                </div>  
              <div class="col-12">
                <div class="card h-100">      
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold">Poin Kontrol Presensi</div>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#form-rule-item">Tambah Poin</button>
                      </div>
                      <div class="collapse mb-2" id="form-rule-item">
                        <form class="card card-body border" method="POST" action="{{ route('attendance.rules.items.store') }}">
                          @csrf
                          <div class="row g-2">
                            <div class="col-md-4">
                              <label class="form-label small mb-1">Judul</label>
                              <input type="text" id="rule-item-title" name="title" class="form-control form-control-sm" placeholder="Contoh: Wajib GPS" required>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label small mb-1">Deskripsi</label>
                              <input type="text" id="rule-item-desc" name="description" class="form-control form-control-sm" placeholder="Contoh: Check-in hanya di outlet">
                            </div>
                            <div class="col-md-2">
                              <label class="form-label small mb-1">Icon (mdi)</label>
                              <input type="text" id="rule-item-icon" name="icon_class" class="form-control form-control-sm" placeholder="mdi-map-marker-radius">
                            </div>
                          </div>
                          <div class="mt-2">
                            <button class="btn btn-sm btn-primary">Simpan Poin</button>
                          </div>
                        </form>
                      </div>
                      <ul class="list-unstyled mb-3">
                        @forelse($ruleItems as $item)
                          <li class="d-flex align-items-start mb-2">
                            <span class="badge bg-light text-primary me-2">
                              @if(!empty($item->icon_class))
                                <i class="mdi {{ $item->icon_class }}"></i>
                              @else
                                <i class="mdi mdi-check-circle-outline"></i>
                              @endif
                            </span>
                            <div class="flex-grow-1">
                              <div class="fw-semibold">{{ $item->title }}</div>
                              @if($item->description)
                                <div class="text-muted small">{{ $item->description }}</div>
                              @endif
                            </div>
                            <form method="POST" action="{{ route('attendance.rules.items.delete', $item) }}" class="ms-2">
                              @csrf
                              <button class="btn btn-xs btn-outline-danger" type="submit">Hapus</button>
                            </form>
                          </li>
                        @empty
                          <li class="text-muted">Belum ada poin kontrol presensi.</li>
                        @endforelse
                      </ul>
                      <div class="row g-3 align-items-start">
                        <div class="col-lg-6">
                          <h6 class="card-title mb-2">Atur Geofence & Presensi</h6>
                          <div id="geofence-map" class="border rounded mb-3 position-relative" style="height: 260px; background: #f8f9fa;"></div>
                          <div
                            id="rule-points-data"
                            data-rule-points='{{ $rulePoints
                              ->map(function ($p) {
                                return [
                                  "lat" => (float) $p->lat,
                                  "lng" => (float) $p->lng,
                                  "radius" => (int) $p->radius_m,
                                  "name" => $p->name,
                                ];
                              })
                              ->values()
                              ->toJson()
                            }}'
                            hidden
                          ></div>
                          <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="small text-muted" id="geofence-map-label">Pusat: -, - | Radius: {{ $attendanceRules['radius_m'] ?? 200 }}m</div>
                            <button type="button" class="btn btn-sm btn-outline-success" id="use-gps-btn"><i class="mdi mdi-crosshairs-gps me-1"></i>Gunakan GPS</button>
                          </div>
                          <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-waypoint-btn">Tambah Titik</button>
                            <small class="text-muted align-self-center">Double click di peta atau gunakan GPS lalu simpan titik.</small>
                          </div>
                          <div class="card card-body border mb-3 p-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                              <strong class="small mb-0">Titik Presensi</strong>
                              <span class="small text-muted" id="waypoint-count"></span>
                            </div>
                            <div id="waypoints-list" class="list-group list-group-flush small"></div>
                          </div>
                          <form method="POST" action="{{ route('attendance.rules.save') }}" class="mb-3">
                            @csrf
                            <div id="waypoints-hidden"></div>
                            <div class="row g-2">
                              <div class="col-12">
                                <label class="form-label small mb-1">Nama Titik</label>
                                <input type="text" id="geofence_name" class="form-control form-control-sm" placeholder="Contoh: Outlet Cabang A">
                              </div>
                              <div class="col-6">
                                <label class="form-label small mb-1">Latitude</label>
                                <input type="number" step="0.000001" id="geofence_lat" name="geofence_lat" class="form-control form-control-sm" value="{{ $attendanceRules['center']['lat'] ?? '' }}" required>
                              </div>
                              <div class="col-6">
                                <label class="form-label small mb-1">Longitude</label>
                                <input type="number" step="0.000001" id="geofence_lng" name="geofence_lng" class="form-control form-control-sm" value="{{ $attendanceRules['center']['lng'] ?? '' }}" required>
                              </div>
                              <div class="col-6">
                                <label class="form-label small mb-1">Radius (meter)</label>
                                <input type="number" min="50" max="5000" id="geofence_radius_m" name="geofence_radius_m" class="form-control form-control-sm" value="{{ $attendanceRules['radius_m'] ?? 200 }}" required>
                              </div>
                              <div class="col-6">
                                <label class="form-label small mb-1">Dispensasi (menit)</label>
                                <input type="number" min="0" max="120" name="grace_minutes" class="form-control form-control-sm" value="{{ $attendanceRules['grace_minutes'] ?? 15 }}" required>
                              </div>
                            </div>
                            <div class="form-check mt-2">
                              <input class="form-check-input" type="checkbox" name="require_gps" value="1" id="require_gps" {{ ($attendanceRules['require_gps'] ?? true) ? 'checked' : '' }}>
                              <label class="form-check-label" for="require_gps">Wajib GPS</label>
                              <input class="form-check-input" type="checkbox" name="require_selfie" value="1" id="require_selfie" {{ ($attendanceRules['require_selfie'] ?? false) ? 'checked' : '' }}>
                              <label class="form-check-label" for="require_selfie">Wajib Selfie</label>
                              <input class="form-check-input" type="checkbox" name="require_fingerprint" value="1" id="require_fingerprint" {{ ($attendanceRules['require_fingerprint'] ?? false) ? 'checked' : '' }}>
                              <label class="form-check-label" for="require_fingerprint">Wajib Fingerprint</label>
                            </div>
                            <button class="btn btn-sm btn-primary w-100">Simpan Aturan</button>
                          </form>
                        </div>
                        <div class="col-lg-6">
                          <h6 class="card-title mb-2">Log Presensi Terakhir</h6>
                          <div class="alert alert-secondary mb-0 small">Belum ada data presensi.</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-golongan" role="tabpanel" aria-labelledby="tab-golongan-tab">
              <div class="border rounded p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                  <div>
                    <h5 class="mb-0">Golongan Pegawai</h5>
                    <small class="text-muted">Struktur role & tunjangan</small>
                  </div>
                  <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#form-golongan">Tambah Golongan</button>
                </div>
                <div class="collapse mb-3" id="form-golongan">
                  <form class="card card-body border" method="POST" action="{{ route('employees.grades.store') }}" id="grade-form">
                    @csrf
                    <div class="row g-2">
                      <div class="col-md-2">
                        <label class="form-label small mb-1">Kode</label>
                        <input type="text" name="code" class="form-control form-control-sm" placeholder="A" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label small mb-1">Peran</label>
                        <input type="text" name="role" class="form-control form-control-sm" placeholder="Supervisor" required>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label small mb-1">Tunjangan</label>
                        <input type="number" min="0" name="allowance" class="form-control form-control-sm" placeholder="600000">
                      </div>
                      <div class="col-md-3">
                        <label class="form-label small mb-1">Benefit</label>
                        <input type="text" name="benefit" class="form-control form-control-sm" placeholder="BPJS, Insentif">
                      </div>
                    </div>
                    <div class="mt-2 d-flex gap-2">
                      <button class="btn btn-sm btn-primary" id="grade-submit-btn">Simpan Golongan</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary" id="grade-reset-btn">Batal</button>
                    </div>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Gol.</th>
                        <th>Peran</th>
                        <th>Tunjangan</th>
                        <th>Benefit</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($grades as $grade)
                        @php $gradeId = $grade['id'] ?? null; @endphp
                        <tr>
                          <td><span class="badge bg-primary">{{ $grade['code'] }}</span></td>
                          <td>{{ $grade['role'] }}</td>
                          <td>{{ $grade['allowance'] ? 'Rp'.number_format($grade['allowance'],0,',','.') : '-' }}</td>
                          <td>{{ $grade['benefit'] ?? '-' }}</td>
                          <td class="text-end">
                            <button
                              class="btn btn-xs btn-outline-primary grade-edit-btn"
                              type="button"
                              data-grade-id="{{ $gradeId }}"
                              data-code="{{ $grade['code'] ?? '' }}"
                              data-role="{{ $grade['role'] ?? '' }}"
                              data-allowance="{{ $grade['allowance'] ?? '' }}"
                              data-benefit="{{ $grade['benefit'] ?? '' }}"
                              data-update-url="{{ $gradeId ? route('employees.grades.update', ['grade' => $gradeId]) : '' }}"
                            >Edit</button>
                            @if($gradeId)
                              <form method="POST" action="{{ route('employees.grades.delete', ['grade' => $gradeId]) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-xs btn-outline-danger" type="submit" onclick="return confirm('Hapus golongan ini?');">Delete</button>
                              </form>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="5" class="text-muted text-center">Belum ada golongan</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="tab-pegawai" role="tabpanel" aria-labelledby="tab-pegawai-tab">
              <div class="border rounded p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                  <div>
                    <h5 class="mb-0">Daftar Pegawai</h5>
                    <small class="text-muted">Status hadir & shift berjalan</small>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#form-pegawai">Tambah Pegawai</button>
                  </div>
                </div>
                <div class="collapse mb-3" id="form-pegawai">
                  <form class="card card-body border" method="POST" action="{{ route('employees.store') }}" id="employee-form">
                    @csrf
                    <div class="row g-3">
                      <div class="col-md-3">
                        <label class="form-label small mb-1">Nama</label>
                        <input type="text" name="name" class="form-control form-control-sm" id="emp-name" required>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label small mb-1">Golongan</label>
                        <select name="grade_id" class="form-select form-select-sm" id="emp-grade">
                          <option value="">Pilih</option>
                          @foreach($grades as $grade)
                            <option value="{{ $grade['id'] }}">{{ $grade['code'] }} - {{ $grade['role'] }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label small mb-1">Shift</label>
                        <select name="shift_id" class="form-select form-select-sm" id="emp-shift">
                          <option value="">Pilih</option>
                          @foreach($shifts as $shift)
                            <option value="{{ $shift['id'] }}">{{ $shift['name'] ?? '' }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label small mb-1">Kontak</label>
                        <input type="text" name="contact" class="form-control form-control-sm" id="emp-contact" placeholder="Email/No. Telp">
                      </div>
                    </div>
                    <div class="mt-2 d-flex gap-2">
                      <button class="btn btn-sm btn-primary" id="emp-submit-btn">Simpan Pegawai</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary" id="emp-reset-btn">Batal</button>
                    </div>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Gol.</th>
                        <th>Shift</th>
                        <th>Kontak</th>
                        <th class="text-end">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($employees as $employee)
                        <tr>
                          <td>{{ $employee->name }}</td>
                          <td><span class="badge bg-primary">{{ $employee->grade->code ?? '-' }}</span></td>
                          <td>{{ $employee->shift->name ?? '-' }}</td>
                          <td><span class="text-muted small">{{ $employee->contact ?? '-' }}</span></td>
                          <td class="text-end">
                            <button
                              class="btn btn-xs btn-outline-primary emp-edit-btn"
                              type="button"
                              data-id="{{ $employee->id }}"
                              data-name="{{ $employee->name }}"
                              data-grade="{{ $employee->grade_id }}"
                              data-shift="{{ $employee->shift_id }}"
                              data-contact="{{ $employee->contact }}"
                              data-update-url="{{ route('employees.update', ['employee' => $employee->id]) }}"
                            >Edit</button>
                            <form method="POST" action="{{ route('employees.delete', ['employee' => $employee->id]) }}" class="d-inline">
                              @csrf
                              <button class="btn btn-xs btn-outline-danger" type="submit" onclick="return confirm('Hapus pegawai ini?');">Delete</button>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="5" class="text-muted text-center">Belum ada pegawai</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-jadwal" role="tabpanel" aria-labelledby="tab-jadwal-tab">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <h5 class="mb-0">Jadwal Pegawai</h5>
                  <small class="text-muted">Pekan berjalan</small>
                </div>
                <button class="btn btn-sm btn-outline-secondary">Cetak</button>
              </div>
              <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Hari</th>
                      <th>Shift</th>
                      <th>Tim</th>
                      <th>PIC</th>
                      <th>Catatan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Senin</td>
                      <td><span class="badge bg-light text-primary">Pagi</span></td>
                      <td>Sorter & Wash</td>
                      <td>Andini</td>
                      <td>Prioritas express</td>
                    </tr>
                    <tr>
                      <td>Selasa</td>
                      <td><span class="badge bg-light text-info">Sore</span></td>
                      <td>Dry & Iron</td>
                      <td>Rizky</td>
                      <td>Backup mesin 2</td>
                    </tr>
                    <tr>
                      <td>Rabu</td>
                      <td><span class="badge bg-light text-primary">Pagi</span></td>
                      <td>Delivery</td>
                      <td>Sela</td>
                      <td>Route barat</td>
                    </tr>
                    <tr>
                      <td>Kamis</td>
                      <td><span class="badge bg-light text-dark">Malam</span></td>
                      <td>Deep Clean</td>
                      <td>Damar</td>
                      <td>Sanitasi mesin</td>
                    </tr>
                    <tr>
                      <td>Jumat</td>
                      <td><span class="badge bg-light text-info">Sore</span></td>
                      <td>QC & Packing</td>
                      <td>Putra</td>
                      <td>Prep weekend</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade" id="tab-gaji" role="tabpanel" aria-labelledby="tab-gaji-tab">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <h5 class="mb-0">Komponen Gaji</h5>
                  <small class="text-muted">Draft perhitungan gaji</small>
                </div>
                <button class="btn btn-sm btn-outline-primary">Atur Komponen</button>
              </div>
              <div class="row g-3">
                <div class="col-lg-7">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                          <thead>
                            <tr>
                              <th>Komponen</th>
                              <th>Jenis</th>
                              <th>Nominal</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Gaji Pokok</td>
                              <td><span class="badge bg-light text-primary">Tetap</span></td>
                              <td>Rp3.000.000</td>
                            </tr>
                            <tr>
                              <td>Tunjangan Transport</td>
                              <td><span class="badge bg-light text-success">Tunjangan</span></td>
                              <td>Rp300.000</td>
                            </tr>
                            <tr>
                              <td>Lembur</td>
                              <td><span class="badge bg-light text-info">Variabel</span></td>
                              <td>Rp120.000</td>
                            </tr>
                            <tr>
                              <td>Insentif Kinerja</td>
                              <td><span class="badge bg-light text-success">Bonus</span></td>
                              <td>Rp250.000</td>
                            </tr>
                            <tr>
                              <td>Potongan Terlambat</td>
                              <td><span class="badge bg-light text-danger">Potongan</span></td>
                              <td>-Rp50.000</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="card-title mb-2">Simulasi Gaji</h6>
                      <div class="d-flex justify-content-between small mb-1">
                        <span>Golongan</span>
                        <span>A (Supervisor)</span>
                      </div>
                      <div class="d-flex justify-content-between small mb-1">
                        <span>Shift</span>
                        <span>Pagi (26 hari)</span>
                      </div>
                      <div class="d-flex justify-content-between small">
                        <span>Lembur</span>
                        <span>12 jam</span>
                      </div>
                      <hr class="my-2">
                      <div class="d-flex justify-content-between small">
                        <span>Gaji Pokok</span>
                        <span>Rp3.000.000</span>
                      </div>
                      <div class="d-flex justify-content-between small">
                        <span>Tunjangan</span>
                        <span>Rp550.000</span>
                      </div>
                      <div class="d-flex justify-content-between small">
                        <span>Lembur</span>
                        <span>Rp180.000</span>
                      </div>
                      <div class="d-flex justify-content-between small">
                        <span>Potongan</span>
                        <span>-Rp120.000</span>
                      </div>
                      <hr class="my-2">
                      <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>Rp3.610.000</strong>
                      </div>
                      <button class="btn btn-sm btn-outline-primary w-100 mt-2">Simpan Simulasi</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-slip" role="tabpanel" aria-labelledby="tab-slip-tab">
              <div class="row g-3">
                <div class="col-lg-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                          <h5 class="mb-0">Slip Gaji Terakhir</h5>
                          <small class="text-muted">Contoh detail</small>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary">Unduh</button>
                      </div>
                      <div class="border rounded p-3 bg-light">
                        <div class="d-flex justify-content-between">
                          <div>
                            <strong>Nama</strong>
                            <div class="text-muted">Andini Putri</div>
                          </div>
                          <div class="text-end">
                            <strong>Periode</strong>
                            <div class="text-muted">Jan 2024</div>
                          </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between small">
                          <span>Gaji Pokok</span>
                          <span>Rp3.000.000</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                          <span>Tunjangan</span>
                          <span>Rp550.000</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                          <span>Lembur</span>
                          <span>Rp180.000</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                          <span>Potongan</span>
                          <span>-Rp120.000</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                          <strong>Total Diterima</strong>
                          <strong>Rp3.610.000</strong>
                        </div>
                      </div>
                      <div class="d-flex flex-wrap gap-2 mt-3">
                        <button class="btn btn-sm btn-primary">Kirim ke Email</button>
                        <button class="btn btn-sm btn-outline-primary">Lihat Detail</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="card-title mb-2">Riwayat Slip</h6>
                      <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                          <thead>
                            <tr>
                              <th>Periode</th>
                              <th>Status</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Jan 2024</td>
                              <td><span class="badge bg-success">Terkirim</span></td>
                              <td><button class="btn btn-xs btn-outline-primary">Unduh</button></td>
                            </tr>
                            <tr>
                              <td>Des 2023</td>
                              <td><span class="badge bg-success">Terkirim</span></td>
                              <td><button class="btn btn-xs btn-outline-primary">Unduh</button></td>
                            </tr>
                            <tr>
                              <td>Nov 2023</td>
                              <td><span class="badge bg-warning text-dark">Draft</span></td>
                              <td><button class="btn btn-xs btn-outline-primary">Kirim</button></td>
                            </tr>
                            <tr>
                              <td>Okt 2023</td>
                              <td><span class="badge bg-success">Terkirim</span></td>
                              <td><button class="btn btn-xs btn-outline-primary">Unduh</button></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="tab-instruksi" role="tabpanel" aria-labelledby="tab-instruksi-tab">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <h5 class="mb-0">Instruksi ke Pegawai</h5>
                  <small class="text-muted">Pengumuman dan SOP singkat</small>
                </div>
                <button class="btn btn-sm btn-outline-primary">Tambah Instruksi</button>
              </div>
              <div class="row g-3">
                <div class="col-lg-7">
                  <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                      <div>
                        <div class="fw-bold">Penerapan SOP Baru</div>
                        <div class="text-muted small">Gunakan label warna baru untuk paket express mulai Senin.</div>
                      </div>
                      <span class="badge bg-primary">Operasional</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                      <div>
                        <div class="fw-bold">Briefing Pagi 07:50</div>
                        <div class="text-muted small">Wajib hadir untuk tim Pagi di outlet utama.</div>
                      </div>
                      <span class="badge bg-info text-dark">Shift</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                      <div>
                        <div class="fw-bold">Insentif Akurasi</div>
                        <div class="text-muted small">Bonus Rp10.000 per order tanpa komplain untuk bulan ini.</div>
                      </div>
                      <span class="badge bg-success">Insentif</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                      <div>
                        <div class="fw-bold">Cut-Off Presensi</div>
                        <div class="text-muted small">Approve izin maksimal Jumat pukul 17:00.</div>
                      </div>
                      <span class="badge bg-secondary">Presensi</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="card-title mb-2">Kirim Instruksi</h6>
                      <div class="mb-2">
                        <label class="form-label small">Judul</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Contoh: Update SOP Express">
                      </div>
                      <div class="mb-2">
                        <label class="form-label small">Pesan</label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Tuliskan instruksi singkat"></textarea>
                      </div>
                      <div class="mb-2">
                        <label class="form-label small">Kirim ke</label>
                        <select class="form-select form-select-sm">
                          <option>Semua Pegawai</option>
                          <option>Supervisor</option>
                          <option>Operator</option>
                          <option>Kurir</option>
                        </select>
                      </div>
                      <button class="btn btn-sm btn-primary w-100">Kirim</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

{{-- Modal edit waypoint --}}
<div class="modal fade" id="editWaypointModal" tabindex="-1" aria-labelledby="editWaypointModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="editWaypointModalLabel">Edit Titik Presensi</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label small mb-1">Nama Titik</label>
          <input type="text" class="form-control form-control-sm" id="edit-wp-name">
        </div>
        <div class="mb-2">
          <label class="form-label small mb-1">Latitude</label>
          <input type="number" step="0.000001" class="form-control form-control-sm" id="edit-wp-lat">
        </div>
        <div class="mb-2">
          <label class="form-label small mb-1">Longitude</label>
          <input type="number" step="0.000001" class="form-control form-control-sm" id="edit-wp-lng">
        </div>
        <div class="mb-2">
          <label class="form-label small mb-1">Radius (meter)</label>
          <input type="number" min="50" max="5000" class="form-control form-control-sm" id="edit-wp-radius">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-sm btn-primary" id="edit-wp-save">Simpan</button>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('#tab-shift-tab, #tab-presensi-tab, #tab-golongan-tab, #tab-pegawai-tab, #tab-jadwal-tab, #tab-gaji-tab, #tab-slip-tab, #tab-instruksi-tab');
    const hashToTab = {
      '#shift': 'tab-shift-tab',
      '#presensi': 'tab-presensi-tab',
      '#golongan': 'tab-golongan-tab',
      '#pegawai': 'tab-pegawai-tab',
      '#jadwal': 'tab-jadwal-tab',
      '#gaji': 'tab-gaji-tab',
      '#slip': 'tab-slip-tab',
      '#instruksi': 'tab-instruksi-tab'
    };

    function activateTabByHash(hash) {
      const buttonId = hashToTab[hash];
      const btn = buttonId ? document.getElementById(buttonId) : null;
      if (btn && window.bootstrap) {
        const tab = new bootstrap.Tab(btn);
        tab.show();
      }
    }

    tabButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.getAttribute('data-bs-target');
        if (target) {
          const newHash = target.replace('#tab-', '#');
          history.replaceState(null, '', newHash);
        }
      });
    });

    if (hashToTab[window.location.hash]) {
      activateTabByHash(window.location.hash);
    }

    // Geofence map preview
    const latInput = document.getElementById('geofence_lat');
    const lngInput = document.getElementById('geofence_lng');
    const radiusInput = document.getElementById('geofence_radius_m');
    const mapLabel = document.getElementById('geofence-map-label');
    const mapEl = document.getElementById('geofence-map');
    const gpsBtn = document.getElementById('use-gps-btn');
    const addWaypointBtn = document.getElementById('add-waypoint-btn');
    const nameInput = document.getElementById('geofence_name');
    const waypointListEl = document.getElementById('waypoints-list');
    const waypointCountEl = document.getElementById('waypoint-count');
    const waypointHiddenEl = document.getElementById('waypoints-hidden');
    const rulePointsDataEl = document.getElementById('rule-points-data');
    const editModalEl = document.getElementById('editWaypointModal');
    const editModal = editModalEl ? new bootstrap.Modal(editModalEl) : null;
    const editNameInput = document.getElementById('edit-wp-name');
    const editLatInput = document.getElementById('edit-wp-lat');
    const editLngInput = document.getElementById('edit-wp-lng');
    const editRadiusInput = document.getElementById('edit-wp-radius');
    const editSaveBtn = document.getElementById('edit-wp-save');
    const attendanceForm = document.querySelector('form[action*="attendance.rules.save"]');
    let rulePoints = [];
    let editingIdx = null;
    if (rulePointsDataEl && rulePointsDataEl.dataset.rulePoints) {
      try {
        rulePoints = JSON.parse(rulePointsDataEl.dataset.rulePoints);
      } catch (e) {
        rulePoints = [];
      }
    }
    let waypoints = Array.isArray(rulePoints) ? rulePoints : [];
    let waypointLayers = [];
    let map;

    function updateLabel(lat, lng, radius) {
      if (mapLabel) {
        mapLabel.textContent = `Pusat: ${lat.toFixed(6)}, ${lng.toFixed(6)} | Radius: ${radius}m`;
      }
    }

    function syncWaypointHidden() {
      if (!waypointHiddenEl) return;
      waypointHiddenEl.innerHTML = '';
      waypoints.forEach(wp => {
        const inputs = [
          { name: 'waypoints_name[]', value: wp.name || '' },
          { name: 'waypoints_lat[]', value: wp.lat },
          { name: 'waypoints_lng[]', value: wp.lng },
          { name: 'waypoints_radius[]', value: wp.radius },
        ];
        inputs.forEach(i => {
          const el = document.createElement('input');
          el.type = 'hidden';
          el.name = i.name;
          el.value = i.value;
          waypointHiddenEl.appendChild(el);
        });
      });
    }

    function renderWaypointLayers() {
      if (!map || !window.L) return;
      waypointLayers.forEach(l => map.removeLayer(l));
      waypointLayers = [];
      waypoints.forEach(wp => {
        const circ = L.circle([wp.lat, wp.lng], { radius: wp.radius, color: '#0d6efd', fillColor: '#0d6efd', fillOpacity: 0.15 }).addTo(map);
        const mark = L.marker([wp.lat, wp.lng]).addTo(map);
        waypointLayers.push(circ, mark);
      });
    }

    function renderWaypointList() {
      if (waypointCountEl) waypointCountEl.textContent = `${waypoints.length} titik`;
      if (waypointListEl) {
        waypointListEl.innerHTML = '';
        if (!waypoints.length) {
          waypointListEl.innerHTML = '<div class="small text-muted px-2 py-1">Belum ada titik presensi.</div>';
        } else {
          waypoints.forEach((wp, idx) => {
            const item = document.createElement('div');
            item.className = 'list-group-item d-flex justify-content-between align-items-start';
            item.innerHTML = `
              <div>
                <div class="fw-semibold">${wp.name || 'Titik ' + (idx + 1)}</div>
                <div class="text-muted">Lat: ${wp.lat.toFixed(6)}, Lng: ${wp.lng.toFixed(6)}</div>
                <div class="text-muted">Radius: ${wp.radius} m</div>
              </div>
              <div class="d-flex gap-1">
                <button class="btn btn-xs btn-outline-primary" data-idx="${idx}" data-action="edit">Edit</button>
                <button class="btn btn-xs btn-outline-danger" data-idx="${idx}" data-action="delete">Hapus</button>
              </div>
            `;
            item.querySelectorAll('button').forEach(btn => {
              btn.addEventListener('click', () => {
                const action = btn.dataset.action;
                if (action === 'delete') {
                  waypoints.splice(idx, 1);
                  if (editingIdx === idx) editingIdx = null;
                } else if (action === 'edit') {
                  editingIdx = idx;
                  const wpData = waypoints[idx];
                  if (editNameInput) editNameInput.value = wpData.name || '';
                  if (editLatInput) editLatInput.value = wpData.lat.toFixed(6);
                  if (editLngInput) editLngInput.value = wpData.lng.toFixed(6);
                  if (editRadiusInput) editRadiusInput.value = wpData.radius;
                  if (editModal) editModal.show();
                }
                renderWaypointList();
              });
            });
            waypointListEl.appendChild(item);
          });
        }
      }
      syncWaypointHidden();
      renderWaypointLayers();
      autoSubmitRules();
    }

    function addWaypointFromInputs() {
      const lat = parseFloat(latInput?.value ?? '');
      const lng = parseFloat(lngInput?.value ?? '');
      const radius = parseInt(radiusInput?.value ?? '', 10);
      const name = nameInput?.value?.trim() || `Titik ${waypoints.length + 1}`;
      if (isNaN(lat) || isNaN(lng) || isNaN(radius)) {
        alert('Lengkapi latitude, longitude, dan radius terlebih dahulu.');
        return;
      }
      waypoints.push({ lat, lng, radius, name });
      renderWaypointList();
    }

    function initLeaflet(lat, lng, radius) {
      if (!window.L || !mapEl) return;
      map = L.map(mapEl, { zoomControl: true, doubleClickZoom: false, attributionControl: false }).setView([lat, lng], 17);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: ''
      }).addTo(map);
      map.on('dblclick', (e) => {
        const { lat: clat, lng: clng } = e.latlng;
        if (latInput) latInput.value = clat.toFixed(6);
        if (lngInput) lngInput.value = clng.toFixed(6);
        updateMap();
        addWaypointFromInputs();
      });
      renderWaypointLayers();
    }

    function updateMap() {
      const lat = parseFloat(latInput?.value ?? '0');
      const lng = parseFloat(lngInput?.value ?? '0');
      const radius = parseInt(radiusInput?.value ?? '0', 10);
      if (isNaN(lat) || isNaN(lng) || isNaN(radius)) return;
      updateLabel(lat, lng, radius);
      if (map) {
        map.setView([lat, lng], 17);
      }
    }

    const defaults = (() => {
      if (waypoints.length) {
        const first = waypoints[0];
        if (latInput) latInput.value = first.lat;
        if (lngInput) lngInput.value = first.lng;
        if (radiusInput) radiusInput.value = first.radius;
        if (nameInput) nameInput.value = first.name || '';
        return { lat: first.lat, lng: first.lng, radius: first.radius };
      }
      return {
        lat: parseFloat(latInput?.value || '0'),
        lng: parseFloat(lngInput?.value || '0'),
        radius: parseInt(radiusInput?.value || '200', 10)
      };
    })();
    initLeaflet(defaults.lat, defaults.lng, defaults.radius);
    updateLabel(defaults.lat, defaults.lng, defaults.radius);
    renderWaypointList();

    [latInput, lngInput, radiusInput].forEach(input => {
      if (!input) return;
      input.addEventListener('input', updateMap);
      input.addEventListener('change', updateMap);
    });

    if (gpsBtn && navigator.geolocation) {
      gpsBtn.addEventListener('click', () => {
        gpsBtn.disabled = true;
        gpsBtn.textContent = 'Mengambil lokasi...';
        navigator.geolocation.getCurrentPosition(
          (pos) => {
            const { latitude, longitude } = pos.coords;
            if (latInput) latInput.value = latitude.toFixed(6);
            if (lngInput) lngInput.value = longitude.toFixed(6);
            updateMap();
            gpsBtn.textContent = 'Gunakan GPS';
            gpsBtn.disabled = false;
          },
          (err) => {
            alert('Gagal mengambil lokasi: ' + err.message);
            gpsBtn.textContent = 'Gunakan GPS';
            gpsBtn.disabled = false;
          },
          { enableHighAccuracy: true, timeout: 8000, maximumAge: 10000 }
        );
      });
    }

    if (addWaypointBtn) {
      addWaypointBtn.addEventListener('click', addWaypointFromInputs);
      addWaypointBtn.addEventListener('click', () => {
        if (nameInput) nameInput.value = '';
      });
    }

    function saveEditedWaypoint() {
      if (editingIdx === null || editingIdx < 0 || editingIdx >= waypoints.length) {
        if (editModal) editModal.hide();
        return;
      }
      const lat = parseFloat(editLatInput?.value ?? '');
      const lng = parseFloat(editLngInput?.value ?? '');
      const radius = parseInt(editRadiusInput?.value ?? '', 10);
      const name = editNameInput?.value?.trim() || `Titik ${editingIdx + 1}`;
      if (isNaN(lat) || isNaN(lng) || isNaN(radius)) {
        alert('Lengkapi data titik terlebih dahulu.');
        return;
      }
      waypoints[editingIdx] = { lat, lng, radius, name };
      editingIdx = null;
      renderWaypointList();
      if (editModal) editModal.hide();
    }

    if (editSaveBtn) {
      editSaveBtn.addEventListener('click', saveEditedWaypoint);
    }

    const presensiTabBtn = document.getElementById('tab-presensi-tab');
    if (presensiTabBtn) {
      presensiTabBtn.addEventListener('shown.bs.tab', () => {
        if (map) {
          setTimeout(() => {
            map.invalidateSize();
          }, 100); // beri jeda sedikit supaya transition selesai
        }
      });
    }

    // Edit shift: isi form dan ubah action ke update
    const shiftForm = document.querySelector('#form-shift form');
    const shiftSubmitBtn = document.getElementById('shift-submit-btn');
    const shiftResetBtn = document.getElementById('shift-reset-btn');
    const shiftEditBtns = document.querySelectorAll('.shift-edit-btn');
    const shiftFormCollapseEl = document.getElementById('form-shift');
    const shiftDefaultAction = shiftForm ? shiftForm.getAttribute('action') : '';
    const shiftDefaultBtnText = shiftSubmitBtn ? shiftSubmitBtn.textContent : '';
    const shiftInputs = shiftForm ? {
      name: shiftForm.querySelector('input[name="name"]'),
      start: shiftForm.querySelector('input[name="start_time"]'),
      end: shiftForm.querySelector('input[name="end_time"]'),
      days: shiftForm.querySelector('input[name="days"]'),
      quota: shiftForm.querySelector('input[name="quota"]'),
    } : {};

    function openShiftCollapse() {
      if (shiftFormCollapseEl && window.bootstrap) {
        const col = new bootstrap.Collapse(shiftFormCollapseEl, { show: true, toggle: true });
        col.show();
      }
    }

    function setShiftForm(mode, data = {}) {
      if (!shiftForm) return;
      if (mode === 'edit' && data.updateUrl) {
        shiftForm.setAttribute('action', data.updateUrl);
        if (shiftSubmitBtn) shiftSubmitBtn.textContent = 'Update Shift';
      } else {
        shiftForm.setAttribute('action', shiftDefaultAction);
        if (shiftSubmitBtn) shiftSubmitBtn.textContent = shiftDefaultBtnText || 'Simpan Shift';
      }
      if (shiftInputs.name) shiftInputs.name.value = data.name || '';
      if (shiftInputs.start) shiftInputs.start.value = data.start || '';
      if (shiftInputs.end) shiftInputs.end.value = data.end || '';
      if (shiftInputs.days) shiftInputs.days.value = data.days || '';
      if (shiftInputs.quota) shiftInputs.quota.value = data.quota ?? 0;
    }

    shiftEditBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        setShiftForm('edit', {
          updateUrl: btn.dataset.updateUrl,
          name: btn.dataset.name,
          start: btn.dataset.start,
          end: btn.dataset.end,
          days: btn.dataset.days,
          quota: btn.dataset.quota
        });
        openShiftCollapse();
      });
    });

    if (shiftResetBtn) {
      shiftResetBtn.addEventListener('click', () => {
        setShiftForm('new');
        if (shiftFormCollapseEl && window.bootstrap) {
          const col = new bootstrap.Collapse(shiftFormCollapseEl, { show: true, toggle: true });
          col.hide();
        }
      });
    }

    // Edit golongan
    const gradeForm = document.getElementById('grade-form');
    const gradeSubmitBtn = document.getElementById('grade-submit-btn');
    const gradeResetBtn = document.getElementById('grade-reset-btn');
    const gradeEditBtns = document.querySelectorAll('.grade-edit-btn');
    const gradeCollapseEl = document.getElementById('form-golongan');
    const gradeDefaultAction = gradeForm ? gradeForm.getAttribute('action') : '';
    const gradeDefaultBtnText = gradeSubmitBtn ? gradeSubmitBtn.textContent : '';
    const gradeInputs = gradeForm ? {
      code: gradeForm.querySelector('input[name="code"]'),
      role: gradeForm.querySelector('input[name="role"]'),
      allowance: gradeForm.querySelector('input[name="allowance"]'),
      benefit: gradeForm.querySelector('input[name="benefit"]'),
    } : {};

    function openGradeCollapse() {
      if (gradeCollapseEl && window.bootstrap) {
        const col = new bootstrap.Collapse(gradeCollapseEl, { show: true, toggle: true });
        col.show();
      }
    }

    function setGradeForm(mode, data = {}) {
      if (!gradeForm) return;
      if (mode === 'edit' && data.updateUrl) {
        gradeForm.setAttribute('action', data.updateUrl);
        if (gradeSubmitBtn) gradeSubmitBtn.textContent = 'Update Golongan';
      } else {
        gradeForm.setAttribute('action', gradeDefaultAction);
        if (gradeSubmitBtn) gradeSubmitBtn.textContent = gradeDefaultBtnText || 'Simpan Golongan';
      }
      if (gradeInputs.code) gradeInputs.code.value = data.code || '';
      if (gradeInputs.role) gradeInputs.role.value = data.role || '';
      if (gradeInputs.allowance) gradeInputs.allowance.value = data.allowance || '';
      if (gradeInputs.benefit) gradeInputs.benefit.value = data.benefit || '';
    }

    gradeEditBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        setGradeForm('edit', {
          updateUrl: btn.dataset.updateUrl,
          code: btn.dataset.code,
          role: btn.dataset.role,
          allowance: btn.dataset.allowance,
          benefit: btn.dataset.benefit
        });
        openGradeCollapse();
      });
    });

    if (gradeResetBtn) {
      gradeResetBtn.addEventListener('click', () => {
        setGradeForm('new');
        if (gradeCollapseEl && window.bootstrap) {
          const col = new bootstrap.Collapse(gradeCollapseEl, { show: true, toggle: true });
          col.hide();
        }
      });
    }

    // Edit pegawai
    const empForm = document.getElementById('employee-form');
    const empSubmitBtn = document.getElementById('emp-submit-btn');
    const empResetBtn = document.getElementById('emp-reset-btn');
    const empEditBtns = document.querySelectorAll('.emp-edit-btn');
    const empCollapseEl = document.getElementById('form-pegawai');
    const empDefaultAction = empForm ? empForm.getAttribute('action') : '';
    const empDefaultBtnText = empSubmitBtn ? empSubmitBtn.textContent : '';
    const empInputs = empForm ? {
      name: document.getElementById('emp-name'),
      grade: document.getElementById('emp-grade'),
      shift: document.getElementById('emp-shift'),
      contact: document.getElementById('emp-contact'),
    } : {};

    function openEmpCollapse() {
      if (empCollapseEl && window.bootstrap) {
        const col = new bootstrap.Collapse(empCollapseEl, { show: true, toggle: true });
        col.show();
      }
    }

    function setEmpForm(mode, data = {}) {
      if (!empForm) return;
      if (mode === 'edit' && data.updateUrl) {
        empForm.setAttribute('action', data.updateUrl);
        if (empSubmitBtn) empSubmitBtn.textContent = 'Update Pegawai';
      } else {
        empForm.setAttribute('action', empDefaultAction);
        if (empSubmitBtn) empSubmitBtn.textContent = empDefaultBtnText || 'Simpan Pegawai';
      }
      if (empInputs.name) empInputs.name.value = data.name || '';
      if (empInputs.grade) empInputs.grade.value = data.grade || '';
      if (empInputs.shift) empInputs.shift.value = data.shift || '';
      if (empInputs.contact) empInputs.contact.value = data.contact || '';
    }

    empEditBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        setEmpForm('edit', {
          updateUrl: btn.dataset.updateUrl,
          name: btn.dataset.name,
          grade: btn.dataset.grade,
          shift: btn.dataset.shift,
          contact: btn.dataset.contact,
        });
        openEmpCollapse();
      });
    });

    if (empResetBtn) {
      empResetBtn.addEventListener('click', () => {
        setEmpForm('new');
        if (empCollapseEl && window.bootstrap) {
          const col = new bootstrap.Collapse(empCollapseEl, { show: true, toggle: true });
          col.hide();
        }
      });
    }

    function autoSubmitRules() {
      if (attendanceForm) {
        attendanceForm.submit();
      }
    }

  });
</script>
@endsection
