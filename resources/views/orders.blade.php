@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('success') || session('error'))
            <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dimissible fade show" role="alert">
                {{ session('success') }}{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card">
                <div class="card-header">Total pending: <span id="product_count">{{ $pending_count }}</span> order(s)</div>

                <div class="card-body p-0">
                    <table id="product_table" class="table table-striped table-bordered mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:20%">ID</th>
                                <th style="width:50%">Date Time Created</th>
                                <th style="width:15%">Status</th>
                                <th style="width:15%">Details</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
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
                                    <a href='/orders/{{ $order->id }}' class="selectOrder btn btn-secondary">View</a>
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
