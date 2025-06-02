@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Lupa Password</h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="mb-4">Masukkan alamat email Anda untuk memulai proses reset password.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="EMAIL_PEMBELI" class="form-label">Email</label>
                            <input type="email" class="form-control" id="EMAIL_PEMBELI" name="EMAIL_PEMBELI" value="{{ old('EMAIL_PEMBELI') }}" required autofocus>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Lanjutkan</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <p>Ingat password? <a href="{{ route('login') }}">Login disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
