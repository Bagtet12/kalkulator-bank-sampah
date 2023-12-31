<x-app-layout>
    @section('navbar')
    @include('layouts.navigation_user')
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-4 ml-2">
                    <a href="{{ route('user.index') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mb-4 space-y-4">Kembali</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Total Harga</h3>
                    <p>Total harga yang Anda dapatkan: Rp {{ $totalHarga }}</p>

                    <!-- Tambahkan informasi lainnya yang diperlukan -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>