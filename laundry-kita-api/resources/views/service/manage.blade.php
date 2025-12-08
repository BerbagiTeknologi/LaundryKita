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
              <i class="mdi mdi-spray me-2"></i>Tambahan
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
                      <input type="text" name="name" class="form-control" placeholder="Contoh: Cuci Kiloan" value="{{ old('name') }}" required>
                    </div>
                  </div>
                  <div class="row g-3 mt-2">
                    <div class="col-md-6 col-lg-4">
                      <label class="form-label mb-1 text-success">Harga per Kg</label>
                      <div class="input-group">
                        <span class="input-group-text bg-success text-white">Rp</span>
                        <input type="text" name="price_per_kg" class="form-control" inputmode="numeric" data-rupiah value="{{ old('price_per_kg') ? number_format(old('price_per_kg'), 0, ',', '.') : '' }}" required>
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
                @php
                  $groupId = \Illuminate\Support\Str::slug($group, '-') ?: 'group-' . $loop->index;
                @endphp
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                      <div>
                        <h6 class="mb-0">{{ $group }}</h6>
                        <small class="text-muted">Layanan dalam grup ini</small>
                      </div>
                      <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#edit-group-{{ $groupId }}">
                          <i class="mdi mdi-pencil"></i> Edit Grup
                        </button>
                        <form method="POST" action="{{ route('services.regular.group.delete', $group) }}" onsubmit="return confirm('Hapus grup ini beserta semua layanan di dalamnya?');">
                          @csrf
                          <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="mdi mdi-delete"></i> Hapus Grup
                          </button>
                        </form>
                      </div>
                    </div>
                    <div class="collapse mb-3" id="edit-group-{{ $groupId }}">
                      <form method="POST" action="{{ route('services.regular.group.rename', $group) }}">
                        @csrf
                        <div class="row g-2 align-items-end">
                          <div class="col-md-8 col-lg-9">
                            <label class="form-label mb-1">Nama Grup</label>
                            <input type="text" name="new_group_name" class="form-control" value="{{ $group }}" required>
                          </div>
                          <div class="col-md-4 col-lg-3 text-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100"><i class="mdi mdi-content-save"></i> Simpan Grup</button>
                          </div>
                        </div>
                      </form>
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
                                        <input type="text" name="price_per_kg" class="form-control" inputmode="numeric" data-rupiah value="{{ number_format($service->price_per_kg, 0, ',', '.') }}" required>
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
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <div>
                    <h5 class="mb-0">Tambah Paket Layanan</h5>
                    <small class="text-muted">Pilih grup layanan reguler, kuota, dan masa berlaku opsional</small>
                  </div>
                </div>
                <form method="POST" action="{{ route('services.package.store') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label mb-1">Nama Paket</label>
                      <input type="text" name="name" class="form-control" placeholder="Contoh: Paket Hemat 30 Kg" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Grup Layanan Reguler</label>
                      <select name="regular_group_name" class="form-select" required>
                        <option value="">-- Pilih grup --</option>
                        @foreach ($regularGroups as $group)
                          <option value="{{ $group }}" {{ old('regular_group_name') === $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Upload Gambar Paket</label>
                      <input type="file" name="image" class="form-control" accept="image/*">
                      <small class="text-muted">Format: JPG, JPEG, PNG. Ukuran maksimal 2MB.</small>
                    </div>
                  </div>
                  <div class="row g-3 mt-2">
                    <div class="col-md-4">
                      <label class="form-label mb-1 text-success">Harga Paket</label>
                      <div class="input-group">
                        <span class="input-group-text bg-success text-white">Rp</span>
                        <input type="text" name="price" class="form-control" inputmode="numeric" data-rupiah value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : '' }}" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Kuota yang Didapat</label>
                      <div class="input-group">
                        <input type="number" name="quota_value" class="form-control" min="1" step="1" placeholder="Contoh: 30" value="{{ old('quota_value') }}" required>
                        <select name="quota_unit_id" class="form-select" required>
                          <option value="">Satuan</option>
                          @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('quota_unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Waktu Pengerjaan (jam)</label>
                      <input type="number" name="work_hours" class="form-control" min="1" max="168" step="1" value="{{ old('work_hours') }}" required>
                    </div>
                  </div>
                  <div class="row g-3 mt-2 align-items-center">
                    <div class="col-md-4">
                      <label class="form-label mb-1 d-block">Status Masa Berlaku</label>
                      <div class="form-check mb-0">
                        <input type="hidden" name="has_expiry" value="0">
                        <input class="form-check-input" type="checkbox" id="has-expiry" name="has_expiry" value="1" {{ old('has_expiry') ? 'checked' : '' }}>
                        <label class="form-check-label" for="has-expiry">Pakai masa berlaku</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Masa berlaku (hari)</label>
                      <input type="number" name="expires_in_days" class="form-control" min="1" max="365" value="{{ old('expires_in_days') }}">
                    </div>
                  </div>
                  @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('regular_group_name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('image')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('price')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('quota_value')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('quota_unit_id')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('work_hours')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('expires_in_days')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan Paket</button>
                  </div>
                </form>
              </div>
            </div>

            @if ($packageServices->isEmpty())
              <div class="alert alert-info mb-0">Belum ada paket layanan. Tambahkan dari formulir di atas.</div>
            @else
              <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Paket</th>
                      <th>Grup Layanan</th>
                      <th>Harga</th>
                      <th>Kuota</th>
                      <th>Waktu</th>
                      <th>Masa Berlaku</th>
                      <th style="width: 170px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($packageServices as $index => $package)
                      @php
                        $packageHours = (int) $package->work_hours;
                        $packageDays = intdiv($packageHours, 24);
                        $packageRemHours = $packageHours % 24;
                        $packageDuration = $packageDays > 0 ? $packageDays . ' hari' . ($packageRemHours > 0 ? ' ' . $packageRemHours . ' jam' : '') : $packageHours . ' jam';
                        $packageUnitName = $units->firstWhere('id', $package->quota_unit_id)->name ?? null;
                        $packageQuotaLabel = ($package->quota_value && $packageUnitName)
                          ? ($package->quota_value . ' ' . $packageUnitName)
                          : ($package->quota ?? '-');
                      @endphp
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="d-flex align-items-center gap-2">
                          @if ($package->image_path)
                            <img src="{{ Storage::disk('public')->url($package->image_path) }}" alt="img" style="width: 38px; height: 38px; object-fit: cover;" class="rounded">
                          @endif
                          <span>{{ $package->name }}</span>
                        </td>
                        <td>{{ $package->regular_group_name }}</td>
                        <td>Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                        <td>{{ $packageQuotaLabel }}</td>
                        <td>{{ $packageDuration }}</td>
                        <td>
                          @if ($package->has_expiry)
                            {{ $package->expires_in_days ? $package->expires_in_days . ' hari' : 'Pakai masa berlaku' }}
                          @else
                            Tidak ada
                          @endif
                        </td>
                        <td>
                          <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-package-{{ $package->id }}">
                              <i class="mdi mdi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('services.package.delete', $package->id) }}" onsubmit="return confirm('Hapus paket ini?');">
                              @csrf
                              <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="mdi mdi-delete"></i>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                      <tr class="collapse" id="edit-package-{{ $package->id }}">
                        <td colspan="8">
                          <form method="POST" action="{{ route('services.package.update', $package->id) }}" enctype="multipart/form-data">
                            @csrf
                            @php
                              $editUnitName = $units->firstWhere('id', $package->quota_unit_id)->name ?? null;
                              $editQuotaValue = $package->quota_value ?? (int) preg_replace('/\D+/', '', (string) $package->quota);
                              $editQuotaUnitId = $package->quota_unit_id;
                            @endphp
                            <div class="row g-2">
                              <div class="col-md-4">
                                <label class="form-label mb-1">Nama Paket</label>
                                <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
                              </div>
                              <div class="col-md-4">
                                <label class="form-label mb-1">Grup Layanan Reguler</label>
                                <select name="regular_group_name" class="form-select" required>
                                  @foreach ($regularGroups as $group)
                                    <option value="{{ $group }}" {{ $package->regular_group_name === $group ? 'selected' : '' }}>{{ $group }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-md-4">
                                <label class="form-label mb-1">Gambar Paket (opsional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                              </div>
                            </div>
                            <div class="row g-2 mt-2">
                              <div class="col-md-3">
                                <label class="form-label mb-1">Harga Paket</label>
                                <div class="input-group">
                                  <span class="input-group-text">Rp</span>
                                  <input type="text" name="price" class="form-control" inputmode="numeric" data-rupiah value="{{ number_format($package->price, 0, ',', '.') }}" required>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Kuota</label>
                                <div class="input-group">
                                  <input type="number" name="quota_value" class="form-control" min="1" step="1" value="{{ $editQuotaValue }}" required>
                                  <select name="quota_unit_id" class="form-select" required>
                                    @foreach ($units as $unit)
                                      <option value="{{ $unit->id }}" {{ $editQuotaUnitId === $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Waktu Pengerjaan (jam)</label>
                                <input type="number" name="work_hours" class="form-control" min="1" max="168" step="1" value="{{ $package->work_hours }}" required>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1 d-block">Status Masa Berlaku</label>
                                <div class="form-check mb-0">
                                  <input type="hidden" name="has_expiry" value="0">
                                  <input class="form-check-input" type="checkbox" name="has_expiry" id="has-expiry-{{ $package->id }}" value="1" {{ $package->has_expiry ? 'checked' : '' }}>
                                  <label class="form-check-label" for="has-expiry-{{ $package->id }}">Pakai masa berlaku</label>
                                </div>
                              </div>
                            </div>
                            <div class="row g-2 mt-2">
                              <div class="col-md-3">
                                <label class="form-label mb-1">Masa berlaku (hari)</label>
                                <input type="number" name="expires_in_days" class="form-control" min="1" max="365" value="{{ $package->expires_in_days }}">
                              </div>
                            </div>
                            <div class="text-end mt-3">
                              <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan Paket</button>
                            </div>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

          {{-- Parfum dan Add-on --}}
          <div class="tab-pane fade" id="tab-services-addon" role="tabpanel">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <div>
                    <h5 class="mb-0">Tambahan</h5>
                    <small class="text-muted">Tambahan parfum/add-on untuk melengkapi layanan</small>
                  </div>
                </div>
                <form method="POST" action="{{ route('services.addon.store') }}">
                  @csrf
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label mb-1">Nama Produk</label>
                      <input type="text" name="name" class="form-control" placeholder="Contoh: Parfum Premium" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Jenis Produk</label>
                      <div class="input-group">
                        <select name="type" class="form-select" data-addon-type-select required>
                          <option value="">-- Pilih jenis --</option>
                          @foreach ($addonTypes as $type)
                            <option value="{{ $type->name }}" {{ old('type') === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                          @endforeach
                          @if ($addonTypes->isEmpty())
                            <option value="Tidak dikategorikan" {{ old('type') === 'Tidak dikategorikan' ? 'selected' : '' }}>Tidak dikategorikan</option>
                          @endif
                        </select>
                        <button class="btn btn-outline-secondary bg-primary" type="button" data-open-type-modal data-mode="add" data-action="{{ route('services.addon.type.store') }}" title="Tambah jenis produk baru">
                          <i class="mdi mdi-plus"></i>
                        </button>
                        <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split bg-info" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 220px;">
                          @forelse ($addonTypes as $type)
                            <li class="px-3 py-2 d-flex align-items-center justify-content-between gap-2">
                              <span class="small text-muted">{{ $type->name }}</span>
                              <div class="d-flex gap-2 align-items-center">
                                <button type="button" class="btn btn-link text-primary p-0" data-open-type-modal data-mode="edit" data-action="{{ route('services.addon.type.update', $type->id) }}" data-name="{{ $type->name }}">Edit</button>
                                <button type="button" class="btn btn-link text-danger p-0" data-open-type-delete data-action="{{ route('services.addon.type.delete', $type->id) }}" data-name="{{ $type->name }}">Hapus</button>
                              </div>
                            </li>
                          @empty
                            <li class="px-3 py-2"><span class="small text-muted">Belum ada jenis.</span></li>
                          @endforelse
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Harga</label>
                      <div class="input-group">
                        <span class="input-group-text bg-success text-white">Rp</span>
                        <input type="text" name="price" class="form-control text-success" inputmode="numeric" data-rupiah value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : '' }}" required>
                      </div>
                    </div>
                  </div>
                  <div class="row g-3 mt-2">
                    <div class="col-md-4">
                      <label class="form-label mb-1 d-block">Status</label>
                      <div class="form-check mb-0">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="addon-active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="addon-active">Aktif</label>
                      </div>
                    </div>
                  </div>
                  @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('type')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('price')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan Add-on</button>
                  </div>
                </form>
              </div>
            </div>

            @if ($addons->isEmpty())
              <div class="alert alert-info mb-0">Belum ada parfum/add-on. Tambahkan dari formulir di atas.</div>
            @else
              <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                      <th style="width: 140px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($addons as $index => $addon)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $addon->name }}</td>
                        <td>{{ ucfirst($addon->type) }}</td>
                        <td>Rp {{ number_format($addon->price, 0, ',', '.') }}</td>
                        <td>
                          @if ($addon->is_active)
                            <span class="badge bg-success">Aktif</span>
                          @else
                            <span class="badge bg-danger">Nonaktif</span>
                          @endif
                        </td>
                        <td>
                          <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-addon-{{ $addon->id }}"><i class="mdi mdi-pencil"></i></button>
                            <form method="POST" action="{{ route('services.addon.delete', $addon->id) }}" onsubmit="return confirm('Hapus add-on ini?');">
                              @csrf
                              <button type="submit" class="btn btn-outline-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                            </form>
                          </div>
                        </td>
                      </tr>
                      <tr class="collapse" id="edit-addon-{{ $addon->id }}">
                        <td colspan="6">
                          <form method="POST" action="{{ route('services.addon.update', $addon->id) }}">
                            @csrf
                            <div class="row g-2 align-items-end">
                              <div class="col-md-4">
                                <label class="form-label mb-1">Nama Produk</label>
                                <input type="text" name="name" class="form-control" value="{{ $addon->name }}" required>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Jenis Produk</label>
                                <div class="input-group">
                                  <select name="type" class="form-select" data-addon-type-select required>
                                    @foreach ($addonTypes as $type)
                                      <option value="{{ $type->name }}" {{ $addon->type === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                    @if ($addonTypes->where('name', $addon->type)->isEmpty())
                                      <option value="{{ $addon->type }}" selected>{{ $addon->type }}</option>
                                    @endif
                                  </select>
                                  <button class="btn btn-outline-secondary" type="button" data-open-type-modal data-mode="add" data-action="{{ route('services.addon.type.store') }}">
                                    <i class="mdi mdi-plus"></i>
                                  </button>
                                  <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-end" style="min-width: 220px;">
                                    @forelse ($addonTypes as $type)
                                      <li class="px-3 py-2 d-flex align-items-center justify-content-between gap-2">
                                        <span class="small text-muted">{{ $type->name }}</span>
                                        <div class="d-flex gap-2 align-items-center">
                                          <button type="button" class="btn btn-link text-primary p-0" data-open-type-modal data-mode="edit" data-action="{{ route('services.addon.type.update', $type->id) }}" data-name="{{ $type->name }}">Edit</button>
                                          <button type="button" class="btn btn-link text-danger p-0" data-open-type-delete data-action="{{ route('services.addon.type.delete', $type->id) }}" data-name="{{ $type->name }}">Hapus</button>
                                        </div>
                                      </li>
                                    @empty
                                      <li class="px-3 py-2"><span class="small text-muted">Belum ada jenis.</span></li>
                                    @endforelse
                                  </ul>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Harga</label>
                                <div class="input-group">
                                  <span class="input-group-text">Rp</span>
                                  <input type="text" name="price" class="form-control" inputmode="numeric" data-rupiah value="{{ number_format($addon->price, 0, ',', '.') }}" required>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1 d-block">Status</label>
                                <div class="form-check mb-0">
                                  <input type="hidden" name="is_active" value="0">
                                  <input class="form-check-input" type="checkbox" name="is_active" id="addon-active-{{ $addon->id }}" value="1" {{ $addon->is_active ? 'checked' : '' }}>
                                  <label class="form-check-label" for="addon-active-{{ $addon->id }}">Aktif</label>
                                </div>
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
            @endif
          </div>

          {{-- Promo --}}
          <div class="tab-pane fade" id="tab-services-promo" role="tabpanel">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <div>
                    <h5 class="mb-0">Promo & Diskon</h5>
                    <small class="text-muted">Buat promo berdasarkan nominal, persen, atau gratis ongkir</small>
                  </div>
                </div>
                <form method="POST" action="{{ route('services.promo.store') }}">
                  @csrf
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label mb-1">Nama Promo</label>
                      <input type="text" name="name" class="form-control" placeholder="Diskon 10% Senin-Kamis" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Jenis Promo</label>
                      <select name="type" class="form-select" required>
                        <option value="">-- Pilih jenis --</option>
                        <option value="percent" {{ old('type') === 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="amount" {{ old('type') === 'amount' ? 'selected' : '' }}>Nominal (Rp)</option>
                        <option value="free_shipping" {{ old('type') === 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label mb-1">Nilai Promo</label>
                      <input type="number" name="value" class="form-control" min="0" step="1" value="{{ old('value') }}" placeholder="Isi jika persen/nominal">
                    </div>
                  </div>
                  <div class="row g-3 mt-2">
                    <div class="col-md-6">
                      <label class="form-label mb-1">Periode</label>
                      <input type="date" name="period" class="form-control" value="{{ old('period') }}">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label mb-1 d-block">Status</label>
                      <div class="form-check mb-0">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="promo-active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="promo-active">Aktif</label>
                      </div>
                    </div>
                  </div>
                  @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('type')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('value')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('period')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan Promo</button>
                  </div>
                </form>
              </div>
            </div>

            @if ($promos->isEmpty())
              <div class="alert alert-info mb-0">Belum ada promo. Tambahkan dari formulir di atas.</div>
            @else
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
                      <th style="width: 150px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($promos as $index => $promo)
                      @php
                        $valueLabel = '-';
                        if ($promo->type === 'percent') {
                          $valueLabel = ($promo->value ?? 0) . '%';
                        } elseif ($promo->type === 'amount') {
                          $valueLabel = 'Rp ' . number_format($promo->value ?? 0, 0, ',', '.');
                        } elseif ($promo->type === 'free_shipping') {
                          $valueLabel = 'Gratis Ongkir';
                        }
                      @endphp
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $promo->name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $promo->type)) }}</td>
                        <td>{{ $valueLabel }}</td>
                        <td>{{ $promo->period ?? '—' }}</td>
                        <td>
                          @if ($promo->is_active)
                            <span class="badge bg-success">Aktif</span>
                          @else
                            <span class="badge bg-danger">Nonaktif</span>
                          @endif
                        </td>
                        <td>
                          <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-promo-{{ $promo->id }}"><i class="mdi mdi-pencil"></i></button>
                            <form method="POST" action="{{ route('services.promo.delete', $promo->id) }}" onsubmit="return confirm('Hapus promo ini?');">
                              @csrf
                              <button type="submit" class="btn btn-outline-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                            </form>
                          </div>
                        </td>
                      </tr>
                      <tr class="collapse" id="edit-promo-{{ $promo->id }}">
                        <td colspan="7">
                          <form method="POST" action="{{ route('services.promo.update', $promo->id) }}">
                            @csrf
                            <div class="row g-2">
                              <div class="col-md-4">
                                <label class="form-label mb-1">Nama Promo</label>
                                <input type="text" name="name" class="form-control" value="{{ $promo->name }}" required>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Jenis Promo</label>
                                <select name="type" class="form-select" required>
                                  <option value="percent" {{ $promo->type === 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                                  <option value="amount" {{ $promo->type === 'amount' ? 'selected' : '' }}>Nominal (Rp)</option>
                                  <option value="free_shipping" {{ $promo->type === 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Nilai Promo</label>
                                <input type="number" name="value" class="form-control" min="0" step="1" value="{{ $promo->value }}">
                              </div>
                              <div class="col-md-2"></div>
                            </div>
                            <div class="row g-2 mt-2">
                              <div class="col-md-4">
                                <label class="form-label mb-1">Periode</label>
                                <input type="date" name="period" class="form-control" value="{{ $promo->period }}">
                              </div>
                              <div class="col-md-3 d-flex align-items-center mt-2">
                                <div class="form-check mb-0">
                                  <input type="hidden" name="is_active" value="0">
                                  <input class="form-check-input" type="checkbox" name="is_active" id="promo-active-{{ $promo->id }}" value="1" {{ $promo->is_active ? 'checked' : '' }}>
                                  <label class="form-check-label ms-2" for="promo-active-{{ $promo->id }}">Aktif</label>
                                </div>
                              </div>
                            </div>
                            <div class="text-end mt-2">
                              <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan Promo</button>
                            </div>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

          {{-- Kategori dan Satuan --}}
          <div class="tab-pane fade" id="tab-services-category" role="tabpanel">
            <div class="row g-3">
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                      <h5 class="mb-0">Kategori Item</h5>
                      <span class="text-muted small">Kelompokkan item sesuai satuan</span>
                    </div>
                    <form method="POST" action="{{ route('services.category.store') }}" class="mb-3">
                      @csrf
                      <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                          <label class="form-label mb-1">Nama Kategori</label>
                          <input type="text" name="name" class="form-control" placeholder="Contoh: Pakaian" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label mb-1">Satuan Utama</label>
                          <select name="unit_id" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach ($units as $unit)
                              <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-2 text-end">
                          <button type="submit" class="btn btn-primary btn-sm w-100"><i class="mdi mdi-content-save"></i> Simpan</button>
                        </div>
                      </div>
                      @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                      @error('unit_id')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </form>
                    <div class="table-responsive">
                      <table class="table table-striped align-middle mb-0">
                        <thead>
                          <tr>
                            <th style="width: 48px;">#</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th style="width: 140px;">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($categories as $index => $category)
                            <tr>
                              <td>{{ $index + 1 }}</td>
                              <td>{{ $category->name }}</td>
                              <td>{{ $category->unit_name ?? '—' }}</td>
                              <td>
                                <div class="d-flex flex-wrap gap-2">
                                  <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-category-{{ $category->id }}"><i class="mdi mdi-pencil"></i></button>
                                  <form method="POST" action="{{ route('services.category.delete', $category->id) }}" onsubmit="return confirm('Hapus kategori ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                            <tr class="collapse" id="edit-category-{{ $category->id }}">
                              <td colspan="4">
                                <form method="POST" action="{{ route('services.category.update', $category->id) }}">
                                  @csrf
                                  <div class="row g-2 align-items-end">
                                    <div class="col-md-6">
                                      <label class="form-label mb-1">Nama Kategori</label>
                                      <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                    </div>
                                    <div class="col-md-4">
                                      <label class="form-label mb-1">Satuan Utama</label>
                                      <select name="unit_id" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($units as $unit)
                                          <option value="{{ $unit->id }}" {{ $category->unit_id === $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="col-md-2 text-end">
                                      <button type="submit" class="btn btn-primary btn-sm w-100"><i class="mdi mdi-content-save"></i> Simpan</button>
                                    </div>
                                  </div>
                                </form>
                              </td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="4" class="text-center text-muted">Belum ada kategori.</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                      <h5 class="mb-0">Satuan Pengukuran</h5>
                      <span class="text-muted small">Dipakai untuk paket, kategori, dan produk</span>
                    </div>
                    <form method="POST" action="{{ route('services.unit.store') }}" class="mb-3">
                      @csrf
                      <div class="row g-2 align-items-end">
                        <div class="col-md-8">
                          <label class="form-label mb-1">Nama Satuan</label>
                          <input type="text" name="name" class="form-control" placeholder="Contoh: Kg" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-4 text-end">
                          <button type="submit" class="btn btn-primary btn-sm w-100"><i class="mdi mdi-content-save"></i> Simpan</button>
                        </div>
                      </div>
                      @if ($errors->has('name') && session('active_tab') === '#tab-services-category')
                        <small class="text-danger d-block mt-1">{{ $errors->first('name') }}</small>
                      @endif
                    </form>
                    <div class="table-responsive">
                      <table class="table table-striped align-middle mb-0">
                        <thead>
                          <tr>
                            <th style="width: 48px;">#</th>
                            <th>Nama Satuan</th>
                            <th style="width: 140px;">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($units as $index => $unit)
                            <tr>
                              <td>{{ $index + 1 }}</td>
                              <td>{{ $unit->name }}</td>
                              <td>
                                <div class="d-flex flex-wrap gap-2">
                                  <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-unit-{{ $unit->id }}"><i class="mdi mdi-pencil"></i></button>
                                  <form method="POST" action="{{ route('services.unit.delete', $unit->id) }}" onsubmit="return confirm('Hapus satuan ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                            <tr class="collapse" id="edit-unit-{{ $unit->id }}">
                              <td colspan="3">
                                <form method="POST" action="{{ route('services.unit.update', $unit->id) }}">
                                  @csrf
                                  <div class="row g-2 align-items-end">
                                    <div class="col-md-8">
                                      <label class="form-label mb-1">Nama Satuan</label>
                                      <input type="text" name="name" class="form-control" value="{{ $unit->name }}" required>
                                    </div>
                                    <div class="col-md-4 text-end">
                                      <button type="submit" class="btn btn-primary btn-sm w-100"><i class="mdi mdi-content-save"></i> Simpan</button>
                                    </div>
                                  </div>
                                </form>
                              </td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="3" class="text-center text-muted">Belum ada satuan.</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Daftar Produk --}}
          <div class="tab-pane fade" id="tab-services-product" role="tabpanel">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <div>
                    <h5 class="mb-0">Daftar Produk</h5>
                    <small class="text-muted">Pantau stok bahan, perlengkapan, dan titik restock</small>
                  </div>
                </div>
                <form method="POST" action="{{ route('services.product.store') }}" class="mb-3">
                  @csrf
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label mb-1">Nama Produk</label>
                      <input type="text" name="name" class="form-control" placeholder="Contoh: Detergen Cair" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label mb-1">SKU (opsional)</label>
                      <input type="text" name="sku" class="form-control" placeholder="PRD-001" value="{{ old('sku') }}">
                    </div>
                    <div class="col-md-2">
                      <label class="form-label mb-1">Satuan</label>
                      <select name="unit_id" class="form-select">
                        <option value="">-</option>
                        @foreach ($units as $unit)
                          <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-1">
                      <label class="form-label mb-1">Stok</label>
                      <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', 0) }}" required>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label mb-1">Reorder Point</label>
                      <input type="number" name="reorder_point" class="form-control" min="0" value="{{ old('reorder_point', 0) }}" required>
                    </div>
                  </div>
                  @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('sku')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('unit_id')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('stock')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  @error('reorder_point')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan Produk</button>
                  </div>
                </form>

                <div class="table-responsive">
                  <table class="table table-striped align-middle mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>SKU</th>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Reorder Point</th>
                        <th>Status</th>
                        <th style="width: 150px;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($products as $index => $product)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $product['sku'] ?? '—' }}</td>
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
                              <span class="badge bg-danger">Harus Restock</span>
                            @endif
                          </td>
                          <td>
                            <div class="d-flex flex-wrap gap-2">
                              <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-product-{{ $product['id'] }}"><i class="mdi mdi-pencil"></i></button>
                              <form method="POST" action="{{ route('services.product.delete', $product['id']) }}" onsubmit="return confirm('Hapus produk ini beserta add-on terkait?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                              </form>
                            </div>
                          </td>
                        </tr>
                        <tr class="collapse" id="edit-product-{{ $product['id'] }}">
                          <td colspan="8">
                            <form method="POST" action="{{ route('services.product.update', $product['id']) }}">
                              @csrf
                              <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                  <label class="form-label mb-1">Nama Produk</label>
                                  <input type="text" name="name" class="form-control" value="{{ $product['name'] }}" required>
                                </div>
                                <div class="col-md-3">
                                  <label class="form-label mb-1">SKU</label>
                                  <input type="text" name="sku" class="form-control" value="{{ $product['sku'] }}">
                                </div>
                                <div class="col-md-2">
                                  <label class="form-label mb-1">Satuan</label>
                                  <select name="unit_id" class="form-select">
                                    <option value="">-</option>
                                    @foreach ($units as $unit)
                                      <option value="{{ $unit->id }}" {{ ($product['unit_id'] ?? null) == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-1">
                                  <label class="form-label mb-1">Stok</label>
                                  <input type="number" name="stock" class="form-control" min="0" value="{{ $product['stock'] }}" required>
                                </div>
                                <div class="col-md-2">
                                  <label class="form-label mb-1">Reorder Point</label>
                                  <input type="number" name="reorder_point" class="form-control" min="0" value="{{ $product['reorder'] ?? 0 }}" required>
                                </div>
                              </div>
                              <div class="text-end mt-2">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan</button>
                              </div>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="8" class="text-center text-muted">Belum ada produk.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
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
    const rupiahInputs = document.querySelectorAll('[data-rupiah]');
    const addonTypeForm = document.getElementById('addon-type-form');
    const addonTypeModalEl = document.getElementById('modal-add-addon-type');
    const addonTypeModal = addonTypeModalEl && window.bootstrap ? new bootstrap.Modal(addonTypeModalEl) : null;
    const addonTypeTitle = document.getElementById('modal-add-addon-type-label');
    const addonTypeSubmit = document.getElementById('addon-type-submit');
    const addonTypeNameInput = document.getElementById('addon-type-name');
    const deleteTypeForm = document.getElementById('addon-type-delete-form');
    const deleteTypeName = document.getElementById('addon-type-delete-name');
    const deleteTypeModalEl = document.getElementById('modal-delete-addon-type');
    const deleteTypeModal = deleteTypeModalEl && window.bootstrap ? new bootstrap.Modal(deleteTypeModalEl) : null;
    const sessionTab = "{{ session('active_tab', '') }}";

    function activateHashTab(hash) {
      if (!hash) return;
      const btn = document.querySelector(`#service-tabs [data-bs-target="${hash}"]`);
      if (btn && window.bootstrap && window.bootstrap.Tab) {
        window.bootstrap.Tab.getOrCreateInstance(btn).show();
      }
    }

    const initialHash = window.location.hash;
    if (initialHash && initialHash.startsWith('#tab-services-')) {
      activateHashTab(initialHash);
    } else if (sessionTab && sessionTab.startsWith('#tab-services-')) {
      activateHashTab(sessionTab);
      history.replaceState(null, '', sessionTab);
    }

    tabButtons.forEach(btn => {
      btn.addEventListener('shown.bs.tab', (e) => {
        const target = e.target.getAttribute('data-bs-target');
        if (target) {
          history.replaceState(null, '', target);
        }
      });
    });

    function onlyDigits(value) {
      return (value || '').replace(/\D+/g, '');
    }

    function formatRupiahInput(input) {
      const digits = onlyDigits(input.value);
      if (!digits) {
        input.value = '';
        return;
      }
      const asNumber = Number(digits);
      input.value = asNumber.toLocaleString('id-ID');
    }

    rupiahInputs.forEach(input => {
      formatRupiahInput(input);
      input.addEventListener('input', () => formatRupiahInput(input));
      input.form?.addEventListener('submit', () => {
        input.value = onlyDigits(input.value);
      });
    });

    document.querySelectorAll('[data-open-type-modal]').forEach(btn => {
      btn.addEventListener('click', () => {
        if (!addonTypeForm || !addonTypeNameInput || !addonTypeTitle || !addonTypeSubmit) return;
        const mode = btn.getAttribute('data-mode') || 'add';
        const action = btn.getAttribute('data-action') || addonTypeForm.action;
        const name = btn.getAttribute('data-name') || '';
        addonTypeForm.action = action;
        addonTypeNameInput.value = name;
        addonTypeTitle.textContent = mode === 'edit' ? 'Edit Jenis Produk' : 'Tambah Jenis Produk';
        addonTypeSubmit.textContent = mode === 'edit' ? 'Simpan' : 'Tambah';
        addonTypeModal?.show();
      });
    });

    document.querySelectorAll('[data-open-type-delete]').forEach(btn => {
      btn.addEventListener('click', () => {
        if (!deleteTypeForm || !deleteTypeName) return;
        const action = btn.getAttribute('data-action');
        const name = btn.getAttribute('data-name') || '';
        deleteTypeForm.action = action || deleteTypeForm.action;
        deleteTypeName.textContent = name;
        deleteTypeModal?.show();
      });
    });

  });
</script>

<!-- Modal Tambah/Edit Jenis Add-on -->
<div class="modal fade" id="modal-add-addon-type" tabindex="-1" aria-labelledby="modal-add-addon-type-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="addon-type-form" action="{{ route('services.addon.type.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modal-add-addon-type-label">Tambah Jenis Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label class="form-label">Nama jenis baru</label>
          <input type="text" name="name" id="addon-type-name" class="form-control" placeholder="Contoh: Anti Kusut" required>
          <small class="text-muted">Jenis baru akan ditambahkan ke semua pilihan add-on.</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="addon-type-submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus Jenis Add-on -->
<div class="modal fade" id="modal-delete-addon-type" tabindex="-1" aria-labelledby="modal-delete-addon-type-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="addon-type-delete-form" action="#">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modal-delete-addon-type-label">Hapus Jenis Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus jenis <strong id="addon-type-delete-name"></strong>?</p>
          <p class="text-muted mb-0">Pastikan tidak dipakai oleh add-on aktif.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
