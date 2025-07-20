<?php

namespace App\Http\Controllers\Healing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealingRequest;
use App\Models\HealingBid;
use App\Models\MonthlyWallet;
use Carbon\Carbon;

class Healingcontroller extends Controller
{
    
    public function healing_requests(Request $request) {
        return view('healing.healing_requests');
    }

    public function new_healing_request(Request $request){
        return view('healing.new_healing_request');
    }

    public function storeHealingRequest(Request $request)
{
    $request->validate([
        'healing_requirement' => 'required|string',
        'date' => 'required|date',
        'time' => 'required',
    ]);
    HealingRequest::create([
        'user_id' => auth()->id(),
        'healing_requirement' => $request->healing_requirement,
        'date' => $request->date,
        'time' => $request->time,
        'status' => 'pending',
    ]);
    
   $now = Carbon::now();
    $wallet = MonthlyWallet::firstOrCreate(
        [
            'user_id' => auth()->id(),
            'month' => $now->month,
            'year' => $now->year,
        ],
        [
            'credit' => 0,
            'debit' => 0,
            'balance' => 0,
        ]
    );

    $wallet->increment('debit');
    // $wallet->decrement('balance'); // optional: if you want to maintain balance

    return response()->json(['success' => true, 'message' => 'Healing Request Submitted!']);
}

public function getUserRequests(Request $request)
{
    $perPage = 10;
    $page = $request->get('page', 1);
    $selectedDate = $request->get('date');

    $query = HealingRequest::where('user_id', auth()->id())->latest();

    if ($selectedDate) {
        $query->where('date', $selectedDate);
    }

    $totalRequests = $query->count();

    $requests = $query->orderBy('date', 'asc')
        ->skip(($page - 1) * $perPage)
        ->take($perPage)
        ->get()
        ->map(function ($item) {
            $item->formatted_datetime = Carbon::parse($item->date . ' ' . $item->time)->format('D, M j Y \a\t g:i A');
            return $item;
        });

    return response()->json([
        'data' => $requests,
        'total' => $totalRequests,
        'page' => $page
    ]);
}


public function healing_cancel(Request $request)
{
    $id = $request->input('id');

    $requestModel = HealingRequest::where('id', $id)
                    ->where('user_id', auth()->id()) 
                    ->where('status', 'pending')
                    ->first();

    if (!$requestModel) {
        return response()->json(['success' => false, 'message' => 'Request not found or already processed.']);
    }

    $requestModel->status = 'cancelled';
    $requestModel->save();

    $month = Carbon::parse($requestModel->created_at)->month;
    $year = Carbon::parse($requestModel->created_at)->year;

    $wallet = MonthlyWallet::where([
        'user_id' => auth()->id(),
        'month' => $month,
        'year' => $year
    ])->first();

    if ($wallet && $wallet->debit > 0) {
        $wallet->decrement('debit');
    }

    return response()->json(['success' => true]);
}

public function viewopenbids(Request $request){
    return view('healing.viewopenbids');
}


public function getAvailableRequestsForBid(Request $request)
{
    $perPage = 10;
    $page = $request->get('page', 1);
    $selectedDate = $request->get('date');

    $query = HealingRequest::where('user_id', '!=', auth()->id())
        ->where('status', 'pending') // Only open for bid
        ->whereDoesntHave('bids', function ($q) {
            $q->where('healer_id', auth()->id());
        });

    if ($selectedDate) {
        $query->where('date', $selectedDate);
    }

    $totalRequests = $query->count();

    $requests = $query->orderBy('date', 'asc')
        ->skip(($page - 1) * $perPage)
        ->take($perPage)
        ->get()
        ->map(function ($item) {
            $item->formatted_datetime = Carbon::parse($item->date . ' ' . $item->time)->format('D, M j Y \a\t g:i A');
            return $item;
        });

    return response()->json([
        'data' => $requests,
        'total' => $totalRequests,
        'page' => $page
    ]);
}

public function placeBid(Request $request)
{
    $bids = $request->input('bids');

    foreach ($bids as $bid) {
        HealingBid::create([
            'healing_request_id' => $bid['id'],
            'healer_id' => auth()->id(),
            'remarks' => $bid['remarks'] ?? null,
        ]);
    }
    return response()->json(['success' => true]);
}


public function assigned_healings(Request $request){
    return view('healing.assigned_healings');
}

public function ajaxHealingList()
{
    $healerId = auth()->id();

    $requests = HealingRequest::where('assigned_healer_id', $healerId)
        // ->whereDate('date', today())
        ->where('is_completed_by_healer', false)
        ->orderBy('time')
        ->get();

    return response()->json($requests);
}

public function ajaxMarkDone(Request $request)
{
    $healerId = auth()->id();
    $ids = $request->input('selected_requests', []);
    $remarks = $request->input('remarks');

    HealingRequest::whereIn('id', $ids)
        ->where('assigned_healer_id', $healerId)
        ->update([
            'is_completed_by_healer' => true,
            'completed_remarks' => $remarks
        ]);

    return response()->json(['status' => 'success', 'message' => 'Marked successfully']);
}

public function reports(Request $request){
    return view('healing.reports');
}


public function fetch_reports(Request $request)
{
    $healerId = auth()->id();

    $reports = HealingRequest::with('user') // 👈 eager load
        ->where('assigned_healer_id', $healerId)
        ->where('is_completed_by_healer', true)
        ->orderByDesc('date')
        ->get()
        ->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
        });

    return response()->json($reports);
}
}