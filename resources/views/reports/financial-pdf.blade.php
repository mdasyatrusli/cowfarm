<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .meta { color: #6b7280; margin-bottom: 16px; }
        .cards { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .cards td { width: 25%; border: 1px solid #e5e7eb; padding: 8px; vertical-align: top; }
        .cards .label { color: #6b7280; font-size: 11px; }
        .cards .value { font-size: 15px; font-weight: bold; margin-top: 2px; }
        .section-title { font-size: 14px; font-weight: bold; margin: 18px 0 8px; }
        table.report { width: 100%; border-collapse: collapse; }
        table.report th, table.report td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        table.report th { background: #f3f4f6; font-size: 11px; text-transform: uppercase; }
        table.report td.num { text-align: right; }
        table.report tfoot td { font-weight: bold; background: #f9fafb; }
        .bar-wrap { background: #e5e7eb; height: 12px; width: 100%; border-radius: 3px; }
        .bar-income { background: #16a34a; height: 12px; border-radius: 3px; }
        .bar-expense { background: #dc2626; height: 12px; border-radius: 3px; }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .footer { margin-top: 24px; color: #9ca3af; font-size: 10px; text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Keuangan</h1>
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
                <div class="label">Total Pendapatan</div>
                <div class="value text-green">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Total Biaya</div>
                <div class="value text-red">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Biaya Kesehatan</div>
                <div class="value text-red">Rp {{ number_format($healthCostTotal, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Laba / Rugi</div>
                <div class="value {{ $profitLoss >= 0 ? 'text-green' : 'text-red' }}">
                    Rp {{ number_format($profitLoss, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Pendapatan vs Biaya per Bulan</div>
    @if (count($chartMonths) > 0)
        <table class="report">
            <thead>
                <tr>
                    <th style="width:120px;">Bulan</th>
                    <th>Pendapatan</th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chartMonths as $i => $month)
                    @php
                        $maxVal = max(max($chartIncome), max($chartExpense), 1);
                        $incomePct = $maxVal > 0 ? ($chartIncome[$i] / $maxVal) * 100 : 0;
                        $expensePct = $maxVal > 0 ? ($chartExpense[$i] / $maxVal) * 100 : 0;
                    @endphp
                    <tr>
                        <td>{{ $month }}</td>
                        <td>
                            <div class="bar-wrap"><div class="bar-income" style="width: {{ $incomePct }}%"></div></div>
                            <span class="text-green">Rp {{ number_format($chartIncome[$i], 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <div class="bar-wrap"><div class="bar-expense" style="width: {{ $expensePct }}%"></div></div>
                            <span class="text-red">Rp {{ number_format($chartExpense[$i], 0, ',', '.') }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data untuk periode ini.</p>
    @endif

    <div class="section-title">Rincian per Kategori</div>
    <table class="report">
        <thead>
            <tr>
                <th>Kategori</th>
                <th class="num">Pendapatan</th>
                <th class="num">Biaya</th>
                <th class="num">Selisih</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactionCategories as $cat)
                <tr>
                    <td>{{ $cat->category }}</td>
                    <td class="num text-green">Rp {{ number_format($cat->total_income, 0, ',', '.') }}</td>
                    <td class="num text-red">Rp {{ number_format($cat->total_expense, 0, ',', '.') }}</td>
                    <td class="num {{ ($cat->total_income - $cat->total_expense) >= 0 ? 'text-green' : 'text-red' }}">
                        Rp {{ number_format($cat->total_income - $cat->total_expense, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada transaksi.</td>
                </tr>
            @endforelse
            @if ($healthCostTotal > 0)
                <tr>
                    <td>Kesehatan (biaya langsung)</td>
                    <td class="num text-green">Rp 0</td>
                    <td class="num text-red">Rp {{ number_format($healthCostTotal, 0, ',', '.') }}</td>
                    <td class="num text-red">-Rp {{ number_format($healthCostTotal, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td>TOTAL</td>
                <td class="num text-green">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                <td class="num text-red">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                <td class="num {{ $profitLoss >= 0 ? 'text-green' : 'text-red' }}">
                    Rp {{ number_format($profitLoss, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">Sistem Manajemen Peternakan Sapi &mdash; Laporan Keuangan</div>
</body>
</html>