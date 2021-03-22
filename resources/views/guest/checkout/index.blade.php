@extends('layouts.app')

@section('root', 'checkout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session()->has('error-payment-message'))
                    <div class="alert alert-danger">
                        {{ session()->get('error-payment-message') }}
                    </div>
                @endif
                <h1>Checkout</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <h3>Billing Details</h3>
                <form id="payment-form" action="{{ route('checkout.store') }}" method="POST" @submit.prevent="handleSubmission()">
                    @csrf
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" name="address" id="address" v-model="address">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input class="form-control" name="city" id="city" v-model="city">
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <input class="form-control" name="province" id="province" v-model="province">
                    </div>
                    <div class="form-group">
                        <label>Postal code</label>
                        <input class="form-control" name="postalcode" id="postalcode" v-model="postalcode">
                    </div>
                    <h3>Payment details</h3>
                    <div class="form-group">
                        <label for="name_on_card">Name on Card</label>
                        <input type="text" class="form-control" id="name_on_card" name="name_on_card" v-model="nameOnCard">
                    </div>

                    @if (session()->has('order_id'))
                        <div class="form-group">
                            <input type="hidden" name="order_id" value="{{ session()->get('order_id') }}">
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="card-element">
                            Credit or debit card
                        </label>
                        <div id="card-element">
                            <!-- a Stripe Element will be inserted here -->
                        </div>

                        <!-- Used to display form errors -->
                        <div id="card-errors" role="alert">
                            @{{ cardError }}
                        </div>
                    </div>
                    <div class="spacer"></div>

                    <button type="submit" id="complete-order" class="btn btn-primary w-100">Complete Order</button>
                </form>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <h3>Your order</h3>
                    </div>
                </div>
                @foreach (Cart::content() as $product)
                    <div class="row mb-4 border-bottom border-dark text-right">
                        <div class="col-12 col-md-3">
                            <img class="mb-4" src="{{ asset('storage/' . $product->model->image) }}">
                        </div>
                        <div class="col-12 col-md-3">
                            <p>{{ $product->model->name }}</p>
                        </div>
                        <div class="col-12 col-md-3">
                            <p>{{ $product->qty }}</p>
                        </div>
                        <div class="col-12 col-md-3">
                            <p>€ {{ $product->model->price }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="row text-right">
                    <div class="col-12">
                        <p>Total: € {{ Cart::subTotal() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
