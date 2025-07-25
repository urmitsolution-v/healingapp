<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HealingRequest;
use App\Models\User;
use Carbon\Carbon;
use App\Models\HealingBid;
use App\Models\MonthlyWallet;

class AutoAssignHealers extends Command
{
    protected $signature = 'healing:auto-assign';
    protected $description = 'Automatically assigns a healer before 30 mins of healing time';

public function handle(): void
{
    $this->line('🛠️ Auto-assign command started...');

    $isTesting = false;

    $targetTime = $isTesting ? now() : now()->copy()->addMinutes(30);

    $requests = HealingRequest::where('status', 'pending')
        ->whereDate('date', $targetTime->toDateString())
        ->whereTime('time', $targetTime->format('H:i'))
        ->get();
        
    if ($requests->isEmpty()) {
        $this->line('📭 No pending healing requests found for auto-assign.');
        return;
    }

    foreach ($requests as $request) {
        $bids = HealingBid::where('healing_request_id', $request->id)->get();

        if ($bids->isEmpty()) {
            $this->line("⚠️ No bids found for request ID {$request->id}");
            continue;
        }

        $healerId = $bids->pluck('healer_id')->unique()->mapWithKeys(function ($healerId) {
            $wallet = MonthlyWallet::firstOrCreate([
                'user_id' => $healerId,
                'month' => now()->month,
                'year' => now()->year,
            ], [
                'credit' => 0,
                'debit' => 0,
                'balance' => 0,
            ]);
            return [$healerId => $wallet->balance];
        })->sort()->keys()->first();

        $request->assigned_healer_id = $healerId;
        $request->status = 'assigned';
        $request->save();

        $wallet = MonthlyWallet::firstOrCreate([
            'user_id' => $healerId,
            'month' => now()->month,
            'year' => now()->year,
        ]);
        $wallet->increment('credit');
        $wallet->update([
            'balance' => $wallet->credit - $wallet->debit,
        ]);

        $this->line("✅ Assigned healer ID {$healerId} to request ID {$request->id}");
    }
}
}