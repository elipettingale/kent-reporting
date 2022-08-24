<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::query()
            ->orderBy('created_at')
            ->get();

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
