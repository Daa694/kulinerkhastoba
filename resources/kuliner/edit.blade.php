
@extends('layouts.app')

@section('content')
<form action="{{ route('kuliner.update', $kuliner->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="nama" value="{{ $kuliner->nama }}" placeholder="Nama Kuliner" required>
    <input type="number" name="harga" value="{{ $kuliner->harga }}" placeholder="Harga" required>
    <input type="text" name="gambar_kuliner" value="{{ $kuliner->gambar_kuliner }}" placeholder="Nama File Gambar">
    <input type="number" step="0.1" name="rating" value="{{ $kuliner->rating }}" placeholder="Rating">
    <button type="submit">Update</button>
</form>
@endsection