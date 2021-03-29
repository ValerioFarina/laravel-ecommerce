@extends('layouts.dashboard')

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
                <canvas id="myChart" width="400" height="280"></canvas>
            </div>
        </div>
    </div>
@endsection
