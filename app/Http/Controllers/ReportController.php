<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function showReportForm()
    {
        return view('report');
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'reporter_id' => 'required|exists:users,id',
            'reported_id' => 'required|exists:users,id',
            'description' => 'required|string|max:1000',
            'violation_type' => 'required|string|in:spam,abuse,harassment,other',
        ]);

        $report = Report();
        $report = new Report();
        $report->reporter_id = Auth::id();
        $report->reported_id = $request->reported_id;
        $report->description = $request->description;
        $report->violation_type = $request->violation_type;

        $totalReports = Report::where('reported_id', $request->reported_id)->count();

        if ($totalReports >= 3) {
            $report->status = 'resolved';
            $report->resolved_at = now();
            $reportedUser = User::find($request->reported_id);
            $reportedUser->status = 'banned';
            $reportedUser->save();
        } elseif ($totalReports >= 1) {
            $report->status = 'dismissed';
            $report->dismissed_at = now();
            $reportedUser = User::find($request->reported_id);
            $reportedUser->status = 'reported';
            $reportedUser->save();
        } else {
            $report->status = 'pending';
        }

        $report->save();
        return redirect()->route('report.success')->with('success', 'Report submitted successfully.');
    }
}
