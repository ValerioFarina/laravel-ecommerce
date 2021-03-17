@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if ($products->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->slug }}</td>
                                <td>actions</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h1>There are no products</h1>
                @endif
            </div>
        </div>
    </div>
@endsection
