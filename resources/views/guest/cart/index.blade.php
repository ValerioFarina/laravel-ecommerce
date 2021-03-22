@extends('layouts.app')

@section('root', 'cart')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="pb-4 mb-4 border-bottom border-dark">
                    @if (Cart::count() == 0)
                        The cart is empty
                    @elseif (Cart::count() == 1)
                        There is 1 item in the cart
                    @else
                        There are @{{ cartCount() }} items in the cart
                    @endif
                </h1>
            </div>
        </div>
        @if (Cart::count() > 0)
            <div class="row text-md-right">
                <div class="col-12">
                    <div v-for="(product, id) in cart" class="row mb-4 border-bottom border-dark">
                        <div class="col-12 col-md-4">
                            <img class="mb-4" :src="'storage/' + product.model.image">
                        </div>
                        <div class="col-12 col-xs-6 col-md-4">
                            <div class="row">
                                <div class="col-6">
                                    <a :href="'/products/' + product.model.slug">
                                        <h5>@{{ product.name }}</h5>
                                    </a>
                                </div>
                                <div class="col-6 text-right">
                                    <form :action="'/cart/' + product.rowId + '/delete'" method="POST" class="mb-2">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xs-6 col-md-4">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" v-model="product.qty" name="quantity" @change="updateQuantity(id)" min="1" :max="product.model.quantity">
                                </div>
                                <div class="col-6 text-right">
                                    <p>€ @{{ product.price }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="col-12">
                            <p>Total: € @{{ cartSubtotal() }}</p>
                            <a href="{{ route('checkout.index') }}" class="btn btn-success">Checkout</a>
                        </div>
                    </div>
                    <div class="row text-left">
                        <div class="col-12">
                            <form action="{{ route('cart.empty') }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Empty the cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
