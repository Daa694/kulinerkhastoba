<?php
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#2E5A43]">Kelola Menu</h1>
        <a href="{{ route('admin.kuliner.create') }}" 
           class="bg-[#2E5A43] text-white px-4 py-2 rounded-lg hover:bg-[#244934]">
            Tambah Menu
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-[#2E5A43] text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($kuliners as $kuliner)
                <tr>
                    <td class="px-6 py-4">{{ $kuliner->nama }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">Aktif</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" 
                               class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection