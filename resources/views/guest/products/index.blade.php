@extends('layouts.app')

@section('content')
    <div id="guest-products-index" class="container">
        <div class="row">
            <div class="col-12">
                @if (session()->has('success-payment-message'))
                    <div class="alert alert-success">
                        {{ session()->get('success-payment-message') }}
                    </div>
                @endif
                <div class="product-container d-flex flex-wrap">
                    @foreach ($products as $product)
                        <a href="{{ route('guest.products.show', ['product' => $product->slug]) }}" class="card m-4" style="width: 18rem;">
                            <img class="card-img-top" src="{{ asset("storage/{$product->image}") }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $product->brand }}</h6>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
