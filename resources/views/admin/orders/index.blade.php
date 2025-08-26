@extends('admin.layouts.master')
@section('title', __('attributes.orders'))

@section('content')

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">

                            {{-- <a class="btn btn-success"
                                href="{{ route('admin.orders.create') }}">{{ __('attributes.create') }}</a> --}}

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <h4 class="header-title mt-0 mb-1">{{ __('attributes.orders') }}</h4>
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('attributes.name')</th>
                                            {{-- <th>@lang('attributes.email')</th> --}}
                                            <th>@lang('attributes.phone')</th>
                                            <th>@lang('attributes.product_count')</th>
                                            <th>@lang('attributes.total')</th>
                                            <th>@lang('attributes.shipping_price')</th>
                                            <th>@lang('attributes.status')</th>
                                            <th>@lang('attributes.payment_method')</th>
                                            <th>@lang('attributes.payment_status')</th>
                                            {{-- <th>@lang('attributes.created_at')</th> --}}
                                            <th>@lang('attributes.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($result->count())
                                            @foreach ($result as $order)
                                                <tr id="row-{{ $order->id ?? '' }}">
                                                    <td>{{ $loop->iteration ?? '' }}</td>
                                                    <td>{{ $order->full_name ?? '' }}</td>
                                                    {{-- <td>{{ $order->email ?? '' }}</td> --}}
                                                    <td>{{ $order->phone ?? '' }}</td>
                                                    <td>{{ $order->items->count() ?? '' }}</td>
                                                    <td>EGP {{ $order->total ?? '' }}</td>
                                                    <td>EGP {{ $order->shipping_price ?? '' }}</td>

                                                    <td>
                                                        @switch($order->status)
                                                            @case('pending')
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @break

                                                            @case('confirmed')
                                                                <span class="badge bg-info text-dark">Confirmed</span>
                                                            @break

                                                            @case('shipped')
                                                                <span class="badge bg-primary">Shipped</span>
                                                            @break

                                                            @case('delivered')
                                                                <span class="badge bg-success">Delivered</span>
                                                            @break

                                                            @case('canceled')
                                                                <span class="badge bg-danger">Canceled</span>
                                                            @break
                                                        @endswitch
                                                    </td>

                                                    <td>
                                                        @if ($order->payment_method == 'cash')
                                                            <span class="badge bg-secondary">Cash</span>
                                                        @elseif($order->payment_method == 'visa')
                                                            <span class="badge bg-primary">Visa</span>
                                                        @elseif($order->payment_method == 'instapay')
                                                            <span class="badge bg-success">InstaPay</span>
                                                        @endif
                                                    </td>


                                                    <td>
                                                        @switch($order->payment_status)
                                                            @case('pending')
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @break

                                                            @case('completed')
                                                                <span class="badge bg-success">Completed</span>
                                                            @break

                                                            @case('failed')
                                                                <span class="badge bg-danger">Failed</span>
                                                            @break
                                                        @endswitch
                                                    </td>

                                                    {{-- <td>{{ formatDate($order->created_at ?? '') }}</td> --}}

                                                    <td>

                                                        <a href="{{ route('admin.orders.show', $order->id) }}">
                                                            <button type="button" class="btn btn-primary btn-block">
                                                                <i class="fa uil-eye"></i>
                                                            </button>
                                                        </a>

                                                        <a href="{{ route('admin.orders.edit', $order->id) }}">
                                                            <button type="button" class="btn btn-warning btn-block "><i
                                                                    class="fa uil-edit"></i> </button>
                                                        </a>


                                                        <button type="button" class="btn btn-danger btn-block btn-delete"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete{{ $order->id }}">
                                                            <i class="fa uil-trash"></i>
                                                        </button>

                                                    </td>
                                                </tr>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete{{ $order->id }}" tabindex="-1"
                                                    role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myCenterModalLabel">
                                                                    @lang('attributes.delete') : <span
                                                                        class="text-danger">{{ $order->title }}</span>
                                                                </h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form id="deleteForm{{ $order->id }}"
                                                                action="{{ route('admin.orders.delete', $order->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <div class="modal-body">
                                                                    <p class="text-center text-danger fs-2 m-0 fw-bold">
                                                                        @lang('attributes.delete')
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-success"
                                                                        data-bs-dismiss="modal">
                                                                        @lang('attributes.close')
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger"
                                                                        onclick="deleteData({{ $order->id }})">
                                                                        @lang('attributes.delete')
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
@section('js')
    @include('admin.components.delete-script')
    <script>
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const Id = this.getAttribute('data-id');
                const status = this.checked ? 1 : 0;

                fetch("{{ route('admin.orders.status', app()->getLocale()) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: Id,
                        status: status
                    })
                })

            });
        });
    </script>

@endsection
