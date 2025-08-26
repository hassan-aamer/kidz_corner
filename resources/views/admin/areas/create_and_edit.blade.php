@extends('admin.layouts.master')
@section('title', __('attributes.area'))
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ __('attributes.area') }}</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST"
                                action="{{ isset($result) && $result->id ? route('admin.areas.update', $result->id) : route('admin.areas.store') }}"
                                class="parsley-examples" enctype="multipart/form-data">
                                @csrf
                                @if (isset($result) && $result->id)
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-xl-6 col-sm-4">
                                        <div class="mb-3 mt-3 mt-sm-0">
                                            <label class="form-label">{{ __('attributes.cities') }}</label>
                                            <select name="parent_id" data-plugin="customselect"
                                                class="form-select @error('parent_id') is-invalid @enderror"
                                                data-placeholder="{{ __('attributes.cities') }}">
                                                <option></option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ old('parent_id', isset($result) && $result->parent_id == $city->id ? 'selected' : '') }}>
                                                        {{ $city->title ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @include('admin.components.shipping_price')
                                    @include('admin.components.title')
                                    @include('admin.components.position')
                                    @include('admin.components.active')
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
