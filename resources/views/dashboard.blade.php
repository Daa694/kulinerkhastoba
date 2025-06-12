@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-[#2E5A43] mb-6">Daftar Kuliner</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-[#2E5A43] text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Harga</th>
                    <th class="py-3 px-4 text-left">Detail</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($kuliners as $kuliner)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $kuliner->nama }}</td>
                    <td class="py-3 px-4">Rp {{ number_format($kuliner->harga, 0, ',', '.') }}</td>
                    <td class="py-3 px-4">{{ $kuliner->detail }}</td>
                    <td class="py-3 px-4">
                        <div class="flex gap-2">
                            <a href="{{ route('kuliner.edit', $kuliner->id) }}" 
                               class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('kuliner.destroy', $kuliner->id) }}" 
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
