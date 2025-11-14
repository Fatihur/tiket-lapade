@extends('layouts.auth')

@section('title', 'Login - Tiket Wisata Online')

@section('content')
<div class="card mb-0">
  <div class="card-body">
    <a href="{{ route('landing') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
      <h3 class="fw-bold text-primary">Tiket Wisata Online</h3>
    </a>
    <p class="text-center">Silakan login untuk melanjutkan</p>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
      </div>
      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
          <input class="form-check-input primary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="form-check-label text-dark" for="remember">
            Ingat Saya
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
      <div class="d-flex align-items-center justify-content-center">
        <a class="text-primary fw-bold" href="{{ route('landing') }}">← Kembali ke Beranda</a>
      </div>
    </form>

    <div class="mt-4 p-3 bg-light rounded">
      <p class="mb-2 fw-bold">Akun Demo:</p>
      <small class="d-block">Admin: admin@wisata.com / password</small>
      <small class="d-block">Petugas: petugas@wisata.com / password</small>
      <small class="d-block">Bendahara: bendahara@wisata.com / password</small>
      <small class="d-block">Owner: owner@wisata.com / password</small>
    </div>
  </div>
</div>
@endsection

