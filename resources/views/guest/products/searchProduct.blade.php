@extends('layouts.app')

@section('extra-js')
    <script>
        var searched = "{{ $searched }}";
    </script>
@endsection

@section('content')
    <div id="search-product" class="container">
        <div class="row">
            <div class="col-12">
                <h1>
                    @if ($products->count() == 1)
                        {{ $products->count() }} result found for "{{ $searched }}"
                    @else
                        {{ $products->count() }} results found for "{{ $searched }}"
                    @endif
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" @click.prevent="showFilters = true" v-if="!showFilters">Show filters</a>
                <div id="filters-menu" v-if="showFilters" class="mb-4">
                    <select name="category" v-model="category">
                        <option value="">-- select category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                        <option :value="null">other</option>
                    </select>
                    <div>
                        <label>Max price:</label>
                        <input type="number" v-model="maxPrice" min="0" max="99999.99" step="0.1">
                    </div>
                    <div class="actions">
                        <button class="btn btn-danger" @click="resetFilters()">Reset filters</button>
                    </div>
                    <div class="close" @click="showFilters = false">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="order-by-price">
                    <label>Order by price:</label>
                    <select v-model="order" @change="orderByPrice()">
                        <option :value="null">random</option>
                        <option value="desc">From the most expensive</option>
                        <option value="asc">From the least expensive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-container d-flex flex-wrap" v-if="sortedProducts.length == 0">
                    @foreach ($products as $product)
                        <a href="{{ route('guest.products.show', ['product' => $product->slug]) }}" class="card m-4" style="width: 18rem;" v-if="checkCategory({{ $product->category_id }}) && checkPrice({{ $product->price }})">
                            <img class="card-img-top" src="{{ asset("storage/{$product->image}") }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $product->brand }}</h6>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="product-container d-flex flex-wrap" v-else>
                    <a v-for="product in sortedProducts" :href="'/products/' + product.slug" class="card m-4" style="width: 18rem;" v-if="checkCategory(product['category_id']) && checkPrice(product.price)">
                        <img class="card-img-top" :src="'storage/' + product.image" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">@{{ product.name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">@{{ product.brand }}</h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

