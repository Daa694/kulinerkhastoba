<form action="{{ route('kuliner.destroy', $kuliner->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus kuliner ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Hapus Kuliner
    </button>
</form>
