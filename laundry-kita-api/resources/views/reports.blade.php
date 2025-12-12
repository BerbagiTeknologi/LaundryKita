@extends('layouts.app')
@section('title', 'Laporan | Laundry Kita')

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card" id="report-tabs">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
          <h4 class="card-title mb-0">Laporan</h4>
          <span class="text-muted small">Keuangan, transaksi, persediaan, pegawai, pelanggan, dan export data</span>
        </div>

        <ul class="nav nav-tabs mt-3" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-report-keuangan-tab" data-bs-toggle="tab" data-bs-target="#tab-report-keuangan" type="button" role="tab">
              <i class="mdi mdi-cash-multiple me-2"></i>Keuangan
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-report-transaksi-tab" data-bs-toggle="tab" data-bs-target="#tab-report-transaksi" type="button" role="tab">
              <i class="mdi mdi-swap-horizontal me-2"></i>Transaksi
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-report-persediaan-tab" data-bs-toggle="tab" data-bs-target="#tab-report-persediaan" type="button" role="tab">
              <i class="mdi mdi-package-variant-closed me-2"></i>Persediaan
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-report-pegawai-tab" data-bs-toggle="tab" data-bs-target="#tab-report-pegawai" type="button" role="tab">
              <i class="mdi mdi-account-multiple me-2"></i>Pegawai
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-report-pelanggan-tab" data-bs-toggle="tab" data-bs-target="#tab-report-pelanggan" type="button" role="tab">
              <i class="mdi mdi-account-group me-2"></i>Pelanggan
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-report-export-tab" data-bs-toggle="tab" data-bs-target="#tab-report-export" type="button" role="tab">
              <i class="mdi mdi-file-export me-2"></i>Export Data
            </button>
          </li>
        </ul>

        <div class="tab-content pt-3">
          <div class="tab-pane fade show active" id="tab-report-keuangan" role="tabpanel">
            <p class="text-muted mb-2">Ringkasan pendapatan, pengeluaran, dan profit.</p>

            <ul class="nav nav-pills mb-3" role="tablist">
              <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sub-omzet" type="button" role="tab">Omzet</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#sub-arus" type="button" role="tab">Arus Keuangan</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#sub-pendapatan-transaksi" type="button" role="tab">Pendapatan Transaksi</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#sub-pendapatan-produk" type="button" role="tab">Pendapatan Jual Produk</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#sub-pendapatan-lain" type="button" role="tab">Pendapatan Lain</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#sub-pengeluaran" type="button" role="tab">Pengeluaran</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#sub-coa" type="button" role="tab">Chart of Account</button></li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane fade show active" id="sub-omzet" role="tabpanel">
                <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                  <div>
                    <label class="form-label mb-1">Periode</label>
                    <div class="d-flex gap-2">
                      <input type="date" class="form-control" style="max-width: 180px;">
                      <input type="date" class="form-control" style="max-width: 180px;">
                    </div>
                  </div>
                  <button class="btn btn-outline-success btn-sm"><i class="mdi mdi-download"></i> Download Excel</button>
                </div>
                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="card bg-dark text-white">
                      <div class="card-body">
                        <p class="mb-1 text-muted">Omzet</p>
                        <h5 class="mb-0">Rp 12.500.000</h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="alert alert-info mb-0">Grafik omzet bulanan akan ditempatkan di sini.</div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="sub-arus" role="tabpanel">
                <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                  <div>
                    <label class="form-label mb-1">Periode</label>
                    <div class="d-flex gap-2">
                      <input type="date" class="form-control" style="max-width: 180px;">
                      <input type="date" class="form-control" style="max-width: 180px;">
                    </div>
                  </div>
                  <button class="btn btn-outline-success btn-sm"><i class="mdi mdi-download"></i> Download Excel</button>
                </div>
                <div class="alert alert-info mb-0">Arus kas (cashflow) akan ditampilkan di sini.</div>
              </div>

              <div class="tab-pane fade" id="sub-pendapatan-transaksi" role="tabpanel">
                <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                  <div>
                    <label class="form-label mb-1">Periode</label>
                    <div class="d-flex gap-2">
                      <input type="date" class="form-control" style="max-width: 180px;">
                      <input type="date" class="form-control" style="max-width: 180px;">
                    </div>
                  </div>
                  <button class="btn btn-outline-success btn-sm"><i class="mdi mdi-download"></i> Download Excel</button>
                </div>
                <div class="alert alert-info mb-0">Rincian pendapatan transaksi akan ditempatkan di sini.</div>
              </div>

              <div class="tab-pane fade" id="sub-pendapatan-produk" role="tabpanel">
                <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                  <div>
                    <label class="form-label mb-1">Periode</label>
                    <div class="d-flex gap-2">
                      <input type="date" class="form-control" style="max-width: 180px;">
                      <input type="date" class="form-control" style="max-width: 180px;">
                    </div>
                  </div>
                  <button class="btn btn-outline-success btn-sm"><i class="mdi mdi-download"></i> Download Excel</button>
                </div>
                <div class="alert alert-info mb-0">Rincian pendapatan penjualan produk akan ditempatkan di sini.</div>
              </div>

              <div class="tab-pane fade" id="sub-pendapatan-lain" role="tabpanel">
                <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                  <div>
                    <label class="form-label mb-1">Periode</label>
                    <div class="d-flex gap-2">
                      <input type="date" class="form-control" style="max-width: 180px;">
                      <input type="date" class="form-control" style="max-width: 180px;">
                    </div>
                  </div>
                  <button class="btn btn-outline-success btn-sm"><i class="mdi mdi-download"></i> Download Excel</button>
                </div>
                <div class="alert alert-info mb-0">Pendapatan lain-lain akan ditampilkan di sini.</div>
              </div>

              <div class="tab-pane fade" id="sub-pengeluaran" role="tabpanel">
                <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                  <div>
                    <label class="form-label mb-1">Periode</label>
                    <div class="d-flex gap-2">
                      <input type="date" class="form-control" style="max-width: 180px;">
                      <input type="date" class="form-control" style="max-width: 180px;">
                    </div>
                  </div>
                  <button class="btn btn-outline-success btn-sm"><i class="mdi mdi-download"></i> Download Excel</button>
                </div>
                <div class="alert alert-info mb-0">Pengeluaran operasional akan ditampilkan di sini.</div>
              </div>

              <div class="tab-pane fade" id="sub-coa" role="tabpanel">
                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                  <h6 class="mb-0">Chart of Account</h6>
                  <a class="btn btn-outline-success btn-sm" href="{{ route('reports.coa.download') }}"><i class="mdi mdi-download"></i> Download Excel</a>
                  <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-upload-coa"><i class="mdi mdi-file-excel"></i> Upload Excel</button>
                  <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-add-coa"><i class="mdi mdi-plus"></i> Tambah Akun</button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Kode</th>
                        <th>Nama Akun</th>
                        <th>Jenis</th>
                        <th>Saldo Awal</th>
                        <th>Balance</th>
                        <th style="width: 140px;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($coas ?? [] as $coa)
                        <tr>
                        <td>{{ $coa->code }}</td>
                        <td>{{ $coa->name }}</td>
                        <td>{{ $coa->type }}</td>
                        <td>Rp {{ number_format($coa->opening_balance, 0, ',', '.') }}</td>
                        <td class="text-capitalize">{{ $coa->balance_nature ?? 'debit' }}</td>
                        <td>
                          <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-coa-{{ $coa->id }}"><i class="mdi mdi-pencil"></i></button>
                            <form method="POST" action="{{ route('reports.coa.delete', $coa->id) }}" onsubmit="return confirm('Hapus akun ini?');">
                              @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                              </form>
                            </div>
                          </td>
                        </tr>
                        <tr class="collapse" id="edit-coa-{{ $coa->id }}">
                          <td colspan="5">
                            <form method="POST" action="{{ route('reports.coa.update', $coa->id) }}" class="row g-2 align-items-end">
                              @csrf
                              <div class="col-md-3">
                                <label class="form-label mb-1">Jenis</label>
                                <select name="type" class="form-select form-select-sm" data-coa-type required>
                                  @foreach (['Aset Lancar','Aset Tetap','Liability','Equity','Revenue','Expense'] as $t)
                                    <option value="{{ $t }}" {{ $coa->type === $t ? 'selected' : '' }}>{{ $t }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-md-3" data-coa-code-wrapper>
                                <label class="form-label mb-1">Kode</label>
                                <input type="number" name="code" class="form-control form-control-sm" value="{{ $coa->code }}" data-coa-code min="1000" max="9999">
                                <small class="text-muted">Maks 4 digit (9999). Prefix 1/12/2/3/4/5 sesuai jenis.</small>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Nama Akun</label>
                                <input type="text" name="name" class="form-control form-control-sm" value="{{ $coa->name }}" required>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Saldo Awal</label>
                                <div class="input-group input-group-sm">
                                  <span class="input-group-text">Rp</span>
                                  <input type="number" name="opening_balance" class="form-control" min="0" step="1000" value="{{ $coa->opening_balance }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label mb-1">Balance</label>
                                <select name="balance_nature" class="form-select form-select-sm" required>
                                  <option value="debit" {{ ($coa->balance_nature ?? 'debit') === 'debit' ? 'selected' : '' }}>Debit</option>
                                  <option value="credit" {{ ($coa->balance_nature ?? '') === 'credit' ? 'selected' : '' }}>Kredit</option>
                                </select>
                              </div>
                              <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save"></i> Simpan</button>
                              </div>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="5" class="text-center text-muted">Belum ada akun. Tambahkan atau upload template.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tab-report-transaksi" role="tabpanel">
            <p class="text-muted mb-2">Status transaksi dan pembayaran.</p>
            <div class="alert alert-info mb-0">Konten transaksi akan ditempatkan di sini.</div>
          </div>
          <div class="tab-pane fade" id="tab-report-persediaan" role="tabpanel">
            <p class="text-muted mb-2">Kondisi stok, restock, dan opname.</p>
            <div class="alert alert-info mb-0">Konten persediaan akan ditempatkan di sini.</div>
          </div>
<div class="tab-pane fade" id="tab-report-pegawai" role="tabpanel">
            <p class="text-muted mb-2">Data pegawai dan performa.</p>
            <div class="alert alert-info mb-0">Konten pegawai akan ditempatkan di sini.</div>
          </div>
          <div class="tab-pane fade" id="tab-report-pelanggan" role="tabpanel">
            <p class="text-muted mb-2">Aktivitas pelanggan dan segmentasi.</p>
            <div class="alert alert-info mb-0">Konten pelanggan akan ditempatkan di sini.</div>
          </div>
          <div class="tab-pane fade" id="tab-report-export" role="tabpanel">
            <p class="text-muted mb-2">Unduh data dalam format CSV/Excel/PDF.</p>
            <div class="alert alert-info mb-0">Konten export data akan ditempatkan di sini.</div>
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
    // Sinkronisasi hash untuk tab utama & sub-tab keuangan
    const reportContainer = document.getElementById('report-tabs');
    const mainTabs = reportContainer ? reportContainer.querySelectorAll('[data-bs-toggle="tab"][id^="tab-report-"]') : [];
    const financeSubTabs = reportContainer ? reportContainer.querySelectorAll('#tab-report-keuangan [data-bs-toggle="tab"]') : [];
    const typePrefix = {
      'Aset Lancar': '1',
      'Aset Tetap': '12',
      'Liability': '2',
      'Equity': '3',
      'Revenue': '4',
      'Expense': '5',
    };

    function toggleCodeVisibility(selectEl) {
      const form = selectEl.closest('form');
      if (!form) return;
      const codeWrapper = form.querySelector('[data-coa-code-wrapper]');
      if (!codeWrapper) return;
      if (selectEl.value) {
        codeWrapper.classList.remove('d-none');
      } else {
        codeWrapper.classList.add('d-none');
        const codeInput = codeWrapper.querySelector('[data-coa-code]');
        if (codeInput) codeInput.value = '';
      }
    }

    function applyPrefix(selectEl) {
      const prefix = typePrefix[selectEl.value];
      if (!prefix) return;
      const form = selectEl.closest('form');
      const codeInput = form ? form.querySelector('[data-coa-code]') : null;
      if (!codeInput) return;
      const current = (codeInput.value || '').trim();
      if (!current || !current.startsWith(prefix)) {
        codeInput.value = prefix;
      }
    }

    document.querySelectorAll('[data-coa-type]').forEach(sel => {
      sel.addEventListener('change', () => {
        toggleCodeVisibility(sel);
        applyPrefix(sel);
      });
      toggleCodeVisibility(sel);
      applyPrefix(sel);
    });

    function activateFromHash(hash) {
      if (!hash || !window.bootstrap) return;
      // format: #tab-report-keuangan:sub-omzet
      const [mainId, subId] = hash.replace('#', '').split(':');
      const mainBtn = document.querySelector(`#report-tabs [data-bs-target="#${mainId}"]`);
      if (mainBtn) {
        window.bootstrap.Tab.getOrCreateInstance(mainBtn).show();
      }
      if (subId && mainId === 'tab-report-keuangan') {
        const subBtn = document.querySelector(`#tab-report-keuangan [data-bs-target="#${subId}"]`);
        if (subBtn) {
          window.bootstrap.Tab.getOrCreateInstance(subBtn).show();
        }
      }
    }

    if (window.location.hash) {
      activateFromHash(window.location.hash);
    }

    mainTabs.forEach(btn => {
      btn.addEventListener('shown.bs.tab', (e) => {
        const target = e.target.getAttribute('data-bs-target');
        if (target) {
          history.replaceState(null, '', target);
        }
      });
    });

    financeSubTabs.forEach(btn => {
      btn.addEventListener('shown.bs.tab', (e) => {
        const mainActive = document.querySelector('#report-tabs [data-bs-target="#tab-report-keuangan"].active');
        const subTarget = e.target.getAttribute('data-bs-target');
        if (mainActive && subTarget) {
          history.replaceState(null, '', '#tab-report-keuangan:' + subTarget.replace('#', ''));
        }
      });
    });

  });
