@extends('layouts.app')

@section('title', 'Laporan Keuangan - Admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Laporan Keuangan</h1>

    <!-- Filter -->
    <div class="bg-white rounded shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">Periode</label>
                <select name="period" class="border rounded px-3 py-2">
                    <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="weekly" {{ request('period') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Tahun</label>
                <input type="number" name="year" value="{{ request('year', date('Y')) }}" class="border rounded px-3 py-2 w-24">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-bold hover:bg-green-700">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Grafik Penjualan</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">{{ request('period') == 'monthly' ? 'Bulan' : 'Minggu' }}</th>
                        <th class="px-4 py-3 text-center">Jumlah Pesanan</th>
                        <th class="px-4 py-3 text-right">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr class="border-b">
                            <td class="px-4 py-3">
                                @if(request('period') == 'monthly')
                                    {{ strtotime('2025-' . $item->month . '-01') ? date('F', strtotime('2025-' . $item->month . '-01')) : 'Bulan ' . $item->month }}
                                @else
                                    Minggu {{ $item->week }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">{{ $item->orders }}</td>
                            <td class="px-4 py-3 text-right font-bold">Rp {{ number_format($item->revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-3 text-center col-span-3 text-gray-600">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
