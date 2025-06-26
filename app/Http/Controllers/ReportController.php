<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function showReportForm(Request $request)
    {
        $reportedId = $request->query('reported');

        if (Auth::id() == $reportedId) {
            return redirect()->back()->withErrors(['error' => 'You cannot report yourself.']);
        }

        return view('report', compact('reportedId'));
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'reported_id' => 'required|exists:users,id',
            'description' => 'required|string|max:1000',
            'violation_type' => 'required|string|in:spam,abuse,harassment,other',
        ]);

        $existing = Report::where('reporter_id', Auth::id())
            ->where('reported_id', $request->reported_id)
            ->first();
        if ($existing) {
            return redirect()->back()->withErrors(['error' => 'You have already reported this user.']);
        }

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
        } else {
            $report->status = 'pending';
            $reportedUser = User::find($request->reported_id);
            $reportedUser->status = 'reported';
            $reportedUser->save();
        }

        $report->save();

        return redirect()->route('profile', $request->reported_id)->with('success', 'Report submitted successfully.');
    }
}
