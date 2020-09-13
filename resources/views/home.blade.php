@extends('layouts.app')

@section('content')
{{-- {{ dd($result) }} --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Number of products: {{ $total_products }}</div>

                <div class="card-body p-0">
                    <table id="product_table" class="table table-striped table-bordered mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>In Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach ($result as $row)
                            <tr>
                                <td>{{ $row['id'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['regular_price']==='' ? 'Null' : $row['regular_price'] }}</td>
                                <td>{{ $row['in_stock'] ? 'Yes' : 'No' }}</td>
                                <td><button type="button" class="addToCartButton btn btn-secondary">Add to Cart</button></td>
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

<div class="modal"><!-- Loading spinning thing for AddToCart --></div>
@endsection
