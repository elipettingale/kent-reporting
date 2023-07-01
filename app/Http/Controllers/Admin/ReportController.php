<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query()
            ->orderBy('created_at');

        if ($club = $request->input('club')) {
            $query = $query->whereHas('user', function($query) use ($club) {
                return $query->where('club', $club);
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

    public function downloadFile(Report $report, Media $media)
    {   
        if ($media->model_id !== $report->id) {
            abort(404);
        }

        return response()->download($media->getPath(), $media->file_name);
    }
}
