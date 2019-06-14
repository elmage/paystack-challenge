<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Requests\ScheduleExists;
use App\Http\Requests\ScheduleTransferRequest;
use App\Supplier\Supplier;
use App\Transfer\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ScheduleController extends Controller
{
    public function index(Schedule $schedule,Supplier $supplier)
    {
        $schedules = $schedule->getSchedules();
        $suppliers = $supplier->orderBy('name', 'ASC')->get(['id','name']);
        return view('transfer.schedule.index', ['schedules'=>$schedules,'suppliers'=>$suppliers]);
    }

    public function schedule(ScheduleTransferRequest $request, Schedule $schedule)
    {
        $validated = $request->validated();

        $start = Carbon::parse($validated['start']);
        $end = Carbon::parse($validated['end']);

        if ($start > $end)
        {
            return redirect()->back()->with('error','The end date has to be later than the start date');
        }

        if ($start < now())
        {
            return redirect()->back()->with('error','The start date must be later than now.');
        }

        $schedule = $schedule->create($validated);

        return redirect()->back()->with('success', 'The transfer was scheduled successfully.');
    }

    public function toggleStatus(ScheduleExists $request, Schedule $schedule)
    {
        $validated = $request->validated();
        $schedule = $schedule->find($validated['id']);

        $schedule->update(['status' => ! $schedule->status]);

        return redirect()->back()->with('success', 'The transfer scheduled status was changed successfully.');
    }

    public function delete(ScheduleExists $request, Schedule $schedule)
    {
        $validated = $request->validated();
        $schedule->destroy($validated['id']);

        return redirect()->back()->with('success', 'The transfer scheduled was deleted successfully.');
    }
}
