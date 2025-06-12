@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#2E5A43]">Kelola Menu Kuliner</h1>
        <a href="{{ route('admin.kuliner.create') }}" 
           class="bg-[#2E5A43] text-white px-4 py-2 rounded hover:bg-[#244934] transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Menu Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-[#2E5A43] text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Gambar</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Stok</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kuliners as $kuliner)
                    <tr>
                        <td class="px-6 py-4">                            @if($kuliner->gambar)
                                <img src="{{ asset('storage/' . $kuliner->gambar) }}" 
                                     alt="{{ $kuliner->nama }}" 
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $kuliner->nama }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $kuliner->stok }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                       {{ $kuliner->tersedia ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $kuliner->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.kuliner.edit', $kuliner) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.kuliner.destroy', $kuliner) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada menu kuliner yang ditambahkan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
