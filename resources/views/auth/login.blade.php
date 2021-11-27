@extends('website.ecommerce.layouts.ecommerce')
@section('content')

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 my-4">
                <div class="card">
                    <div class="card-body">
                        <div class="account-heading mb-25">
                            <h2>Login</h2>
                        </div>
                        <div class="account-form form-style mt-3 p-20 mb-30 bg-fff box-shadow">
                            <form method="POST" action="{{ route('login') }}" id="login_form">
                                @csrf
                                <div>
                                    <b>email address <span>*</span></b>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div>
                                    <b>Password <span>*</span></b>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="login-button">
                                    <button type="submit" class="btn btn-secondary">Login</button>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 my-4">
                <div class="card">
                    <div class="card-body">
                        <div class="account-heading mb-25">
                            <h2>Register</h2>
                        </div>
                        <div class="account-form form-style p-20 mb-30 bg-fff box-shadow mt-3">
                            <form action="#" @submit.prevent="user_registration()" id="registration_form">
                                @csrf
                                <div>
                                    <b>First Name <span>*</span></b>
                                    <input name="first_name" type="text" />
                                </div>
                                <div>
                                    <b>Last Name <span>*</span></b>
                                    <input name="last_name" type="text" />
                                </div>
                                <div>
                                    <b>Phone <span>*</span></b>
                                    <input name="phone" type="text" />
                                </div>
                                <div>
                                    <b>Email address <span>*</span></b>
                                    <input name="email" type="text" />
                                </div>
                                <div>
                                    <b>Password <span>*</span></b>
                                    <input name="password" type="password" />
                                </div>
                                <div>
                                    <b>Confirm Password <span>*</span></b>
                                    <input name="password_confirmation" type="password" />
                                </div>
                                <div class="login-button">
                                    <button type="submit" class="btn btn-secondary">register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('cjs')
    <style>
        #registration_form input{
            margin-bottom: 0;
        }
        #registration_form div{
            margin-bottom: 20px;
        }
    </style>
@endpush

@endsection
