@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Total pending: <span id="product_count">{{ $pending_count }}</span> order(s)</div>

                <div class="card-body p-0">
                    <table id="product_table" class="table table-striped table-bordered mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:15%">ID</th>
                                <th style="width:15%">User ID</th>
                                <th style="width:30%">Date Time Created</th>
                                <th style="width:15%">Status</th>
                                <th style="width:10%">Details</th>
                                <th style="width:15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user_id }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    @if ($order->status == 0)
                                        <span style='color:black'>Pending</span>
                                    @elseif ($order->status == 1)
                                        <span style='color:green'>Accepted</span>
                                    @else
                                        <span style='color:red'>Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href='/admin/orders/{{ $order->id }}' class="selectOrder btn btn-secondary">View</a>
                                </td>
                                <td>
                                    <select class="adminHomeSelect form-control">
                                        <option disabled selected>-</option>
                                        <option value="1">Accept</option>
                                        <option value="2">Reject</option>
                                    </select>
                                </td>
                            </tr>
@endforeach                      
                        </tbody>
                    </table>
                </div>
                {{-- end of table container --}}
            </div>
            {{-- end of card --}}
        </div>
    </div>
</div>

<div class="modal"><!-- Loading spinning thing for CheckOut --></div>
@endsection
