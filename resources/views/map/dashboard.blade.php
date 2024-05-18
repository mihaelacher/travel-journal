@extends('layout')

@section('title', 'Travel Journal')

@section('vite-content')
    @vite(['resources/css/style.scss', 'resources/js/app.js'])
@endsection

@section('content')
    <div class="map-container">
        <div id="map"></div>
        <x-loader/>
    </div>

@endsection
