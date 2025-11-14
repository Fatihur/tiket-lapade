@extends('layouts.auth')

@section('title', 'Login - Tiket Wisata Online')

@section('content')
<div class="card mb-0 shadow-lg border-0">
  <div class="card-body p-4 p-md-5">
    <!-- Logo & Header -->
    <div class="text-center mb-4">
      <a href="{{ route('landing') }}" class="text-decoration-none">
        <div class="mb-3">
          <i class="ti ti-ticket" style="font-size: 64px; color: #5D87FF;"></i>
        </div>
        <h2 class="fw-bold text-primary mb-2">Tiket Wisata Online</h2>
      </a>
      <p class="text-muted mb-0">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Alert Error -->
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
          <i class="ti ti-alert-circle fs-5 me-2"></i>
          <div>
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
          <i class="ti ti-check-circle fs-5 me-2"></i>
          <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Login Form -->
    <form action="{{ route('login.post') }}" method="POST" class="mt-4">
      @csrf
      
      <!-- Email Input -->
      <div class="mb-4">
        <label for="email" class="form-label fw-semibold">
          <i class="ti ti-mail me-1"></i> Email
        </label>
        <input 
          type="email" 
          class="form-control form-control-lg @error('email') is-invalid @enderror" 
          id="email" 
          name="email" 
          value="{{ old('email') }}" 
          placeholder="Masukkan email Anda"
          required 
          autofocus
        >
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Password Input -->
      <div class="mb-4">
        <label for="password" class="form-label fw-semibold">
          <i class="ti ti-lock me-1"></i> Password
        </label>
        <div class="input-group">
          <input 
            type="password" 
            class="form-control form-control-lg @error('password') is-invalid @enderror" 
            id="password" 
            name="password"
            placeholder="Masukkan password Anda"
            required
          >
          <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="ti ti-eye" id="eyeIcon"></i>
          </button>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Remember Me -->
      <div class="mb-4">
        <div class="form-check">
          <input 
            class="form-check-input" 
            type="checkbox" 
            name="remember" 
            id="remember" 
            {{ old('remember') ? 'checked' : '' }}
          >
          <label class="form-check-label" for="remember">
            Ingat Saya
          </label>
        </div>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary w-100 py-3 fs-5 mb-3 rounded-2">
        <i class="ti ti-login me-2"></i> Login
      </button>

      <!-- Back to Home -->
      <div class="text-center">
        <a class="text-primary fw-semibold text-decoration-none" href="{{ route('landing') }}">
          <i class="ti ti-arrow-left me-1"></i> Kembali ke Beranda
        </a>
      </div>
    </form>

  
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword?.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIcon.classList.remove('ti-eye-off');
            eyeIcon.classList.add('ti-eye');
        } else {
            eyeIcon.classList.remove('ti-eye');
            eyeIcon.classList.add('ti-eye-off');
        }
    });
});
</script>
@endpush
@endsection

