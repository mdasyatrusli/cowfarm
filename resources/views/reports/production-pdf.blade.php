<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Produksi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .meta { color: #6b7280; margin-bottom: 16px; }
        .cards { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .cards td { width: 33%; border: 1px solid #e5e7eb; padding: 8px; vertical-align: top; }
        .cards .label { color: #6b7280; font-size: 11px; }
        .cards .value { font-size: 15px; font-weight: bold; margin-top: 2px; }
        .section-title { font-size: 14px; font-weight: bold; margin: 18px 0 8px; }
        table.report { width: 100%; border-collapse: collapse; }
        table.report th, table.report td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        table.report th { background: #f3f4f6; font-size: 11px; text-transform: uppercase; }
        table.report td.num { text-align: right; }
        table.report tfoot td { font-weight: bold; background: #f9fafb; }
        .bar-wrap { background: #e5e7eb; height: 12px; width: 100%; border-radius: 3px; }
        .bar-volume { background: #6366f1; height: 12px; border-radius: 3px; }
        .text-indigo { color: #4f46e5; }
        .text-red { color: #dc2626; }
        .text-green { color: #16a34a; }
        .footer { margin-top: 24px; color: #9ca3af; font-size: 10px; text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Produksi</h1>
    <div class="meta">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
        &ndash; {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        @if ($selectedFarmName)
            | Farm: {{ $selectedFarmName }}
        @endif
        <br>
        Dicetak: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
    </div>

    <table class="cards">
        <tr>
            <td>
                <div class="label">Total Produksi Susu</div>
                <div class="value text-indigo">{{ number_format($totalMilkLiters, 2, ',', '.') }} L</div>
            </td>
            <td>
                <div class="label">Total Biaya Kesehatan</div>
                <div class="value text-red">Rp {{ number_format($totalHealthCost, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Sapi Aktif</div>
                <div class="value text-green">{{ $totalActiveCows }} Ekor</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Tren Produksi Susu Harian</div>
    @if (count($chartDates) > 0)
        @php
            $maxVol = max($chartVolumes) > 0 ? max($chartVolumes) : 1;
        @endphp
        <table class="report">
            <thead>
                <tr>
                    <th style="width:120px;">Tanggal</th>
                    <th>Volume</th>
                    <th class="num">Liter</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chartDates as $i => $date)
                    @php
                        $pct = ($chartVolumes[$i] / $maxVol) * 100;
                    @endphp
                    <tr>
                        <td>{{ $date }}</td>
                        <td>
                            <div class="bar-wrap"><div class="bar-volume" style="width: {{ $pct }}%"></div></div>
                        </td>
                        <td class="num">{{ number_format($chartVolumes[$i], 1, ',', '.') }} L</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data untuk periode ini.</p>
    @endif

    <div class="section-title">Populasi Sapi per Jenis (Breed)</div>
    <table class="report">
        <thead>
            <tr>
                <th>Jenis</th>
                <th class="num">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cowsPerBreed as $breed)
                <tr>
                    <td>{{ $breed->name }}</td>
                    <td class="num">{{ $breed->cows_count }} ekor</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align:center;">Belum ada data breed sapi.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td>TOTAL</td>
                <td class="num">{{ $cowsPerBreed->sum('cows_count') }} ekor</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">Sistem Manajemen Peternakan Sapi &mdash; Laporan Produksi</div>
</body>
</html>