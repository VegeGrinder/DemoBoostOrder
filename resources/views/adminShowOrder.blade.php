@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div id="alert">
                {{-- for alert after AJAX --}}
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 align-self-center">Order number (<span id="order_id">{{ $order->id }}</span>) at {{ $order->created_at }} by User ({{ $order->user_id }})</div>
                        <div class="col-md-2 align-self-center"><span>Status: </span>
                            @if ($order->status == 0)
                                <span id="status" style='color:black'>Pending</span>
                            @elseif ($order->status == 1)
                                <span id="status" style='color:green'>Accepted</span>
                            @else
                                <span id="status" style='color:red'>Rejected</span>
                            @endif
                        </div>
                        <div class="col-md-2 text-right align-self-center">Action: </div>
                        <div class="col-md-2">
                            <select class="adminOrderSelect form-control">
                                <option disabled selected>-</option>
                                <option value="1">Accept</option>
                                <option value="2">Reject</option>
                            </select>
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
