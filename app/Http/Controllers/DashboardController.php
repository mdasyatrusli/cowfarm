<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use App\Models\Farm;
use App\Models\HealthRecord;
use App\Models\MilkRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the appropriate dashboard based on user role.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    /**
     * Super Admin dashboard — aggregate stats across all farms.
     */
    protected function adminDashboard()
    {
        // Summary cards
        $totalFarms = Farm::count();
        $totalCows = Cow::count();
        $totalUsers = User::count();

        // Bar chart: top 10 farms by cow count
        $farmsByCowCount = Farm::withCount('cows')
            ->orderBy('cows_count', 'desc')
            ->take(10)
            ->get(['id', 'name', 'cows_count']);

        // Farm table: list with cow & user counts
        $farms = Farm::withCount(['cows', 'users'])
            ->orderBy('name')
            ->get();

        return view('admin.dashboard', compact(
            'totalFarms',
            'totalCows',
            'totalUsers',
            'farmsByCowCount',
            'farms'
        ));
    }

    /**
     * Admin farm / User dashboard — scoped to the user's farm via BelongsToTenant.
     */
    protected function userDashboard()
    {
        $user = Auth::user();

        // Summary cards (all scoped by BelongsToTenant automatically)
        $totalCowsActive = Cow::where('status', 'active')->count();
        $totalCowsAll = Cow::count();

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        $healthRecordsThisMonth = HealthRecord::where('record_date', '>=', $startOfMonth)
            ->where('record_date', '<=', $now)
            ->count();

        $milkVolumeThisMonth = MilkRecord::where('record_date', '>=', $startOfMonth)
            ->where('record_date', '<=', $now)
            ->sum('volume_liters');

        // Line chart: milk production last 7 days
        $sevenDaysAgo = $now->copy()->subDays(6)->startOfDay();

        $milkLast7Days = MilkRecord::where('record_date', '>=', $sevenDaysAgo)
            ->where('record_date', '<=', $now)
            ->select(
                DB::raw("DATE(record_date) as date"),
                DB::raw("SUM(volume_liters) as total_volume")
            )
            ->groupBy(DB::raw("DATE(record_date)"))
            ->orderBy('date')
            ->pluck('total_volume', 'date');

        // Build arrays for Chart.js: ensure all 7 days are represented
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i)->format('Y-m-d');
            $chartLabels[] = $now->copy()->subDays($i)->format('D');
            $chartData[] = (float) ($milkLast7Days[$date] ?? 0);
        }

        // Recent 5 health records
        $recentHealthRecords = HealthRecord::with('cow')
            ->orderBy('record_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalCowsActive',
            'totalCowsAll',
            'healthRecordsThisMonth',
            'milkVolumeThisMonth',
            'chartLabels',
            'chartData',
            'recentHealthRecords'
        ));
    }
}
