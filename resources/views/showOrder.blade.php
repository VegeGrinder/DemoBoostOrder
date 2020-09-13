@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if ($updated == 1)
                <div class="alert alert-primary alert-dimissible fade show" role="alert">
                    This order status is changed by Admin!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 align-self-center">Order number ({{ $order->id }}) at {{ $order->created_at }}</div>
                        <div class="col-md-6 align-self-center">
                            <span>Status: </span>
                            @if ($order->status == 0)
                                <span id="status" style='color:black'>Pending</span>
                            @elseif ($order->status == 1)
                                <span id="status" style='color:green'>Accepted</span>
                            @else
                                <span id="status" style='color:red'>Rejected</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table id="product_table" class="table table-striped table-bordered mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:20%">ID</th>
                                <th style="width:60%">Product Name</th>
                                <th style="width:20%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach ($order_products as $order_product)
                            <tr>
                                <td>{{ $order_product->product_id }}</td>
                                <td>{{ $order_product->product_name }}</td>
                                <td>{{ $order_product->product_quantity }}</td>
                            </tr>
@endforeach                      
                        </tbody>
                    </table>
                </div>
                {{-- end of table container --}}
            </div>
        </div>
    </div>
</div>
@endsection
