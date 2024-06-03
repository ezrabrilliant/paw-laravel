@if (auth()->check())
    @section('content')
        <script>
            window.location = "/";
        </script>
    @endsection
@endif

@extends('app')

@section('title', 'Sign Up')

@section('content')
<section>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card animate bg-dark text-white template-paw">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold m-5 text-uppercase">Sign Up</h2>
                            <p class="text-white-50 mb-4">Sign up to get access to our services.</p>

                            @if ($errors->any())
                                <div class="container">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Invalid! </strong>
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            <form id="phoneNumberForm" name="login" action="{{ route('register') }}" method="post" class="m-3">
                                @csrf
                                <div class="form-outline form-white mb-4">
                                    <h4><label class="form-label" for="username">Username</label></h4>
                                    <input type="text" id="username" required class="form-control form-control-lg" placeholder="Username" name="username" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <h4><label class="form-label" for="email">Email</label></h4>
                                    <input type="email" id="email" required class="form-control form-control-lg" placeholder="Email" name="email" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <h3><label class="form-label" for="telepon">No. telepon</label></h3>
                                    <input type="telepon" id="telepon" required class="form-control form-control-lg" placeholder="No. Telp" name="telepon" />
                                    <div class="invalid-feedback">
                                        Nomor telepon harus memiliki 10-13 digit dan diawali dengan '08'.
                                    </div>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <h4><label class="form-label" for="password">Password</label></h4>
                                    <input type="password" id="password" required class="form-control form-control-lg" placeholder="Password" name="password" />
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Sign Up</button>
                            </form>

                        </div>

                        <div>
                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-white-50 fw-bold">Login</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
