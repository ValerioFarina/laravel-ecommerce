@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{ $product->name }}</h1>
                <h3>{{ $product->brand }}</h3>
                <div class="img-container">
                    <img src="{{ asset("storage/{$product->image}") }}" class="mw-100">
                </div>
                <ul>
                    <li>
                        <strong>Price:</strong>
                        <span>{{ $product->price }}</span>
                    </li>
                    <li>
                        <strong>Quantity:</strong>
                        <span>{{ $product->quantity }}</span>
                    </li>
                    <li>
                        <strong>Category:</strong>
                        <span>{{ $product->category ? $product->category->name : '' }}</span>
                    </li>
                    <li>
                        <strong>Description:</strong>
                        <p>{{ $product->description }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
