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
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Full Name:</strong>
                                        <span class="text-dark">{{ $result->full_name ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Email:</strong>
                                        <span class="text-dark">{{ $result->email ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Phone:</strong>
                                        <span class="text-dark">{{ $result->phone ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">City:</strong>
                                        <span class="text-dark">{{ $result->city->title ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Shipping Price:</strong>
                                        <span class="text-dark">{{ $result->shipping_price ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Status:</strong>
                                        <span class="text-dark">{{ $result->status ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Payment Method:</strong>
                                        <span class="text-dark">{{ $result->payment_method ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Payment Status:</strong>
                                        <span class="text-dark">{{ $result->payment_status ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Total:</strong>
                                        <span class="text-dark">{{ $result->total ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Product Count:</strong>
                                        <span class="text-dark">{{ $result->items->count() ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong class="text-primary fw-bold">Created At:</strong>
                                        <span class="text-dark">{{ $result->created_at ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <strong class="text-primary fw-bold">Address:</strong>
                                        <span class="text-dark">{{ $result->address ?? '-' }}</span>
                                    </div>
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
