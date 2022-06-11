<?php

namespace App\Http\Controllers\User;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

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

    public function update(Report $report, Request $request)
    {
        $report->data = $request->get('data');

        if ($request->has('status')) {
            if ($request->get('status') === Status::COMPLETE) {
                $report->submitted_at = now();
            } else {
                $report->submitted_at = null;
            }
        }

        $report->save();

        return [
            'success' => true
        ];
    }
}
