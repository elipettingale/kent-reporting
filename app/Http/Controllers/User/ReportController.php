<?php

namespace App\Http\Controllers\User;

use App\Enums\LogEvent;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function getData(Report $report)
    {
        return [
            'viewOnly' => $report->status() === 'complete',
            'data' => $report->data
        ];
    }

    public function show(Report $report)
    {
        record_log(LogEvent::VIEWED_REPORT, [
            'club' => Auth()->user()->club,
            'year' => $report->financial_year
        ]);

        return view('user.report', [
            'report' => $report
        ]);
    }

    public function update(Report $report, Request $request)
    {
        // todo: authorize

        $report->data = $request->get('data');

        if ($request->has('status')) {
            if ($request->get('status') === Status::COMPLETE) {
                $report->submitted_at = now();

                record_log(LogEvent::SUBMITTED_REPORT, [
                    'club' => Auth()->user()->club,
                    'year' => $report->financial_year
                ]);
            } else {
                $report->submitted_at = null;
            }
        }

        $report->save();

        return [
            'success' => true
        ];
    }

    public function storeFile(Report $report, Request $request)
    {
        // todo: authorize

        $files = [];

        $uploads = $request->file('uploads');

        foreach ($uploads as $upload) {
            $media = $report->addMedia($upload)
                ->toMediaCollection();

            $files[] = [
                'id' => $media->id,
                'name' => $media->file_name
            ];
        }

        return [
            'success' => true,
            'files' => $files
        ];
    }

    public function destroyFile(Report $report, Media $media)
    {
        // todo: authorise

        $media->delete();

        return [
            'success' => true
        ]; 
    }
}
