@extends('layouts.app')
@section('title', 'Kelola Layanan | Laundry Kita')

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card" id="service-tabs">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
          <h4 class="card-title mb-0">Kelola Layanan</h4>
          <span class="text-muted small">Atur layanan reguler, paket, add-on, promo, kategori, dan stok</span>
        </div>

        <ul class="nav nav-tabs mt-3" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-services-regular-tab" data-bs-toggle="tab" data-bs-target="#tab-services-regular" type="button" role="tab">
              <i class="mdi mdi-washing-machine me-2"></i>Layanan Reguler
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-services-package-tab" data-bs-toggle="tab" data-bs-target="#tab-services-package" type="button" role="tab">
              <i class="mdi mdi-package-variant-closed me-2"></i>Layanan Paket
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-services-addon-tab" data-bs-toggle="tab" data-bs-target="#tab-services-addon" type="button" role="tab">
              <i class="mdi mdi-spray me-2"></i>Parfum & Add-on
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-services-promo-tab" data-bs-toggle="tab" data-bs-target="#tab-services-promo" type="button" role="tab">
              <i class="mdi mdi-sale me-2"></i>Promo
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-services-category-tab" data-bs-toggle="tab" data-bs-target="#tab-services-category" type="button" role="tab">
              <i class="mdi mdi-format-list-bulleted me-2"></i>Kategori & Satuan
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-services-product-tab" data-bs-toggle="tab" data-bs-target="#tab-services-product" type="button" role="tab">
              <i class="mdi mdi-clipboard-list-outline me-2"></i>Daftar Produk
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-services-purchase-tab" data-bs-toggle="tab" data-bs-target="#tab-services-purchase" type="button" role="tab">
              <i class="mdi mdi-cart-plus me-2"></i>Pembelian Produk
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-services-opname-tab" data-bs-toggle="tab" data-bs-target="#tab-services-opname" type="button" role="tab">
              <i class="mdi mdi-warehouse me-2"></i>Stok Opname
            </button>
          </li>
        </ul>

        <div class="tab-content pt-3">
          {{-- Layanan Reguler --}}
          <div class="tab-pane fade show active" id="tab-services-regular" role="tabpanel">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <div>
                    <h5 class="mb-0">Tambah Layanan Reguler</h5>
                    <small class="text-muted">Kelompokkan layanan (contoh: Kiloan, Kiloan tanpa Setrika)</small>
                  </div>
                </div>
                <form method="POST" action="{{ route('services.regular.store') }}">
                  @csrf
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label mb-1">Pilih Grup</label>
                      <select name="group_name" class="form-select">
                        <option value="">-- Pilih grup yang ada --</option>
                        @foreach ($regularGroups as $group)
                          <option value="{{ $group }}" {{ old('group_name') === $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                      </select>
                      <small class="text-muted">Atau buat grup baru</small>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Grup Baru</label>
                      <input type="text" name="new_group" class="form-control" placeholder="Contoh: Kiloan tanpa Setrika" value="{{ old('new_group') }}">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Nama Layanan</label>
                      <input type="text" name="name" class="form-control" placeholder="Cuci Kiloan" value="{{ old('name') }}" required>
                    </div>
                  </div>
                  <div class="row g-3 mt-2">
                    <div class="col-md-6 col-lg-4">
                      <label class="form-label mb-1">Harga per Kg</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price_per_kg" class="form-control" min="0" step="500" value="{{ old('price_per_kg') }}" required>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <label class="form-label mb-1">Waktu Proses per Kg (jam)</label>
                      <input type="number" name="process_hours" class="form-control" min="1" max="168" step="1" placeholder="Contoh: 3" value="{{ old('process_hours') }}" required>
                    </div>
                  </div>
                  @error('group_name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('price_per_kg')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('process_hours')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan Layanan</button>
                  </div>
                </form>
              </div>
            </div>

            @if ($regularServices->isEmpty())
              <div class="alert alert-info mb-0">Belum ada layanan reguler. Tambahkan dari formulir di atas.</div>
            @else
              @foreach ($regularServices as $group => $services)
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                      <div>
                        <h6 class="mb-0">{{ $group }}</h6>
                        <small class="text-muted">Layanan dalam grup ini</small>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped align-middle mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nama Layanan</th>
                            <th>Harga/kg</th>
                            <th>Waktu Proses</th>
                            <th style="width: 160px;">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($services as $index => $service)
                            @php
                              $minutes = (int) $service->process_minutes;
                              $hoursTotal = intdiv($minutes, 60);
                              $days = intdiv($hoursTotal, 24);
                              $remHours = $hoursTotal % 24;
                              if ($days > 0) {
                                $duration = $days . ' hari' . ($remHours > 0 ? ' ' . $remHours . ' jam' : '');
                              } else {
                                $duration = $hoursTotal . ' jam';
                              }
                            @endphp
                            <tr>
                              <td>{{ $index + 1 }}</td>
                              <td>{{ $service->name }}</td>
                              <td>Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}</td>
                              <td>{{ $duration }}</td>
                              <td>
                                <div class="d-flex flex-wrap gap-2">
                                  <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-service-{{ $service->id }}" aria-expanded="false">
                                    <i class="mdi mdi-pencil"></i>
                                  </button>
                                  <form method="POST" action="{{ route('services.regular.delete', $service->id) }}" onsubmit="return confirm('Hapus layanan ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                      <i class="mdi mdi-delete"></i>
                                    </button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                            <tr class="collapse" id="edit-service-{{ $service->id }}">
                              <td colspan="5">
                                <form method="POST" action="{{ route('services.regular.update', $service->id) }}">
                                  @csrf
                                  <div class="row g-2">
                                    <div class="col-lg-3 col-md-6">
                                      <label class="form-label mb-1">Grup</label>
                                      <input type="text" name="group_name" class="form-control" value="{{ $service->group_name }}" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                      <label class="form-label mb-1">Nama Layanan</label>
                                      <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                      <label class="form-label mb-1">Harga per Kg</label>
                                      <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="price_per_kg" class="form-control" value="{{ $service->price_per_kg }}" min="0" step="500" required>
                                      </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                      <label class="form-label mb-1">Waktu Proses (jam)</label>
                                      <input type="number" name="process_hours" class="form-control" value="{{ ceil($service->process_minutes / 60) }}" min="1" max="168" step="1" required>
                                    </div>
                                  </div>
                                  <div class="text-end mt-2">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan</button>
                                  </div>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </div>

          {{-- Layanan Paket --}}
          <div class="tab-pane fade" id="tab-services-package" role="tabpanel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <div>
                <h5 class="mb-0">Paket Langganan</h5>
                <small class="text-muted">Berikan kuota dan masa berlaku</small>
              </div>
              <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah Paket</button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama Paket</th>
                    <th>Harga</th>
                    <th>Kuota</th>
                    <th>Masa Berlaku</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($packageServices as $index => $package)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $package['name'] }}</td>
                      <td>Rp {{ number_format($package['price'], 0, ',', '.') }}</td>
                      <td>{{ $package['quota'] }}</td>
                      <td>{{ $package['expires'] }}</td>
                      <td>
                        @if ($package['status'] === 'Aktif')
                          <span class="badge bg-success">Aktif</span>
                        @else
                          <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          {{-- Parfum dan Add-on --}}
          <div class="tab-pane fade" id="tab-services-addon" role="tabpanel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <div>
                <h5 class="mb-0">Parfum dan Add-on</h5>
                <small class="text-muted">Tambahan layanan untuk meningkatkan nilai order</small>
              </div>
              <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah Add-on</button>
            </div>
            <div class="table-responsive">
              <table class="table table-striped align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Satuan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($addons as $index => $addon)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $addon['name'] }}</td>
                      <td>Rp {{ number_format($addon['price'], 0, ',', '.') }}</td>
                      <td>{{ ucfirst($addon['unit']) }}</td>
                      <td>
                        @if ($addon['status'] === 'Aktif')
                          <span class="badge bg-success">Aktif</span>
                        @else
                          <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          {{-- Promo --}}
          <div class="tab-pane fade" id="tab-services-promo" role="tabpanel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <div>
                <h5 class="mb-0">Promo dan Diskon</h5>
                <small class="text-muted">Buat kode promo, periode, dan syarat</small>
              </div>
              <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Buat Promo</button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama Promo</th>
                    <th>Jenis</th>
                    <th>Nilai</th>
                    <th>Periode</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($promos as $index => $promo)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $promo['name'] }}</td>
                      <td>{{ $promo['type'] }}</td>
                      <td>{{ $promo['value'] }}</td>
                      <td>{{ $promo['period'] }}</td>
                      <td>
                        @if ($promo['status'] === 'Aktif')
                          <span class="badge bg-success">Aktif</span>
                        @else
                          <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          {{-- Kategori dan Satuan --}}
          <div class="tab-pane fade" id="tab-services-category" role="tabpanel">
            <div class="row g-3">
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                      <h5 class="mb-0">Kategori Item</h5>
                      <button type="button" class="btn btn-outline-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah Kategori</button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped align-middle mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Satuan Utama</th>
                            <th>Jumlah Item</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($categories as $index => $category)
                            <tr>
                              <td>{{ $index + 1 }}</td>
                              <td>{{ $category['name'] }}</td>
                              <td>{{ $category['unit'] }}</td>
                              <td>{{ $category['items'] }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title mb-2">Satuan Pengukuran</h5>
                    <p class="text-muted mb-2">Gunakan satuan ini untuk kategori atau produk baru.</p>
                    <div class="d-flex flex-wrap gap-2">
                      <span class="badge bg-primary">Kg</span>
                      <span class="badge bg-primary">Pasang</span>
                      <span class="badge bg-primary">Buah</span>
                      <span class="badge bg-primary">Lembar</span>
                      <span class="badge bg-primary">L</span>
                      <span class="badge bg-primary">Botol</span>
                    </div>
                    <div class="mt-3">
                      <label class="form-label mb-1">Tambah satuan</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Contoh: Paket, Koli, Box">
                        <button class="btn btn-outline-primary" type="button">Simpan</button>
                      </div>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">Pastikan satuan konsisten agar laporan stok rapi.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Daftar Produk --}}
          <div class="tab-pane fade" id="tab-services-product" role="tabpanel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <div>
                <h5 class="mb-0">Daftar Produk</h5>
                <small class="text-muted">Pantau stok bahan, perlengkapan, dan titik restock</small>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm"><i class="mdi mdi-upload"></i> Unggah Produk</button>
                <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah Produk</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Reorder Point</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($products as $index => $product)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $product['sku'] }}</td>
                      <td>{{ $product['name'] }}</td>
                      <td>{{ $product['stock'] }}</td>
                      <td>{{ $product['uom'] }}</td>
                      <td>{{ $product['reorder'] }}</td>
                      <td>
                        @if ($product['status'] === 'Aman')
                          <span class="badge bg-success">Aman</span>
                        @elseif ($product['status'] === 'Perlu Restock')
                          <span class="badge bg-warning text-dark">Perlu Restock</span>
                        @else
                          <span class="badge bg-secondary">{{ $product['status'] }}</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          {{-- Pembelian Produk --}}
          <div class="tab-pane fade" id="tab-services-purchase" role="tabpanel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <div>
                <h5 class="mb-0">Pembelian Produk</h5>
                <small class="text-muted">Catat pembelian bahan & perlengkapan ke pemasok</small>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-upload"></i> Impor PO</button>
                <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Buat Pembelian</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Pemasok</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Biaya</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($productPurchases as $index => $purchase)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $purchase['vendor'] }}</td>
                      <td>{{ $purchase['product'] }}</td>
                      <td>{{ $purchase['qty'] }} {{ $purchase['uom'] }}</td>
                      <td>Rp {{ number_format($purchase['cost'], 0, ',', '.') }}</td>
                      <td>{{ $purchase['date'] }}</td>
                      <td>
                        @if ($purchase['status'] === 'Selesai')
                          <span class="badge bg-success">Selesai</span>
                        @elseif ($purchase['status'] === 'Menunggu')
                          <span class="badge bg-warning text-dark">Menunggu</span>
                        @else
                          <span class="badge bg-secondary">{{ $purchase['status'] }}</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          {{-- Stok Opname --}}
          <div class="tab-pane fade" id="tab-services-opname" role="tabpanel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <div>
                <h5 class="mb-0">Stok Opname</h5>
                <small class="text-muted">Validasi stok fisik vs sistem</small>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-upload"></i> Impor Opname</button>
                <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Buat Opname</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Stok Sistem</th>
                    <th>Stok Fisik</th>
                    <th>Selisih</th>
                    <th>Catatan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($stockOpnames as $index => $opname)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $opname['date'] }}</td>
                      <td>{{ $opname['product'] }}</td>
                      <td>{{ $opname['system'] }}</td>
                      <td>{{ $opname['actual'] }}</td>
                      <td>{{ $opname['diff'] }}</td>
                      <td>{{ $opname['note'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
    const tabButtons = document.querySelectorAll('#service-tabs [data-bs-toggle="tab"]');

    function activateHashTab(hash) {
      if (!hash) return;
      const btn = document.querySelector(`#service-tabs [data-bs-target="${hash}"]`);
      if (btn && window.bootstrap && window.bootstrap.Tab) {
        window.bootstrap.Tab.getOrCreateInstance(btn).show();
      }
    }

    if (window.location.hash && window.location.hash.startsWith('#tab-services-')) {
      activateHashTab(window.location.hash);
    }

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
