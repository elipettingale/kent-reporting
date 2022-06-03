<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::query()
            ->where('user_id', auth()->user()->id)
            ->orderByDesc('financial_year')
            ->get();

        return view('user.reports', [
            'reports' => $reports
        ]);
    }

    public function show(Report $report)
    {
        return view('user.report', [
            'report' => $report
        ]);
    }
}
