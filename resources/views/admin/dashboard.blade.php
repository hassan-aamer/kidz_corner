@extends('admin.layouts.master')
@section('title', __('translation.dashboard'))
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Welcome ( {{ Auth::user()->name ?? '' }} )</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <!-- stats with icon -->
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span
                                            class="text-muted text-uppercase fs-12 fw-bold">{{ __('attributes.products') }}</span>
                                        <h3 class="mb-0">{{ $count['products'] }}</h3>
                                    </div>
                                    <div class="align-self-center flex-shrink-0">
                                        <span class="icon-lg icon-dual-primary" data-feather="shopping-bag"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span
                                            class="text-muted text-uppercase fs-12 fw-bold">{{ __('attributes.categories') }}</span>
                                        <h3 class="mb-0">{{ $count['categories'] }}</h3>
                                    </div>
                                    <div class="align-self-center flex-shrink-0">
                                        <span class="icon-lg icon-dual-warning" data-feather="coffee"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span
                                            class="text-muted text-uppercase fs-12 fw-bold">{{ __('attributes.orders') }}</span>
                                        <h3 class="mb-0">{{ $count['orders'] }}</h3>
                                    </div>
                                    <div class="align-self-center flex-shrink-0">
                                        <span class="icon-lg icon-dual-success" data-feather="shopping-bag"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span
                                            class="text-muted text-uppercase fs-12 fw-bold">{{ __('attributes.contuct') }}</span>
                                        <h3 class="mb-0">{{ $count['contacts'] }}</h3>
                                    </div>
                                    <div class="align-self-center flex-shrink-0">
                                        <span class="icon-lg icon-dual-info" data-feather="file-text"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- content -->
        </div>
    </div>
@endsection
