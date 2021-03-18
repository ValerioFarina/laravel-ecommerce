@extends('layouts.app')

@section('content')
    <div id="cart" class="container">
        <div class="row">
            <div class="col-12">
                <h1>
                    @if (Cart::count() == 0)
                        The cart is empty
                    @elseif (Cart::count() == 1)
                        There is 1 item in the cart
                    @else
                        There are @{{ cartCount() }} items in the cart
                    @endif
                </h1>
                @if (Cart::count() > 0)
                    <ul class="list-unstyled">
                        <li v-for="(product, id) in cart" class="d-flex justify-content-between align-items-center flex-wrap border border-dark pr-2">
                            <img :src="'storage/' + product.model.image">
                            <a :href="'/products/' + product.model.slug">
                                <h5>@{{ product.name }}</h5>
                            </a>
                            <form :action="'/cart/' + product.rowId + '/delete'" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                            <div>
                                <input type="number" v-model="product.qty" name="quantity" @change="updateQuantity(id)" min="1" :max="product.model.quantity">
                            </div>
                            <p>€ @{{ product.price }}</p>
                        </li>
                        <li class="d-flex justify-content-end align-items-center border border-dark mb-4 pr-2">
                            <p>Total: € @{{ cartSubtotal() }}</p>
                        </li>
                    </ul>
                    <form action="{{ route('cart.empty') }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Empty the cart</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
