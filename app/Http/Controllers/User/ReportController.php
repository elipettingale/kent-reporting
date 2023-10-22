<?php

namespace App\Http\Controllers\User;

use App\Enums\LogEvent;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::user()->id !== $report->user_id) {
            abort(403);
        }

        return [
            'viewOnly' => $report->status() === 'complete',
            'data' => $report->data
        ];
    }

    public function show(Report $report)
    {
        if (Auth::user()->id !== $report->user_id) {
            abort(403);
        }
        
        record_log(LogEvent::VIEWED_REPORT, [
            'club' => Auth()->user()->club,
            'year' => $report->season()
        ]);

        return view('user.report', [
            'report' => $report
        ]);
    }

    public function store(Request $request)
    {   
        $financialYear = (int) $request->input('financial_year', now()->format('Y'));

        $alreadyExists = Report::query()
            ->where('user_id', Auth::user()->id)
            ->where('financial_year', $financialYear)
            ->exists();

        if ($alreadyExists) {
            throw new \Exception("Report already exists.");
        }
    
        $report = Report::create([
            'user_id' => Auth::user()->id,
            'financial_year' => $financialYear,
            'form_version' => config('form.version')
        ]);

        $preFill = (bool) $request->input('pre_fill');

        if ($preFill) {
            $previousReport = Report::query()
                ->where('user_id', Auth::user()->id)
                ->where('financial_year', $financialYear - 1)
                ->whereNotNull('submitted_at')
                ->first();

            $data = $previousReport->data;

            $data['general_details_accounts_upload']['value'] = null;

            foreach ($data as $key => $value) {
                if (is_array($value) && isset($value['error'])) {
                    $data[$key]['error'] = null;
                }
            }

            if ($data['general_details_accounting_year_start']['value'] !== null) {
                $accountingYearStart = Carbon::createFromFormat('Y-m-d', $data['general_details_accounting_year_start']['value'])->addYear();
                $data['general_details_accounting_year_start']['value'] = $accountingYearStart->format('Y-m-d');
            }

            if ($data['general_details_accounting_year_end']['value'] !== null) {
                $accountingYearStart = Carbon::createFromFormat('Y-m-d', $data['general_details_accounting_year_end']['value'])->addYear();
                $data['general_details_accounting_year_end']['value'] = $accountingYearStart->format('Y-m-d');
            }

            $report->data = $data;
            $report->save();
        }

        return redirect()->back();
    }

    public function update(Report $report, Request $request)
    {
        if (Auth::user()->id !== $report->user_id) {
            abort(403);
        }

        $report->data = $request->get('data');

        if ($request->has('status')) {
            if ($request->get('status') === Status::COMPLETE) {
                $report->submitted_at = now();

                record_log(LogEvent::SUBMITTED_REPORT, [
                    'club' => Auth()->user()->club,
                    'year' => $report->season()
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
        if (Auth::user()->id !== $report->user_id) {
            abort(403);
        }

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
        if (Auth::user()->id !== $report->user_id) {
            abort(403);
        }

        $media->delete();

        return [
            'success' => true
        ]; 
    }

    public function downloadFile(Report $report, Media $media)
    {
        if (Auth::user()->id !== $report->user_id) {
            abort(403);
        }

        if ($media->model_id !== $report->id) {
            abort(404);
        }

        return response()->download($media->getPath(), $media->file_name);
    }
}
