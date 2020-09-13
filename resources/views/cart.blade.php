@extends('layouts.app')

@section('content')
{{-- {{ dd($result) }} --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action={{ route('addOrder') }} method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">Shopping Cart: <span id="product_count">{{ $cart_products->count() }}</span> item(s)</div>

                    <div class="card-body p-0">
                        <table id="product_table" class="table table-striped table-bordered mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:20%">ID</th>
                                    <th style="width:55%">Name</th>
                                    <th style="width:15%">Quantity</th>
                                    <th style="width:10%">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
@foreach ($cart_products as $cart_product)
                                <tr>
                                    <input name="product_id[]" type="hidden" value="{{ $cart_product->product_id }}" >
                                    <td>{{ $cart_product->product_id }}</td>
                                    <input name="product_name[]" type="hidden" value="{{ $cart_product->product_name }}" >
                                    <td>{{ $cart_product->product_name }}</td>
                                    <td><input type="number" name="product_quantity[]" style="width:80px" min="1" value="1" required></td>
                                    <td><button type="button" class="deleteProductButton btn btn-secondary">&times;</button></td>
                                </tr>
@endforeach                      
                            </tbody>
                        </table>
                    </div>
                    {{-- end of card body --}}
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" class="checkOutButton btn {{ $cart_products->count()==0 ? 'btn-danger' : 'btn-primary' }}"@if($cart_products->count()==0) {{'disabled'}} @endif>Check Out</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal"><!-- Loading spinning thing for CheckOut --></div>
@endsection
