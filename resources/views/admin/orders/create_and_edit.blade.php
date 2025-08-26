@extends('admin.layouts.master')
@section('title', __('attributes.orders'))
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('attributes.orders') }}</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST"
                                action="{{ isset($result) && $result->id ? route('admin.orders.update', $result->id) : route('admin.orders.store') }}"
                                class="parsley-examples" enctype="multipart/form-data">
                                @csrf
                                @if (isset($result) && $result->id)
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-xl-6 col-sm-4">
                                        <div class="mb-3 mt-3 mt-sm-0">
                                            <label class="form-label">{{ __('attributes.status') }}</label>
                                            <select name="status"
                                                class="form-select wide @error('status') is-invalid @enderror"
                                                data-plugin="customselect" data-placeholder="{{ __('attributes.status') }}">
                                                <option value="pending"
                                                    {{ old('status', isset($result) ? $result->status : '') == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="confirmed"
                                                    {{ old('status', isset($result) ? $result->status : '') == 'confirmed' ? 'selected' : '' }}>
                                                    Confirmed</option>
                                                <option value="shipped"
                                                    {{ old('status', isset($result) ? $result->status : '') == 'shipped' ? 'selected' : '' }}>
                                                    Shipped</option>
                                                <option value="delivered"
                                                    {{ old('status', isset($result) ? $result->status : '') == 'delivered' ? 'selected' : '' }}>
                                                    Delivered</option>
                                                <option value="canceled"
                                                    {{ old('status', isset($result) ? $result->status : '') == 'canceled' ? 'selected' : '' }}>
                                                    Canceled</option>
                                            </select>

                                            @error('status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-4">
                                        <div class="mb-3 mt-3 mt-sm-0">
                                            <label class="form-label">{{ __('attributes.payment_method') }}</label>
                                            <select name="payment_method"
                                                class="form-select wide @error('payment_method') is-invalid @enderror"
                                                data-plugin="customselect"
                                                data-placeholder="{{ __('attributes.payment_method') }}">
                                                <option value="cash"
                                                    {{ old('payment_method', isset($result) ? $result->payment_method : '') == 'cash' ? 'selected' : '' }}>
                                                    Cash</option>
                                                <option value="credit_card"
                                                    {{ old('payment_method', isset($result) ? $result->payment_method : '') == 'credit_card' ? 'selected' : '' }}>
                                                    Credit Card</option>
                                                <option value="visa"
                                                    {{ old('payment_method', isset($result) ? $result->payment_method : '') == 'visa' ? 'selected' : '' }}>
                                                    Visa</option>
                                                <option value="instapay"
                                                    {{ old('payment_method', isset($result) ? $result->payment_method : '') == 'instapay' ? 'selected' : '' }}>
                                                    Instapay</option>
                                            </select>

                                            @error('payment_method')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-4">
                                        <div class="mb-3 mt-3 mt-sm-0">
                                            <label class="form-label">{{ __('attributes.payment_status') }}</label>
                                            <select name="payment_status"
                                                class="form-select wide @error('payment_status') is-invalid @enderror"
                                                data-plugin="customselect"
                                                data-placeholder="{{ __('attributes.payment_status') }}">
                                                <option value="pending"
                                                    {{ old('payment_status', isset($result) ? $result->payment_status : '') == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="completed"
                                                    {{ old('payment_status', isset($result) ? $result->payment_status : '') == 'completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                                <option value="failed"
                                                    {{ old('payment_status', isset($result) ? $result->payment_status : '') == 'failed' ? 'selected' : '' }}>
                                                    Failed</option>
                                            </select>

                                            @error('payment_status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @include('admin.components.submit')

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
