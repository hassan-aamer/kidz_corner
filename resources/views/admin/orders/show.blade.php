@extends('admin.layouts.master')
@section('title', __('attributes.orders_details'))

@section('content')

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                        </div>
                    </div>
                </div>
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
