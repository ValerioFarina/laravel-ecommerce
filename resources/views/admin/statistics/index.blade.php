@extends('layouts.dashboard')

@section('extra-js')
    <script>
        var productId = undefined;
    </script>
@endsection

@section('content')
    <div id="statistics" class="container">
        <div class="row">
            <div class="col-12">
                <h1>Sales statistics</h1>
                <select name="year" @change="getData()" v-model="year">
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
                <select name="dataset" @change="getData()" v-model="dataset">
                    <option value="items">Number of items sold</option>
                    <option value="revenues">Revenues</option>
                </select>
                <select v-model="productFilter" @change="changeProductFilter()">
                    <option value="all">All products</option>
                    <option value="product type">Select a product type</option>
                    <option value="single product">Select a single product</option>
                </select>
                <span v-if="productFilter != 'all'">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <select name="type" @change="getData()" v-model="productType" v-if="productFilter == 'product type'">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="product" @change="getData()" v-model="productId" v-if="productFilter == 'single product'">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <canvas id="myChart" width="400" height="280"></canvas>
            </div>
        </div>
    </div>
@endsection
