<x-app-layout>
    @section('navbar')
    @include('layouts.navigation_user')
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-4 ml-2">
                    <a href="{{ route('user.index') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mb-4">Home User</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto border-2 w-full">
                        <thead>
                            <tr>
                                <th class="border-2">Nama Sampah</th>
                                <th class="border-2">Jumlah/Kg</th>
                                <th class="border-2">Price</th>
                                <th class="border-2">Status</th>
                                <th class="border-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $transaction)
                            <tr>
                                <td class="border-2 text-center">{{ $transaction->nama }}</td>
                                <td class="border-2 text-center">{{ $transaction->jumlah_kg }}/Kg</td>
                                <td class="border-2 text-center">Rp. {{ $transaction->total_harga }}</td>
                                <td class="border-2 text-center">{{ $transaction->verifikasi }}</td>
                                <td class="border-2 text-center">{{ $transaction->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Di dalam view Blade Anda -->
                    <div id="grafik-batang" class="p-6 bg-white border-t border-gray-200">
                        <canvas id="myBarChart" width="400" height="200"></canvas>
                    </div>
                    <!-- Sisipkan script JavaScript untuk membuat grafik -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Mengambil data dari variabel $transaksi
                        var transaksiData = @json($verifiedTransaksi);

                        // Objek untuk menyimpan total harga per jenis sampah
                        var totalHargaPerSampah = {};

                        // Loop melalui data transaksi untuk menghitung total harga per jenis sampah
                        transaksiData.forEach(function(transaksi) {
                            var jenisSampah = transaksi.nama;
                            var harga = transaksi.harga;
                        
                            if (!totalHargaPerSampah[jenisSampah]) {
                                totalHargaPerSampah[jenisSampah] = 0;
                            }
                        
                            totalHargaPerSampah[jenisSampah] += harga;
                        });
                    
                        // Membuat array label (jenis sampah) dan data (total harga)
                        var labels = Object.keys(totalHargaPerSampah);
                        var data = Object.values(totalHargaPerSampah);
                    
                        // Membuat grafik batang dengan Chart.js
                        var ctx = document.getElementById('myBarChart').getContext('2d');
                        var myBarChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Harga per Jenis Sampah yang sudah Verifikasi',
                                    data: data,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
