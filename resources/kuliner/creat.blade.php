
<!-- filepath: resources/views/kuliner/create.blade.php -->
@extends('layouts.app')

@section('content')
<form action="{{ route('kuliner.store') }}" method="POST">
    @csrf
    <input type="text" name="nama" placeholder="Nama Kuliner" required>
    <input type="number" name="harga" placeholder="Harga" required>
    <input type="text" name="gambar_kuliner" placeholder="Nama File Gambar">
    <input type="number" step="0.1" name="rating" placeholder="Rating">
    <button type="submit">Simpan</button>
</form>
@endsection