<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function show()
    {
        return view('admin.stats');
    }

    public function getClub(Request $request)
    {
        $club = $request->input('club');
        $user = User::where('club', $club)->first();

        if (!$user) {
            return [
                'success' => false
            ];
        }

        $reports = Report::query()
            ->where('user_id', $user->id)
            ->orderBy('financial_year', 'desc')
            ->get();

        $years = [];

        $stats = config('form.stats');

        foreach ($reports as $report) {
            $data = [
                'status' => $report->status(),
                'stats' => []
            ];

            foreach ($stats as $stat) {
                $total = 0;
                $reportData = $report->data ?? [];

                foreach ($stat['values'] as $value) {
                    $fields = array_values(preg_grep("/{$value}/", array_keys($reportData)));

                    foreach ($fields as $field) {
                        $total += (float) $reportData[$field]['value'];
                    }
                }
                
                $data['stats'][] = [
                    'label' => $stat['label'],
                    'value' => '£' . number_format($total, 2)
                ];
            }

            $years[$report->financial_year] = $data;
        }

        $statList = [];

        foreach ($stats as $stat) {
            $statList[] = $stat['label'];
        }

        return [
            'success' => true,
            'id' => $user->id,
            'years' => $years,
            'statList' => $statList
        ];
    }

    public function getStat(Request $request)
    {
        $user = User::find($request->input('club'));

        if (!$user) {
            return [
                'success' => false
            ];
        }

        $requestedStat = $request->input('stat');
        $statBlueprints = config('form.stats');
        $requestedStatBlueprint = null;

        foreach ($statBlueprints as $statBlueprint) {
            if ($statBlueprint['label'] === $requestedStat) {
                $requestedStatBlueprint = $statBlueprint;
            }
        }

        $reports = Report::query()
            ->where('user_id', $user->id)
            ->orderBy('financial_year', 'desc')
            ->get();

        $years = [];

        foreach ($reports as $report) {
            $total = 0;
            $reportData = $report->data ?? [];

            foreach ($requestedStatBlueprint['values'] as $value) {
                $fields = array_values(preg_grep("/{$value}/", array_keys($reportData)));

                foreach ($fields as $field) {
                    $total += (float) $reportData[$field]['value'];
                }
            }

            $years[] = [
                'year' => $report->financial_year,
                'value' => number_format($total, 2)
            ];
        }

        return [
            'success' => true,
            'years' => $years
        ];
    }
}
