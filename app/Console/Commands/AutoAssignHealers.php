<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HealingRequest;
use App\Models\User; // assuming healer is user
use Carbon\Carbon;

class AutoAssignHealers extends Command
{
    protected $signature = 'healing:auto-assign';
    protected $description = 'Auto assign healers 30 minutes before healing time to requests with bids';

    public function handle()
    {
        $now = Carbon::now();

        $requests = HealingRequest::whereNull('assigned_healer_id')
            ->where('status', 'pending')
            ->whereDate('date', $now->toDateString())
            ->get()
            ->filter(function ($request) use ($now) {
                $scheduled = Carbon::parse($request->date . ' ' . $request->time);
                return $now->diffInMinutes($scheduled, false) === 30;
            });

        foreach ($requests as $request) {
            $bids = $request->bids;

            if ($bids->isEmpty()) {
                $this->info("No bids for request ID: {$request->id}");
                continue;
            }

            $healerIds = $bids->pluck('healer_id')->unique();

            $healerData = $healerIds->mapWithKeys(function ($healerId) {
                $wallet = User::find($healerId)?->wallet_balance ?? 0;
                $assignedCount = HealingRequest::where('assigned_healer_id', $healerId)->count();

                return [$healerId => [
                    'wallet_balance' => $wallet,
                    'assigned_count' => $assignedCount
                ]];
            });

            // Sort: lowest wallet, then least assignments
            $sorted = $healerData->sort(function ($a, $b) {
                return $a['wallet_balance'] <=> $b['wallet_balance']
                    ?: $a['assigned_count'] <=> $b['assigned_count'];
            });

            $selectedHealerId = $sorted->keys()->first();

            // Save assignment
            $request->assigned_healer_id = $selectedHealerId;
            $request->status = 'assigned';
            $request->save();

            $this->info("Assigned healer ID {$selectedHealerId} to request ID {$request->id}");
        }

        $this->info('✅ Auto-assignment job complete at ' . now());
    }
}