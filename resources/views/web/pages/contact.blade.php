@extends('web.layouts.app')
@section('title', __('attributes.contacts'))
@section('content')

    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                @include('web.components.category-dropdown')
            </div>
            <div class="col-lg-9">
                @include('web.layouts.nav')
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    {{-- <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Contact</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Contact</p>
            </div>
        </div>
    </div> --}}
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">

        {{-- <div class="mb-4">
            <h2 class="px-lg-5 px-3" style="font-weight: bold; text-align: left; margin-bottom: 0;">{{
                __('attributes.contuct') }}</h2>
        </div> --}}
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form action="{{ route('contact.store') }}" method="post">
                        @csrf

                        {{-- Display all errors at top --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4" style="border-radius: 10px;">
                                <ul class="mb-0" style="padding-left: 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Name Input --}}
                        <div class="control-group mb-4">
                            <input type="text" class="form-control shadow-sm @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="{{__('attributes.name')}}" value="{{ old('name') }}" required
                                minlength="3" maxlength="100" autocomplete="name" style="border-radius: 10px;" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email Input (Gmail Only) --}}
                        <div class="control-group mb-4">
                            <input type="email" class="form-control shadow-sm @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="your.email@gmail.com" value="{{ old('email') }}"
                                required maxlength="255" pattern="[a-zA-Z0-9._%+-]+@gmail\.com$"
                                title="Only Gmail addresses are allowed" autocomplete="email"
                                style="border-radius: 10px;" />
                            <small class="text-muted">Gmail addresses only (@gmail.com)</small>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone Input (Egyptian Only) --}}
                        <div class="control-group mb-4">
                            <input type="tel" class="form-control shadow-sm @error('phone') is-invalid @enderror" id="phone"
                                name="phone" placeholder="01012345678" value="{{ old('phone') }}" required minlength="11"
                                maxlength="11" pattern="(010|011|012|015)[0-9]{8}"
                                title="Egyptian phone number (e.g., 01012345678)" autocomplete="tel" inputmode="numeric"
                                style="border-radius: 10px;" />
                            <small class="text-muted">Egyptian numbers only (010, 011, 012, 015)</small>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Message Input --}}
                        <div class="control-group mb-4">
                            <textarea class="form-control shadow-sm @error('message') is-invalid @enderror" rows="6"
                                id="message" name="message" placeholder="{{__('attributes.message')}}" required
                                minlength="10" maxlength="2000" style="border-radius: 10px;">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-end">
                            <button class="btn btn-primary btn-lg px-5 shadow-sm" type="submit"
                                style="border-radius: 10px;">
                                {{ __('attributes.submit') }} <i class="fa fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="d-flex flex-column mb-3">
                    <h4 class="font-weight-bold mb-3">{{ setting('name') }}</h4>
                    <p class="mb-2" style="font-weight: bold;"><i
                            class="fa fa-map-marker-alt text-primary mr-3"></i>{{ setting('address') }}</p>
                    <p class="mb-2" style="font-weight: bold;"><i
                            class="fa fa-envelope text-primary mr-3"></i>{{ setting('email') }}</p>
                    <p class="mb-2" style="font-weight: bold;"><i
                            class="fa fa-phone-alt text-primary mr-3"></i>{{ setting('phone') }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

@endsection