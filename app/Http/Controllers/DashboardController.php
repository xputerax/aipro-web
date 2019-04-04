<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Shows the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $todays_date = Carbon::now();

        $sales_today = DB::table('order_payments')
            ->selectRaw('COALESCE(SUM(amount), "0.00") as sum_sales')
            ->whereRaw('DATE(created_at) = ?', [
                $todays_date->toDateString(),
            ])
            ->where('branch_id', $request->session()->get('selected_branch_id'))
            ->first();

        $sales_month = DB::table('order_payments')
            ->selectRaw('COALESCE(SUM(amount), "0.00") as sum_sales')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [
                $todays_date->format('Y-m'),
            ])
            ->where('branch_id', $request->session()->get('selected_branch_id'))
            ->first();

        $sales_year = DB::table('order_payments')
            ->selectRaw('COALESCE(SUM(amount), "0.00") as sum_sales')
            ->whereRaw('YEAR(created_at) = ?', [
                $todays_date->format('Y'),
            ])
            ->where('branch_id', $request->session()->get('selected_branch_id'))
            ->first();

        $sales = [
            'day' => $sales_today->sum_sales,
            'month' => $sales_month->sum_sales,
            'year' => $sales_year->sum_sales,
        ];

        return view('dashboard', compact('sales'));
    }
}
