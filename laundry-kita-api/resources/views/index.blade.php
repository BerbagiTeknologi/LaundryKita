@extends('layouts.app')

@section('title', 'Dashboard | Laundry Kita')

@section('content')
  <div class="row">
    <div class="col-12 grid-margin stretch-card" id="dashboard-tabs">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="card-title mb-0">Dashboard</h4>
            <span class="text-muted small">Pilih ringkasan yang ingin dilihat</span>
          </div>
          <ul class="nav nav-tabs mt-3" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-keuangan-tab" data-bs-toggle="tab" data-bs-target="#tab-keuangan" type="button" role="tab" aria-controls="tab-keuangan" aria-selected="true">
                <i class="mdi mdi-cash-multiple me-2"></i>Keuangan
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-transaksi-tab" data-bs-toggle="tab" data-bs-target="#tab-transaksi" type="button" role="tab" aria-controls="tab-transaksi" aria-selected="false">
                <i class="mdi mdi-swap-horizontal me-2"></i>Transaksi
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-kepegawaian-tab" data-bs-toggle="tab" data-bs-target="#tab-kepegawaian" type="button" role="tab" aria-controls="tab-kepegawaian" aria-selected="false">
                <i class="mdi mdi-account-tie me-2"></i>Kepegawaian
              </button>
            </li>
          </ul>
          <div class="tab-content pt-3">
            <div class="tab-pane fade show active" id="tab-keuangan" role="tabpanel" aria-labelledby="tab-keuangan-tab">
              <p class="text-muted mb-3">Pantau arus kas, pendapatan, dan biaya operasional.</p>
              <div class="row">
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-9">
                          <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">Rp. 10.000</h3>
                            <p class="text-success ms-2 mb-0 font-weight-medium">+0%</p>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                          </div>
                        </div>
                      </div>
                      <h6 class="text-muted font-weight-normal">Pendapatan</h6>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-9">
                          <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">Rp. 100.000</h3>
                            <p class="text-success ms-2 mb-0 font-weight-medium">+0%</p>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="icon icon-box-success">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                          </div>
                        </div>
                      </div>
                      <h6 class="text-muted font-weight-normal">Omzet</h6>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-9">
                          <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">Rp. 20.000</h3>
                            <p class="text-danger ms-2 mb-0 font-weight-medium">-1%</p>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="icon icon-box-danger">
                            <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                          </div>
                        </div>
                      </div>
                      <h6 class="text-muted font-weight-normal">Pengeluaran</h6>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-9">
                          <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">Rp. 1.000.000</h3>
                            <p class="text-success ms-2 mb-0 font-weight-medium">+0%</p>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                          </div>
                        </div>
                      </div>
                      <h6 class="text-muted font-weight-normal">Saldo Awal</h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                          <h5 class="card-title mb-0">Tren Keuangan</h5>
                          <small class="text-muted" id="keuangan-range-label">Mingguan (12 minggu)</small>
                        </div>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Rentang tren keuangan">
                          <button type="button" class="btn btn-outline-primary" data-keuangan-range="daily">Harian</button>
                          <button type="button" class="btn btn-outline-primary active" data-keuangan-range="weekly">Mingguan</button>
                          <button type="button" class="btn btn-outline-primary" data-keuangan-range="monthly">Bulanan</button>
                          <button type="button" class="btn btn-outline-primary" data-keuangan-range="yearly">Tahunan</button>
                        </div>
                      </div>
                      <div style="height: 260px;">
                        <canvas id="keuangan-area-chart"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-transaksi" role="tabpanel" aria-labelledby="tab-transaksi-tab">
              <p class="text-muted mb-2">Ringkasan transaksi terakhir dan status pembayaran.</p>
              <div class="row">
                <div class="col-md-4 col-sm-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                      <div>
                        <p class="text-muted mb-1">Masuk Pesanan</p>
                        <h4 class="mb-0">132</h4>
                      </div>
                      <div class="icon icon-box-primary">
                        <span class="mdi mdi-cart-arrow-down icon-item"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                      <div>
                        <p class="text-muted mb-1">Belum Selesai</p>
                        <h4 class="mb-0 text-warning">24</h4>
                      </div>
                      <div class="icon icon-box-warning">
                        <span class="mdi mdi-timer-sand icon-item"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                      <div>
                        <p class="text-muted mb-1">Terlambat</p>
                        <h4 class="mb-0 text-danger">7</h4>
                      </div>
                      <div class="icon icon-box-danger">
                        <span class="mdi mdi-alert-circle-outline icon-item"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-konfirmasi-tab" data-bs-toggle="tab" data-bs-target="#tab-konfirmasi" type="button" role="tab" aria-controls="tab-konfirmasi" aria-selected="true">
                      <i class="mdi mdi-check-circle-outline me-1"></i>Konfirmasi
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-penjemputan-tab" data-bs-toggle="tab" data-bs-target="#tab-penjemputan" type="button" role="tab" aria-controls="tab-penjemputan" aria-selected="false">
                      <i class="mdi mdi-truck-delivery-outline me-1"></i>Penjemputan
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-validasi-tab" data-bs-toggle="tab" data-bs-target="#tab-validasi" type="button" role="tab" aria-controls="tab-validasi" aria-selected="false">
                      <i class="mdi mdi-clipboard-check-outline me-1"></i>Validasi
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-antrian-tab" data-bs-toggle="tab" data-bs-target="#tab-antrian" type="button" role="tab" aria-controls="tab-antrian" aria-selected="false">
                      <i class="mdi mdi-timer-outline me-1"></i>Antrian
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-proses-tab" data-bs-toggle="tab" data-bs-target="#tab-proses" type="button" role="tab" aria-controls="tab-proses" aria-selected="false">
                      <i class="mdi mdi-progress-clock me-1"></i>Proses
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-siap-ambil-tab" data-bs-toggle="tab" data-bs-target="#tab-siap-ambil" type="button" role="tab" aria-controls="tab-siap-ambil" aria-selected="false">
                      <i class="mdi mdi-package-check me-1"></i>Siap Ambil
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-siap-antar-tab" data-bs-toggle="tab" data-bs-target="#tab-siap-antar" type="button" role="tab" aria-controls="tab-siap-antar" aria-selected="false">
                      <i class="mdi mdi-home-export-outline me-1"></i>Siap Antar
                    </button>
                  </li>
                </ul>
                <div class="tab-content pt-3">
                  <div class="tab-pane fade show active" id="tab-konfirmasi" role="tabpanel" aria-labelledby="tab-konfirmasi-tab">
                    <p class="text-muted mb-1">Pesanan yang perlu dikonfirmasi.</p>
                    <p>Total: <strong>132</strong></p>
                    <div class="table-responsive">
                      <table class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Estimasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Andi</td>
                            <td>Cuci Lipat</td>
                            <td><span class="badge bg-primary">Konfirmasi</span></td>
                            <td>Hari ini</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Budi</td>
                            <td>Cuci Setrika</td>
                            <td><span class="badge bg-primary">Konfirmasi</span></td>
                            <td>Hari ini</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-penjemputan" role="tabpanel" aria-labelledby="tab-penjemputan-tab">
                    <p class="text-muted mb-1">Jadwal dan status penjemputan.</p>
                    <p>Belum diambil: <strong>18</strong></p>
                    <div class="table-responsive">
                      <table class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Jadwal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Citra</td>
                            <td>Jl. Melati 12</td>
                            <td><span class="badge bg-primary">Penjemputan</span></td>
                            <td>10:30</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Doni</td>
                            <td>Jl. Pahlawan 5</td>
                            <td><span class="badge bg-primary">Penjemputan</span></td>
                            <td>11:00</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-validasi" role="tabpanel" aria-labelledby="tab-validasi-tab">
                    <p class="text-muted mb-1">Pesanan menunggu validasi berat/item.</p>
                    <p>Perlu validasi: <strong>9</strong></p>
                    <div class="table-responsive">
                      <table class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Berat</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Eka</td>
                            <td>Cuci Lipat</td>
                            <td><span class="badge bg-primary">Validasi</span></td>
                            <td>—</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Fajar</td>
                            <td>Cuci Setrika</td>
                            <td><span class="badge bg-primary">Validasi</span></td>
                            <td>—</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-antrian" role="tabpanel" aria-labelledby="tab-antrian-tab">
                    <p class="text-muted mb-1">Pesanan dalam antrian cuci.</p>
                    <p>Antrian: <strong>24</strong></p>
                    <div class="table-responsive">
                      <table class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Estimasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Gina</td>
                            <td>Cuci Setrika</td>
                            <td><span class="badge bg-primary">Antrian</span></td>
                            <td>2 jam</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Hari</td>
                            <td>Cuci Lipat</td>
                            <td><span class="badge bg-primary">Antrian</span></td>
                            <td>3 jam</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-proses" role="tabpanel" aria-labelledby="tab-proses-tab">
                    <p class="text-muted mb-1">Pesanan sedang dicuci/dikeringkan.</p>
                    <p>Diproses: <strong>16</strong></p>
                    <div class="table-responsive">
                      <table class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Estimasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Ika</td>
                            <td>Cuci Lipat</td>
                            <td><span class="badge bg-primary">Proses</span></td>
                            <td>1.5 jam</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Joko</td>
                            <td>Cuci Setrika</td>
                            <td><span class="badge bg-primary">Proses</span></td>
                            <td>2 jam</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-siap-ambil" role="tabpanel" aria-labelledby="tab-siap-ambil-tab">
                    <p class="text-muted mb-1">Pesanan siap diambil pelanggan.</p>
                    <p>Siap ambil: <strong>11</strong></p>
                    <div class="table-responsive">
                      <table class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Kirana</td>
                            <td>Cuci Lipat</td>
                            <td><span class="badge bg-primary">Siap Ambil</span></td>
                            <td>Outlet 1</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Lutfi</td>
                            <td>Cuci Setrika</td>
                            <td><span class="badge bg-primary">Siap Ambil</span></td>
                            <td>Outlet 2</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-siap-antar" role="tabpanel" aria-labelledby="tab-siap-antar-tab">
                    <p class="text-muted mb-1">Pesanan siap diantar ke pelanggan.</p>
                    <p>Siap antar: <strong>7</strong></p>
                    <div class="table-responsive">
                      <table class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Kurir</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Maya</td>
                            <td>Jl. Kenanga 3</td>
                            <td><span class="badge bg-primary">Siap Antar</span></td>
                            <td>Rudi</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Nino</td>
                            <td>Jl. Mawar 7</td>
                            <td><span class="badge bg-primary">Siap Antar</span></td>
                            <td>Adi</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-kepegawaian" role="tabpanel" aria-labelledby="tab-kepegawaian-tab">
              <p class="text-muted mb-2">Lihat ketersediaan staf dan performa terbaru.</p>
              <div class="d-flex flex-wrap gap-4">
                <div>
                  <span class="text-muted d-block">Total pegawai</span>
                  <h5 class="mb-0">42</h5>
                </div>
                <div>
                  <span class="text-muted d-block">Shift aktif</span>
                  <h5 class="mb-0 text-info">18</h5>
                </div>
                <div>
                  <span class="text-muted d-block">Kinerja rata-rata</span>
                  <h5 class="mb-0 text-success">4.6/5</h5>
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
    const canvas = document.getElementById('keuangan-area-chart');
    if (!canvas || typeof Chart === 'undefined') {
      return;
    }

    const ctx = canvas.getContext('2d');
    const canvasHeight = canvas.clientHeight || canvas.height || 260;
    const makeGradient = (color) => {
      const g = ctx.createLinearGradient(0, 0, 0, canvasHeight);
      g.addColorStop(0, color);
      g.addColorStop(1, 'rgba(0, 0, 0, 0)');
      return g;
    };

    const gradients = {
      pendapatan: makeGradient('rgba(76, 175, 80, 0.35)'),
      pengeluaran: makeGradient('rgba(239, 83, 80, 0.35)'),
      laba: makeGradient('rgba(66, 165, 245, 0.35)'),
      saldo: makeGradient('rgba(171, 71, 188, 0.35)')
    };

    const ranges = {
      daily: {
        title: 'Harian (30 hari)',
        labels: Array.from({ length: 30 }, (_, i) => `H${i + 1}`),
        pendapatan: [4, 5, 6, 7, 6, 8, 7, 9, 11, 10, 9, 8, 10, 12, 11, 13, 12, 14, 15, 13, 14, 16, 15, 17, 16, 18, 19, 18, 19, 20],
        pengeluaran: [2, 3, 3, 4, 3, 5, 4, 5, 6, 5, 5, 4, 5, 6, 6, 7, 6, 8, 8, 7, 7, 8, 7, 9, 8, 9, 9, 9, 10, 10],
        laba: [2, 2, 3, 3, 3, 3, 3, 4, 5, 5, 4, 4, 5, 6, 5, 6, 6, 6, 7, 6, 7, 8, 8, 8, 8, 9, 10, 9, 9, 10],
        saldo: [10, 12, 13, 15, 15, 18, 18, 21, 24, 25, 25, 25, 28, 31, 32, 35, 37, 39, 42, 43, 45, 48, 49, 52, 54, 57, 59, 61, 64, 66]
      },
      weekly: {
        title: 'Mingguan (12 minggu)',
        labels: ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7', 'W8', 'W9', 'W10', 'W11', 'W12'],
        pendapatan: [12, 14, 13, 16, 18, 17, 19, 21, 20, 22, 24, 25],
        pengeluaran: [7, 8, 7, 9, 10, 9, 10, 11, 11, 12, 13, 13],
        laba: [5, 6, 6, 7, 8, 8, 9, 10, 9, 10, 11, 12],
        saldo: [60, 64, 68, 75, 83, 91, 100, 111, 121, 133, 145, 158]
      },
      monthly: {
        title: 'Bulanan (12 bulan)',
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        pendapatan: [42, 45, 44, 48, 51, 55, 58, 57, 60, 63, 65, 68],
        pengeluaran: [25, 27, 26, 28, 30, 32, 34, 33, 35, 37, 38, 39],
        laba: [17, 18, 18, 20, 21, 23, 24, 24, 25, 26, 27, 29],
        saldo: [200, 220, 238, 260, 281, 304, 328, 348, 371, 395, 418, 447]
      },
      yearly: {
        title: 'Tahunan (5 tahun)',
        labels: ['2020', '2021', '2022', '2023', '2024'],
        pendapatan: [280, 320, 365, 410, 455],
        pengeluaran: [180, 195, 220, 245, 270],
        laba: [100, 125, 145, 165, 185],
        saldo: [480, 605, 750, 905, 1075]
      }
    };

    let activeRange = 'weekly';
    const rangeLabel = document.getElementById('keuangan-range-label');
    const buttons = document.querySelectorAll('[data-keuangan-range]');

    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ranges[activeRange].labels,
        datasets: [
          {
            label: 'Pendapatan',
            data: ranges[activeRange].pendapatan,
            borderColor: '#4caf50',
            backgroundColor: gradients.pendapatan,
            borderWidth: 2,
            fill: true,
            tension: 0.35,
            pointRadius: 0
          },
          {
            label: 'Pengeluaran',
            data: ranges[activeRange].pengeluaran,
            borderColor: '#ef5350',
            backgroundColor: gradients.pengeluaran,
            borderWidth: 2,
            fill: true,
            tension: 0.35,
            pointRadius: 0
          },
          {
            label: 'Laba',
            data: ranges[activeRange].laba,
            borderColor: '#42a5f5',
            backgroundColor: gradients.laba,
            borderWidth: 2,
            fill: true,
            tension: 0.35,
            pointRadius: 0
          },
          {
            label: 'Saldo',
            data: ranges[activeRange].saldo,
            borderColor: '#ab47bc',
            backgroundColor: gradients.saldo,
            borderWidth: 2,
            fill: true,
            tension: 0.35,
            pointRadius: 0
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
          legend: { display: true },
          tooltip: { intersect: false, mode: 'index' }
        },
        scales: {
          x: { grid: { display: false } },
          y: { grid: { color: 'rgba(0, 0, 0, 0.05)' } }
        }
      }
    });

    function setActiveRange(rangeKey) {
      if (!ranges[rangeKey] || rangeKey === activeRange) return;
      activeRange = rangeKey;
      const { labels, pendapatan, pengeluaran, laba, saldo, title } = ranges[rangeKey];
      chart.data.labels = labels;
      chart.data.datasets[0].data = pendapatan;
      chart.data.datasets[1].data = pengeluaran;
      chart.data.datasets[2].data = laba;
      chart.data.datasets[3].data = saldo;
      rangeLabel.textContent = title;
      chart.update();
    }

    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        buttons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        setActiveRange(btn.getAttribute('data-keuangan-range'));
      });
    });

    const transaksiTabTrigger = document.getElementById('tab-transaksi-tab');
    const dashboardTabsSection = document.getElementById('dashboard-tabs');
    const jumpers = document.querySelectorAll('[data-jump-transaksi]');

    function activateTransaksiTab(scroll = true) {
      if (transaksiTabTrigger && window.bootstrap && window.bootstrap.Tab) {
        const tab = new bootstrap.Tab(transaksiTabTrigger);
        tab.show();
      }
      if (scroll && dashboardTabsSection) {
        dashboardTabsSection.scrollIntoView({ behavior: 'smooth' });
      }
    }

    jumpers.forEach(j => {
      j.addEventListener('click', (e) => {
        e.preventDefault();
        activateTransaksiTab(true);
        history.replaceState(null, '', '#transaksi');
      });
    });

    const keuanganTabTrigger = document.getElementById('tab-keuangan-tab');
    const keuanganJumpers = document.querySelectorAll('[data-jump-keuangan]');

    function activateKeuanganTab(scroll = true) {
      if (keuanganTabTrigger && window.bootstrap && window.bootstrap.Tab) {
        const tab = new bootstrap.Tab(keuanganTabTrigger);
        tab.show();
      }
      if (scroll && dashboardTabsSection) {
        dashboardTabsSection.scrollIntoView({ behavior: 'smooth' });
      }
    }

    keuanganJumpers.forEach(j => {
      j.addEventListener('click', (e) => {
        e.preventDefault();
        activateKeuanganTab(true);
        history.replaceState(null, '', '#keuangan');
      });
    });

    if (window.location.hash === '#transaksi') {
      activateTransaksiTab(false);
    }
    if (window.location.hash === '#keuangan') {
      activateKeuanganTab(false);
    }
  });
</script>
@endsection