</script>

<!-- Modal Tambah Akun COA -->
<div class="modal fade" id="modal-add-coa" tabindex="-1" aria-labelledby="modal-add-coa-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="coa-form" method="POST" action="{{ route('reports.coa.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modal-add-coa-label">Tambah Akun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Jenis</label>
            <select name="type" class="form-select" data-coa-type required>
              <option value="">-- Pilih --</option>
              <option value="Aset Lancar">Aset Lancar</option>
              <option value="Aset Tetap">Aset Tetap</option>
              <option value="Liability">Liability</option>
              <option value="Equity">Equity</option>
              <option value="Revenue">Revenue</option>
              <option value="Expense">Expense</option>
            </select>
          </div>
          <div class="mb-3 d-none" data-coa-code-wrapper>
            <label class="form-label">Kode Akun</label>
            <input type="number" name="code" class="form-control" placeholder="Contoh: 1001" data-coa-code min="1000" max="9999" step="1">
            <small class="text-muted">Maks 4 digit (9999). Prefix otomatis mengikuti jenis.</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Akun</label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Kas" required>
          </div>
          <div class="mb-0">
            <label class="form-label">Saldo Awal</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" name="opening_balance" class="form-control" min="0" step="1000" placeholder="0">
            </div>
          </div>
          <div class="mt-3">
            <label class="form-label">Nominal Balance</label>
            <select name="balance_nature" class="form-select" required>
              <option value="debit">Debit</option>
              <option value="credit">Kredit</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Upload COA -->
<div class="modal fade" id="modal-upload-coa" tabindex="-1" aria-labelledby="modal-upload-coa-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('reports.coa.upload') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modal-upload-coa-label">Upload COA (CSV)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Pilih file CSV</label>
            <input type="file" name="coa_file" accept=".csv" class="form-control bg-light text-dark" required>
            <small class="text-muted">Gunakan template download.</small>
          </div>
          <div class="mb-0">
            <a class="btn btn-link p-0" href="{{ route('reports.coa.download') }}"><i class="mdi mdi-download"></i> Unduh template CSV</a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
