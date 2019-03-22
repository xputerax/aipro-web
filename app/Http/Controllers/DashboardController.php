<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Shows the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $todays_date = Carbon::now();

        $cannot_get_sales_report_all_branches = function ($query) use ($user) {
            if ($user->cannot('get-sales-report-all-branches')) {
                $query->where('branch_id', $user->branch_id);
            }
        };

        $sales_today = DB::table('order_payments')
            ->selectRaw('COALESCE(SUM(amount), "0.00") as sum_sales')
            ->whereRaw('DATE(created_at) = ?', [
                $todays_date->toDateString(),
            ])
            ->where($cannot_get_sales_report_all_branches)
            ->first()
        ;

        $sales_month = DB::table('order_payments')
            ->selectRaw('COALESCE(SUM(amount), "0.00") as sum_sales')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [
                $todays_date->format('Y-m'),
            ])
            ->where($cannot_get_sales_report_all_branches)
            ->first()
        ;

        $sales_year = DB::table('order_payments')
            ->selectRaw('COALESCE(SUM(amount), "0.00") as sum_sales')
            ->whereRaw('YEAR(created_at) = ?', [
                $todays_date->format('Y'),
            ])
            ->where($cannot_get_sales_report_all_branches)
            ->first()
        ;

        $sales = [
            'day' => $sales_today->sum_sales,
            'month' => $sales_month->sum_sales,
            'year' => $sales_year->sum_sales,
        ];

        return view('dashboard', compact('sales'));
    }
}
