@extends('admin.layouts.master')
@section('title', __('attributes.orders_details'))

@section('content')

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                {{-- <div class="container-fluid"> --}}
                <div class="row justify-content-center" style="margin-top: 50px;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Customer Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Full Name :</strong> {{ $result->full_name ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Email :</strong> {{ $result->email ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Phone :</strong> {{ $result->phone ?? '-' }}</div>
                                    <div class="col-md-3"><strong>City :</strong> {{ $result->city->title ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Shipping Price :</strong>
                                        {{ $result->shipping_price ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Status :</strong> {{ $result->status ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Payment Method :</strong>
                                        {{ $result->payment_method ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Payment Status :</strong>
                                        {{ $result->payment_status ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Total :</strong>
                                        {{ $result->total ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Product Count :</strong>
                                        {{ $result->items->count() ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Created At :</strong>
                                        {{ $result->created_at ?? '-' }}</div>
                                </div>
                                <div class="row mb-12">
                                    <div class="col-md-3"><strong>Address :</strong> {{ $result->address ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </div> --}}

                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <h4 class="header-title mt-0 mb-1">{{ __('attributes.orders_details') }}</h4>
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('attributes.image')</th>
                                            <th>@lang('attributes.categories')</th>
                                            <th>@lang('attributes.title')</th>
                                            <th>@lang('attributes.price')</th>
                                            <th>@lang('attributes.quantity')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($result->count())
                                            @foreach ($result->items as $order)
                                                <tr id="row-{{ $order->id ?? '' }}">
                                                    <td>{{ $loop->iteration ?? '' }}</td>
                                                    <td><img src="{{ App\Helpers\Image::getMediaUrl($order->product, 'products') }}"
                                                            alt="products" width="100"
                                                            onclick="openImage('{{ App\Helpers\Image::getMediaUrl($order->product, 'products') }}')"
                                                            style="width: 100px; height: auto; cursor: pointer; transition: transform 0.3s;"
                                                            onmouseover="this.style.transform='scale(1.1)'"
                                                            onmouseout="this.style.transform='scale(1)'" loading="lazy">
                                                    </td>
                                                    <td>{{ $order->product->category->title ?? '' }}</td>
                                                    <td>{{ $order->product->title ?? '' }}</td>
                                                    <td>EGP {{ $order->product->price ?? '' }}</td>
                                                    <td>{{ $order->quantity ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center text-danger">
                                                    @lang('attributes.no_data_found')
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
                <!-- end row-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

@endsection
