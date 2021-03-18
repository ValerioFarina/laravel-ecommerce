@extends('layouts.app')

@section('content')
    <div id="guest-products-show" class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{ $product->name }}</h1>
                <h3>{{ $product->brand }}</h3>
                <div class="img-container">
                    <img src="{{ asset("storage/{$product->image}") }}" class="mw-100">
                </div>
                <ul class="list-unstyled">
                    <li class="p-2">
                        <strong>Price:</strong>
                        <span>€ {{ $product->price }}</span>
                    </li>
                    <li class="p-2">
                        <strong>Category:</strong>
                        <span>{{ $product->category ? $product->category->name : '' }}</span>
                    </li>
                    <li class="p-2">
                        <strong>Description:</strong>
                        <p>{{ $product->description }}</p>
                    </li>
                    <li class="p-2">
                        <form ref="addToCart" action="{{ route('cart.store') }}" method="POST" @submit.prevent="addToCart({{ $product->id }}, {{ $product->quantity }})">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <button type="submit" class="btn btn-success">Add to cart</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
