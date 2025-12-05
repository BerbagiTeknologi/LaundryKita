<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Laundry Kita')</title>
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
      /* Make layout fixed while only main content scrolls */
      html, body, .container-scroller, .page-body-wrapper, .main-panel {
        height: 100%;
      }
      .container-scroller {
        overflow: hidden;
      }
      .page-body-wrapper {
        display: flex;
        overflow: hidden;
      }
      .main-panel {
        display: flex;
        flex-direction: column;
        overflow: hidden;
      }
      .content-wrapper {
        flex: 1 1 auto;
        overflow-y: auto;
      }
      .sidebar.sidebar-offcanvas {
        position: sticky;
        top: 0;
        min-height: 100vh;
        height: auto;
        overflow-y: auto;
      }
      .status-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
      }
      .status-btn .mdi {
        font-size: 16px;
        line-height: 1;
      }
      .menu-arrow {
        transition: transform 0.2s ease;
      }
      .menu-arrow.rotate-90 {
        transform: rotate(-90deg);
      }
      .collapse-menu {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.25s ease, opacity 0.2s ease;
      }
      .collapse-menu.show {
        max-height: 500px;
        opacity: 1;
      }
      .collapse-menu.collapsing {
        max-height: 0 !important;
        opacity: 0;
        transition: max-height 0.25s ease, opacity 0.2s ease;
      }
      .toast-stack-top-right {
        position: fixed;
        top: 5rem; /* di bawah navbar supaya tidak menutupi */
        right: 1.5rem;
        z-index: 1080;
      }
      .animated-toast {
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.25s ease, transform 0.25s ease;
      }
      .animated-toast.showing,
      .animated-toast.show {
        opacity: 1;
        transform: translateY(0);
      }
      .animated-toast.hide {
        opacity: 0;
        transform: translateY(-10px);
      }
    </style>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    @yield('head')
  </head>
  <body>
    <div class="container-scroller">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="{{ route('home') }}"><img src="{{ asset('images/logo.svg') }}" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="{{ route('home') }}"><img src="{{ asset('images/logo-mini.svg') }}" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="{{ asset('images/faces/face15.jpg') }}" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name ?? 'Pengguna' }}</h5>
                  <span>{{ Auth::user()->role ?? '' }}</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="{{ route('account.settings') }}" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-cog text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Pengaturan Akun</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item" onclick="event.preventDefault(); document.getElementById('logout-form-dropdown').submit();">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-logout text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Logout</p>
                  </div>
                </a>
                <form id="logout-form-dropdown" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Menu Utama</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('home') }}#keuangan" data-jump-keuangan>
              <span class="menu-icon"><i class="mdi mdi-home"></i></span>
              <span class="menu-title">Beranda</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('home') }}#transaksi" data-jump-transaksi>
              <span class="menu-icon"><i class="mdi mdi-cart"></i></span>
              <span class="menu-title">Pesanan</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon"><i class="mdi mdi-file-chart"></i></span>
              <span class="menu-title">Laporan</span>
              <i class="menu-arrow mdi mdi-menu-down"></i>
            </a>
            <div class="collapse collapse-menu" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="#"><i class="mdi mdi-cash-multiple me-2"></i>Keuangan</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="mdi mdi-swap-horizontal me-2"></i>Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="mdi mdi-package-variant-closed me-2"></i>Persediaan</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="mdi mdi-account-multiple me-2"></i>Pegawai</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="mdi mdi-account-group me-2"></i>Pelanggan</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="mdi mdi-file-export me-2"></i>Export Data</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Menu Lainnya</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon"><i class="mdi mdi-account-group"></i></span>
              <span class="menu-title">Pelanggan Saya</span>
            </a>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('outlet.*') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('outlet.*') ? 'active' : '' }}" href="{{ route('outlet.manage') }}">
              <span class="menu-icon"><i class="mdi mdi-store"></i></span>
              <span class="menu-title">Kelola Outlet</span>
            </a>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('services.*') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.manage') }}#tab-services-regular">
              <span class="menu-icon"><i class="mdi mdi-package-variant"></i></span>
              <span class="menu-title">Kelola Layanan</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon"><i class="mdi mdi-account-cog"></i></span>
              <span class="menu-title">Kelola Pegawai</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon"><i class="mdi mdi-cash-multiple"></i></span>
              <span class="menu-title">Kelola Keuangan</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon"><i class="mdi mdi-cancel"></i></span>
              <span class="menu-title">Pembatalan Transaksi</span>
            </a>
          </li>
        </ul>
      </nav>

      <div class="container-fluid page-body-wrapper">
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="{{ route('home') }}"><img src="{{ asset('images/logo-mini.svg') }}" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                  <input type="text" class="form-control" placeholder="Search products">
                </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-bs-toggle="dropdown" aria-expanded="false" href="#">+ Buak akun untuk karyawan</a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                  <h6 class="p-3 mb-0">Projects</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-file-outline text-primary"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-web text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">UI Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-layers text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Testing</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all projects</p>
                </div>
              </li>
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#"><i class="mdi mdi-view-grid"></i></a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="{{ asset('images/faces/face4.jpg') }}" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                      <p class="text-muted mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="{{ asset('images/faces/face2.jpg') }}" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                      <p class="text-muted mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="{{ asset('images/faces/face3.jpg') }}" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                      <p class="text-muted mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">4 new messages</p>
                </div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-calendar text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Event today</p>
                      <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-cog text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                      <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-link-variant text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Launch Admin</p>
                      <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all notifications</p>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>

        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a href="https://www.bootstrapdash.com/" target="_blank"></a> All rights reserved.</span>
            </div>
          </footer>
        </div>
      </div>
    </div>

    @if (session('status') || session('error'))
      <div class="toast-stack-top-right">
        @if (session('status'))
          <div class="toast animated-toast align-items-center text-bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3500">
            <div class="d-flex">
              <div class="toast-body">
                {{ session('status') }}
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        @endif
        @if (session('error'))
          <div class="toast animated-toast align-items-center text-bg-danger border-0 shadow mt-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
            <div class="d-flex">
              <div class="toast-body">
                {{ session('error') }}
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        @endif
      </div>
    @endif

    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <script src="{{ asset('js/proBanner.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const collapseTriggers = document.querySelectorAll('a[data-bs-toggle="collapse"]');
        collapseTriggers.forEach(trigger => {
          const arrow = trigger.querySelector('.menu-arrow');
          const targetSelector = trigger.getAttribute('data-bs-target') || trigger.getAttribute('href');
          const target = targetSelector ? document.querySelector(targetSelector) : null;
          if (!arrow || !target) return;

          target.addEventListener('show.bs.collapse', () => {
            arrow.classList.add('rotate-90');
          });
          target.addEventListener('hide.bs.collapse', () => {
            arrow.classList.remove('rotate-90');
          });
        });

        const toastEls = document.querySelectorAll('.toast');
        toastEls.forEach(t => {
          const toast = new bootstrap.Toast(t);
          toast.show();
        });
      });
    </script>
    @yield('scripts')
  </body>
</html>
