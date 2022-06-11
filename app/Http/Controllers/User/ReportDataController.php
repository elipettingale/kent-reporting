<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportDataController extends Controller
{
    public function get(Report $report)
    {
        return $report->data;
    }
}
