<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Get Totals
        // Assuming your transactions table has an 'amount' column
        $totalTransactions = Transaction::count();
        $totalAmount = Transaction::sum('amount'); 

        // 2. Get Recent Transactions (Limit 5)
        // 'latest()' is a shortcut for orderBy('created_at', 'desc')
        $recentTransactions = Transaction::with('category') // Eager load category if relationship exists
            ->latest()
            ->take(5)
            ->get();

        // 3. Get Chart Data (Sum of amounts per day for last 7 days)
        $chartData = Transaction::select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('SUM(amount) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        // Prepare data for Chart.js
        $chartLabels = $chartData->pluck('date');
        $chartValues = $chartData->pluck('total');

        return view('dashboard', compact(
            'totalTransactions', 
            'totalAmount', 
            'recentTransactions', 
            'chartLabels', 
            'chartValues'
        ));
    }
}
