<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Models\Cow;
use App\Models\Farm;
use App\Models\HealthRecord;
use App\Models\MilkRecord;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Financial report (HTML view): Income vs Expense summary, chart, and category breakdown.
     */
    public function financial(Request $request)
    {
        return view('reports.financial', $this->financialData($request));
    }

    /**
     * Financial report (PDF download).
     */
    public function financialPdf(Request $request)
    {
        $data = $this->financialData($request);
        $pdf = Pdf::loadView('reports.financial-pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-keuangan-' . Carbon::now()->format('Ymd') . '.pdf');
    }

    /**
     * Build the data set shared by the financial HTML view and PDF export.
     */
    private function financialData(Request $request): array
    {
        $user = Auth::user();

        // Default period: current month
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Base query scoped by BelongsToTenant for admin_farm, or all for super_admin
        $transactionQuery = Transaction::query();
        $healthQuery = HealthRecord::query();

        // For super_admin, allow farm filter; for admin_farm, scoped by tenant trait
        $selectedFarmName = null;
        if ($user->isSuperAdmin()) {
            // Optional farm filter
            if ($request->filled('farm_id')) {
                $transactionQuery->where('farm_id', $request->farm_id);
                $healthQuery->where('farm_id', $request->farm_id);
                $selectedFarmName = optional(Farm::find($request->farm_id))->name;
            }
        }

        // Apply date range
        $transactionQuery->whereBetween('transaction_date', [$startDate, $endDate]);
        $healthQuery->whereBetween('record_date', [$startDate, $endDate]);

        // --- Summary cards ---
        $totalIncome = (float) $transactionQuery->clone()->where('type', 'income')->sum('amount');
        $totalExpenseTransactions = (float) $transactionQuery->clone()->where('type', 'expense')->sum('amount');
        $totalHealthCost = (float) $healthQuery->clone()->sum('cost');
        $totalExpense = $totalExpenseTransactions + $totalHealthCost;
        $profitLoss = $totalIncome - $totalExpense;

        // --- Chart: Income vs Expense per month ---
        // We need monthly aggregates across the selected range
        $monthlyIncome = $transactionQuery->clone()
            ->where('type', 'income')
            ->select(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m') as month"), DB::raw("SUM(amount) as total"))
            ->groupBy(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m')"))
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyExpenseTrans = $transactionQuery->clone()
            ->where('type', 'expense')
            ->select(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m') as month"), DB::raw("SUM(amount) as total"))
            ->groupBy(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m')"))
            ->orderBy('month')
            ->pluck('total', 'month');

        // Health costs per month
        $monthlyHealthCost = $healthQuery->clone()
            ->select(DB::raw("DATE_FORMAT(record_date, '%Y-%m') as month"), DB::raw("SUM(cost) as total"))
            ->groupBy(DB::raw("DATE_FORMAT(record_date, '%Y-%m')"))
            ->orderBy('month')
            ->pluck('total', 'month');

        // Build complete month labels between start and end
        $chartMonths = [];
        $chartIncome = [];
        $chartExpense = [];
        $start = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->startOfMonth();

        while ($start->lte($end)) {
            $key = $start->format('Y-m');
            $chartMonths[] = $start->format('M Y');
            $chartIncome[] = (float) ($monthlyIncome[$key] ?? 0);
            $healthVal = (float) ($monthlyHealthCost[$key] ?? 0);
            $expTransVal = (float) ($monthlyExpenseTrans[$key] ?? 0);
            $chartExpense[] = $healthVal + $expTransVal;
            $start->addMonth();
        }

        // --- Breakdown table by category ---
        $transactionCategories = $transactionQuery->clone()
            ->select('category', DB::raw("SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as total_income"),
                DB::raw("SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as total_expense"))
            ->groupBy('category')
            ->orderByDesc(DB::raw("SUM(amount)"))
            ->get();

        // Health cost as an "expense" category entry
        $healthCostTotal = $healthQuery->clone()->sum('cost');

        // For super_admin, list all farms for the filter dropdown
        $farms = collect();
        if ($user->isSuperAdmin()) {
            $farms = Farm::orderBy('name')->get(['id', 'name']);
        }

        return compact(
            'startDate',
            'endDate',
            'selectedFarmName',
            'totalIncome',
            'totalExpense',
            'profitLoss',
            'chartMonths',
            'chartIncome',
            'chartExpense',
            'transactionCategories',
            'healthCostTotal',
            'farms'
        );
    }

    /**
     * Production report (HTML view): Milk production, health costs, cow counts, breed breakdown.
     */
    public function production(Request $request)
    {
        return view('reports.production', $this->productionData($request));
    }

    /**
     * Production report (PDF download).
     */
    public function productionPdf(Request $request)
    {
        $data = $this->productionData($request);
        $pdf = Pdf::loadView('reports.production-pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-produksi-' . Carbon::now()->format('Ymd') . '.pdf');
    }

    /**
     * Build the data set shared by the production HTML view and PDF export.
     */
    private function productionData(Request $request): array
    {
        $user = Auth::user();

        // Default period: current month
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $milkQuery = MilkRecord::query();
        $healthQuery = HealthRecord::query();
        $cowQuery = Cow::query();

        // For super_admin, allow farm filter
        $selectedFarmName = null;
        if ($user->isSuperAdmin()) {
            if ($request->filled('farm_id')) {
                $milkQuery->where('farm_id', $request->farm_id);
                $healthQuery->where('farm_id', $request->farm_id);
                $cowQuery->where('farm_id', $request->farm_id);
                $selectedFarmName = optional(Farm::find($request->farm_id))->name;
            }
        }

        // Apply date range
        $milkQuery->whereBetween('record_date', [$startDate, $endDate]);
        $healthQuery->whereBetween('record_date', [$startDate, $endDate]);

        // --- Summary cards ---
        $totalMilkLiters = (float) $milkQuery->clone()->sum('volume_liters');
        $totalHealthCost = (float) $healthQuery->clone()->sum('cost');
        $totalActiveCows = (int) $cowQuery->clone()->where('status', 'active')->count();

        // --- Chart: daily milk production trend ---
        $dailyMilk = $milkQuery->clone()
            ->select(DB::raw("DATE(record_date) as date"), DB::raw("SUM(volume_liters) as total_volume"))
            ->groupBy(DB::raw("DATE(record_date)"))
            ->orderBy('date')
            ->pluck('total_volume', 'date');

        // Build complete date labels
        $chartDates = [];
        $chartVolumes = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($current->lte($end)) {
            $key = $current->format('Y-m-d');
            $chartDates[] = $current->format('d M');
            $chartVolumes[] = (float) ($dailyMilk[$key] ?? 0);
            $current->addDay();
        }

        // --- Table: Cows per Breed ---
        $cowsPerBreed = Breed::withCount(['cows' => function ($q) use ($cowQuery, $user) {
            // Scope by farm if applicable
            if ($user->isSuperAdmin() && request()->filled('farm_id')) {
                $q->where('farm_id', request()->farm_id);
            }
        }])->orderByDesc('cows_count')->get();

        // For super_admin, list all farms for the filter dropdown
        $farms = collect();
        if ($user->isSuperAdmin()) {
            $farms = Farm::orderBy('name')->get(['id', 'name']);
        }

        return compact(
            'startDate',
            'endDate',
            'selectedFarmName',
            'totalMilkLiters',
            'totalHealthCost',
            'totalActiveCows',
            'chartDates',
            'chartVolumes',
            'cowsPerBreed',
            'farms'
        );
    }
}