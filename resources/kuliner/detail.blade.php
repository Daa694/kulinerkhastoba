
@extends('layouts.app')

@section('content')
    <h2>{{ $kuliner->nama }}</h2>
    <p>Harga: Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</p>
    <p>Rating: {{ $kuliner->rating }}</p>
    <img src="{{ asset('images/' . $kuliner->gambar_kuliner) }}" alt="{{ $kuliner->nama }}" width="200">
    <br>
    <a href="{{ route('kuliner.index') }}">Kembali ke daftar</a>
@endsection