<x-app-layout>
    @section('navbar')
    @include('layouts.navigation_user')
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-4 ml-2">
                    <a href="{{ route('user.dashboard', ['id' => Auth::user()->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mb-4">Dashboard User</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Pilih Jenis Sampah</h3>
                    <form method="POST" action="{{route('user.proses')}}">
                        @csrf
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Jenis Sampah</label>
                            <select name="nama" id="nama" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm">
                                @foreach($sampah as $sampahItem)
                                <option value="{{ $sampahItem->id }}">{{ $sampahItem->nama }} (Rp {{ $sampahItem->harga_kg }}/Kg)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="jumlah_kg" class="block text-sm font-medium text-gray-700">Jumlah Sampah (kg)</label>
                            <input type="number" name="jumlah_kg" id="jumlah_kg" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm" min="0" required>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-black rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Hitung Harga</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>