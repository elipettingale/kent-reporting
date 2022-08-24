<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query()
            ->orderBy('created_at');

        if ($club = $request->input('club')) {
            $query = $query->whereHas(User::class, function($query) use ($club) {
                $query->where('club', $club);
            });
        }

        if ($status = $request->input('status')) {
            $query = $query->whereStatus($status);
        }

        if ($financialYear = $request->input('financial_year')) {
            $query = $query->where('financial_year', $financialYear);
        }

        $reports = $query->get();

        return view('admin.reports', [
            'reports' => $reports
        ]);
    }

    public function getData(Report $report)
    {
        return [
            'viewOnly' => true,
            'data' => $report->data
        ];
    }

    public function show(Report $report)
    {
        return view('user.report', [
            'report' => $report
        ]);
    }
}
