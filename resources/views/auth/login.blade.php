@if (auth()->check())
    @section('content')
        <script>
            window.location = "/";
        </script>
    @endsection
@endif

@extends('app')

@section('title', 'Login')

@section('content')
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card animate bg-light text-white template-paw">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h1 class="fw-bold m-5 text-uppercase">Login</h1>
                            <p class="text-white-50 mb-4">Log in to access your account.</p>

                            @if ($errors->any())
                                <div class="container">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error! </strong>
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            <form name="login" action="{{ route('login') }}" method="post" class="m-3">
                                @csrf
                                <div class="form-outline form-white mb-4">
                                    <h4><label class="form-label" for="username">Username</label></h4>
                                    <input required type="text" id="username" class="form-control form-control-lg" placeholder="Username" name="username" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <h4><label class="form-label" for="password">Password</label></h4>
                                    <input required type="password" id="password" class="form-control form-control-lg" placeholder="Password" name="password" />
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            </form>

                        </div>

                        <div>
                            <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-white-50 fw-bold">Sign Up</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
