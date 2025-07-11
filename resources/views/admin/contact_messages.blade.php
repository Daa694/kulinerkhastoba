@extends('layouts.app')

@section('title', 'Pesan Kontak User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-[#2E5A43] mb-6">Pesan Kontak User</h2>
    <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-sm font-semibold mb-1">Nama</label>
            <input type="text" name="name" value="{{ request('name') }}" class="border rounded px-3 py-2 text-sm" placeholder="Cari nama...">
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Email</label>
            <input type="text" name="email" value="{{ request('email') }}" class="border rounded px-3 py-2 text-sm" placeholder="Cari email...">
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="border rounded px-3 py-2 text-sm">
        </div>
        <button class="bg-[#2E5A43] text-white px-4 py-2 rounded font-semibold hover:bg-[#1d3a29] text-sm" type="submit">Filter</button>
        <a href="{{ route('admin.contact.messages') }}" class="text-sm underline ml-2">Reset</a>
    </form>
    @if($messages->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500">Belum ada pesan masuk</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-[#2E5A43] text-white">
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Pesan</th>
                        <th class="px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $msg)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $msg->name }}</td>
                        <td class="px-4 py-2">{{ $msg->email }}</td>
                        <td class="px-4 py-2" style="max-width:350px;white-space:pre-line;word-break:break-word;">{{ $msg->message }}</td>
                        <td class="px-4 py-2">{{ $msg->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
