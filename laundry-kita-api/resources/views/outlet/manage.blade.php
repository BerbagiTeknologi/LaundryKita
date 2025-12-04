@extends('layouts.app')
@section('title', 'Kelola Outlet | Laundry Kita')

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card" id="outlet-tabs">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
          <h4 class="card-title mb-0">Kelola Outlet</h4>
          <span class="text-muted small">Atur profil, jam operasional, antar jemput, ongkir, review, dan nota</span>
        </div>

        <ul class="nav nav-tabs mt-3" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-outlet-profile-tab" data-bs-toggle="tab" data-bs-target="#tab-outlet-profile" type="button" role="tab">
              <i class="mdi mdi-account-edit me-2"></i>Edit Profil Outlet
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-outlet-hours-tab" data-bs-toggle="tab" data-bs-target="#tab-outlet-hours" type="button" role="tab">
              <i class="mdi mdi-clock-outline me-2"></i>Jam Operasional
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-outlet-pickup-tab" data-bs-toggle="tab" data-bs-target="#tab-outlet-pickup" type="button" role="tab">
              <i class="mdi mdi-truck-delivery-outline me-2"></i>Jam Antar Jemput
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-outlet-ongkir-tab" data-bs-toggle="tab" data-bs-target="#tab-outlet-ongkir" type="button" role="tab">
              <i class="mdi mdi-cash-fast me-2"></i>Tarif Ongkir
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-outlet-review-tab" data-bs-toggle="tab" data-bs-target="#tab-outlet-review" type="button" role="tab">
              <i class="mdi mdi-star-outline me-2"></i>Review Pelanggan
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-outlet-nota-tab" data-bs-toggle="tab" data-bs-target="#tab-outlet-nota" type="button" role="tab">
              <i class="mdi mdi-receipt-text-outline me-2"></i>Nota & Bukti
            </button>
          </li>
        </ul>

        <div class="tab-content pt-3">
          {{-- Tab Edit Profil --}}
          <div class="tab-pane fade show active" id="tab-outlet-profile" role="tabpanel">
            <form method="POST" action="{{ route('outlet.update') }}">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nama Outlet</label>
                    <input type="text" class="form-control" name="outlet_name" value="{{ old('outlet_name', $user->name) }}" required>
                    @error('outlet_name')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" name="province" value="{{ old('province', $user->province) }}">
                    @error('province')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" class="form-control" name="city" value="{{ old('city', $user->city) }}">
                    @error('city')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
              <div class="form-group">
                <label>Zona Waktu</label>
                <select class="form-control" name="timezone" required>
                  <option value="WIB" {{ old('timezone', $user->timezone)==='WIB'?'selected':'' }}>WIB</option>
                  <option value="WITA" {{ old('timezone', $user->timezone)==='WITA'?'selected':'' }}>WITA</option>
                  <option value="WIT" {{ old('timezone', $user->timezone)==='WIT'?'selected':'' }}>WIT</option>
                </select>
                @error('timezone')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
              <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Simpan Profil</button>
              </div>
            </form>
          </div>

          {{-- Tab Jam Operasional --}}
          <div class="tab-pane fade" id="tab-outlet-hours" role="tabpanel">
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
                        <td><input type="time" class="form-control" name="open[{{ $day }}]" value="{{ $hours[$day]->open_time ?? '' }}"></td>
                        <td><input type="time" class="form-control" name="close[{{ $day }}]" value="{{ $hours[$day]->close_time ?? '' }}"></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Simpan Jam Operasional</button>
              </div>
            </form>
          </div>

          {{-- Tab Jam Antar Jemput --}}
          <div class="tab-pane fade" id="tab-outlet-pickup" role="tabpanel">
            <form method="POST" action="{{ route('outlet.pickup.update') }}">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Jam Mulai Antar Jemput</label>
                    <input type="time" class="form-control" name="start_time" value="{{ old('start_time', $pickup->start_time ?? '') }}">
                    @error('start_time')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Jam Selesai Antar Jemput</label>
                    <input type="time" class="form-control" name="end_time" value="{{ old('end_time', $pickup->end_time ?? '') }}">
                    @error('end_time')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                </div>
              </div>
              <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Simpan Jam Antar Jemput</button>
              </div>
            </form>
          </div>

          {{-- Tab Tarif Ongkir --}}
          <div class="tab-pane fade" id="tab-outlet-ongkir" role="tabpanel">
            <p class="text-muted mb-3">Atur tarif ongkir dan ketentuan antar jemput.</p>
            <div class="row g-3">
              <div class="col-lg-5">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">Pengaturan Dasar</h5>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="ongkir-enable" checked>
                      <label class="form-check-label" for="ongkir-enable">Aktifkan layanan antar jemput</label>
                    </div>
                    <div class="form-check form-switch mt-2">
                      <input class="form-check-input" type="checkbox" id="ongkir-free-min" checked>
                      <label class="form-check-label" for="ongkir-free-min">Gratis ongkir untuk order minimal</label>
                    </div>
                    <div class="row g-2 mt-3">
                      <div class="col-6">
                        <label class="form-label mb-1">Tarif Dasar</label>
                        <div class="input-group">
                          <span class="input-group-text">Rp</span>
                          <input type="number" class="form-control" value="8000">
                        </div>
                        <small class="text-muted">0-3 km</small>
                      </div>
                      <div class="col-6">
                        <label class="form-label mb-1">Tarif per Km</label>
                        <div class="input-group">
                          <span class="input-group-text">Rp</span>
                          <input type="number" class="form-control" value="2500">
                        </div>
                        <small class="text-muted">Di atas 3 km</small>
                      </div>
                    </div>
                    <div class="mt-3">
                      <label class="form-label mb-1">Minimal Order Gratis Ongkir</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" value="50000">
                      </div>
                    </div>
                    <div class="mt-3">
                      <label class="form-label mb-1">Catatan Kurir</label>
                      <textarea class="form-control" rows="2" placeholder="Contoh: Hubungi pelanggan sebelum berangkat"></textarea>
                    </div>
                    <div class="text-end mt-3">
                      <button type="button" class="btn btn-primary btn-sm">Simpan Konfigurasi</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div>
                        <h5 class="card-title mb-0">Daftar Tarif</h5>
                        <small class="text-muted">Sesuaikan zona dan biaya tambahan</small>
                      </div>
                      <button type="button" class="btn btn-outline-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah Zona</button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped align-middle mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Zona</th>
                            <th>Rentang Jarak</th>
                            <th>Tarif</th>
                            <th>Catatan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Default</td>
                            <td>0 - 3 km</td>
                            <td>Rp 8.000</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Perumahan</td>
                            <td>3 - 7 km</td>
                            <td>Rp 12.000</td>
                            <td>Gratis ongkir >= Rp 50.000</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Antar Kota</td>
                            <td>7 - 15 km</td>
                            <td>Rp 18.000</td>
                            <td>Tambahan tol bila ada</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">Atur tarif sesuai zona layanan agar kurir punya pedoman jelas.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Tab Review Pelanggan --}}
          <div class="tab-pane fade" id="tab-outlet-review" role="tabpanel">
            <p class="text-muted mb-3">Pantau kepuasan pelanggan dan beri respon cepat.</p>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="card h-100">
                  <div class="card-body">
                    <p class="text-muted mb-1">Rating rata-rata</p>
                    <div class="d-flex align-items-baseline gap-2">
                      <h3 class="mb-0">4.7</h3>
                      <div>
                        <span class="text-warning mdi mdi-star"></span>
                        <span class="text-warning mdi mdi-star"></span>
                        <span class="text-warning mdi mdi-star"></span>
                        <span class="text-warning mdi mdi-star"></span>
                        <span class="text-warning mdi mdi-star-half-full"></span>
                      </div>
                    </div>
                    <small class="text-muted">Berdasarkan 128 ulasan</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card h-100">
                  <div class="card-body">
                    <p class="text-muted mb-1">Total Ulasan</p>
                    <h3 class="mb-0">128</h3>
                    <small class="text-muted">16 ulasan baru minggu ini</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card h-100">
                  <div class="card-body">
                    <p class="text-muted mb-1">Menunggu balasan</p>
                    <h3 class="mb-0 text-warning">5</h3>
                    <small class="text-muted">Prioritaskan balasan untuk rating rendah</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="card mt-3">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <h5 class="card-title mb-0">Daftar Review</h5>
                  <div class="btn-group btn-group-sm" role="group" aria-label="Filter review">
                    <button type="button" class="btn btn-outline-primary active">Semua</button>
                    <button type="button" class="btn btn-outline-primary">5 bintang</button>
                    <button type="button" class="btn btn-outline-primary">4 bintang</button>
                    <button type="button" class="btn btn-outline-primary">Negatif</button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table align-middle mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Andien</td>
                        <td>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star-half-full"></span>
                          <small class="text-muted ms-1">4.8</small>
                        </td>
                        <td>Outlet rapi, kurir datang tepat waktu.</td>
                        <td>3 hari lalu</td>
                        <td><span class="badge bg-success">Publik</span></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Bima</td>
                        <td>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star-outline"></span>
                          <small class="text-muted ms-1">4.0</small>
                        </td>
                        <td>Pakaian bersih, wangi, pelayanan ramah.</td>
                        <td>5 hari lalu</td>
                        <td><span class="badge bg-success">Publik</span></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Citra</td>
                        <td>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star"></span>
                          <span class="text-warning mdi mdi-star-outline"></span>
                          <span class="text-warning mdi mdi-star-outline"></span>
                          <small class="text-muted ms-1">3.0</small>
                        </td>
                        <td>Pesanan sedikit terlambat, mohon dipercepat.</td>
                        <td>1 minggu lalu</td>
                        <td><span class="badge bg-warning text-dark">Butuh Balasan</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="card mt-3">
              <div class="card-body">
                <h6 class="card-title mb-2">Balas Cepat</h6>
                <div class="row g-2 align-items-end">
                  <div class="col-md-9">
                    <textarea class="form-control" rows="2" placeholder="Tulis template balasan untuk pelanggan">Terima kasih sudah mencuci di Laundry Kita! Kami senang bisa membantu, tunggu kedatangan berikutnya.</textarea>
                  </div>
                  <div class="col-md-3 d-flex flex-column gap-2">
                    <button type="button" class="btn btn-primary w-100">Kirim Balasan</button>
                    <button type="button" class="btn btn-outline-secondary w-100 btn-sm">Simpan sebagai template</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Tab Nota & Bukti --}}
          <div class="tab-pane fade" id="tab-outlet-nota" role="tabpanel">
            <p class="text-muted mb-3">Atur format nota, mode transaksi, dan bukti pembayaran.</p>
            <div class="row g-3">
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-3">Konfigurasi Nota</h5>
                    <div class="mb-3">
                      <label class="form-label mb-1">Judul Nota</label>
                      <input type="text" class="form-control" value="Laundry Kita - Tanda Terima">
                    </div>
                    <div class="mb-3">
                      <label class="form-label mb-1">Footer/Perhatian</label>
                      <textarea class="form-control" rows="3">Terima kasih telah menggunakan layanan kami. Simpan nota ini sebagai bukti transaksi.</textarea>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="nota-qr" checked>
                      <label class="form-check-label" for="nota-qr">Tampilkan QR/tautan pembayaran</label>
                    </div>
                    <div class="form-check form-switch mt-2">
                      <input class="form-check-input" type="checkbox" id="nota-delivery" checked>
                      <label class="form-check-label" for="nota-delivery">Cetak detail penjemputan & pengantaran</label>
                    </div>
                    <div class="form-check form-switch mt-2">
                      <input class="form-check-input" type="checkbox" id="nota-mode" checked>
                      <label class="form-check-label" for="nota-mode">Tampilkan mode transaksi (Tunai/QR/Transfer)</label>
                    </div>
                    <div class="text-end mt-3">
                      <button type="button" class="btn btn-primary btn-sm">Simpan Preferensi</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div>
                        <h5 class="card-title mb-0">Bukti Transaksi</h5>
                        <small class="text-muted">Unggah foto bukti atau nota digital.</small>
                      </div>
                      <button type="button" class="btn btn-outline-primary btn-sm"><i class="mdi mdi-upload"></i> Unggah Bukti</button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped align-middle mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Waktu</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Rania</td>
                            <td>Foto bukti bayar</td>
                            <td><span class="badge bg-success">Tersimpan</span></td>
                            <td>09:45</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Bayu</td>
                            <td>Nota digital</td>
                            <td><span class="badge bg-primary">Siap dikirim</span></td>
                            <td>08:10</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Salsa</td>
                            <td>Foto serah terima</td>
                            <td><span class="badge bg-warning text-dark">Butuh verifikasi</span></td>
                            <td>1 hari lalu</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">Arsipkan nota dan bukti agar riwayat transaksi rapi dan mudah ditelusuri.</div>
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

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('#outlet-tabs [data-bs-toggle="tab"]');

    function activateHashTab(hash) {
      if (!hash) return;
      const btn = document.querySelector(`#outlet-tabs [data-bs-target="${hash}"]`);
      if (btn && window.bootstrap && window.bootstrap.Tab) {
        window.bootstrap.Tab.getOrCreateInstance(btn).show();
      }
    }

    // Buka tab sesuai hash saat halaman dibuka
    if (window.location.hash && window.location.hash.startsWith('#tab-outlet-')) {
      activateHashTab(window.location.hash);
    }

    // Saat tab diganti, perbarui hash supaya bertahan setelah submit/refresh
    tabButtons.forEach(btn => {
      btn.addEventListener('shown.bs.tab', (e) => {
        const target = e.target.getAttribute('data-bs-target');
        if (target) {
          history.replaceState(null, '', target);
        }
      });
    });
  });
</script>
@endsection
