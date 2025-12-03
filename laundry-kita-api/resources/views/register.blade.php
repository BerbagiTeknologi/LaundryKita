<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register | Laundry Kita</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-start mb-3">Register</h3>
                <form method="POST" action="{{ route('register.attempt') }}">
                  @csrf
                  <div class="form-group">
                    <label>Nama Outlet *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control p_input" required>
                    @error('name')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control p_input" required>
                    @error('email')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Daftar sebagai *</label>
                    <select name="role" class="form-control p_input" required>
                      <option value="">-- Pilih --</option>
                      <option value="pelanggan" {{ old('role') === 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                      <option value="pemilik" {{ old('role') === 'pemilik' ? 'selected' : '' }}>Pemilik Outlet / Mitra</option>
                    </select>
                    @error('role')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Telepon *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control p_input" required>
                    @error('phone')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <div class="input-group">
                      <input type="password" name="password" class="form-control p_input" id="password" required>
                      <button class="btn btn-outline-secondary" type="button" id="toggle-password"><i class="mdi mdi-eye-off"></i></button>
                    </div>
                    @error('password')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="text-center d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Register</button>
                  </div>
                  <p class="sign-up text-center">Sudah punya akun?<a href="{{ route('login') }}"> Login</a></p>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <script>
      const passwordInput = document.getElementById('password');
      const toggleBtn = document.getElementById('toggle-password');
      if (passwordInput && toggleBtn) {
        toggleBtn.addEventListener('click', () => {
          const isHidden = passwordInput.type === 'password';
          passwordInput.type = isHidden ? 'text' : 'password';
          toggleBtn.innerHTML = isHidden ? '<i class="mdi mdi-eye"></i>' : '<i class="mdi mdi-eye-off"></i>';
        });
      }
    </script>
    <!-- endinject -->
  </body>
</html>
