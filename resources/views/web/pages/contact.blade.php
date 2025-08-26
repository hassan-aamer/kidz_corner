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
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Contact</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Contact</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Contact For Any Queries</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form action="{{ route('contact.store') }}" method="post">
                        @csrf
                        <div class="control-group">
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Your Name" required="required"
                                data-validation-required-message="Please enter your name" />
                            <p class="help-block text-danger"></p>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Your Email" required="required"
                                data-validation-required-message="Please enter your email" />
                            <p class="help-block text-danger"></p>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control  @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="phone" required="required"
                                data-validation-required-message="Please enter a phone number" />
                            <p class="help-block text-danger"></p>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="control-group">
                            <textarea class="form-control  @error('message') is-invalid @enderror" rows="6" id="message" name="message"
                                placeholder="Message" required="required" data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-semi-bold mb-3">{{ setting('name') }}</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{ setting('address') }}</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ setting('email') }}</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ setting('phone') }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

@endsection
