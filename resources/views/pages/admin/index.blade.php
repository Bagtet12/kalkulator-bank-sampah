<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Jenis Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('admin.create') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mb-4">Tambah Jenis Sampah Baru</a>

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    <table class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nama Sampah</th>
                                <th class="border px-4 py-2">Deskripsi</th>
                                <th class="border px-4 py-2">Foto</th>
                                <th class="border px-4 py-2">Harga per Kg</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sampah as $sampah)
                            <tr>
                                <td class="border px-4 py-2">{{ $sampah->nama }}</td>
                                <td class="border px-4 py-2">{{ $sampah->deskripsi }}</td>
                                <td class="border px-4 py-2">
                                    <img src="{{ asset('sampah_foto/' . $sampah->foto) }}" alt="{{ $sampah->nama }}">
                                </td>
                                <td class="border px-4 py-2">{{ $sampah->harga_kg }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.edit', $sampah->id) }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-1 px-2 rounded">Edit</a>
                                    <form action="{{ route('admin.destroy', $sampah->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-black font-bold py-1 px-2 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis sampah ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>