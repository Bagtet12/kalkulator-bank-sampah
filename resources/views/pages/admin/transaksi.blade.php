<x-app-layout>
    @section('navbar')
    @include('layouts.navigation_admin')
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-4 ml-2">
                    <a href="{{ route('admin.index') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mb-4 space-y-4">Dashboard Admin</a>
                    <a href="{{ route('admin.transaksi') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mb-4 space-y-4">Verifikasi Transkasi</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">

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
                                <th class="border px-4 py-2">Nama User</th>
                                <th class="border px-4 py-2">Jumlah</th>
                                <th class="border px-4 py-2">Total Harga</th>
                                <th class="border px-4 py-2">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $transaksi)
                            <tr>
                                <td class="border px-4 py-2 text-center">{{ $transaksi->nama_sampah }}</td>
                                <td class="border px-4 py-2 text-center">{{ $transaksi->nama_user }}</td>
                                <td class="border px-4 py-2 text-center">{{ $transaksi->kg }}</td>
                                <td class="border px-4 py-2 text-center">{{ $transaksi->harga }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($transaksi->verifikasi == 'Belum Verifikasi')
                                        <form action="{{ route('admin.verifikasi', $transaksi->transaksi_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-black font-bold py-1 px-2 rounded">Verifikasi</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.verifikasi', $transaksi->transaksi_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-black font-bold py-1 px-2 rounded">Batalkan Verifikasi</button>
                                        </form>
                                    @endif
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