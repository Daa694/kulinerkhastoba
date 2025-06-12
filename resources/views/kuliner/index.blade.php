@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[#2E5A43]">Daftar Kuliner</h1>
            @if(auth()->user() && auth()->user()->role === 'admin')                <a href="{{ route('admin.kuliner.create') }}" 
                   class="bg-[#2E5A43] text-white px-4 py-2 rounded hover:bg-[#244934]">
                    <i class="fas fa-plus"></i> Tambah Kuliner
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-[#2E5A43] text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Nama</th>
                        <th class="py-3 px-4 text-left">Harga</th>
                        <th class="py-3 px-4 text-left">Detail</th>
                        @if(auth()->user() && auth()->user()->role === 'admin')
                            <th class="py-3 px-4 text-left">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($kuliners as $kuliner)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $kuliner->nama }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">{{ $kuliner->detail }}</td>
                        @if(auth()->user() && auth()->user()->role === 'admin')
                            <td class="py-3 px-4">
                                <div class="flex gap-2">                                    <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" 
                                       class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuliner ini?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection